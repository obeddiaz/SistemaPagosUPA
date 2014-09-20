<?php 

class Cobros extends \Eloquent {
	protected $fillable = ['id','descripcion','estatus'];
	protected $table = 'cobros';
}