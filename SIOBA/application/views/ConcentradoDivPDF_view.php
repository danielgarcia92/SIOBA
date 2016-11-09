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
		        <div>
		            <h2>Informe de resultados por división</h2>
		            <h1>' . $numDep['resultados'][0]->division . '</h1><br>
		        </div>';
		for ($i=0; $i < $numDep['longitud']; $i++) {
		    $html .= '
		    	<div>
		    		<br><hr/>
		            <h2>' . $numDep['resultados'][$i]->departamento . '</h2><br>
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
			for ($j=0; $j < $resultados[$i]['longitud']; $j++) {
				$html .= '
			            <tr>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$resultados[$i]['resultados'][$j]->nombreProfesor.'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$resultados[$i]['resultados'][$j]->nombreObservador.'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaMenos[$i][$j].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcMenos[$i][$j].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaEsperado[$i][$j].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcEsperado[$i][$j].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaSobresaliente[$i][$j].'</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaPorcSobresaliente[$i][$j].'%</td>
			            	<td style="vertical-align: middle; text-align: center; height: 40px">'.$filaTotal[$i][$j].'</td>
			            </tr>';
			}
			$html .= '
						<tr>
							<th colspan="2">Total</th>
							<th>'.$colMenos[$i].'</th>
							<th>'.$colPorcMenos[$i].'%</th>
							<th>'.$colEsperado[$i].'</th>
							<th>'.$colPorcEsperado[$i].'%</th>
							<th>'.$colSobresaliente[$i].'</th>
							<th>'.$colPorcSobresaliente[$i].'%</th>
							<th>'.$colTotal[$i].'</th>
						</tr>
					</tbody>
				</table><br><br>';
		}
			$html .= '
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
file_put_contents('ReporteDivision.pdf', $output);

?>
