<?php

class Reportes extends \Eloquent {
	protected $fillable = [];

	public static function getMatriculasAdeudos($data)
	{
		$table=DB::table('alumno');
		$query=$table->join('alumnos_cobros','alumno.nocuenta','=','alumnos_cobros.nocuenta')
	    		->join('referencia','alumnos_cobros.id','=','referencia.alumnos_cobros_id')
	    		->join('curso', 'alumno.idcurso', '=','curso.idcurso')
				->join('niveles_academicos', 'curso.nivel', '=','niveles_academicos.idnivel')
				->join('ciclos','alumnos_cobros.ciclos_id','=','ciclos.id')
			    ->where('referencia.estatus',0);
		if (isset($data['nivelid'])) {
			$query=$query->where('curso.nivel',$data['nivelid'] );
		}
		if (isset($data['ciclosid'])) {
			$query=$query->where('alumnos_cobros.ciclos_id',$data['ciclosid']);
		}
		$query=$query->select('alumno.nocuenta','niveles_academicos.nombre')->distinct();
	    return $query->get();
	}
}