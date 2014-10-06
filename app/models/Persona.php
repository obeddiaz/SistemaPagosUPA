<?php

class Persona extends \Eloquent {
	protected $fillable = [];
	protected $table = 'persona';

	public static function getAllPersonas()
	{
		$query=Persona::Select(
			'persona.idpersonas',
			'persona.apellidopat',
			'persona.apellidomat',
			'persona.nombre',
			'persona.fechanaci',
			'persona.curp',
			'persona.sexo',
			'persona.alumno_activo',
			'persona.admin_activo',
			'persona.profesor_activo');

		return $query->get();
	}
	public static function getPersonasByIDPersonas($id)
	{
		$query=Persona::Select(
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
			->where('persona.idpersonas', $id);

		return $query->first();
	}

	public static function getProfesor($data)
	{
		$persona=new Persona;
		$query=$persona->Select(
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

		if(isset($data['idProfesor']))
		{
			$query=$query->where('profesor.idprofesor', $data['idProfesor']);
		} 


		if(isset($data['idPersona']))
		{
			$query=$query->where('persona.idpersonas', $data['idPersona']);
		} 

		return $query->get();
	}

	public static function getAdmin($data)
	{
		$persona=new Persona;
		$query=$persona->Select(
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

		if(isset($data['idAdmin']))
		{
			$query=$query->where('admin.idadmin', $data['idAdmin']);
		} 

		if(isset($data['idPersona']))
		{
			$query=$query->where('persona.idpersonas', $data['idPersona']);
		} 
		return $query->get();
	}

	public static function getAlumno($data)
	{
		$persona=new Persona;
		$query=$persona->Select(
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

		if(isset($data['nocuenta']))
		{
			$query=$query->where('alumno.nocuenta', $data['nocuenta']);
		} 


		if(isset($data['idPersona']))
		{
			$query=$query->where('persona.idpersonas', $data['idPersona']);
		} 

		return $query->get();

	}

	public static function getAlumnoByNombre($data)
	{
		$persona=DB::table('persona');
		$query=$persona->Select(
					'alumno.nocuenta as matricula',
					'alumno.estatus as situacion',
					DB::raw('concat(persona.nombre," ",persona.apellidopat," ",persona.apellidomat) as nombre')
					)
					->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas');

		if (isset($data['nombre'])&&$data['nombre']!="") {
			$persona=$persona->where('persona.nombre','LIKE','%'.$data['nombre'].'%');
		}

		if (isset($data['apellidopat'])&&$data['apellidopat']!="") {
			$persona=$persona->where('persona.apellidopat',$data['apellidopat']);
		}
					
		if(isset($data['apellidomat'])&&$data['apellidomat']!="")
		{
			$persona=$persona->where('persona.apellidomat',$data['apellidomat']);
		}

		return $query->get();

	}
}