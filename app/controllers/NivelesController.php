<?php

class NivelesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$niveles_info=Niveles::Select(
			'*'
			)
			->get();
		if($niveles_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$niveles_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($toke)
	{
		$params=Input::get();
		$info= array('nombre' => $params['nombre'],
			'descripcion' => $params['descripcion'],
			'estatus' => $params['estatus'];
		$id_niveles=Niveles::InsertGetId($info);
		if ($id_niveles) {
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New ciclo created ID'.$id_niveles));
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
	public function show($token,$id)
	{
		$niveles_info=Niveles::Select(
		'*'
		)
		->where('niveles_academicos.id', $id)
		->first();
		if($niveles_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$niveles_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_by_nocuenta($token,$nocuenta)

	{
		$niveles_info=Niveles::Select(
		'niveles_academicos.*'
		)
		->join('curso', 'curso.nivel', '=', 'niveles_academicos.idnivel')
		->join('alumno', 'curso.idcurso', '=', 'alumno.idcurso' )
		->where('alumno.nocuenta', $nocuenta)
		->first();
		if($niveles_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$niveles_info));
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
	public function update($token)
	{
		$params=Input::get();
		try {
			$id=$params['id'];
			unset($params['id']);

			DB::table('niveles_academicos')
					->where('id', $id)
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
			DB::table('niveles_academicos')->where('id', '=', $id)->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}


}
