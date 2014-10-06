<?php

class BecasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$becas_info=Becas::getAll();
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
	public function create()
	{
		$params=Input::get();
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

	public function show($params){
		$params=Input::get();
		$becas_info = Becas::showAll($params);
		try {
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$becas_info->get()));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}		
	}

	public function show_by_nocuenta($params)
	{
		$params=Input::get();
		$becas_info = Becas::showByNocuenta($params);
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
	public function update($params)
	{
		$params=Input::get();
		try {
	        Becas::update($params);

		    echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Update'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
		
	}

	public function update_autorizada($params)
	{
		$params=Input::get();
		try {
			Becas::updateAutorizada($params);

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
	public function destroy($id)
	{
		try {
			Becas::destroy($id);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}

	public function destroy_autrizada($nocuenta)
	{
		try {
			Becas::destroyAutorizada($nocuenta);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}
}
