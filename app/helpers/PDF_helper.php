<?php
	// My common functionse
	function CreateAlumno($data)
	{

		return CreatePDF($body);		
	}
	function CreateMatriculas($data)
	{
		$body=null;	
		$total_alumnos=0;
		$columnas_matriculas=4;
		
		foreach ($data as $key => $value) {
			foreach ($value as $key_value => $values_data) {
				$counter=0;
				$body.=  '<tr>';
				$body.= 	'<td colspan="2" style="border-bottom: 1px solid #000;" >
				 				<p style="font-size:15px"><b>Nivel</b> '.$key_value.'</p>
				 			 </td>';
				$body.= '</tr>';
				
				$body.= '<tr>';
				$body.=		'<td colspan="2">
								<table style="width:100%;">';
				foreach ($values_data as $key => $matricula) {
					if ($counter<$columnas_matriculas && $counter>0) {
						if($counter+1==count($values_data))
						{
							$body.='<td colspan="'.($columnas_matriculas-$counter).'">'.$matricula.'</td>';
							$body.=	'</tr>';
						} else {
							$body.='<td>'.$matricula.'</td>';
						}
						$counter++;
						
					} else {
						if ($counter==$columnas_matriculas) {
							$body.=	'</tr>';
							$counter=0;
						} else {
							$body.=	'<tr>
										<td>'.$matricula.'</td>';
							$counter++;

						}
					}
					
				}
				$body.=		'	</table>
							</td>';
				$body.= '</tr>';

				$body.=  '<tr>';
				$body.= 	'<td colspan="2" >
				 				<p style="font-size:13px">Total de Alumnos por Nivel <b>'.count($values_data).'</b></p>
				 			 </td>';
				$body.= '</tr>';
				$total_alumnos+=count($values_data);

			}
		}
				$body.=  '<tr>';
				$body.= 	'<td colspan="2" >
				 				<p style="font-size:13px">Total de Alumnos por Escuela <b>'.$total_alumnos.'</b></p>
				 			 </td>';
				$body.= '</tr>';
		return CreatePDF($body);

	}
	function CreatePDF($body)
	{
		$path = asset('files/Logo_upa.jpg');
        $html = '<html><body>';
        $html.= '<table style="width:100%;">';
        $html.= '<tr>
        			<td width="170px"> 
        				<img src="' . $path . '" width="140px" height="70px" /> 
        			</td>
        			<td>
        				<h3>' . $path . 'UNIVERSIDAD POLITECNICA DE AGUASCALIENTES</h3>
        				<p style="font-size:12px">Reporte de Alumnos que Adeudan Colegiatura a la Fecha '.date('d-m-Y').'</p>
        			</td>
        		 </tr>';
        $html.= $body;
        $html.= '</table>';
        $html.= '</body></html>';
        return $html;
	}