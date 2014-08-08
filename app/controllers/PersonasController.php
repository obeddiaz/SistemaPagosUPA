<?php

class PersonasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		'This is the controller for manage Personas of the API of the Universidad Politecnica de Aguascalientes';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
		$persona_info=Persona::Select(
												'persona.idpersonas',
												'persona.apellidopat',
												'persona.apellidomat',
												'persona.nombre',
												'persona.fechanaci',
												'persona.curp',
												'persona.sexo',
												'persona.alumno_activo',
												'persona.admin_activo',
												'persona.profesor_activo')
												->where('persona.idpersonas', $id)
												->first();
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}
	public function show_admin()
	{
		$persona_info=Persona::Select(
									'persona.idpersonas',
									'persona.apellidopat',
									'persona.apellidomat',
									'persona.nombre',
									'persona.fechanaci',
									'persona.curp',
									'persona.sexo',
									'admin.idadmin',
									'admin.grado_siglas',
									'admin.fecha_inicio'
									)
									->join('admin', 'persona.idpersonas', '=', 'admin.idpersonas')
									->where('persona.admin_activo','1')
									->get();	
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_admin_by_id($token,$id=null)
	{
			$persona_info=Persona::Select(
									'persona.idpersonas',
									'persona.apellidopat',
									'persona.apellidomat',
									'persona.nombre',
									'persona.fechanaci',
									'persona.curp',
									'persona.sexo',
									'admin.idadmin',
									'admin.grado_siglas',
									'admin.fecha_inicio'
									)
									->join('admin', 'persona.idpersonas', '=', 'admin.idpersonas')
									->where('persona.idpersonas', $id)
									->where('persona.admin_activo','1')
									->first();
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_alumno()
	{
		$persona_info=Persona::Select(
									'persona.idpersonas',
									'persona.apellidopat',
									'persona.apellidomat',
									'persona.nombre',
									'persona.fechanaci',
									'persona.curp',
									'persona.sexo',
									'alumno.nocuenta',
									'alumno.idcurso',
									'alumno.idplan_estudios'
									)
									->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas')
									->where('persona.alumno_activo','1')
									->get();	
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_alumno_by_id($token,$id=null)
	{
		$persona_info=Persona::Select(
									'persona.idpersonas',
									'persona.apellidopat',
									'persona.apellidomat',
									'persona.nombre',
									'persona.fechanaci',
									'persona.curp',
									'persona.sexo',
									'alumno.nocuenta',
									'alumno.idcurso',
									'alumno.idplan_estudios'
									)
									->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas')
									->where('persona.idpersonas', $id)
									->where('persona.alumno_activo','1')
									->get();	
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}
	public function show_maestros($id=null)
	{

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
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
