<?php

class Grados extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cuatrimestre_cursado';

public static function getAll()
{
	$table->get();
}

public static function create($params){
	$table->insert($params);
}

public static function InsertGetId()
{
		$table->insert($info);
}

	public static function show($params)
{
		$table
			->join('beca_tipo','beca_tipo.idbeca_tipo','=','becas_autorizadas.idbeca_tipo')
			->join('alumno','alumno.nocuenta','=','becas_autorizadas.nocuenta')
			->join('estatus_alumno','estatus_alumno.estatus','=','alumno.estatus')
			->join('curso','curso.idcurso','=','alumno.idcurso')
			->join('niveles_academicos','niveles_academicos.idnivel','=','curso.nivel')
			->where('estatus_alumno.estatus', $params->estatus_alumno);
		if($params->niveles_academicos!='TODOS')
			$table->where('niveles_academicos.idnivel', $params->niveles_academicos);
		$table->Select('becas_autorizadas.*','alumno.nocuenta','beca_tipo.beca','estatus_alumno.estatus','niveles_academicos.nombre');
		
}
	public static function showByNocuenta($nocuenta){
		$table
		->where('cuatrimestre_cursado.nocuenta', $nocuenta)
		->get();
	}

	public static function update($params){
			$table
					->where('nocuenta', $params->nocuenta)
					->where('grado',$params->grado)
	        		->update($params);
	}


	public static function updateAutorizada($params){
			$table
				->where('nocuenta', $params->nocuenta)
	  			->update($params);	
	}

	public static function destroy($params){
			$table
				->where('nocuenta', '=', $params->nocuenta)
				->where('grado', '=', $params->grado)
				->delete();
	}

	public static function destroyAutorizada($nocuenta){
			$table->where('nocuenta', '=', $nocuenta)->delete();
	}	
}