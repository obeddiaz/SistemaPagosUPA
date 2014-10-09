<?php

class Ciclos extends \Eloquent {

    protected $fillable = [];
    protected $table = 'ciclos';

    public static function getAll() {
        $query=$table->Select('*');
        return $query->get();
    }

    public static function get($params) {
        $query=$table
                ->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=', 'ciclos.id')
                ->where('cuatrimestre_cursado.nocuenta', $params->nocuenta);
        return $query->get();
    }

    public static function InsertGetId() {
        $table->insert($info);
    }

    public static function show($params) {
        $query=DB::table('ciclos')
                ->Select('*')
                ->where('ciclos.id', $params['id']);
        return $query->get();
    }

    public static function showByNocuenta($params) {
        $query=$table
                ->join('cuatrimestre_cursado', 'cuatrimestre_cursado.idciclo', '=', 'ciclos.id')
                ->where('cuatrimestre_cursado.nocuenta', $params->nocuenta);
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
