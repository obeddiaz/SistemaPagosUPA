<?php

class Ciclos extends \Eloquent {
	protected $fillable = [];
	protected $table = 'ciclos';

public static function getAll()
{
	$table->get();
}

public static function get($params){
	$table
		->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=','ciclos.id')
		->where('cuatrimestre_cursado.nocuenta', $params->nocuenta)
		->get();
}


public static function InsertGetId()
{
	$table->insert($info);

}

	public static function show($params)
{
		$becas_info=$table
		->where('ciclos.id', $params->id)
		->first();		
}
	public static function showByNocuenta($params){
		$becas_info=$table
		->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=','ciclos.id')
		->where('cuatrimestre_cursado.nocuenta', $params->nocuenta)
		->get();
	}

	public static function update($params){
		$table
			->where('id', $params->id)
	        ->update($params);	
	}

	public static function destroy($id){
			$table->where('id', '=', $id)->delete();
	}

}