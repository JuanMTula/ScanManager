<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="favicon.png">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <title>ScanManager</title>

        <style>
.btn-plr5{
      padding-left: 5px;
    padding-right: 5px;
}
.chfix2{
  position: fixed;
  left: 10px;
  top: 10px;
  -webkit-backface-visibility: hidden;
}

.chfix{
  margin-top: 15px;
}
.imgviewer {
  position: absolute;
  left: 0px;
  top: 0px;
  z-index: 1002;
  width: 20000px;
  height:20000px;
  margin: 0;
  display: block;
  background-color: white;
  background-repeat: no-repeat;


}

.preloader .preloader-spin {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1001;
  width: 80px;
  height: 80px;
  margin: -40px 0 0 -40px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border: 2px solid transparent;
  border-top-color: #b9b7ff;
  -webkit-animation: PreloaderSpin 2s linear infinite;
  animation: PreloaderSpin 2s linear infinite;
  display: block;
  border-top-color: #2c181e;
}

.preloader-spin:before {
  content: "";
  position: absolute;
  top: 4px;
  left: 4px;
  right: 4px;
  bottom: 4px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border: 2px solid transparent;
  border-top-color: #00bcd4;
  -webkit-animation: PreloaderSpin 3s linear infinite;
  animation: PreloaderSpin 3s linear infinite;
  border-top-color: #ca7b8a;
}

.preloader-spin:after{
  content: "";
  position: absolute;
  top: 10px;
  left: 10px;
  right: 10px;
  bottom: 10px;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border: 2px solid transparent;
  border-top-color: #a3e7f0;
  -webkit-animation: PreloaderSpin 1.5s linear infinite;
  animation: PreloaderSpin 1.5s linear infinite;
  border-top-color: #f0c7cd;
}

.preloader{
  position:fixed;
  left:0;
  right:0;
  top:0;
  bottom:0;
  z-index:999999;
  opacity:1;
  background:#fff;
}

@-webkit-keyframes PreloaderSpin{
  0%{
    -webkit-transform:rotate(0deg);
    -ms-transform:rotate(0deg);
    transform:rotate(0deg)
  }
  100%{
    -webkit-transform:rotate(360deg);
    -ms-transform:rotate(360deg);
    transform:rotate(360deg)
  }
}
@keyframes PreloaderSpin{
  0%{
    -webkit-transform:rotate(0deg);
    -ms-transform:rotate(0deg);
    transform:rotate(0deg)
  }
  100%{
    -webkit-transform:rotate(360deg);
    -ms-transform:rotate(360deg);
    transform:rotate(360deg)
  }
}

/* made with love by Micaela Echeverría www.micaela.com.ar */
        </style>

        <!-- Fonts -->

        <!-- scripts -->

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <script>

        var $imagen='';
        var $imageninfo;

        const Toast = Swal.mixin({
                  toast: true,
                  position: 'center',
                  showConfirmButton: false,
                  timer: 3000
  })

        $( document ).ready(function() {

            $('.tabs').tabs();

            reloadtable(0);

            $("#filtrarx").keyup(function () {

            var rows = $("#listado").find(".eof").hide();

            if (this.value.length) {
                var data = this.value.split(" ");

                data[0] = data[0];
                data[1] = data[0].toLowerCase();
                data[2] = data[0].charAt(0).toUpperCase() + data[0].slice(1);
                data[3] = data[0].toUpperCase();

                $.each(data, function (i, v) {
                   rows.filter(":contains('" + v + "')").show();
                });
            } else rows.show();
        });

        });

        function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                            .attr('src', e.target.result);
                        $imagen = e.target.result;
                    };
                    $('#blah').show();
                    $('#btnenviar').show();
                    reader.readAsDataURL(input.files[0]);
                }
            }

        function enviar(){

            if($('#Nombre').val() == "" ){

                Toast.fire({
                  type: 'warning',
                  title: 'El campo nombre no puede estar vacio.'
                });

                return;

            }

            if($('#Titulo').val() == "" ){

                Toast.fire({
                  type: 'warning',
                  title: 'El campo titulo no puede estar vacio.'
                });

                return;

            }

            if($imagen == "" ){

                Toast.fire({
                  type: 'warning',
                  title: 'Es necesaria una foto.'
                });

                return;

            }

            $('#loading').show();

          axios.post("{{route('enviar')}}", {
            nombre: $('#Nombre').val(),
            titulo: $('#Titulo').val(),
            imagen: $imagen
          })
          .then(function (response) {

            switch (response.data) {
                case 0:

                    Toast.fire({
                      type: 'warning',
                      title: 'El servidor no permitio guardar los datos.'
                    });

                    break;

                case 1:

                    Toast.fire({
                      type: 'success',
                      title: 'Captura y descripción enviada'
                    });

                    $('#Titulo').val('');
                    imagen = "";
                    $("#btnfoto").val(null);
                    $('#blah').hide();
                    $('#btnenviar').hide();

                    reloadtable();

                    break;

            }

                $('#loading').hide();

                return;



          })
          .catch(function (error) {

                    Toast.fire({
                  type: 'error',
                  title: 'Hay un error desconocido, ver en la consola.'
                });
            console.log(error);
          });






        }

        function cambiarestado($uid,$estado,$estadofrom){


          axios.post("{{route('cambiarestado')}}", {
            uid: $uid,
            estado: $estado
          })
          .then(function (response) {

            switch (response.data) {
                case 'error':

                    Toast.fire({
                      type: 'warning',
                      title: 'No se pudo modificar.'
                    });

                    break;

                case 1:

                    Toast.fire({
                      type: 'success',
                      title: 'Modificado'
                    });

                    reloadtable($estadofrom);


                    break;

            }



                return;



          });





        }

        function verimagen($imguid){

            $('#loading').show();

            $imageninfo = new Image();
            $imageninfo.src = "{{route('imagen')}}/"+$imguid;
            $("#imgviw2").css("background-image","url({{route('imagen')}}/"+$imguid+")");
            $("#imgviw").show();
            $(".chfix2").css("top",10);

            $imageninfo.onload = function()
              {

              if($imageninfo.height < 100){
              $(".chfix2").css("top",130);

              }

              $('#loading').hide();

              };




        }

        function reloadtable($estado){

          var $nuevo_estado = 0 ;
          var $nuevo_estado_icono = '' ;

            $(".btn0ac").removeClass("blue");
            $(".btn1ac").removeClass("blue");
            $(".btn2ac").removeClass("blue");

            switch ($estado) {
                case 0:
                    $(".btn0ac").addClass("blue");

                    break;

                case 1:
                    $(".btn1ac").addClass("blue");

                    break;

                case 2:
                    $(".btn2ac").addClass("blue");


                    break;

            }


          $('#listado').empty();

          axios.get("{{route('lista')}}/"+$estado, {

          })
          .then(function (response) {

            if (response.data == 'empty'){


                $('#listado').empty();

                $('#listado').append(`

                  <div>
                    <h5 class="center-align">No hay elemento en esta tabla.</h5>
                  </div>

                `);


                return 0;

            }

            switch ($estado) {
                case 0:

                    $nuevo_estado = 1;
                    $nuevo_estado_icono = 'check' ;

                    break;

                case 1:

                    $nuevo_estado = 0;
                    $nuevo_estado_icono = 'check_box_outline_blank' ;

                    break;

                case 2:

                    $nuevo_estado = 0;
                    $nuevo_estado_icono = 'arrow_back' ;

                    break;

            }

            var $resp = '';
            $('#listado').empty();


           response.data.forEach(data => {



            $resp=`
              <div class="card horizontal chfix eof" >
                <div class="card-image">
                  <img  src="{{route('imagen_sm')}}/`+data.uid+`" >
                </div>
                <div class="card-stacked">

                  <div class="card-content">
                    <span class="card-title">`+data.nombre+`</span>
                    <p>`+data.titulo+`</p>
                  </div>
                  <div class="card-action">

                      <a href="#"  onclick="cambiarestado('`+data.uid+`',`+$nuevo_estado+','+$estado+`)" class="waves-effect waves-light btn light-green lighten-3"><i class="material-icons tiny">`+$nuevo_estado_icono+`</i></a> &nbsp;&nbsp;

                      <a href="#!" onclick="verimagen('`+data.uid+`')" class="waves-effect waves-light btn blue lighten-3"><i class="material-icons tiny">pageview</i></a>

                      <a href="#"  onclick="cambiarestado('`+data.uid+`', 2,`+$estado+`)" class="waves-effect waves-light btn right deep-orange lighten-2"><i class="material-icons tiny">delete</i></a>

                  </div>
                </div>
              </div>
                `;

                $('#listado').append($resp);



                })

          })

          $nuevo_estado = 0 ;
          $nuevo_estado_icono = '' ;

        }


    </script>

    </head>
    <body>
    <div class="container">


      <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2">
          <div style="height:20px"></div>
        <a class="flow-text">&nbsp; ScanManager</a>
          <ul class="tabs">
            <li class="tab col s3"><a class="active" href="#scan">Scan</a></li>
            <li class="tab col s3"><a href="#lista">Listado</a></li>
            <li class="tab col s3"><a href="#help">?</a></li>
          </ul>

        <div id="scan" class="col s12">



            <div style="height:30px"></div>

            <div class="row">
                <div class="input-field col s12">
                  <input id="Nombre" type="text">
                  <label for="Nombre">Nombre</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input id="Titulo" type="text">
                  <label for="Titulo">Titulo</label>
                </div>
            </div>
            <div class="row">
                <div class="center">
                    <a onclick="$('#btnfoto').click()" class="waves-effect waves-light btn-small"><i class="material-icons right">camera_alt</i>Tomar fotografia</a>
                </div>
                <input id="btnfoto" type='file' style="display:none" onchange="readURL(this);" />

                <div style="height:20px"></div>
                <div class="center">
                    <img id="blah" src="#" alt="your image" style="display:none;max-width:350px;max-height:300px"/>
                </div>

            </div>

            <div class="row">
                <div class="center">
                    <a onclick="enviar()" style="display:none" id="btnenviar" class="waves-effect waves-light btn-small green"><i class="material-icons right">chevron_right</i>Enviar</a>
                </div>

            </div>






        </div>
        <div id="lista" class="col s12">
          <div style="height:10px;"></div>
          <div id="filtro" class="col s12">
            <a href="#!" onclick="reloadtable(0)" class="btn0ac waves-effect waves-light btn btn-small btn-plr5">Pendientes</a>
            <a href="#!" onclick="reloadtable(1)" class="btn1ac waves-effect waves-light btn btn-small btn-plr5">Verificados</a>
            <a href="#!" onclick="reloadtable(2)" class="btn2ac waves-effect waves-light btn btn-small btn-plr5">Borrados</a>
          </div>
          <div id="busqueda" class="col s12">
            <input placeholder="Filtrar" id="filtrarx" type="text">
          </div>
        <div id="listado" class="col s12">

        </div>
        </div>
        <div id="help" class="col s12">

          <div style="height:20px;"></div>

          <div class="row center">
            <div class="col s12">
              <div class="card blue darken-1">
                <div class="card-content white-text">
                  <span class="card-title">MadMoss</span>
                  <p>Servicio de gestion de imagenes con cambio de estado, de acceso publico, con fines demostrativos.</p>
                  <div style="height:20px;"></div>
                  <h5>Creado por Juan Manuel Tula</h5>
                </div>
                <div class="card-action">
                  <a href="http://www.madmoss.com">MadMoss.com</a>

                </div>
              </div>
            </div>
          </div>



        </div>

        </div>
      </div>

       <div id="loading" class="preloader" style="display:none;opacity: 0.7">
          <div class="preloader-spin"></div>
       </div>


       <div id="imgviw" style="display:none;">

          <div class="imgviewer" id="imgviw2">

            <a onclick="$('#imgviw').hide()" class="btn-floating btn-large waves-effect waves-light green chfix2" style="margin: 5px;"><i class="material-icons">chevron_left</i></a>

          </div>

       </div>

    </div>

    </body>

</html>

