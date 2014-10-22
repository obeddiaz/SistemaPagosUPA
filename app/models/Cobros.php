<?php

class Cobros extends \Eloquent {

    protected $fillable = ['id', 'descripcion', 'estatus'];
    protected $table = 'cobros';
    protected $tbl_alumnos = 'alumnos_cobros';
    protected $tbl_cuatrimeste = 'cuatrimestre_cursado';

    public static function getAll() {
        $query=$table->Select('*');
        return $query->get();
    }

    public static function create($params) {
         $query=$table->insert($params);
    }

    public static function create_alumno($info_new) {
         $query=$tbl_alumnos
                ->insertGetId($info_new);
    }

    public static function getReferenciaInfo() {
        $query=$tbl_alumnos
                ->join('cobros', 'alumnos_cobros.cobros_id', '=', 'cobros.id_cobro')
                ->join('alumno', 'alumnos_cobros.nocuenta', '=', 'alumno.nocuenta')
                ->join('curso', 'curso.idcurso', '=', 'alumno.idcurso')
                ->where('alumnos_cobros.id', '=', $new_id)
                ->Select('curso.nombre_corto as nombre', 'cobros.monto as monto', db::raw("UPPER(cobros.descripcion) as des"));
        return $query->get();
    }

    public static function setReferencia($info_referencia) {
         $query=$tbl_alumnos
                ->where('id', $info_referencia['id'])
                ->update($info_referencia);
    }

    public static function find($id) {
        $query= $table
                ->where('id', $id);
        return $query->get();
    }

    public static function get($params) {
        $query= $table
                ->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=', 'ciclos.id')
                ->where('cuatrimestre_cursado.nocuenta', $params->nocuenta);
        return $query->get();
    }

    public static function getGradoCiclo($params) {
        $query= DB::table('cuatrimestre_cursado')
                ->join('ciclos', 'cuatrimestre_cursado.idciclo', '=', 'ciclos.id')
                ->where('cuatrimestre_cursado.nocuenta', $params->nocuenta)
                ->Select(
                        db::raw("max(cuatrimestre_cursado.grado) as grado"), db::raw('max(cuatrimestre_cursado.idciclo) as ciclo'));
                return $query->get();
    }

    public static function getEdoCuenta($params) {
        $query=DB::table('alumnos_cobros')
                ->join('alumno', 'alumnos_cobros.nocuenta', '=', 'alumno.nocuenta')
                ->join('cobros', 'alumnos_cobros.cobros_id', '=', 'cobros.id_cobro')
                ->join('mes_ciclo', 'alumnos_cobros.mes_ciclo_id', '=', 'mes_ciclo.id')
                ->join('curso', 'alumno.idcurso', '=', 'curso.idcurso')
                ->join('niveles_academicos', 'curso.nivel', '=', 'niveles_academicos.idnivel')
                ->where('alumnos_cobros.nocuenta', $params['nocuenta'])
                ->where('alumnos_cobros.ciclos_id', $params['ciclosid'])
                ->Select("alumnos_cobros.id as id", "alumnos_cobros.fecha_limite as fecha_limite", "cobros.monto as monto", "alumno.promanterior as promedio", "alumnos_cobros.id_beca_autorizada as id_beca_autorizada", db::raw("UPPER(concat(cobros.descripcion,'-',cobros.descripcion,' ',niveles_academicos.nombre,' ',mes_ciclo.mes)) as concepto_cobro"));
                return $query->get();
    }

    public static function getCiclos($params) {
        $table->insert($info);
        $query=DB::table('cuatrimestre_cursado')
                ->join('ciclos', 'cuatrimestre_cursado.idciclo', '=', 'ciclos.id')
                ->where('cuatrimestre_cursado.nocuenta', '=', $params->nocuenta)
                ->Select('ciclos.id as ciclos_id', 'ciclos.abreviacion as ciclo');
                return $query->get();
    }

    public static function getInfoAlumno($params) {
        $query=DB::table('alumno')
        ->join('cuatrimestre_cursado', 'alumno.nocuenta', '=', 'cuatrimestre_cursado.nocuenta')
        ->join('curso', 'alumno.idcurso', '=', 'curso.idcurso')
        ->join('niveles_academicos', 'curso.nivel', '=', 'niveles_academicos.nombre')
        ->join('persona', 'alumno.idpersonas', '=', 'persona.idpersonas')
        ->where('alumno.nocuenta', '=', $params->nocuenta)
        ->Select(
                        'niveles_academicos.nombre as nivel', 'alumno.promanterior as promedio', db::raw('max(cuatrimestre_cursado.grado) as grado'), db::raw('concat(persona.nombre," ",persona.apellidopat," ",persona.apellidomat) as nombre')
                );
        return $query->get();
    }

    public static function getBecaAutorizada($params) {
         $query=DB::table('becas_autorizadas')
                ->where('becas_autorizadas.nocuenta', '=', $params->nocuenta)
                ->Select('becas_autorizadas.idbecas_autorizadas as id');
        return $query->get();
    }

    public static function getPorcentajeBeca($params) {
        $query=DB::table('beca_porcentaje')
                ->join('becas_autorizadas', 'beca_porcentaje.idbeca_tipo', '=', 'becas_autorizadas.idbeca_tipo')
                ->join('beca_tipo', 'beca_porcentaje.idbeca_tipo', '=', 'beca_tipo.idbeca_tipo')
                ->where('becas_autorizadas.idbecas_autorizadas', $beca_autorizada[0]->id)
                ->where('beca_porcentaje.calificacion_inicial', '<=', $info_alum[0]->promedio)
                ->where('beca_porcentaje.calificacion_final', '>=', $info_alum[0]->promedio)
                ->Select('beca_porcentaje.porcentaje as porcentaje', 'beca_tipo.beca as tipo', 'becas_autorizadas.estatus as estatus');
        return $query->get();
    }

    public static function update($params) {
        $query=$table
                ->where('id', $params->id)
                ->update($params);
    }

    public static function destroy($id) {
        $query=$table->where('id', '=', $id)->delete();
    }

}
