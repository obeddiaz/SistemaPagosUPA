<?php

class CiclosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ciclos_info=Ciclos::getAll();
		if($ciclos_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$ciclos_info));
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
		$params=Input::post();
		$info=array(
				'descripcion'=>$params->descripcion,
				'abreviacion'=>$params->abreviacion
			);
		$id_ciclo=Ciclos::InsertGetId($info);
		if ($id_ciclo) {
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New ciclo created ID'.$id_ciclo));
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
	public function show()
	{
		$params=Input::get();
		$ciclos_info=Ciclos::show($params);
		if($ciclos_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$ciclos_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	public function show_by_nocuenta()
	{
		$params=Input::get();
		$ciclos_info=Ciclos::showByNoCuenta($params);
		if($ciclos_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$ciclos_info));
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
		$params=Input::get();
		try {
			Ciclos::update($params);
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
		$params=Input::post();
		try {
			Ciclos::destroy($params);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}


}	
