<?php

class GradosController extends \BaseController {

	public function index()
	{
		$cuatrimestre_cursado=Grados::Select(
			'*')
			->get();
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
	public function create($toke,$params)
	{
		try {
			$info=array(
				'nocuenta'=>$params->nocuenta,
				'idcurso'=>$params->idcurso,
				'grado'=>$params->grado
			);
			DB::table('cuatrimestre_cursado')->Insert($info);
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

	public function show_by_nocuenta($token,$nocuenta)
	{

		$cuatrimestre_info=Grados::Select(
		'*'
		)
		->where('cuatrimestre_cursado.nocuenta', $nocuenta)
		->get();
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
	public function update($token,$params)
	{
		try {
			$nocuenta=$params->nocuenta;
			unset($params->nocuenta);

			DB::table('cuatrimestre_cursado')
					->where('nocuenta', $nocuenta)
					->where('grado',$params['grado'])
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
	public function destroy($token,$params)
	{
		try {
			DB::table('cuatrimestre_cursado')
				->where('nocuenta', '=', $params->nocuenta)
				->where('grado', '=', $params->grado)
				->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}

}
