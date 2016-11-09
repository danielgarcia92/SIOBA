function startApp() {
    gapi.load('auth2', function() {
        auth2 = gapi.auth2.init({
            client_id: '58368345419-rqhe4qdlr3t8u8ho4nc8puhvcdq44ufg.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
        });
        attachSignin(document.getElementById('customBtn'));
    });
}

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
        	var perfil = googleUser.getBasicProfile();
        	//console.log(perfil);
            var listaGuardarIngreso = {
                'nombre'		  : perfil.getName(),
                'correoConsultor' : perfil.getEmail(),
                'idToken'		  : googleUser.Zi.id_token,
                'accessToken'	  : googleUser.Zi.access_token
            };
            $.ajax({
                type        : 'post',
                url         : 'LoginConsultor/guardarIngreso',
                data        : listaGuardarIngreso,
                dataType    : 'json',
                encode      : true
            }).error(function() {
                $("#output").removeClass('alert alert-success');
                $("#output").addClass('alert alert-danger animated fadeInUp').html('Error de conexión. Por favor intentelo más tarde');
                googleUser.disconnect();
                setTimeout(function(){ $("#output").removeClass('alert alert-danger animated fadeInUp'); }, 2000);
            }).done(function (datos) {
                if (datos.exito) {
                    $.getJSON('https://picasaweb.google.com/data/entry/api/user/'+ perfil.getEmail() +'?alt=json')
                    .done(function(data){
                        var j = JSON.stringify(data);
                        obj = JSON.parse(j);
                        document.getElementById('avatar').style.backgroundImage = "url('"+obj.entry.gphoto$thumbnail.$t+"')";
                        $("#output").addClass('alert alert-success animated fadeInUp').html('Bienvenido ' + '<span>' + perfil.ofa + '</span>');
                        $("#output").removeClass(' alert-danger');
                        setTimeout(function(){
                            form = $('<form></form');
                            form.attr('method', 'POST');
                            form.attr('action', 'Consultor');

                            input = $('<input />');
                            input.attr('type', 'hidden');
                            input.attr('name', 'correoConsultor');
                            input.attr('value', datos.correo);
                            input.appendTo(form);
                            
                            input = $('<input />');
                            input.attr('type', 'hidden');
                            input.attr('name', 'usuario');
                            input.attr('value', datos.usuario);
                            input.appendTo(form);
                            
                            $('body').append(form);
                            form.submit();
                        }, 2000);
                    });
                }else{
                    $("#output").removeClass('alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("Sin permisos para ingresar");
                    googleUser.disconnect();
                    setTimeout(function(){ $("#output").removeClass('alert alert-danger animated fadeInUp'); }, 2000);
                }
            });
        }, function(error) {
            //alert(JSON.stringify(error, undefined, 2));
            $("#output").removeClass('alert alert-success');
            $("#output").addClass('alert alert-danger animated fadeInUp').html('Error de conexión. Por favor intentelo más tarde');
            googleUser.disconnect();
            setTimeout(function(){ $("#output").removeClass('alert alert-danger animated fadeInUp'); }, 2000);
        }
    );
}
