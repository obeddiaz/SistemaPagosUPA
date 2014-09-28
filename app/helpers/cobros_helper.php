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

				if ($porcentaje_beca && !empty($porcentaje_beca)) { // validacion de existencia de beca
					$porcentaje_beca=$porcentaje_beca[0]->porcentaje; // se toma el porcentaje de beca si este existe
				} else {
					$porcentaje_beca="0"; // se asigna un porcentaje de cero si no se tiene beca asignada
				}

				$response[$key_row]['beca']=$data[$key_row]->monto*intval($porcentaje_beca)/100;  // se calcula la beca correspondiente a el porcentaje
				
 				$referencia=DB::table('referencia')						 // se busca la informacion de la referencia del cobro especificado por ID
					->Where('referencia.alumnos_cobros_id', $data[$key_row]->id)
					->Select('*')
					->get();


				if (isset($referencia[0])) {
					$response[$key_row]['estatus']=$referencia[0]->estatus;   // se asigna el estatus del pago a la respuesta
					if ($referencia[0]->estatus!=0) {						
						$response[$key_row]['pago']=$referencia[0]->fecha_pago;    // Si el adeudo ya se pago solo se asigna la fecha de pago correspondiente
						$response[$key_row]['recargo']=intval($referencia[0]->recargo);	// Si el adeudo ya se pago solo se asigna la ultima cantidad de recargo a la respuesta
					} else {
						if ($data[$key_row]->fecha_limite<date('Y-m-d')) {
							$segundos=strtotime($data[$key_row]->fecha_limite) - strtotime('now'); // se optiene el tiempo que ha pasado de la fecha dada para pagar en segundos
							$meses_retraso=(intval($segundos/60/60/24/30))+1; // los segundos se convierten en meses (de retraso de pago)
							$response[$key_row]['recargo']=70*$meses_retraso; // Se calcula el recargo
						} else {
							$response[$key_row]['recargo']=intval($referencia[0]->recargo);	// si no se ha pasado de la fecha limite se optiene el recargo inicial que es de 0
						}
						$response[$key_row]['pago']=""; // No existe fecha de pago asi que no se asigna ninguna y se crea respuesta nula 
					}
					$response[$key_row]['concepto']=$data[$key_row]->concepto_cobro; // se asigna el concepto a la respuesta
					$response[$key_row]['importe']=$data[$key_row]->monto;// se asigna el monto inicial a la respuesta
						
					
                    $response[$key_row]['saldo']=$response[$key_row]['recargo']+$response[$key_row]['importe']-($data[$key_row]->monto*intval($porcentaje_beca)/100); // se asigna el importe o monto real a pagar a la respuesta

                    $referencia_new['recargo']=$response[$key_row]['recargo']; // se asigna el recargo a la tabla referencias para consultas posteriores
                    $referencia_new['saldo']=$response[$key_row]['saldo']; // se asigna el saldo a la tabla referencias para consultas posteriores
                    $referencia_new['id']=$referencia[0]->id; // se asigna el id al array para actualizar la referencia
                    setReferencia($referencia_new); // se actualiza la referencia
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