<?php

class UsuariosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /usuarios
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /usuarios/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /usuarios
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /usuarios/{id}
	 *
	 * @param  string  $nocuenta
	 * @param  string  $password
	 * @return Response
	 */
	public function show($nocuenta,$password)
	{
		$user=Usuarios::where('alumno.nocuenta', $nocuenta)
			->where('persona.password', '=',hash('md5',$password,false))
			->join('persona', 'alumno.idpersonas', '=', 'persona.idpersonas')
			->select(
				'alumno.nocuenta',
				'persona.nombre',
				'persona.apellidopat',
				'persona.apellidomat',
				'persona.email',
				'persona.password')
		    ->first();
		    //$token = hash('sha256',uniqid(),false);
		    if ($user){
                        $results[] = $user->toArray();
		    	Session::put('user',$results);
		    	return json_encode(Session::all());
		    }
		    else{
		    	return json_encode(array("error"=>"User or password Incorrect"));
		    }
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /usuarios/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /usuarios/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /usuarios/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}