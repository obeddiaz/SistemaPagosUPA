<?php

class CobrosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cobros_info=Cobros::all();
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
	public function create($toke,$params)
	{
		$info_new=array(
			'descripcion'=>$params->descripcion ,
			'estatus'=>$params->estatus
			);
		try {
			Cobros::create($info_new);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New cobro created ID'));
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
	public function show($token,$id)
	{
		$cobro_info=Cobros::find($id);	
		if($cobro_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobro_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_estado_de_cuenta($token,$params)
	{
		$params=json_decode($params);
		$alumnos_cobros= DB::table('alumnos_cobros')
				->join('alumno', 'alumnos_cobros.nocuenta', '=','alumno.nocuenta')
				->join('cobros', 'alumnos_cobros.cobros_id', '=','cobros.id_cobro')
				->join('mes_ciclo', 'alumnos_cobros.mes_ciclo_id', '=','mes_ciclo.id')
				->join('curso', 'alumno.idcurso', '=','curso.idcurso')
				->join('niveles_academicos', 'curso.nivel', '=','niveles_academicos.idnivel')
				->where('alumnos_cobros.nocuenta', $params->nocuenta)
				->where('alumnos_cobros.ciclos_id', $params->ciclosid)
				->Select("alumnos_cobros.id as id",
					"alumnos_cobros.fecha_limite as fecha_limite",
					"cobros.monto as monto",
					"alumno.promanterior as promedio",
					"alumnos_cobros.id_beca_autorizada as id_beca_autorizada",
					db::raw("UPPER(concat(cobros.descripcion,'-',cobros.descripcion,' ',niveles_academicos.nombre,' ',mes_ciclo.mes)) as concepto_cobro"))->get();

		$cobros_info=Ensamble_estado_de_cuenta($alumnos_cobros);

		if($cobros_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobros_info));
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
	public function update($token,$params)
	{
		try {
			$id=$params->id;
			unset($params->id);

			DB::table('cobroa')
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
			DB::table('cobros')->where('id', '=', $id)->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}



}	
