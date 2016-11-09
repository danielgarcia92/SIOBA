<!DOCTYPE html>
<html lang="es">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="varios/css/Login.css"/>
		<link rel="shortcut icon" type="image/x-icon" href="varios/imagenes/udem.ico"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script type="text/javascript" src="varios/js/LoginCalificador.js"></script>
		<script src="https://apis.google.com/js/api:client.js"></script>

		<title>SIOBA | LOGIN</title>

	</head>

	<body id="todo">
		<div class="container">
			<div class="login-container">
				<div id="output"></div>
				<div id="avatar" class="avatar"></div>
				<div class="form-box">
					<br><br>
					<h3 style="font-size: 120%; font-family: 'Noto Sans', sans-serif">Bienvenido a <br> SIOBA!</h3>
					<div id="gSignInWrapper">
						<div id="customBtn" class="customGPlusSignIn">
							<span class="icon"></span>
							<span class="buttonText">Iniciar Sesión</span>
						</div>
						<script>startApp();</script>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
