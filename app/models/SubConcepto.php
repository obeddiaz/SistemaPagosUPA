<?php

class SubConcepto extends \Eloquent {
	protected $fillable = [];
	protected $table = 'up_sub_conceptos';
	public function isValid()
    {
        return Validator::make($this->toArray(),
        	array('sub_concepto'  => 'required|unique:up_sub_conceptos',
        		'concepto_id'=>'required|exists:conceptos,id',
        		'importe'=>'required|numeric')
        	)->passes();
    }
}