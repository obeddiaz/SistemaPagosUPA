<?php

class SubConceptosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /subconceptos
	 *
	 * @return Response
	 */
	public function index()
	{

	}

	/**
	 * Show the form for creating a new resource.
	 * POST /sub_conceptos/create/{id}
	 *
	 * @return Response
	 */
	public function create($token,$id_concepto)
	{
		$sub_concepto = new SubConcepto;
		$sub_concepto->sub_concepto=Input::get('sub_concepto');
		$sub_concepto->importe=Input::get('importe');
		$sub_concepto->concepto_id=$id_concepto;
		if (!$sub_concepto->isValid()){
			return json_encode(array("error"=>true,"message"=>"Datos incorrectos o registro duplicado, Favor de verificar"));
		}else{
			$sub_concepto->save();
			return json_encode($sub_concepto);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /subconceptos
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /subconceptos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /subconceptos/{id}/edit
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
	 * PUT /subconceptos/{id}
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
	 * DELETE /subconceptos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}