<?php

class CiclosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ciclos_info=Ciclos::Select(
			'*'
			)
			->get();
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
	public function create($toke)
	{
		$params=Input::post();
		$info=array(
				'descripcion'=>$params['descripcion'],
				'abreviacion'=>$params['abreviacion']
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
	public function show($token)
	{
		$params=Input::get();
		$ciclos_info=Ciclos::Select(
		'*'
		)
		->where('ciclos.id', $params['id'])
		->first();
		if($ciclos_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$ciclos_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	public function show_by_nocuenta($token)
	{
		$params=Input::get();
		$ciclos_info=Ciclos::Select(
		'ciclos.*'
		)
		->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=','ciclos.id')
		->where('cuatrimestre_cursado.nocuenta', $params['nocuenta'])
		->get();
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
	public function update($token)
	{
		$params=Input::post();
		try {
			DB::table('ciclos')
				->where('id', $params['id'])
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
	public function destroy($token)
	{
		$params=Input::post();
		try {
			DB::table('ciclos')->where('id', '=', $params['id'])->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}


}	
