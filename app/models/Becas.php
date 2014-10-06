<?php

class Becas extends \Eloquent {
	protected $fillable = [];
	protected $table = 'beca_tipo';

public static function getAll()
{
		$table->get();
}


public static function InsertGetId()
{
		$table->insert($info);
}

	public static function show($params)
{
		$becas_info=$table
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
	public static function showByNocuenta($params){
		$becas_info=$table
			->join('becas_autorizadas', 'beca_porcentaje.idbeca_tipo', '=','becas_autorizadas.idbeca_tipo')
			->where('becas_autorizadas.nocuenta', $params->nocuenta)
			->where('beca_porcentaje.calificacion_inicial','<=' ,$params->promedio)
			->where('beca_porcentaje.calificacion_final','>=' ,$params->promedio)
			->Select('becas_autorizadas.*','beca_porcentaje.porcentaje as porcentaje')
			->get();
	}

	public static function update($params){
		$table
			->where('id', $params->id)
	        ->update($params);	
	}


	public static function updateAutorizada($params){
			$table
				->where('nocuenta', $params->nocuenta)
	  			->update($params);	
	}

	public static function destroy($id){
			$table->where('id', '=', $id)->delete();
	}

	public static function destroyAutorizada($nocuenta){
			$table->where('nocuenta', '=', $nocuenta)->delete();
	}


}