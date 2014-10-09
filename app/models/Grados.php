<?php

class Grados extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cuatrimestre_cursado';

public static function getAll()
{
        $query=$table->Select('*');
        return $query->get();
}

public static function create($params){
	$query=$table->insert($params);
}

public static function InsertGetId()
{
	$query=$table->insert($info);
}

	public static function show($params)
{
        $query=$table
			->join('beca_tipo','beca_tipo.idbeca_tipo','=','becas_autorizadas.idbeca_tipo')
			->join('alumno','alumno.nocuenta','=','becas_autorizadas.nocuenta')
			->join('estatus_alumno','estatus_alumno.estatus','=','alumno.estatus')
			->join('curso','curso.idcurso','=','alumno.idcurso')
			->join('niveles_academicos','niveles_academicos.idnivel','=','curso.nivel')
			->where('estatus_alumno.estatus', $params->estatus_alumno);
		if($params->niveles_academicos!='TODOS')
			$table->where('niveles_academicos.idnivel', $params->niveles_academicos);
		$table->Select('becas_autorizadas.*','alumno.nocuenta','beca_tipo.beca','estatus_alumno.estatus','niveles_academicos.nombre');
        return $query->get();		
}
	public static function showByNocuenta($nocuenta){
        $query=$table
		->where('cuatrimestre_cursado.nocuenta', $nocuenta)
        return $query->get();
	}

	public static function update($params){
        $query=$table
					->where('nocuenta', $params->nocuenta)
					->where('grado',$params->grado)
	        		->update($params);
	}


	public static function updateAutorizada($params){
        $query=$table
				->where('nocuenta', $params->nocuenta)
	  			->update($params);	
	}

	public static function destroy($params){
        $query=$table
				->where('nocuenta', '=', $params->nocuenta)
				->where('grado', '=', $params->grado)
				->delete();
	}

	public static function destroyAutorizada($nocuenta){
        $query=$table->where('nocuenta', '=', $nocuenta)->delete();
	}	
}