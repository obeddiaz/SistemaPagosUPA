<?php

class Usuarios extends \Eloquent {
	protected $fillable = [];
	protected $table = 'persona';

	public static function getUserAlumno($data)
	{
		$query=Usuarios::Select(
				'alumno.nocuenta',
				'persona.nombre',
				'persona.apellidopat',
				'persona.apellidomat',
				'persona.email',
				'persona.password',
				'persona.alumno_activo',
				'persona.admin_activo',
				'persona.profesor_activo',
				'persona.operativo_activo',
				'persona.externo_activo')
			->join('alumno', 'persona.idpersonas', '=', 'alumno.idpersonas')
			->where('alumno.nocuenta', $data['u'])
			->where('persona.password', '=',hash('md5',$data['p'],false));
		    
	   return $query->first();
	}
	public static function getUserAdminProfesor($data)
	{
		$query=Usuarios::Select(
				'persona.nombre',
				'persona.apellidopat',
				'persona.apellidomat',
				'persona.email',
				'persona.password',
				'persona.alumno_activo',
				'persona.admin_activo',
				'persona.profesor_activo',
				'persona.operativo_activo',
				'persona.externo_activo')
			->where('persona.nombre', $data['u'])
			->where('persona.password', '=',hash('md5',$data['p'],false));
		    
	   return $query->first();	
	}
}