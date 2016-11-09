$(document).on('ready', funPrincipal);

$(document).ajaxStart(function() {
	$('#loading').show();
	$("#tablaProfesores").empty();
	window.onbeforeunload = function() {
		return "¿Seguro que quieres salir?";
	}
}).ajaxStop(function() {
	$('#loading').hide();
	window.onbeforeunload = "¿Seguro que quieres salir?";
});

function funPrincipal() {
	if ($('#usuario').val() == 'admin') {
		$.ajax({
	        type 	 : 'post',
	        url		 : 'Consultor/divisionesAdmin',
	        dataType : 'json',
	        encode 	 : true
	    }).error(function(){
	        alert('Problemas de conexión, por favor intentelo más tarde');
	        setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
	    }).done(function (datos) {
	    	var tag = '<select id="division" class="form-control" onchange="departamentosSel(this.parentNode)" required><option value="">Seleccione una división</option>';
			for(var i = 0; i < datos.longitud; i++)
				tag = tag + '<option value=' + parseInt(i + 1) + '>' + datos.nombre[i] + '</option>';
			tag = tag + "</select>";	
			$("#divisionSel").append("<h4>Seleccione una División: </h4>" + tag);
	    });
	}else if ($('#usuario').val() == 'division') {
		$.ajax({
			type 	 : 'post',
			url 	 : 'Consultor/divisionesDivDir',
			data 	 : {'correoConsultor' : $('#correoConsultor').val()},
			dataType : 'json',
			encode 	 : true
		}).error(function(){
			alert('Problemas de conexión, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}).done(function(datos) {
			if (datos.longitud == 1) {
				var tag = '<select disabled id="division" class="form-control" required><option value=' + datos.id[0] + '>' + datos.nombre[0] + '</option></select>';
				$("#divisionSel").append("<h4>División: </h4>" + tag);
				departamentosSel();
			}else{
				var tag = '<select id="division" class="form-control" onchange="departamentosSel()" required><option value="">Seleccione una división</option>';
				for(var i = 0; i < datos.longitud; i++)
					tag = tag + '<option value=' + datos.id[i] + '>' + datos.nombre[i] + '</option>';
				tag = tag + "</select>";	
				$("#divisionSel").append("<h4>Seleccione una División: </h4>" + tag);
			}
		});
	}else if ($('#usuario').val() == 'departamento') {
		$.ajax({
			type 	 : 'post',
			url 	 : 'Consultor/departamentosDepDir',
			data 	 : {'correoConsultor' : $('#correoConsultor').val()},
			dataType : 'json',
			encode 	 : true
		}).error(function(){
			alert('Problemas de conexión, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}).done(function(datos) {
			var tag = '<select disabled id="division" class="form-control" required><option value=' + datos.divisionesId[0] + '>' + datos.divisionNombre + '</option></select>';
			$("#divisionSel").append("<h4>División: </h4>" + tag);

			if (datos.longitud == 1) {
				var tag = '<select disabled id="departamento" class="form-control" required><option value=' + datos.id[0] + '>' + datos.departamentosNombre[0] + '</option></select>';
				$("#departamentoSel").append("<h4>Departamento: </h4>" + tag);
				tablaProfesores();
			}else{
				var tag = '<select id="departamento" class="form-control" onchange="tablaProfesores()" required><option value="">Seleccione un departamento</option>';
				for(var i = 0; i < datos.longitud; i++)
					tag = tag + '<option value=' + datos.id[i] + '>' + datos.departamentosNombre[i] + '</option>';
				tag = tag + "</select>";
				$("#departamentoSel").append("<h4>Seleccione un departamento: </h4>" + tag);
			}
		});
	}
}

function departamentosSel() {
	$("#botones").empty();
	$("#tablaProfesores").empty();
	if ($('#usuario').val() != 'departamento') {
		var divisionId = document.getElementById("division").value;
		if (divisionId != "") {
			$.ajax({
		        type 	 : 'post',
		        url		 : 'Consultor/departamentosSel',
		        dataType : 'json',
		        data 	 : {'divisionId' : divisionId},
		        encode 	 : true
		    }).error(function(){
		        alert('Problemas de conexión, por favor intentelo más tarde');
		        setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		    }).done(function (datos) {
		    	var tag = '<select id="departamento" class="form-control" onchange="tablaProfesores()" required><option value="">Seleccione un departamento</option>';
				for(var i = 0; i < datos.longitud; i++)
					tag = tag + '<option value=' + datos.id[i] + '>' + datos.nombre[i] + '</option>';
				tag = tag + "</select>";
				$("#departamentoSel").empty();
				$("#departamentoSel").append("<h4>Seleccione un departamento: </h4>" + tag);
		    });
		}else
			$("#departamentoSel").empty();
	}
}

function tablaProfesores() {
	$("#botones").empty();
	$("#tablaProfesores").empty();
	var tag = '<table>';
	tag = tag + '<center><ul class="boton">';
	tag = tag + '<li><button id="OBS">Observación</button></li>';
	tag = tag + '<li><button id="AUT">Autoevaluación</button></li>';
	tag = tag + '<li><button id="MAT">Obs-Auto</button></li>';
	tag = tag + '</ul></center>';
	tag = tag + '</table>';
	$("#botones").empty();
	$("#botones").append(tag);

	$("#OBS").on('click', function() {
		var departamentoId = document.getElementById("departamento").value;
		$.ajax({
			type 	 : 'post',
			url		 : 'Consultor/resultadosObs',
			dataType : 'json',
			data 	 : {'departamentoId' : departamentoId},
			encode 	 : true
		}).error(function() {
			alert('Problemas de conexión, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}).done(function (datos) {
			if (datos.longitudResultados != 0) {
				var tag = "";
				tag += "<h3>Profesores Observados</h3>";
				tag += "<table class='tablaProfesores'>";
				tag += "<tr>";
				tag += "<th style='width: 30%; padding: 1%'>Observador</th><th style='width: 30%; padding: 1%'>Observado</th><th style='width: 30%; padding: 1%'>Curso</th><th style='width: 10%'><center style='padding-right: 5px'>Observación</center></th>";
				tag += "</tr>";
				for(var i = 0; i < datos.longitudResultados; i++) {
					tag += "<tr>";
					tag += "<td>" + datos.resultados[i].nombreObservador + "</td>";
					tag += "<td>" + datos.resultados[i].nombreProfesor	  + "</td>";
					tag += "<td>" + datos.resultados[i].clave + ' ' + datos.resultados[i].nombreCurso 	  + "</td>";
					tag += "<td><center><button style='background-color: Transparent; width: 5vw;' onclick='generarPDF("+datos.resultados[i].folio+")'><img src='varios/imagenes/pdf.png'></button></center></div></td>";
					tag += "</tr>";
				}
				tag += "<tr>";
				tag += "<th class='concentradoDep' colspan='2'></th>";
				tag += "<th class='concentradoDep'>Concentrado por departamento</th>";
				tag += "<th class='concentradoDep'><center><button style='background-color: Transparent; width: 5vw;' onclick='concentradoDep()'><img src='varios/imagenes/pdf.png'></button></center></th>";
				tag += "</tr>";
				if ($('#usuario').val() == 'admin' || $('#usuario').val() == 'division') {
					tag += "<tr>";
					tag += "<th class='concentradoDep' colspan='2'></th>";
					tag += "<th class='concentradoDep'>Concentrado por división</th>";
					tag += "<th class='concentradoDep'><center><button style='background-color: Transparent; width: 5vw;' onclick='concentradoDiv()'><img src='varios/imagenes/pdf.png'></button></center></th>";
					tag += "</tr>";
				}
				tag += "</table>";
			}else{
				var tag="";
				tag = "<h3>Departamento sin observaciones realizadas</h3>";
			}		
			$("#tablaProfesores").empty();
			$("#tablaProfesores").append(tag);
		});
	});

	$("#AUT").on('click', function() {
		var departamentoId = document.getElementById("departamento").value;
		$.ajax({
			type 	 : 'post',
			url		 : 'Consultor/resultadosAut',
			dataType : 'json',
			data 	 : {'departamentoId' : departamentoId},
			encode 	 : true
		}).error(function(){
			alert('Problemas de conexión, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}).done(function (datos) {
			if (datos.longitudResultados != 0) {
				var tag = "";
				tag = tag + "<h3>Profesores Autoevaluados</h3>";
				tag = tag + "<table class='tablaProfesores'>";
				tag = tag + "<tr>";
				tag = tag + "<th style='width: 45%; padding: 1%'>Profesor</th><th style='width: 45%; padding: 1%'>Curso</th><th style='width: 10%'><center style='padding-right: 5px'>Autoevaluación</center></th>";
				tag = tag + "</tr>";
				for(var i = 0; i < datos.longitudResultados; i++) {
					tag = tag + "<tr>";
					tag = tag + "<td>" + datos.resultados[i].nombreProfesor	  + "</td>";
					tag = tag + "<td>" + datos.resultados[i].clave + ' ' +  datos.resultados[i].nombreCurso 	  + "</td>";
					tag = tag + "<td><center><button style='background-color: Transparent; width: 60%; height: 60px' onclick='generarPDF("+datos.resultados[i].folio+")'><img src='varios/imagenes/pdf.png'></button></center></div></td>";
					tag = tag + "</tr>";
				}
				tag = tag + "</table>";
			}else{
				var tag="";
				tag = "<h3>Departamento sin autoevaluaciones realizadas</h3>";
			}		
			$("#tablaProfesores").empty();
			$("#tablaProfesores").append(tag);
		});
	});

	$("#MAT").on('click', function() {
		var departamentoId = document.getElementById("departamento").value;
		$.ajax({
			type 	 : 'post',
			url		 : 'Consultor/resultadosAmbos',
			dataType : 'json',
			data 	 : {'departamentoId' : departamentoId},
			encode 	 : true
		}).error(function(){
			alert('Problemas de conexión, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}).done(function (datos) {
			if (datos.longitudResultados != 0) {
				var tag = "";
				tag = tag + "<h3>Profesores Autoevaluados y Observados</h3>";
				tag = tag + "<table class='tablaProfesores'>";
				tag = tag + "<tr>";
				tag = tag + "<th style='width: 30%; padding: 1%'>Observado</th><th style='width: 30%; padding: 1%'>Observador</th><th style='width: 30%; padding: 1%'>Curso</th><th style='width: 5%'><center style='padding-right: 5px'>Autoevaluación</center></th><th style='width: 5%'><center style='padding-right: 5px'>Observación</center></th>";
				tag = tag + "</tr>";
				for(var i = 0; i < datos.longitudResultados; i++) {
					tag = tag + "<tr>";
					tag = tag + "<td>" + datos.resultados[i].nombreProfesor	  + "</td>";
					tag = tag + "<td>" + datos.resultados[i].nombreObservador + "</td>";
					tag = tag + "<td>" + datos.resultados[i].clave + ' ' +  datos.resultados[i].nombreCurso 	  + "</td>";
					tag = tag + "<td><center><button style='background-color: Transparent; width: 60%; height: 60px' onclick='generarPDF("+datos.resultados[i].folioA+")'><img src='varios/imagenes/pdf.png'></button></center></div></td>";
					tag = tag + "<td><center><button style='background-color: Transparent; width: 60%; height: 60px' onclick='generarPDF("+datos.resultados[i].folioO+")'><img src='varios/imagenes/pdf.png'></button></center></div></td>";
					tag = tag + "</tr>";
				}
				tag = tag + "</table>";
			}else{
				var tag="";
				tag = "<h3>Departamento sin cursos para mostrar</h3>";
			}		
			$("#tablaProfesores").empty();
			$("#tablaProfesores").append(tag);
		});
	});
}

function generarPDF(folio) {
	$.ajax({
		type 	 : 'post',
		url 	 : 'PDF/consultorPDF',
		data 	 : {'folio' : folio},
		dataType : 'json',
		encode	 : true
	}).error(function() {
		alert('Problemas de conexión, por favor intentelo más tarde');
		setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
	}).done(function(datosPDF) {
		if (datosPDF.exito) {
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    var a;
			    if (xhttp.readyState === 4 && xhttp.status === 200) {
			        a = document.createElement('a');
			        a.href = window.URL.createObjectURL(xhttp.response);
			        a.download = datosPDF.profesor + '_' + datosPDF.tipoEncuesta + '.pdf';
			        a.style.display = 'none';
			        document.body.appendChild(a);
			        a.click();
			    }
			};
			xhttp.open('POST', 'sioba_'+datosPDF.tipoEncuesta+'.pdf');
			xhttp.setRequestHeader('Content-Type', 'application/json');
			xhttp.responseType = 'blob';
			xhttp.send('folio=' + folio);
		}else{
			alert('Error al generar el PDF, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}
	});

}

function concentradoDep () {
	var departamentoId = document.getElementById("departamento").value;
	$.ajax({
		type 	 : 'post',
		url 	 : 'Consultor/concentradoDep',
		data 	 : {'departamentoId' : departamentoId},
		dataType : 'json',
		encode	 : true
	}).error(function() {
		alert('Problemas de conexión, por favor intentelo más tarde');
		setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
	}).done(function(datosPDF) {
		if (datosPDF.exito) {
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    var a;
			    if (xhttp.readyState === 4 && xhttp.status === 200) {
			        a = document.createElement('a');
			        a.href = window.URL.createObjectURL(xhttp.response);
			        a.download = 'Reporte ' + datosPDF.departamento + '.pdf';
			        a.style.display = 'none';
			        document.body.appendChild(a);
			        a.click();
			    }
			};
			xhttp.open('POST', 'ReporteDepartamento.pdf');
			xhttp.setRequestHeader('Content-Type', 'application/json');
			xhttp.responseType = 'blob';
			xhttp.send();
		}else{
			alert('Error al descargar el PDF, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}
	});
}

function concentradoDiv () {
	var divisionId = document.getElementById("division").value;
	$.ajax({
		type 	 : 'post',
		url 	 : 'Consultor/concentradoDiv',
		data 	 : {'divisionId' : divisionId},
		dataType : 'json',
		encode	 : true
	}).error(function() {
		alert('Problemas de conexión, por favor intentelo más tarde');
		setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
	}).done(function(datosPDF) {
		if (datosPDF.exito) {
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    var a;
			    if (xhttp.readyState === 4 && xhttp.status === 200) {
			        a = document.createElement('a');
			        a.href = window.URL.createObjectURL(xhttp.response);
			        a.download = 'Reporte ' + datosPDF.division + '.pdf';
			        a.style.display = 'none';
			        document.body.appendChild(a);
			        a.click();
			    }
			};
			xhttp.open('POST', 'ReporteDivision.pdf');
			xhttp.setRequestHeader('Content-Type', 'application/json');
			xhttp.responseType = 'blob';
			xhttp.send();
		}else{
			alert('Error al descargar el PDF, por favor intentelo más tarde');
			setTimeout(function(){ window.location.href = 'Consultor/cerrarSesion' }, 2000);
		}
	});
}
