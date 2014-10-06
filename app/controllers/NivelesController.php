<?php

class NivelesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$niveles_info=Niveles::all();
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
	public function create()
	{
		$params=Input::get();

		$info= array('nombre' => $params['nombre'],
			'descripcion' => $params['descripcion'],
			'estatus' => $params['estatus']);

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
	public function show($id)
	{
		$params=Input::get();
		if (isset($params['id'])) {
			$niveles_info=Niveles::find($params['id']);
			if($niveles_info)
			{
				echo json_encode(array('error' => false,'messsage'=>'','response'=>$niveles_info));
			} else {
				echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));
		}
	}

	public function show_by_nocuenta()
	{
		$params=Input::get();
		if (isset($params['nocuenta'])) 
		{
			$niveles_info=Niveles::getNivelesbyNocuenta($params['nocuenta']);
			if($niveles_info)
			{
				echo json_encode(array('error' => false,'messsage'=>'','response'=>$niveles_info));
			} else {
				echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));	
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
		$params=Input::get();
		if (isset($params['id'])) {
			try {
				Niveles::updateNiveleAcademico($params);
			    echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Update'));
			} catch (Exception $e) {
				echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));		
		}
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$params=Input::get();
		if (isset($params['id'])) {
			try {
				Niveles::deleteNivelAcademico($params);
				echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
			} catch (Exception $e) {
				echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));		
		}

	}


}
