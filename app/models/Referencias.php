<?php

class Referencias extends \Eloquent {
	protected $fillable = [];
	protected $table = 'referencias';

	public static function getAll($data)
	{
        $query=$table->Select('*');
        return $query->get();
	}

	public static function get($id){
        $query= $table
                ->where('id', $id);
        return $query->get();
	}

	public static function create($params){
		$query=$table->insert($params);

	}

	public static function update($id, $data){
        $query= $table
                ->where('id', $id)
                ->update($data);
	}	

}