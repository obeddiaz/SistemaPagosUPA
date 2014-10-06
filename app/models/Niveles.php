<?php

class Niveles extends \Eloquent {
	protected $fillable = [];
	protected $table = 'niveles_academicos';

	public static function getNivelesbyNocuenta($nocuenta){
		$query=Niveles::Select('niveles_academicos.*')
			->join('curso', 'curso.nivel', '=', 'niveles_academicos.idnivel')
			->join('alumno', 'curso.idcurso', '=', 'alumno.idcurso' )
			->where('alumno.nocuenta', $nocuenta);
		return $query->first();
	}

	public static function updateNivelAcademico($data)
	{
		$query=Niveles::where('id', $data['id'])
	        ->update($data);
	}
	public static function deleteNivelAcademico($data)
	{
		$query=Niveles::where('id', '=', $data['id'])->delete();
	}
}