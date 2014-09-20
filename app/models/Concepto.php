<?php

class Concepto extends \Eloquent {
	protected $fillable = [];

	public function isValid()
    {
        return Validator::make($this->toArray(),
        	array('concepto'  => 'required|max:50|unique:conceptos',)
        	)->passes();
    }
}