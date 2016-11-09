$(document).on('ready', profesoresSel);

$(function(){
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
});

function profesoresSel() {
	$.ajax({
        type        : 'post',
        url         : 'Calificador/profesoresSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function(){ window.location.href = 'Calificador/cerrarSesion' }, 2000);
    })
    .done(function (datos) {
		var tag = '<select class="form-control" id = "profesor" name = "profesor" onchange="cursosSel(this.value)" required><option value="" >Seleccione un Profesor</option>';
    	for(var i = 0; i < datos.longitud; i++)
     		tag = tag + "<option value=" + datos.pidm[i] + ">" + datos.nombre[i] + "</option>";
    	tag = tag + "</select>";
    	$("#divProfesores").append(tag);
    	$("#page").show();
    	tipoSel();
    	cursosSel();
    	periodoSel();
	});
}

function tipoSel() {
	var tag = '<select id = "tipo" style="width: 100%" class="form-control" name = "tipo" onchange="cambiar(this.value)">';
	tag = tag + '<option value="A">Autoevaluación</option>';
	tag = tag + '<option value="O">Observador</option>';
	tag = tag + '</select>';
	$("#divTipo").append("<B class='textos'>Tipo de observación:</B><br>" + tag);
	$("#page").show();
	divisionesSel();
	departamentosSel();
}

function cursosSel(pidm) {
	if (pidm == undefined || pidm == '') {
		var tag = '<input type="text" class="form-control" style="width: 100%; height: 34px" name="curso" id="curso" value="Seleccione un profesor" readonly>';
		$("#enviarBoton").hide();
		$("#divCursos").html("");
		$("#divCursos").append("<B class='textos'>Curso:</B><br>" + tag);
		$("#page").show();
	}
	else{
		$.ajax({
        	type        : 'post',
        	url         : 'Calificador/cursosSel',
        	data 		: {'pidm' : pidm},
        	dataType    : 'json',
        	encode      : true
    	})
    	.error(function(){
        	alert('Problemas de conexión, por favor intentelo más tarde');
        	setTimeout(function(){ window.location.href = 'Calificador/cerrarSesion' }, 2000);
    	})
	    .done(function (datos) {
	    	if (datos.longitud == 0) {
	    		tag = '<input type="text" class="form-control" style="width: 100%; height: 34px" name="curso" id="curso" placeholder="Sin cursos para este semestre" readonly></input>';
	    	}else{
	    		var tag = '<select class="form-control" id = "curso" name = "curso" required><option value="" >Seleccione un Curso</option>';
				for(var i = 0; i < datos.longitud; i++)
	     			tag = tag + "<option value=" + datos.crn[i] + ">" + datos.clave[i] + " " + datos.curso[i] + "</option>";
	    		tag = tag + "</select>";
	    		$("#enviarBoton").show();
	    	}
	    	$("#divCursos").html("");
			$("#divCursos").append("<B class='textos'>Curso:</B><br>" + tag);
			$("#page").show();
		});
	}
}

function observadoresSel() {
	$.ajax({
        type        : 'post',
        url         : 'Calificador/observadoresSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function() { window.location.href = 'Calificador/cerrarSesion' }, 2000);
    })
    .done(function (datos) {
		var tag = '<select class="form-control" id = "observador" name = "observador" required><option value="" >Seleccione un Observador</option>';
    	for(var i = 0; i < datos.longitud; i++)
     		tag = tag + "<option value=" + datos.pidm[i] + ">" + datos.nombre[i] + "</option>";
    	tag = tag + "</select>";
    	$("#divObservadores").append("<B class='textos'>Observador:</B><br>" + tag + "<br>");
    	$("#page").show();
	});
}

function divisionesSel() {
	$.ajax({
        type        : 'post',
        url         : 'Calificador/divisionesSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function() { window.location.href = 'Calificador/cerrarSesion' }, 2000);
    })
	.done(function (datos) {
		var tag = '<select class="form-control" id = "division" name = "division" onchange="departamentosSel(this.value)" required><option value="">Seleccione una División</option>';
		for(var i = 0; i < datos.longitud; i++)
			tag = tag + "<option value=" + datos.division[i].id + ">" + datos.division[i].codigo + "</option>";
		tag = tag + "</select>";
		$("#divDivisiones").html("");
		$("#divDivisiones").append("<B class='textos'>División:</B><br>" + tag);
		$("#page").show();
	});
	
}

function departamentosSel(divisionId) {
	$.ajax({
        type        : 'post',
        url         : 'Calificador/departamentosSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function(){ window.location.href = 'Calificador/cerrarSesion' }, 2000);
    })
	.done(function (datos) {
		if (divisionId == undefined || divisionId == '') {
			var tag = '<select class="form-control" id = "departamento" name = "departamento" required><option value="">Seleccione un Departamento</option>';
			for(var i = 0; i < datos.longitud; i++)
				tag = tag + "<option value=" + datos.departamento[i].id + ">" + datos.departamento[i].nombre_departamento +"</option>";
			tag = tag + "</select>";
			$("#divDepartamentos").html("");
			$("#divDepartamentos").append("<B class='textos'>Departamento:</B><br>" + tag);
			$("#page").show();
		}else{
			var tag = '<select class="form-control" id = "departamento" name = "departamento" required><option value="">Seleccione un Departamento</option>';
			for(var i = 0; i < datos.longitud; i++){
				if (datos.departamento[i].id_divisiones == divisionId)
					tag = tag + "<option value=" + datos.departamento[i].id + ">" + datos.departamento[i].nombre_departamento +"</option>";
			}
			tag = tag + "</select>";
			$("#divDepartamentos").html("");
			$("#divDepartamentos").append("<B class='textos'>Departamento:</B><br>" + tag);
			$("#page").show();
		}
	});
	
}

function periodoSel() {
	$.ajax({
        type        : 'post',
        url         : 'Calificador/periodoSel',
        dataType    : 'json',
        encode      : true
    })
    .error(function(){
        alert('Problemas de conexión, por favor intentelo más tarde');
        setTimeout(function() { window.location.href = 'Calificador/cerrarSesion' }, 2000);
    })
	.done(function (datos) {
		var tag = '<input class="form-control" type="text" name="periodo" style="width: 100%; height: 34px" value="' + datos.descripcion + '" readonly>';
		$("#divPeriodo").html("");
		$("#divPeriodo").append("<B class='textos'>Periodo:</B><br>" + tag);
		$("#page").show();
	});
}

function cambiar(val) {
	if (val == "A")
		$("#divObservadores").empty();
	else
		observadoresSel();
}
