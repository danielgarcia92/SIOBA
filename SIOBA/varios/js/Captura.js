$(document).on('ready', funPrincipal);

$(document).ajaxStart(function() {
	$('#loading').show();
	window.onbeforeunload = function() {
		return "¿Seguro que quieres salir?";
	}
}).ajaxStop(function() {
	$('#loading').hide();
	window.onbeforeunload = "¿Seguro que quieres salir?";
});

function funPrincipal() {
	var tipo = $("#tipo").val();
	var exito = $("#exito").val();
	var folio = $("#folio").val();

	if (exito == true) {
		var tag = '<h4>Sus datos fueron almacenados exitosamente.<br>Ahora enviaremos copia del registro al correo electrónico.</h4><br/>';
		$("#mensaje2").empty();
		$("#mensaje2").append(tag);

		var intentoPDF = 0;
		var intentoCorreo = 0;
		$.ajaxSetup({ retryAfter: 1});
		setTimeout('funcionPDF("")', $.ajaxSetup().retryAfter);

		funcionPDF = function(paramPDF) {
			intentoPDF++;
			$.ajax({
				type 	 : 'post',
				url 	 : '../PDF/calificadorPDF',
				data 	 : {'folio' : folio},
				dataType : 'json',
				encode	 : true
			}).error(function() {
				if (intentoPDF < 20) {
					var tag = '<br/><br/><p>Problemas de conexión.<br/>Estamos experimentando errores al generar el archivo PDF. Intento # ' + intentoPDF + '</p>';
					$("#mensaje").empty();
					$("#mensaje").append(tag);
					setTimeout('funcionPDF("' + paramPDF + '")', $.ajaxSetup().retryAfter);
				} else {
					var tag = '<h5>Problemas de Conexión.<br>Sus datos fueron almacenados exitosamente pero no fue posible generar el archivo PDF, por favor solicite a su jefe de departamento copia de la observación realizada.<br/>Disculpe los inconvenientes, muchas gracias</h5>';
					$("#mensaje").empty();
					$("#mensaje2").empty();
					$("#mensaje").append(tag);
					setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
				}
			}).done(function(datosPDF) {
				if (datosPDF.exito == true) {
					$("#mensaje").empty();
					setTimeout('funcionCorreo("")', $.ajaxSetup().retryAfter);

					funcionCorreo = function(paramCorreo) {
						intentoCorreo++;
						$.ajax({
							type 	 : 'post',
							url 	 : '../Correo/enviarCorreo',
							data 	 : {'folio' : folio, 'tipo' : tipo},
							dataType : 'json',
							encode	 : true
						}).error(function() {
							if (intentoCorreo < 5) {
								var tag = '<br/><br/><p>Problemas de conexión.<br/>Estamos experimentando errores al enviar el correo. Intento # ' + intentoCorreo + '</p>';
								$("#mensaje").empty();
								$("#mensaje").append(tag);
								setTimeout('funcionCorreo("' + paramCorreo + '")', $.ajaxSetup().retryAfter);
							} else {
								var tag = '<h5>Problemas de Conexión.<br>Sus datos fueron almacenados exitosamente pero no fue posible enviar el correo, por favor solicite a su jefe de departamento copia de la observación realizada.<br/>Disculpe los inconvenientes, muchas gracias</h5>';
								$("#mensaje").empty();
								$("#mensaje2").empty();
								$("#mensaje").append(tag);
								setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
							}
						}).done(function(datosCorreo){
							if (datosCorreo.exito == true) {
								var tag = '<h1>El registro ha sido exitoso. Muchas gracias.</h1>';
								$("#mensaje").empty();
								$("#mensaje2").empty();
								$("#mensaje").append(tag);
								setTimeout(function(){ window.location.href = 'cerrarSesion' }, 3000);
							} else {
								if (intentoCorreo < 5) {
									var tag = '<br/><br/><p>Problemas al enviar el correo.<br/>Estamos experimentando errores al enviar el correo. Intento # ' + intentoCorreo + '</p>';
									$("#mensaje").empty();
									$("#mensaje").append(tag);
									setTimeout('funcionCorreo("' + paramCorreo + '")', $.ajaxSetup().retryAfter);
								} else {
									var tag = '<h5>Problemas al enviar el correo.<br>Sus datos fueron almacenados exitosamente pero no fue posible enviar el correo, por favor solicite a su jefe de departamento copia de la observación realizada.<br/>Disculpe los inconvenientes, muchas gracias</h5>';
									$("#mensaje").empty();
									$("#mensaje2").empty();
									$("#mensaje").append(tag);
									setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
								}
							}
						});
					}
				} else {
					if (intentoPDF < 20) {
						var tag = '<br/><br/><p>Problemas al generar PDF.<br/>Estamos experimentando errores al generar el archivo PDF. Intento # ' + intentoPDF + '</p>';
						$("#mensaje").empty();
						$("#mensaje").append(tag);
						setTimeout('funcionPDF("' + paramPDF + '")', $.ajaxSetup().retryAfter);
					} else {
						var tag = '<h5>Problemas al generar PDF.<br>Sus datos fueron almacenados exitosamente pero no fue posible generar el archivo PDF, por favor solicite a su jefe de departamento copia de la observación realizada.<br/>Disculpe los inconvenientes, muchas gracias</h5>';
						$("#mensaje").empty();
						$("#mensaje2").empty();
						$("#mensaje").append(tag);
						setTimeout(function(){ window.location.href = 'cerrarSesion' }, 6000);
					}
				}
			});
		}
	} else {
		if (tipo == 'A') {
			var tag = '<h1>Profesor, su autoevaluación ya se había registrado con anterioridad.</h1>';
			$('#loading').hide();
			$("#mensaje").empty();
			$("#mensaje").append(tag);
		}else if(tipo == 'O'){
			var tag = '<h1>El Profesor ya había sido evaluado con anterioridad.</h1>';
			$('#loading').hide();
			$("#mensaje").empty();
			$("#mensaje").append(tag);
		}else{
			var tag = '<h1>Ha surgido un error inesperado, por favor intentelo más tarde.</h1>';
			$('#loading').hide();
			$("#mensaje").empty();
			$("#mensaje").append(tag);
		}
		setTimeout(function() { window.location.href = 'cerrarSesion' }, 3000);
	}
}
