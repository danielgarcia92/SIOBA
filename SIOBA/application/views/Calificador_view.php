<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="varios/css/Calificador.css">
		<link rel="shortcut icon" type="image/x-icon" href="varios/imagenes/udem.ico" >
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="varios/js/Calificador.js" type="text/javascript"></script>

		<title>SIOBA | Calificador</title>

	</head>

	<body>
		<div id="pagina">
			<p class="cerrar"><a href="Calificador/cerrarSesion"><img src='varios/imagenes/cerrar.png' alt="Cerrar Sesión" onmouseover="this.src='varios/imagenes/cerrar2.png'" onmouseout="this.src='varios/imagenes/cerrar.png'"/></a></p>
			<header>
				<img src="varios/imagenes/vice.png" alt="Vicerrectoria Académica" />
	        	<br/>
	        	<img src="varios/imagenes/banner.png" alt="banner" />
			</header>

			<div id="contenido">

		        <div class="post">
		            <h1 style="font-size: 2vw">Observación en el Aula</h1>
		            <hr/>
		        </div>

		        <form action="Calificador/insertar" method="post">

			        <div id="izquierda">
			        	<div id="divProfesores"><B class="textos">Profesor que imparte la clase (el observado):</B><br></div>
			            <br>
			        	<div id="divCursos"></div>
			        	<br>
			        	<div id="divDivisiones"></div>
			            <br>
			            <div id="divDepartamentos"></div>
			            <br>
			        </div>
			        <div id="derecha">
			        	<div id="divTipo"></div>
			        	<br>
			        	<div id="divObservadores"></div>

			        	<div id="divFecha"><B class='textos'>Fecha:</B><br>
			        		<input class="form-control" type="text" name="fecha" id="datepicker" required>
			        	</div>
			        	<br>
			        	<div id="divPeriodo"></div>
			            <br>
			        </div>
			       	<table width = '100%'>
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
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesInicio1" value="1"> Inicia a destiempo.<br>
									<input type="checkbox" name="opcionesInicio2" value="2"> La sesión inicia sin entusiasmo.<br>
									<input type="checkbox" name="opcionesInicio3" value="3"> Busca lo que va a trabajar, toma tiempo para encontrar o recordar las actividades del día, toma un tiempo para recordar en qué se quedó.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesInicio4" value="4"> Inicia a tiempo.<br>
									<input type="checkbox" name="opcionesInicio5" value="5"> Saluda con gusto, entusiasmando.<br>
									<input type="checkbox" name="opcionesInicio6" value="6"> Resume lo visto en la sesión anterior.<br>
									<input type="checkbox" name="opcionesInicio7" value="7"> Presenta el plan de la sesión y la intención de aprendizaje.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesInicio8" value="8"> Está presente en el salón con anticipación (>5 min).<br>
									<input type="checkbox" name="opcionesInicio9" value="9"> Fomenta que el alumno participe resumiendo lo que se estudió en la sesión anterior.<br>
									<input type="checkbox" name="opcionesInicio10" value="10"> Genera un clima positivo, conectando con los estudiantes.<br>
								</td>
							</tr>
			                <tr>
								<td style="width: 16%; text-align: center; vertical-align: inherit">Preparación y organización de clase</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesPreparacion1" value="11"> Expone leyendo materiales.<br>
									<input type="checkbox" name="opcionesPreparacion2" value="12"> Se muestra inseguro, con poco dominio del tema.<br>
									<input type="checkbox" name="opcionesPreparacion3" value="13"> Improvisa su exposición o actividades.<br>
									<input type="checkbox" name="opcionesPreparacion4" value="14"> Habla de temas no relacionados al curso.<br>
									<input type="checkbox" name="opcionesPreparacion5" value="15"> Los materiales que usa son casuales, no organizados, no formales.<br>
									<input type="checkbox" name="opcionesPreparacion6" value="16"> Le sobra/falta tiempo al final de la sesión.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesPreparacion7" value="17"> Muestra seguridad en los conocimientos.<br>
									<input type="checkbox" name="opcionesPreparacion8" value="18"> Las actividades de la sesión son claras, enlazadas, en tiempo, con objetivos claros y bien organizadas.<br>
									<input type="checkbox" name="opcionesPreparacion9" value="19"> Demuestra preparación ante las preguntas.<br>
									<input type="checkbox" name="opcionesPreparacion10" value="20"> Cuenta con material de respaldo de lo visto en clase.<br>
									<input type="checkbox" name="opcionesPreparacion11" value="21"> Los materiales usados están bien preparados y organizados.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesPreparacion12" value="22"> Prepara y provee recursos adicionales que apoyan el aprendizaje, para que los alumnos trabajen dentro y fuera de clase.<br>
									<input type="checkbox" name="opcionesPreparacion13" value="23"> El material de la clase está disponible con anticipación.<br>
									<input type="checkbox" name="opcionesPreparacion14" value="24"> Usa en clase materiales y actividades preparados de forma superior.<br>
								</td>
							</tr>
			                <tr>
								<td style="width: 16%; text-align: center; vertical-align: inherit">Exposición de clase</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesExposicion1" value="25"> Expone confusamente.<br>
									<input type="checkbox" name="opcionesExposicion2" value="26"> Pasa de una idea a otra de forma poco articulada.<br>
									<input type="checkbox" name="opcionesExposicion3" value="27"> No se comprende la relación de lo que expone con el material del curso, o con otros temas, o con problemas reales.<br>
									<input type="checkbox" name="opcionesExposicion4" value="28"> No resuelve con claridad las dudas.<br>
									<input type="checkbox" name="opcionesExposicion5" value="29"> Se expresa en lenguaje poco técnico o poco profesional.<br>
									<input type="checkbox" name="opcionesExposicion6" value="30"> Su imagen personal es informal o no profesional.<br>
									<input type="checkbox" name="opcionesExposicion7" value="31"> Se nota poco entusiasmado.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesExposicion8" value="32"> Explica  claramente los contenidos, con ejemplos, analogías y comentarios.<br>
									<input type="checkbox" name="opcionesExposicion9" value="33"> Utiliza frases e ideas articuladas.<br>
									<input type="checkbox" name="opcionesExposicion10" value="34"> Contextualiza el conocimiento con una aplicación práctica o real.<br>
									<input type="checkbox" name="opcionesExposicion11" value="35"> Resuelve las dudas.<br>
									<input type="checkbox" name="opcionesExposicion12" value="36"> Su lenguaje verbal y corporal es profesional.<br>
									<input type="checkbox" name="opcionesExposicion13" value="37"> Su imagen personal es aceptable/muy buena.<br>
									<input type="checkbox" name="opcionesExposicion14" value="38"> Su entusiasmo y gusto por la clase y por los estudiantes es evidente.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesExposicion15" value="39"> Expone magistralmente manteniendo a todos los alumnos interesados en el tema.<br>
									<input type="checkbox" name="opcionesExposicion16" value="40"> Incluye comentarios, contenidos que favorecen el desarrollo integral y profesional de los estudiantes.<br>
									<input type="checkbox" name="opcionesExposicion17" value="41"> Ante las preguntas, agrega detalles o ejemplos y encuentra formas alternas de explicar el concepto.<br>
									<input type="checkbox" name="opcionesExposicion18" value="42"> Usa lenguaje verbal y corporal excepcional.<br>
									<input type="checkbox" name="opcionesExposicion19" value="43"> Su imagen personal es impecable.<br>
									<input type="checkbox" name="opcionesExposicion20" value="44"> Expone demostrando pasión por la materia y el aprendizaje, contagiando.<br>
								</td>
							</tr>
			                <tr>
								<td style="width: 16%; text-align: center; vertical-align: inherit">Control de grupo</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesControl1" value="45"> Los alumnos preguntan repetitivamente.<br>
									<input type="checkbox" name="opcionesControl2" value="46"> Los alumnos hablan entre sí.<br>
									<input type="checkbox" name="opcionesControl3" value="47"> El Profesor solicita a los alumnos guardar silencio o poner atención.<br>
									<input type="checkbox" name="opcionesControl4" value="48"> Los alumnos abandonan el salón.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesControl5" value="49"> En el salón existe orden y respeto.<br>
									<input type="checkbox" name="opcionesControl6" value="50"> No permite el uso de distractores.<br>
									<input type="checkbox" name="opcionesControl7" value="51"> Establece reglas claras y las aplica.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesControl8" value="52"> Tiene un control sobresaliente del grupo, incluso en condiciones difíciles como tamaño de grupo, actividades de alto nivel o condiciones externas adversas.<br>
								</td>
							</tr>
			                <tr>
			                	<td style="width: 16%; text-align: center; vertical-align: inherit">Promoción de aprendizaje activo</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesPromocion1" value="53"> Expone el material enfocándose en transmitir la información.<br>
									<input type="checkbox" name="opcionesPromocion2" value="54"> La sesión está centrada en el profesor.<br>
									<input type="checkbox" name="opcionesPromocion3" value="55"> Los alumnos no prestan atención, se distraen o están haciendo otra cosa.<br>
									<input type="checkbox" name="opcionesPromocion4" value="56"> No obtiene respuestas a las preguntas que hace a los alumnos.<br>
									<input type="checkbox" name="opcionesPromocion5" value="57"> Los alumnos no se ven retados o interesados.<br>
								</td>
			                    <td style="width: 28%; padding: 1%">
			                        <input type="checkbox" name="opcionesPromocion6" value="58"> Los alumnos están activos (escuchando, escribiendo, razonando, participando en actividades en forma enfocada).<br>
			                        <input type="checkbox" name="opcionesPromocion7" value="59"> Promueve y asegura la aplicación del conocimiento con actividades planeadas.<br>
			                        <input type="checkbox" name="opcionesPromocion8" value="60"> Permite nuevas propuestas.<br>
			                        <input type="checkbox" name="opcionesPromocion9" value="61"> Obtiene respuestas a la participación que solicita de los alumnos.<br>
			                        <input type="checkbox" name="opcionesPromocion10" value="62"> La mayoría de los alumnos están "ganchados" en la sesión.<br>
			                        <input type="checkbox" name="opcionesPromocion11" value="63"> Se refiere a los alumnos por su nombre.<br>
									<input type="checkbox" name="opcionesPromocion12" value="64"> Existe un ambiente positivo y divertido.<br>
			                    </td>
			                    <td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesPromocion13" value="65"> Entusiasma a los alumnos, los reta, los compromete, los concientiza de la responsabilidad sobre su aprendizaje.<br>
									<input type="checkbox" name="opcionesPromocion14" value="66"> Utiliza preguntas  precisas u otros instrumentos  enfocados a la reflexión, propiciando que el alumno aprenda.<br>
									<input type="checkbox" name="opcionesPromocion15" value="67"> Maneja magistralmente preguntas y comentarios poco claras, descontextualizadas, distractoras o retadoras.<br>
									<input type="checkbox" name="opcionesPromocion16" value="68"> Todos los alumnos están "ganchados" en la sesión.<br>
								</td>
			                </tr>
			                <tr>
								<td style="width: 16%; text-align: center; vertical-align: inherit">Cierre de sesión</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesCierre1" value="69"> La sesión termina abruptamente, los alumnos abandonan el salón sin esperar al cierre.<br>
									<input type="checkbox" name="opcionesCierre2" value="70"> Algunos temas o dudas quedan inconclusos.<br>	
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesCierre3" value="71"> Concluye la clase a tiempo y de manera ordenada.<br>
									<input type="checkbox" name="opcionesCierre4" value="72"> Resume los conceptos más importantes de la sesión, relaciona lo visto con la siguiente sesión.<br>
								</td>
								<td style="width: 28%; padding: 1%">
									<input type="checkbox" name="opcionesCierre5" value="73"> Motiva respecto al trabajo a realizar fuera del aula antes de la próxima sesión.<br>
									<input type="checkbox" name="opcionesCierre6" value="74"> La sesión cierra en un ambiente positivo e inspirador para el aprendizaje.<br>
								</td>
							</tr>
			            </tbody>
					</table>
        			<br><br>
					<p><B>Mayor fortaleza observada en la entrega de la clase:</B></p>
					<textarea class="form-control" style='width: 100%; height: 80px;' name="fortaleza" id="fortaleza" dir="auto" required></textarea>
					<br>
					<p><B>Mayor área de oportunidad observada en la entrega de la clase:</B></p>
					<textarea class="form-control" style='width: 100%; height: 80px;' name="oportunidad" id="oportunidad" dir="auto" required></textarea>
			        <br>
					<p><B>Comentarios/observaciones:</B></p>
					<textarea class="form-control" style='width: 100%; height: 80px;' name="comGenerales" id="comGenerales" dir="auto"></textarea>
			        <BR>
			        <input type="submit" value="Enviar" id="enviarBoton">
			    </form>
    	</div>
    <!--<div style="clear: both;">&nbsp;</div>-->
    <img src="varios/imagenes/banner.png" alt="banner"/>
    <footer  style="font-size:12px;">Universidad de Monterrey © UDEM | Design by <a href="http://www.html5-templates.co.uk" target="_blank">HTML5</a></footer>
    
	</body>

</html>
