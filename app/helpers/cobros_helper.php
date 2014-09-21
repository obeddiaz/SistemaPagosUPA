<?php
	// My common functions

	function Ensamble_estado_de_cuenta($data)
	{
		$response=array();
		foreach ($data as $key_row => $value_row) {
			foreach ($value_row as $key_cell => $value_cell) {
				$response[$key_row]['vence']=$data[$key_row]->fecha_limite;

				$porcentaje_beca=DB::table('beca_porcentaje')
				->join('becas_autorizadas', 'beca_porcentaje.idbeca_tipo', '=','becas_autorizadas.idbeca_tipo')
				->where('becas_autorizadas.idbecas_autorizadas', $data[$key_row]->id_beca_autorizada)
				->where('beca_porcentaje.calificacion_inicial','<=' ,$data[$key_row]->promedio)
				->where('beca_porcentaje.calificacion_final','>=' ,$data[$key_row]->promedio)
				->Select('beca_porcentaje.porcentaje as porcentaje')
				->get();

				if ($porcentaje_beca && !empty($porcentaje_beca)) {
					$porcentaje_beca=$porcentaje_beca[0]->porcentaje;
				} else {
					$porcentaje_beca="0";
				}
				$response[$key_row]['beca']=$data[$key_row]->monto*intval($porcentaje_beca)/100;
				
				$referencia=DB::table('referencia')
					->Where('referencia.alumnos_cobros_id', $data[$key_row]->id)
					->Select('*')
					->get();

				if (isset($referencia[0])) {
					if ($referencia[0]->estatus!=0) {
						$response[$key_row]['pago']=$referencia[0]->fecha_pago;
					} else {
						$response[$key_row]['pago']="";
					}
					$response[$key_row]['concepto']=$data[$key_row]->concepto_cobro;
					$response[$key_row]['importe']=$data[$key_row]->monto;
						
					if ($data[$key_row]->fecha_limite<date('Y-m-d')) {
						$segundos=strtotime($data[$key_row]->fecha_limite) - strtotime('now');
						$meses_retraso=(intval($segundos/60/60/24/30))+1;
						$response[$key_row]['recargo']=70*$meses_retraso;
					} else {
						$response[$key_row]['recargo']=intval($referencia[0]->recargo);	
					}
                    $response[$key_row]['saldo']=$response[$key_row]['recargo']+$response[$key_row]['importe']-($data[$key_row]->monto*intval($porcentaje_beca)/100);

                    $referencia_new['recargo']=$response[$key_row]['recargo'];
                    $referencia_new['saldo']=$response[$key_row]['saldo'];
                    $referencia_new['id']=$referencia[0]->id;
                    setReferencia($referencia_new);
				} else {
					echo json_encode(array('error' => true,'messsage'=>'No reference','response'=>''));
					die();
				}
			}
		}
		return $response;
	}
	function setReferencia($data)
	{
		try {
			if (!isset($data['id'])) {
				DB::table('referencia')->Insert($data);
			}	else{
				DB::table('referencia')->where('referencia.id','=',$data['id'])
									   ->update($data);
			}
	    } catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad data','response'=>''));
			die();
		}

	}
?>	