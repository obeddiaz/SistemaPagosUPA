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
				
				$referencia=DB::table('referencia')
					->Where('referencia.alumnos_cobros_id', $data[$key_row]->id)
					->Select('*')
					->get();

				if ($referencia[0]->estatus!=0) {
					$response[$key_row]['pago']=$referencia[0]->fecha_pago;
				} else {
					$response[$key_row]['pago']="";
				}
				
				$response[$key_row]['concepto']=$data[$key_row]->concepto_cobro;
				$response[$key_row]['importe']=$data[$key_row]->monto;
				
				if ($data[$key_row]->fecha_limite<date('Y-m-d')) {
					$response[$key_row]['recargo']=$referencia[0]->recargo + 70;
				} else {
					$response[$key_row]['recargo']=0.0;	
				}

				$response[$key_row]['beca']=$data[$key_row]->monto*intval($porcentaje_beca[0]->porcentaje)/100;
				$response[$key_row]['saldo']=$response[$key_row]['recargo']+$response[$key_row]['importe']-($data[$key_row]->monto*intval($porcentaje_beca[0]->porcentaje)/100);
			}
		}
		return $response;
	}
?>	