<?php
require_once 'varios/dompdf/autoload.inc.php';

$html = '
<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="varios/css/PDF.css"/>
		<link rel="stylesheet" href="varios/css/bootstrap3.3.6.min.css"/>
	</head>

	<body>
		<div id="pagina">
			<header>
				<img src="varios/imagenes/vice.png" alt="Vicerrectoria Académica" />
	        	<br><br>
	        	<img src="varios/imagenes/banner.png" alt="banner" />
			</header>

			<div id="contenido">
		        <div class="post">
		            <h1>Observación en el Aula</h1>
		            <hr/>
		        </div>
		        <div id="izquierda">
			        <B>Profesor que imparte la clase (el observado):</B>
			        <br>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->profesor . '</textarea>
			        <br>
			        <B>Curso:</B>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCC">' . $resultados->curso . '</textarea>
			        <br>
			        <B>División:</B>
			        <br>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->division .'</textarea>
			        <br>
			        <B>Departamento:</B>
			        <br>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->departamento . '</textarea>
			        <br>
			    </div>
			    <div id="derecha">
			    	<B>Tipo de observación:</B>
			        <br>';
			        if ($resultados->tipoEncuesta == 'O') {
			        	$html = $html . '
			        	<textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">Observador</textarea>
			        	<br>
			        	<B>Observador:</B>
			        	<br>
			        	<textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->observador . '</textarea>';
			        }else{
			        	$html = $html . '<textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">Autoevaluación</textarea>';
			        }
			        $html = $html . '
			        <br>
			        <B>Fecha:</B>
			        <br>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->fecha . '</textarea>
			        <br>
			        <B>Periodo:</B>
			        <br>
			        <textarea class="form-control" style="width: 100%; height: 20px; color: #000; border-color: #CCCCCC">' . $resultados->periodo . '</textarea>
			        <br>
			    </div>
			    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			    <table width = "100%">
					<tbody>
						<tr>
							<th class="indicaciones" style="text-align: center" colspan="4">Indicaciones: Marque cada aspecto del manejo de la sesión de clase usando los criterios indicados abajo.</th>
						</tr>
						<tr>
							<th style="text-align: center">Criterio</th>
							<th style="text-align: center">Menos de lo esperado</th>
							<th style="text-align: center">Lo esperado</th>
							<th style="text-align: center">Sobresaliente</th>
						</tr>
			            <tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Inicio de Clase</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[1]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Inicia a destiempo.<br>
								<input type="text" style="width:10px';if($id[2]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> La sesión inicia sin entusiasmo.<br>
								<input type="text" style="width:10px';if($id[3]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Busca lo que va a trabajar, toma tiempo para encontrar o recordar las actividades del día, toma un tiempo para recordar en qué se quedó.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[4]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Inicia a tiempo.<br>
								<input type="text" style="width:10px ';if($id[5]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Saluda con gusto, entusiasmando.<br>
								<input type="text" style="width:10px';if($id[6]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Resume lo visto en la sesión anterior.<br>
								<input type="text" style="width:10px';if($id[7]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Presenta el plan de la sesión y la intención de aprendizaje.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[8]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Está presente en el salón con anticipación (>5 min).<br>
								<input type="text" style="width:10px';if($id[9]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Fomenta que el alumno participe resumiendo lo que se estudió en la sesión anterior.<br>
								<input type="text" style="width:10px';if($id[10]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Genera un clima positivo, conectando con los estudiantes.<br>
							</td>
						</tr>
						<tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Preparación y organización de clase</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[11]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Expone leyendo materiales.<br>
								<input type="text" style="width:10px';if($id[12]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Se muestra inseguro, con poco dominio del tema.<br>
								<input type="text" style="width:10px';if($id[13]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Improvisa su exposición o actividades.<br>
								<input type="text" style="width:10px';if($id[14]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Habla de temas no relacionados al curso.<br>
								<input type="text" style="width:10px';if($id[15]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los materiales que usa son casuales, no organizados, no formales.<br>
								<input type="text" style="width:10px';if($id[16]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Le sobra/falta tiempo al final de la sesión.<br>		
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[17]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Muestra seguridad en los conocimientos.<br>
								<input type="text" style="width:10px';if($id[18]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Las actividades de la sesión son claras, enlazadas, en tiempo, con objetivos claros y bien organizadas.<br>
								<input type="text" style="width:10px';if($id[19]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Demuestra preparación ante las preguntas.<br>
								<input type="text" style="width:10px';if($id[20]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Cuenta con material de respaldo de lo visto en clase.<br>
								<input type="text" style="width:10px';if($id[21]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los materiales usados están bien preparados y organizados.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[22]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Prepara y provee recursos adicionales que apoyan el aprendizaje, para que los alumnos trabajen dentro y fuera de clase.<br>
								<input type="text" style="width:10px';if($id[23]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> El material de la clase está disponible con anticipación.<br>
								<input type="text" style="width:10px';if($id[24]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Usa en clase materiales y actividades preparados de forma superior.<br>
							</td>
						</tr>
						<tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Exposición de clase</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[25]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Expone confusamente.<br>
								<input type="text" style="width:10px';if($id[26]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Pasa de una idea a otra de forma poco articulada.<br>
								<input type="text" style="width:10px';if($id[27]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> No se comprende la relación de lo que expone con el material del curso, o con otros temas, o con problemas reales.<br>
								<input type="text" style="width:10px';if($id[28]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> No resuelve con claridad las dudas.<br>
								<input type="text" style="width:10px';if($id[29]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Se expresa en lenguaje poco técnico o poco profesional.<br>
								<input type="text" style="width:10px';if($id[30]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Su imagen personal es informal o no profesional.<br>
								<input type="text" style="width:10px';if($id[31]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Se nota poco entusiasmado.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[32]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Explica  claramente los contenidos, con ejemplos, analogías y comentarios.<br>
								<input type="text" style="width:10px';if($id[33]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Utiliza frases e ideas articuladas.<br>
								<input type="text" style="width:10px';if($id[34]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Contextualiza el conocimiento con una aplicación práctica o real.<br>
								<input type="text" style="width:10px';if($id[35]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Resuelve las dudas.<br>
								<input type="text" style="width:10px';if($id[36]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Su lenguaje verbal y corporal es profesional.<br>
								<input type="text" style="width:10px';if($id[37]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Su imagen personal es aceptable/muy buena.<br>
								<input type="text" style="width:10px';if($id[38]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Su entusiasmo y gusto por la clase y por los estudiantes es evidente.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[39]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Expone magistralmente manteniendo a todos los alumnos interesados en el tema.<br>
								<input type="text" style="width:10px';if($id[40]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Incluye comentarios, contenidos que favorecen el desarrollo integral y profesional de los estudiantes.<br>
								<input type="text" style="width:10px';if($id[41]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Ante las preguntas, agrega detalles o ejemplos y encuentra formas alternas de explicar el concepto.<br>
								<input type="text" style="width:10px';if($id[42]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Usa lenguaje verbal y corporal excepcional.<br>
								<input type="text" style="width:10px';if($id[43]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Su imagen personal es impecable.<br>
								<input type="text" style="width:10px';if($id[44]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Expone demostrando pasión por la materia y el aprendizaje, contagiando.<br>
							</td>
						</tr>
						<tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Control de grupo</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[45]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos preguntan repetitivamente.<br>
								<input type="text" style="width:10px';if($id[46]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos hablan entre sí.<br>
								<input type="text" style="width:10px';if($id[47]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> El Profesor solicita a los alumnos guardar silencio o poner atención.<br>
								<input type="text" style="width:10px';if($id[48]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos abandonan el salón.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[49]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> En el salón existe orden y respeto.<br>
								<input type="text" style="width:10px';if($id[50]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> No permite el uso de distractores.<br>
								<input type="text" style="width:10px';if($id[51]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Establece reglas claras y las aplica.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[52]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Tiene un control sobresaliente del grupo, incluso en condiciones difíciles como tamaño de grupo, actividades de alto nivel o condiciones externas adversas.<br>
							</td>
						</tr>
						<tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Promoción de aprendizaje activo</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[53]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Expone el material enfocándose en transmitir la información.<br>
								<input type="text" style="width:10px';if($id[54]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> La sesión está centrada en el profesor.<br>
								<input type="text" style="width:10px';if($id[55]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos no prestan atención, se distraen o están haciendo otra cosa.<br>
								<input type="text" style="width:10px';if($id[56]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> No obtiene respuestas a las preguntas que hace a los alumnos.<br>
								<input type="text" style="width:10px';if($id[57]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos no se ven retados o interesados.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[58]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Los alumnos están activos (escuchando, escribiendo, razonando, participando en actividades en forma enfocada).<br>
								<input type="text" style="width:10px';if($id[59]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Promueve y asegura la aplicación del conocimiento con actividades planeadas.<br>
								<input type="text" style="width:10px';if($id[60]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Permite nuevas propuestas.<br>
								<input type="text" style="width:10px';if($id[61]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Obtiene respuestas a la participación que solicita de los alumnos.<br>
								<input type="text" style="width:10px';if($id[62]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> La mayoría de los alumnos están "ganchados" en la sesión.<br>
								<input type="text" style="width:10px';if($id[63]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Se refiere a los alumnos por su nombre.<br>
								<input type="text" style="width:10px';if($id[64]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Existe un ambiente positivo y divertido.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[65]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Entusiasma a los alumnos, los reta, los compromete, los concientiza de la responsabilidad sobre su aprendizaje.<br>
								<input type="text" style="width:10px';if($id[66]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Utiliza preguntas  precisas u otros instrumentos  enfocados a la reflexión, propiciando que el alumno aprenda.<br>
								<input type="text" style="width:10px';if($id[67]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Maneja magistralmente preguntas y comentarios poco claras, descontextualizadas, distractoras o retadoras.<br>
								<input type="text" style="width:10px';if($id[68]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Todos los alumnos están "ganchados" en la sesión.<br>
							</td>
						</tr>
						<tr>
							<td style="width: 16%; text-align: center; vertical-align: inherit">Cierre de sesión</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[69]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> La sesión termina abruptamente, los alumnos abandonan el salón sin esperar al cierre.<br>
								<input type="text" style="width:10px';if($id[70]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Algunos temas o dudas quedan inconclusos.<br>	
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[71]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Concluye la clase a tiempo y de manera ordenada.<br>
								<input type="text" style="width:10px';if($id[72]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Resume los conceptos más importantes de la sesión, relaciona lo visto con la siguiente sesión.<br>
							</td>
							<td style="width: 28%; padding: 0.5%">
								<input type="text" style="width:10px';if($id[73]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> Motiva respecto al trabajo a realizar fuera del aula antes de la próxima sesión.<br>
								<input type="text" style="width:10px';if($id[74]=='si'){$html=$html.'; background-color: #333';} $html=$html.'"> La sesión cierra en un ambiente positivo e inspirador para el aprendizaje.<br>
							</td>
						</tr>
					</tbody>
				</table>
				<br><br>
				<p><B>Mayor fortaleza observada en la entrega de la clase:</B></p>
				<input type="text" style="width: 100%; height: auto; color: #000; border-color: #CCCCCC" value="'.$resultados->fortalezas.'" />
				<br>
				<p><B>Mayor área de oportunidad observada en la entrega de la clase:</B></p>
				<input type="text" style="width: 100%; height: auto; color: #000; border-color: #CCCCCC" value="'.$resultados->oportunidades.'" />
				<br>
				<p><B>Comentarios/Observaciones:</B></p>
				<input type="text" style="width: 100%; height: auto; color: #000; border-color: #CCCCCC" value="'.$resultados->generales.'" />
				<br><br>
		    </div>
		</div>
		<div style="clear: both;">&nbsp;</div>
		<img src="varios/imagenes/banner.png" alt="banner" />
    	<footer style="font-size:12px;">Universidad de Monterrey © UDEM | Folio: ' . $resultados->folio . '</footer>
	</body>

</html>
';

use Dompdf\Dompdf;

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A3', 'portrait');
$pdf->render();
$output = $pdf->output();
file_put_contents('sioba_'.$resultados->tipoEncuesta.'.pdf', $output);

?>
