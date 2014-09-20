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
		$params=json_decode($params);
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

<<<<<<< HEAD
	public function create_alumno($toke,$params)
=======
	public function create_alumno($toke,params)
>>>>>>> 4b175ee7373ee7e73989df778345852f83acc5c0
	{
		$params=json_decode($params);
		$info_new=array(
			'subconceptos_id'=>$params->subconceptos_id,
			'nocuenta'=>$params->nocuenta,
			'ciclos_id'=>$params->ciclos_id,
			'mes_ciclo_id'=>$params->mes_ciclo_id,
			'id_beca_autorizada'=>$params->id_beca_autorizada,
			'fecha_solicitud'=>$params->fecha_solicitud,
			'fecha_limite'=>$params->fecha_limite
		);
		try {
			$new_id=DB::table('alumnos_cobros')->insertGetId($info_new);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New alumnos_cobros created ID:'.$new_id));
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

	public function show_estado_de_cuenta($token)
	{
		//$params=json_decode($params);
		//var_dump(Input::get());
		//$referencias=new Referencias();
		//var_dump($referencias->generar('ISEI','UP100682', 'INS', '225', '31-25-2014'));
		$alumnos_cobros= DB::table('alumnos_cobros')
				->join('alumno', 'alumnos_cobros.nocuenta', '=','alumno.nocuenta')
				->join('cobros', 'alumnos_cobros.cobros_id', '=','cobros.id_cobro')
				->join('mes_ciclo', 'alumnos_cobros.mes_ciclo_id', '=','mes_ciclo.id')
				->join('curso', 'alumno.idcurso', '=','curso.idcurso')
				->join('niveles_academicos', 'curso.nivel', '=','niveles_academicos.idnivel')
				->where('alumnos_cobros.nocuenta', Input::get('nocuenta'))
				->where('alumnos_cobros.ciclos_id', Input::get('ciclosid'))
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
	public function update($token)
	{
		$params=json_decode($params);
		try {
			$id=Input::get('id');
			DB::table('cobroa')
					->where('id', $id)
	        		->update(Input::except('id'));
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
