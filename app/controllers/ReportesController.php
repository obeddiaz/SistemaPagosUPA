<?php

class ReportesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /reportes
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reportes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reportes
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}
	/**
	 * Display the specified resource.
	 * GET /reportes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show_nocueta_adeudos()
	{
		$params=Input::get();
		$matriculas_adeudos=Reportes::getMatriculasAdeudos($params);
		foreach ($matriculas_adeudos as $key => $value) {
			if ($matriculas_adeudos[$key]->nombre=='LICENCIATURA') {
			 	$data_reporte['Nivel']['LICENCIATURA']['MATRICULAS'][]=$value->nocuenta;
			 } else {
			 	$data_reporte['Nivel']['MAESTRIA']['MATRICULAS'][]=$value->nocuenta;
			 }
		}
		$data_reporte['Nivel']['LICENCIATURA']['TOTAL']=count($data_reporte['Nivel']['LICENCIATURA']['MATRICULAS']);
		$data_reporte['Nivel']['MAESTRIA']['TOTAL']=count($data_reporte['Nivel']['MAESTRIA']['MATRICULAS']);
		$data_reporte['Total']=$data_reporte['Nivel']['MAESTRIA']['TOTAL']+$data_reporte['Nivel']['LICENCIATURA']['TOTAL'];
		if(isset($data_reporte))
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$data_reporte));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
		#$reporte_codigo=CreateMatriculas($data_reporte);
		#return  $reporte_codigo;
		#return PDF::load($reporte_codigo, 'A4', 'portrait')->show();
	}
	public function show_alumnos_adeudos()
	{
		//
	}
	public function show_carta_adeudos()
	{
		//
	}
	public function show_carta_no_adeudos()
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /reportes/{id}/edit
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
	 * PUT /reportes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /reportes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}