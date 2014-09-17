<?php

class BecasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$becas_info=Becas::Select(
			'*'
			)
			->get();
		if($becas_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$becas_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($toke,$params)
	{
		$params=json_decode($params);
		$info=array(
			'beca'=>$params->beca,
			'vinculacion'=>$params->vinculacion
			);
		$id_beca=Becas::InsertGetId($info);
		if ($id_beca) {
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New ciclo created ID'.$id_beca));
		} else {
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
	public function show($token,$params)
	{
		$params=json_decode($params);
		$becas= DB::table('becas_autorizadas');
		$becas_info=$becas
		->join('beca_tipo','beca_tipo.idbeca_tipo','=','becas_autorizadas.idbeca_tipo')
		->join('alumno','alumno.nocuenta','=','becas_autorizadas.nocuenta')
		->join('estatus_alumno','estatus_alumno.estatus','=','alumno.estatus')
		->join('curso','curso.idcurso','=','alumno.idcurso')
		->join('niveles_academicos','niveles_academicos.idnivel','=','curso.nivel')
		->where('estatus_alumno.estatus', $params->estatus_alumno);
		if($params->niveles_academicos!='TODOS')
			$becas->where('niveles_academicos.idnivel', $params->niveles_academicos);
		$becas->Select('becas_autorizadas.*','alumno.nocuenta','beca_tipo.beca','estatus_alumno.estatus','niveles_academicos.nombre');
		
		try {
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$becas_info->get()));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_by_nocuenta($token,$params)
	{
		$params=json_decode($params);
		$becas_info=DB::table('beca_porcentaje')
				->join('becas_autorizadas', 'beca_porcentaje.idbeca_tipo', '=','becas_autorizadas.idbeca_tipo')
				->where('becas_autorizadas.nocuenta', $params->nocuenta)
				->where('beca_porcentaje.calificacion_inicial','<=' ,$params->promedio)
				->where('beca_porcentaje.calificacion_final','>=' ,$params->promedio)
				->Select('becas_autorizadas.*','beca_porcentaje.porcentaje as porcentaje')
				->get();

		if($becas_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$becas_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No beca','response'=>''));
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
	public function update($token,$params)
	{
		$params=json_decode($params);
		try {
			$id=$params->id;
			unset($params->id);

			DB::table('beca_tipo')
					->where('id', $id)
	        		->update($params);	

		    echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Update'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
		
	}

	public function update_autorizada($token,$params)
	{
		$params=json_decode($params);
		try {
			$nocuenta=$params->nocuenta;
			unset($params->nocuenta);

			DB::table('becas_autorizadas')
					->where('nocuenta', $nocuenta)
	        		->update($params);	

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
	public function destroy($token,$id)
	{
		try {
			DB::table('beca_tipo')->where('id', '=', $id)->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}

	public function destroy_autrizada($token,$nocuenta)
	{
		try {
			DB::table('becas_autorizadas')->where('nocuenta', '=', $nocuenta)->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}
}
