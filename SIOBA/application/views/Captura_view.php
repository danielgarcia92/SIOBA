<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="../varios/css/Calificador.css">
		<link rel="shortcut icon" type="image/x-icon" href="../varios/imagenes/udem.ico" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="../varios/js/Captura.js" type="text/javascript"></script>

		<title>SIOBA | Captura</title>

	</head>

	<body>
		<div id="pagina">
			<input type="hidden" id="tipo" value="<?=$tipo;?>">
			<input type="hidden" id="exito" value="<?=$exito;?>">
			<input type="hidden" id="folio" value="<?=$folio;?>">
			
			<p class="cerrar"><a href="cerrarSesion"><img src='../varios/imagenes/cerrar.png' alt="Cerrar Sesión" onmouseover="this.src='../varios/imagenes/cerrar2.png'" onmouseout="this.src='../varios/imagenes/cerrar.png'"/></a></p>
			<header>
				<img src="../varios/imagenes/vice.png" alt="Vicerrectoria Académica" />
	        	<br/>
	        	<img src="../varios/imagenes/banner.png" alt="banner" />
			</header>

			<div id="mensaje2" style="font-size: 100%"></div>

			<div id="loading">
				<p><center><img style="width: 10%" src="../varios/imagenes/cargando.gif"/><br>Enviando el correo electrónico, por favor espere.</center></p>
			</div>

			<div id="mensaje" style="font-size: 100%"></div>

    		<br>
    		<img src="../varios/imagenes/banner.png" alt="banner" />
    		<footer  style="font-size:12px;">Universidad de Monterrey © UDEM | Design by <a href="http://www.html5-templates.co.uk" target="_blank">HTML5</a></footer>
    	</div>

	</body>

</html>
