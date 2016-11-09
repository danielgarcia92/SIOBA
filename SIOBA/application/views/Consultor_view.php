<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="varios/css/Consultor.css">
		<link rel="shortcut icon" type="image/x-icon" href="varios/imagenes/udem.ico" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="varios/js/Consultor.js" type="text/javascript"></script>

		<title>SIOBA | Consultor</title>

		<input type="hidden" id="correoConsultor" value="<?=$correoConsultor;?>">
		<input type="hidden" id="usuario" value="<?=$usuario;?>">

	</head>

	<body>

		<div class="pagina">
			<p class="cerrar"><a href="Consultor/cerrarSesion"><img src='varios/imagenes/cerrar.png' alt="Cerrar Sesión" onmouseover="this.src='varios/imagenes/cerrar2.png'" onmouseout="this.src='varios/imagenes/cerrar.png'"/></a></p>
			<header>
	        	<img src="varios/imagenes/vice.png" alt="Vicerrectoria Académica" />
	        	<br/>
	        	<img src="varios/imagenes/banner.png" alt="banner" />
	    	</header>

	    	<div class="contenido">
	    		<div><h1>Observación en el Aula</h1></div><hr/>
	    		<div id = "divisionSel"></div> <br>
		        <div id = "departamentoSel"></div><br>
		        <div id = "botones"></div>
		        <div id="loading">
					<p><center><img style="width: 10%" src="varios/imagenes/cargando.gif"/><br/><br/></center></p>
				</div>
		        <div id = "tablaProfesores"></div>
		    </div>

		</div>

	</body>

</html>
