<?php

class GradosController extends \BaseController {

	public function index()
	{
		$cuatrimestre_cursado=Grados::getAll();
		if($cuatrimestre_cursado)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cuatrimestre_cursado));
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
		try {
			$info=array(
				'nocuenta'=>$params->nocuenta,
				'idcurso'=>$params->idcurso,
				'grado'=>$params->grado
			);
			Grados::create($info);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New cuatrimestre cursado'));	
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
	public function show($id)
	{
		//
	}

	public function show_by_nocuenta($nocuenta)
	{

		$cuatrimestre_info=Grados::showByNocuenta($nocuenta);

		if($cuatrimestre_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cuatrimestre_info));
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

/*	public function show_grado_by_nocuenta($token,$nocuenta)
	{
		$cuatrimestre_info=Grados::Select(
		'MAX(grado)'
		)
		->where('cuatrimestre_cursado.nocuenta', $nocuenta)
		->first();

		if($cuatrimestre_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cuatrimestre_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	} */


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
		Grados::update($params);
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
	public function destroy($params)
	{
		$params=Input::get();
		try {
			Grados::destroy($params);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}

}
