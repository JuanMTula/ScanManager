<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="favicon.png">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="./css/app.css">

        <title>ScanManager</title>

        <!-- Fonts -->

        <!-- scripts -->

        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


        <!-- Rutas para js -->
        <script>
        const $ruta_enviar="{{route('enviar')}}";
        const $ruta_cambiarestado="{{route('cambiarestado')}}";
        const $ruta_imagen="{{route('imagen')}}";
        const $ruta_lista="{{route('lista')}}";
        const $ruta_imagensm="{{route('imagen_sm')}}";
        const $ruta_vaciar="{{route('vaciar')}}";
        </script>
        <script src="./js/app.js"></script>


    </head>

    <body>

    <div class="containerOFF">


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
                  <h5>Creado pora</h5>
                  <h5>Juan Manuel Tula</h5>
                </div>
                <div class="n">

                  <a href="http://www.madmoss.com" class="white-text" >MadMoss.com</a>
                  <br>
                  <br>

                </div>
              </div>
            </div>
                  <br>
                  <br>
                  <a href="#!" onclick="VaciarTablas()" class="blue-text">Vaciar tablas</p>
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

