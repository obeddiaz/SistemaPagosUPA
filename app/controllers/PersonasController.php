<?php

class PersonasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$persona_info=Persona::getAllPersonas();
		if($persona_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$params=Input::get();

		if (isset($params['id'])) {
			$persona_info=Persona::getPersonasByIDPersonas($params['id']);
			if($persona_info)
			{
				echo json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
			} else {
				echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));
		}

	}
	public function show_admin()
	{
		$params=Input::get();

		$persona_info=Persona::getAdmin($params);

		if($persona_info)
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}

	}

	public function show_alumno()
	{
		$params=Input::get();

		$persona_info=Persona::getAlumno($params);	

		if($persona_info)
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_alumno_by_nombre()
	{
		$params=Input::get();

		$persona_info=Persona::getAlumnoByNombre($params);

		if (isset($params)) {
			if($persona_info)
			{
				return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
			} else {
				return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
			}
		} else {
			echo json_encode(array('error' => true,'messsage'=>'Parameters missing','response'=>''));	
		}

	}

	public function show_profesor($id=null)
	{
		$params=Input::get();

		$persona_info=Persona::getProfesor($params);	

		if($persona_info)
		{
			return json_encode(array('error' => false,'messsage'=>'','response'=>$persona_info));
		} else {
			return json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for editing the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
