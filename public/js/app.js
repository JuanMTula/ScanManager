
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

          axios.post($ruta_enviar, {
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

                    reloadtable(0);

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


          axios.post($ruta_cambiarestado, {
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
            $imageninfo.src = $ruta_imagen+"/"+$imguid;
            $("#imgviw2").css("background-image","url("+$ruta_imagen+"/"+$imguid+")");
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

          axios.get($ruta_lista+"/"+$estado, {

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
                  <img  src="`+$ruta_imagensm+`/`+data.uid+`" >
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

        function VaciarTablas(){




          axios.get($ruta_vaciar, {

          })
          .then(function (response) {

            if (response.data == '1'){


              reloadtable(0);


              return ;

            }

          })

        }


