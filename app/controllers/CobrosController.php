<?php

class CobrosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cobros_info=Cobros::getAll();
		if($cobros_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobros_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$params=Input::get();
		$info_new=array(
			'descripcion'=>$params->descripcion,
			'estatus'=>$params->estatus,
			'monto' => $params->monto
			);
		try {
			Cobros::create($info_new);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New cobro created ID'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));
		}
	}

	public function create_alumno()
	{
		$params=Input::get();
		//var_dump(json_decode($params['id_beca_autorizada']));die();
		$info_new=array(
			'subconceptos_id'=>$params->subconceptos_id,
			'nocuenta'=>$params->nocuenta,
			'ciclos_id'=>$params->ciclos_id,
			'mes_ciclo_id'=>$params->mes_ciclo_id,
			'id_beca_autorizada'=>json_decode($params->id_beca_autorizada),
			'fecha_solicitud'=>$params->fecha_solicitud,
			'fecha_limite'=>$params->fecha_limite,
			'cobros_id'=>$params->cobros_id
		);
		try {
			$new_id = Cobros::create_alumno($info_new);
			$ref_info_query = Cobros::getReferenciaInfo($new_id);

				
			$referencias_library=new Referencias(); 
			$referencia=$referencias_library->generar(
				$ref_info_query[0]->nombre,
				$params['nocuenta'], 
				$ref_info_query[0]->des,
				$ref_info_query[0]->monto,
				date("Y-m-d H:i:s")
			);
			$info_referencia=array(
				'referencia' => $referencia, 
				'recargo'=> 0 ,
				'descuento'=> 0,
				'estatus' => 0,
				'fecha_pago' => null,
				'saldo'=> 0,
				'alumnos_cobros_id' => $new_id
			);
			Cobros::setReferencia($info_referencia);
			
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New alumnos_cobros created ID:'.$new_id));
	} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$params=Input::get();
		$cobro_info=Cobros::find($params->id);	
		if($cobro_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobro_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_estado_de_cuenta()
	{
		$params=Input::get();
		if (isset($params['nocuenta'])) 
		{
				if (!isset($params['ciclosid'])) {
					$params['ciclosid']=Cobros::getGradoCiclo($params);
					$params['ciclosid']=$params['ciclosid'][0]->ciclo;

				}
				$alumnos_cobros= Cobros::getEdoCuenta($params);
		}
		if($alumnos_cobros)
		{
			$cobros_info=Ensamble_estado_de_cuenta($alumnos_cobros);
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobros_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}
	public function show_info_alumno_estado_de_cuenta()
	{
		$params=Input::get();
		$ciclos=Cobros::getCiclos($params);

		$info_alum=Cobros::getInfoAlumno($params);

		$beca_autorizada=getBecaAutorizada($params);
		if(isset($beca_autorizada[0]))
		{
			//$beca_autorizada=$beca_autorizada[0]->id;
			
			$porcentaje_beca=getPorcentajeBeca($beca_autorizada, $info_alum);

			$beca=$porcentaje_beca[0]->tipo.' '.$porcentaje_beca[0]->porcentaje.'% ';
			if ($porcentaje_beca[0]->estatus==0) {
				$beca=$beca.'(CANCELADA)';
			}

		} else{
			$porcentaje_beca='N/A';
		}
		

		$data['ciclos']=$ciclos;
		$data['grado']=$info_alum[0]->grado;
		$data['nivel']=$info_alum[0]->nivel;
		$data['nombre']=$info_alum[0]->nombre;
		$data['beca']=$porcentaje_beca;
		if($data)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$data));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		try {
			$params=Input::get();
			Cobros::update($params);
		    echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Update'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		$params=Input::get();
		try {
			Cobros::destroy($params);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}
}	
