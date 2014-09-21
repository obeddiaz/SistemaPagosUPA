<?php

class CobrosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cobros_info=Cobros::all();
		if($cobros_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobros_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($token)
	{

		$params=Input::get();
		$info_new=array(
			'descripcion'=>$params['descripcion '],
			'estatus'=>$params['estatus']
			);
		try {
			Cobros::create($info_new);
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New cobro created ID'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));
		}
	}

	public function create_alumno($token)
	{
		$params=Input::get();
		//var_dump(json_decode($params['id_beca_autorizada']));die();
		$info_new=array(
			'subconceptos_id'=>$params['subconceptos_id'],
			'nocuenta'=>$params['nocuenta'],
			'ciclos_id'=>$params['ciclos_id'],
			'mes_ciclo_id'=>$params['mes_ciclo_id'],
			'id_beca_autorizada'=>json_decode($params['id_beca_autorizada']),
			'fecha_solicitud'=>$params['fecha_solicitud'],
			'fecha_limite'=>$params['fecha_limite'],
			'cobros_id'=>$params['cobros_id']
		);
		try {
			$new_id=DB::table('alumnos_cobros')->insertGetId($info_new);
			$ref_info_query=DB::table('alumnos_cobros')
				->join('cobros', 'alumnos_cobros.cobros_id', '=','cobros.id_cobro')
				->join('alumno', 'alumnos_cobros.nocuenta', '=','alumno.nocuenta')
				->join('curso', 'curso.idcurso', '=','alumno.idcurso')
				->where('alumnos_cobros.id','=',$new_id)
				->Select('curso.nombre_corto as nombre',
						 'cobros.monto as monto',
						 db::raw("UPPER(cobros.descripcion) as des"))
				->get();

				
			$referencias_library=new Referencias(); 
			$referencia=$referencias_library->generar(
				$ref_info_query[0]->nombre,
				$params['nocuenta'], 
				$ref_info_query[0]->des,
				$ref_info_query[0]->monto,
				date("Y-m-d H:i:s")
			);
			$info_referencia=array(
				'referencia' => $referencia, 
				'recargo'=> 0 ,
				'descuento'=> 0,
				'estatus' => 0,
				'fecha_pago' => null,
				'saldo'=> 0,
				'alumnos_cobros_id' => $new_id
			);
			setReferencia($info_referencia);
			
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'New alumnos_cobros created ID:'.$new_id));
	} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
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
	public function show($token)
	{
		$params=Input::get();
		$cobro_info=Cobros::find($params['id']);	
		if($cobro_info)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobro_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}

	public function show_estado_de_cuenta($token)
	{
		$params=Input::get();
		if (isset($params['nocuenta']) && isset($params['ciclosid'])) 
		{
		
				$alumnos_cobros= DB::table('alumnos_cobros')
				->join('alumno', 'alumnos_cobros.nocuenta', '=','alumno.nocuenta')
				->join('cobros', 'alumnos_cobros.cobros_id', '=','cobros.id_cobro')
				->join('mes_ciclo', 'alumnos_cobros.mes_ciclo_id', '=','mes_ciclo.id')
				->join('curso', 'alumno.idcurso', '=','curso.idcurso')
				->join('niveles_academicos', 'curso.nivel', '=','niveles_academicos.idnivel')
				->where('alumnos_cobros.nocuenta', $params['nocuenta'])
				->where('alumnos_cobros.ciclos_id', $params['ciclosid'])
				->Select("alumnos_cobros.id as id",
					"alumnos_cobros.fecha_limite as fecha_limite",
					"cobros.monto as monto",
					"alumno.promanterior as promedio",
					"alumnos_cobros.id_beca_autorizada as id_beca_autorizada",
					db::raw("UPPER(concat(cobros.descripcion,'-',cobros.descripcion,' ',niveles_academicos.nombre,' ',mes_ciclo.mes)) as concepto_cobro"))
				->get();
		}
		if($alumnos_cobros)
		{
			$cobros_info=Ensamble_estado_de_cuenta($alumnos_cobros);
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$cobros_info));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
		}
	}
	public function show_info_alumno_estado_de_cuenta($token)
	{
		$params=Input::get();
		$ciclos=DB::table('cuatrimestre_cursado')
			->join('ciclos','cuatrimestre_cursado.idciclo','=','ciclos.id')
			->where('cuatrimestre_cursado.nocuenta','=',$params['nocuenta'])
			->Select('ciclos.id as ciclos_id','ciclos.abreviacion as ciclo')
			->get();

		$info_alum=DB::table('alumno')
			->join('cuatrimestre_cursado','alumno.nocuenta','=','cuatrimestre_cursado.nocuenta')
			->join('curso', 'alumno.idcurso', '=','curso.idcurso')
			->join('niveles_academicos', 'curso.nivel', '=','niveles_academicos.nombre')
			->join('persona', 'alumno.idpersonas', '=','persona.idpersonas')
			->where('alumno.nocuenta','=',$params['nocuenta'])
			->Select(
					 'niveles_academicos.nombre as nivel',
					 'alumno.promanterior as promedio',
					 db::raw('max(cuatrimestre_cursado.grado) as grado'),
					 db::raw('concat(persona.nombre," ",persona.apellidopat," ",persona.apellidomat) as nombre')
					 )
			->get();

		$beca_autorizada=DB::table('becas_autorizadas')
						->where('becas_autorizadas.nocuenta','=',$params['nocuenta'])
						->Select('becas_autorizadas.idbecas_autorizadas as id')
						->get();
		if(isset($beca_autorizada[0]))
		{
			//$beca_autorizada=$beca_autorizada[0]->id;
			
			$porcentaje_beca=DB::table('beca_porcentaje')
				->join('becas_autorizadas', 'beca_porcentaje.idbeca_tipo', '=','becas_autorizadas.idbeca_tipo')
				->join('beca_tipo', 'beca_porcentaje.idbeca_tipo', '=','beca_tipo.idbeca_tipo')
				->where('becas_autorizadas.idbecas_autorizadas', $beca_autorizada[0]->id)
				->where('beca_porcentaje.calificacion_inicial','<=' ,$info_alum[0]->promedio)
				->where('beca_porcentaje.calificacion_final','>=' ,$info_alum[0]->promedio)
				->Select('beca_porcentaje.porcentaje as porcentaje',
						 'beca_tipo.beca as tipo',
						 'becas_autorizadas.estatus as estatus')
				->get();

			$beca=$porcentaje_beca[0]->tipo.' '.$porcentaje_beca[0]->porcentaje.'% ';
			if ($porcentaje_beca[0]->estatus==0) {
				$beca=$beca.'(CANCELADA)';
			}

		} else{
			$porcentaje_beca='N/A';
		}
		

		$data['ciclos']=$ciclos;
		$data['grado']=$info_alum[0]->grado;
		$data['nivel']=$info_alum[0]->nivel;
		$data['nombre']=$info_alum[0]->nombre;
		$data['beca']=$porcentaje_beca;
		if($data)
		{
			echo json_encode(array('error' => false,'messsage'=>'','response'=>$data));
		} else {
			echo json_encode(array('error' => true,'messsage'=>'No data','response'=>''));
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
	public function update($token)
	{
		try {
			$params=Input::get();
			DB::table('cobros')
					->where('id', $params['id'])
	        		->update($params);
		    echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Update'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));	
		}
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($token)
	{
		$params=Input::get();
		try {
			DB::table('cobros')->where('id', '=', $params['id'])->delete();
			echo json_encode(array('error' => false,'messsage'=>'Response Ok','response'=>'Success Delete'));
		} catch (Exception $e) {
			echo json_encode(array('error' => true,'messsage'=>'Bad Response','response'=>'Failed'));		
		}
	}



}	
