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
		            <h2>Informe de resultados por departamento</h2>
		            <h1>' . $resultados[0]->departamento . '</h1><br>
		            <hr/>
		        </div>
			    <table width = "100%">
					<tbody>
						<tr>
							<th class="indicaciones" style="width: 30%">Observado</th>
							<th class="indicaciones" style="width: 30%">Observador</th>
							<th class="indicaciones" style="width: 10%" colspan="2">Menos E.</th>
							<th class="indicaciones" style="width: 10%" colspan="2">Esp</th>
							<th class="indicaciones" style="width: 10%" colspan="2">Sob</th>
							<th class="indicaciones" style="width: 10%">Total</th>
						</tr>';
			        for ($i=0; $i < $longitud; $i++) { 
			            $html .= '
			            <tr>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$resultados[$i]->nombreProfesor.'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$resultados[$i]->nombreObservador.'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaMenos[$i].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcMenos[$i].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaEsperado[$i].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcEsperado[$i].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaSobresaliente[$i].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcSobresaliente[$i].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaTotal[$i].'</td>
			            </tr>';
			            }
						$html .= '
						<tr>
							<th colspan="2">Total</th>
							<th>'.$colMenos.'</th>
							<th>'.$colPorcMenos.'%</th>
							<th>'.$colEsperado.'</th>
							<th>'.$colPorcEsperado.'%</th>
							<th>'.$colSobresaliente.'</th>
							<th>'.$colPorcSobresaliente.'%</th>
							<th>'.$colTotal.'</th>
						</tr>
					</tbody>
				</table>
		    </div>
		</div>
		<div style="clear: both;">&nbsp;</div><br><br><br>
		<img src="varios/imagenes/banner.png" alt="banner" />
    	<footer style="font-size:12px;">Universidad de Monterrey © UDEM</footer>
	</body>

</html>
';

use Dompdf\Dompdf;

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A3', 'portrait');
$pdf->render();
$output = $pdf->output();
file_put_contents('ReporteDepartamento.pdf', $output);

?>
