<?php

class PersonasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
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
							->get();
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
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
	public function show($id)
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
	public function show_admin($id=null)
	{
		$persona=new Persona;
		$persona_info=$persona->Select(
									'persona.idpersonas',
									'persona.apellidopat',
									'persona.apellidomat',
									'persona.nombre',
									'persona.fechanaci',
									'persona.curp',
									'persona.sexo',
									'admin.idadmin',
									'admin.grado_siglas',
									'admin.fecha_inicio')
									->join('admin', 'persona.idpersonas', '=', 'admin.idpersonas')
									->where('persona.admin_activo','1');	
		if(!is_null($id))
		{
				$persona_info=$persona_info->where('persona.idpersonas', $id);
		} 

		if($persona_info->get())
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info->get()));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}

	}

	public function show_alumno($id=null)
	{
		$persona=new Persona;
		$persona_info=$persona->Select(
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
					->where('persona.alumno_activo','1');
		if(!is_null($id))
		{
				$persona_info=$persona_info->where('persona.idpersonas', $id);
		}  

		if($persona_info->get())
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info->get()));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_alumno_by_nocuenta($nocuenta)
	{
		$persona=DB::table('persona');
		$persona_info=$persona->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas')
					->where('alumno.nocuenta',$nocuenta)
					->Select(
					'persona.idpersonas',
					'persona.apellidopat',
					'persona.apellidomat',
					'persona.nombre',
					'persona.fechanaci',
					'persona.curp',
					'persona.sexo',
					'alumno.nocuenta',
					'alumno.idcurso',
					'alumno.idplan_estudios',
					DB::raw('concat(nombre," ",apellidopat," ",apellidomat) as nombre_completo')
					);


		
		  

		if($persona_info->get())
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info->get()));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	public function show_alumno_by_nombre()
	{
		$params=Input::get();
		$persona=DB::table('persona');
		$persona_info=$persona->Select(
					'alumno.nocuenta as matricula',
					'alumno.estatus as situacion',
					db::raw('concat(persona.nombre," ",persona.apellidopat," ",persona.apellidomat) as nombre')
					)
					->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas');
		if (isset($params['nombre'])&&$params['nombre']!="") {
			$persona_info=$persona_info->where('persona.nombre','LIKE','%'.$params['nombre'].'%');
		}
		if (isset($params['apellidopat'])&&$params['apellidopat']!="") {
			$persona_info=$persona_info->where('persona.apellidopat',$params['apellidopat']);
		}
					
		if(isset($params['apellidomat'])&&$params['apellidomat']!="")
		{
			$persona_info=$persona_info->where('persona.apellidomat',$params['apellidomat']);
		}
					

		if($persona_info->get())
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info->get()));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_profesor($id=null)
	{
			$persona=new Persona;
			$persona_info=$persona->Select(
						'persona.idpersonas',
						'persona.apellidopat',
						'persona.apellidomat',
						'persona.nombre',
						'persona.fechanaci',
						'persona.curp',
						'persona.sexo',
						'profesor.idprofesor',
						'profesor.idupa',
						'profesor.cargo',
						'profesor.grado',
						'profesor.grado_siglas',
						'profesor.tipo_cont'
						)
					->join('profesor', 'persona.idpersonas', '=', 'profesor.idpersonas')
					->where('persona.profesor_activo','1');
		if(!is_null($id))
		{
				$persona_info=$persona_info->where('persona.idpersonas', $id);
		}  

		if($persona_info->get())
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info->get()));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
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
