<?php

class ConceptosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /conceptos
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /conceptos/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /conceptos
	 *
	 * @return Response
	 */
	public function store()
	{
		$concepto = new Concepto;
		$concepto->concepto=Input::get('concepto');
		if (!$concepto->isValid()){
			return json_encode(array("error"=>true,"message"=>"Nombre de concepto ya existente"));
		}else{
			$concepto->save();
			return json_encode($concepto);
		}
	}

	/**
	 * Display the specified resource.
	 * GET /conceptos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$show_subconceptos = new SubConcepto;
		$show_subconceptos->where('concepto_id','=',$id)->get();
		//var_dump($show_subconceptos->where('concepto_id','=',$id)->get());
		//echo "hola";
		return json_encode($show_subconceptos->select('sub_concepto','importe')->where('concepto_id','=',$id)->get());
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /conceptos/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $id;
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /conceptos/{id}
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
	 * DELETE /conceptos/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$concepto = new Concepto;
		if (!is_null($concepto->find($id))) {
			$concepto->destroy($id);
			return json_encode(array("error"=>false,"message"=>"El concepto fue eliminado correctamente"));
		}
		else{
			return json_encode(array("error"=>true,"message"=>"El concepto no puede ser encontrado, favor de verificarlo"));
		}
		//Route::getCurrentRoute()->getParameter('document')
	}

}