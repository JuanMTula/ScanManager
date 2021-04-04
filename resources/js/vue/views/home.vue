<template>
<div>
    <div class="block is-size-2 has-text-centered mt-2">
        <h1 class="title">ScanManager</h1>
        <h2 class="subtitle">Gestion de escaneos online</h2>
    </div>
    <div class="block">
        <div class="tabs is-centered is-boxed">
            <ul>
                <li id="tab-subirImagen" class="tabElem is-active" @click="tabSubirImagen()"><a>Subir imagen</a></li>
                <li id="tab-listado" class="tabElem" @click="tabListado()"><a>Listado</a></li>
                <li id="tab-desarrollo" class="tabElem"  @click="tabDesarrollo()"><a>Desarrollo</a></li>
            </ul>
        </div>


        <div id="seccion-subirImagen" class="secciones">
            <div class="container">
                <div class="columns">
               <div class="column is-half">
                    <div class="ml-3">
                        <div class="field">
                            <label class="label">Identificador</label>
                            <p class="control">
                                <input id="identificador" class="input" type="text">
                            </p>
                        </div>
                        <div class="field">
                            <label class="label">Detalle</label>
                            <p class="control">
                                <input id="detalle" class="input" type="text">
                            </p>
                        </div>
                    </div>
               </div>
               <div class="column is-half has-text-centered">
                    <div class="is-flex is-justify-content-center">
                        <figure class="image is-128x128 ">
                            <img id="imagenSubida" src="pictures.png">
                        </figure>
                    </div>
                    <div class="mt-2">
                        <a onclick="$('#btnfoto').click();" class="imagen-grupo-tomar button is-link ">Tomar imagen</a>
                        <a onclick="$('#btnfoto').click();" class="imagen-grupo-subir button is-warning is-hidden">Cambiarla</a>
                        <a @click="subirImagen()" class="imagen-grupo-subir button is-primary is-hidden">Subirla</a>
                        <input id="btnfoto" name="imagen" type='file' class="is-hidden" @change="leerImagen()" />
                    </div>
               </div>
            </div>
             </div>
        </div>

        <div id="seccion-listado" class="secciones ml-2 mr-2  is-hidden">
            <section class="buttons">
                <button v-if="estado == 1" class="button is-primary listaEstados listaEstado-1" @click="listadoDeImagenes(1)">Pendientes</button>
                <button v-else class="button is-primary is-outlined listaEstados listaEstado-1" @click="listadoDeImagenes(1)">Pendientes</button>

                <button v-if="estado == 2" class="button is-primary listaEstados listaEstado-2" @click="listadoDeImagenes(2)">Verificado</button>
                <button v-else class="button is-primary is-outlined listaEstados listaEstado-2" @click="listadoDeImagenes(2)">Verificado</button>

                <button v-if="estado == 3" class="button is-primary listaEstados listaEstado-3" @click="listadoDeImagenes(3)">Borrado</button>
                <button v-else class="button is-primary is-outlined listaEstados listaEstado-3" @click="listadoDeImagenes(3)">Borrado</button>
            </section>
            <div class="is-flex is-flex-direction-row is-flex-wrap-wrap">

                <div v-bind:key="objeto.imagen" v-for="objeto in lista"  @click="verImagen(objeto)" class="tile m-2 tiles-width is-clickable">
                    <article class="tile is-child notification is-info">
                        <p class="title">{{objeto.identificador}}</p>
                        <p class="subtitle">{{objeto.detalle}}</p>
                        <figure class="image is-4by3">
                            <img :src="ruta_sm+objeto.imagen">
                        </figure>
                    </article>
                </div>

                <section v-if="lista.length == 0" class="hero is-warning">
                    <div class="hero-body">
                        <p class="title">
                            No hay imagenes
                        </p>
                    </div>
                </section>

            </div>
            <div class="modal" id="modalDetalleDeImagen">
                <div class="modal-background"></div>
                <div class="modal-content">
                    <div class="content m-2">

                        <div class="message is-info message-fix">
                            <div class="message-header">
                                <h1>
                                   <span @click="volverALaLista()" class="is-clickable mr-2">
                                       <BackIcon/>
                                   </span>
                                   <span @click="mostrarOcultarOpciones()" class="is-clickable mr-4">
                                       <OptionsIcon/>
                                   </span>
                                   {{imagen.identificador}}</h1>
                            </div>
                            <div id='opcionesDeImagen' class="message-body p-0 collapsed">
                                <div class="p-4">
                                    <p class="has-text-black">{{imagen.detalle}}</p>
                                    <p>Modificar estado :</p>
                                    <div class="content">
                                        <section class="buttons">
                                            <button v-if="imagen.estado == 1" class="button is-primary ">Pendientes</button>
                                            <button v-else class="button is-primary is-outlined " @click="cambiarEstado(1)" >Pendientes</button>
                                            <button v-if="imagen.estado == 2" class="button is-primary " >Verificado</button>
                                            <button v-else class="button is-primary is-outlined " @click="cambiarEstado(2)" >Verificado</button>
                                            <button v-if="imagen.estado == 3" class="button is-primary " >Borrado</button>
                                            <button v-else class="button is-primary is-outlined " @click="cambiarEstado(3)" >Borrado</button>
                                        </section>
                                    </div>
                                    <p>Herramientas de modificacion:</p>
                                    <label class="checkbox mb-4">
                                        <input type="checkbox" v-model="ajustarImagen" true-value="1" false-value="0" @click="ajustar()">
                                        Ajustar tamaño a pantalla
                                    </label>
                                    <br>

                                    <label class="checkbox mb-4">
                                        Hue &nbsp;
                                    </label>
                                        <input type="range" min="0" max="90" value="0" class="slider" id="hueSlide" @input="hue()">
                                    <br>

                                    <label class="checkbox mb-4">
                                        Contraste &nbsp;
                                    </label>
                                        <input type="range" min="0" max="200" value="100" class="slider" id="contrastSlide" @input="contraste()">
                                    <br>

                                    <label class="checkbox mb-4">
                                        Brillo &nbsp;
                                    </label>
                                        <input type="range" min="0" max="200" value="100" class="slider" id="brilloSlide" @input="brillo()">
                                    <br>

                                    <label class="checkbox mb-4">
                                        Invertir &nbsp;
                                    </label>
                                    <input type="range" min="0" max="100" value="0" class="slider" id="invertirSlide" @input="invertir()">
                                    <br>
                                </div>
                            </div>
                        </div>

                    </div>
                        <span id="filtroBrillo">
                            <span id="filtroContraste">
                                <span id="filtroHue">
                                    <img id="fullImage" class="" style="max-width: unset;" :src="ruta+imagen.imagen" >
                                </span>
                            </span>
                        </span>
                </div>
            </div>
        </div>

        <div id="seccion-desarrollo" class="secciones is-hidden">
            <section class="hero is-primary">
                <div class="hero-body">
                    <p class="title has-text-centered is-size-1">ScanManager</p>
                    <p class="subtitle has-text-centered mb-1">Gestion de escaneo de imagenes para analisis con filtros.</p>
                    <p class="subtitle has-text-centered mb-1">Compatible con todo tipo de dispositivos, permite establecer estados y organizar por medio de estos.</p>
                    <p class="subtitle has-text-centered mb-1">Aplicacion sin fines de lucro, no apto para uso profesional, y de libre distribucion.</p>
                    <p class="subtitle has-text-centered mb-5">Creado por Juan Manuel Tula</p>
                    <p class=" has-text-centered">
                        <button class="button is-danger" @click="vaciar()">Vaciar el listado</button>
                    </p>
                    <hr>
                    <p class="subtitle has-text-centered is-size-3">Herramientas usadas</p>
                    <p class="subtitle has-text-centered mb-1">
                        <a target="_blank" href="https://laravel.com/">Laravel</a> -
                        <a target="_blank" href="https://www.php.net/">Php</a> -
                        <a target="_blank" href="https://www.mysql.com/">MySql</a>
                    </p>
                    <p class="subtitle has-text-centered mb-1">
                        <a target="_blank" href="https://es.vuejs.org/">Vue</a> -
                        <a target="_blank" href="https://mazipan.github.io/vue-ionicons">Vue Ionicons</a> -
                        <a target="_blank" href="https://jquery.com/">Jquery</a> -
                        <a target="_blank" href="https://bulma.io/">Bulma css</a>
                    </p>
                    <p class="subtitle has-text-centered mb-1">
                        <a target="_blank" href="https://sweetalert2.github.io/">SweetAlert2</a> -
                        <a target="_blank" href="https://github.com/axios/axios">Axios</a>
                    </p>
                    <p class="subtitle has-text-centered mb-5">
                        <a target="_blank" href="https://github.com/JuanMTula/ScanManager">GitHub del proyecto</a>
                    </p>
                </div>
            </section>
        </div>

    </div>
</div>
</template>

<script>
import BackIcon from 'vue-ionicons/dist/ios-arrow-back.vue'
import OptionsIcon from 'vue-ionicons/dist/ios-options.vue'

export default {
    name: "home",
    components: {
        BackIcon,OptionsIcon
    },
    data: function() {
        return  {
            lista: [],
            ruta_sm: window.siteRoutes['imagensm'],
            ruta: window.siteRoutes['imagen'],
            estado: window.constantes['estadoPendiente'],
            imagen:[],
            ajustarImagen:"0"
        }
    },
    methods:{
        init: function () {

        },
        cambiarTab: function (nuevaTab) {
            $('.tabElem').removeClass('is-active');
            $('#tab-'+nuevaTab).addClass('is-active');
            $('.secciones').addClass('is-hidden');
            $('#seccion-'+nuevaTab).removeClass('is-hidden');

        },
        tabSubirImagen: function (){
            let that = this;
            that.cambiarTab('subirImagen');

        },
        tabListado: function (){
            let that = this;
            that.cambiarTab('listado');
            that.listadoDeImagenes(that.estado);
        },
        tabDesarrollo: function (){
            let that = this;
            that.cambiarTab('desarrollo');

        },
        leerImagen: function (){
            let that = this;
            if($('#btnfoto').val() == ""){
                that.resetearImagen();
                return false;
            }
            var objeto = $('#btnfoto');
            if (   objeto[0].files
                && objeto[0].files[0]
                && (   objeto[0].files[0]['type'].includes("png")
                    || objeto[0].files[0]['type'].includes("img")
                    || objeto[0].files[0]['type'].includes("jpeg")
                    || objeto[0].files[0]['type'].includes("bmp") ) )
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagenSubida')
                        .attr('src', e.target.result);
                    };
                reader.readAsDataURL(objeto[0].files[0]);
                $('.imagen-grupo-tomar').addClass('is-hidden');
                $('.imagen-grupo-subir').removeClass('is-hidden');
            }else{
                window.mensaje_grande('Tipo de imagen no valida, solo se aceptan png, img, jpeg y bmp');
            }
        },
        subirImagen: function (){
            $('.imagen-grupo-subir').addClass('is-hidden');
            if($('#identificador').val().length < 1 ){
                $('.imagen-grupo-subir').removeClass('is-hidden');
                window.mensaje_grande("El campo de identificador es requerido");
                return false;
            }
            if($('#btnfoto')[0].files.length == 0){
                $('.imagen-grupo-subir').removeClass('is-hidden');
                window.mensaje_grande("Una imagen es requerida");
                return false;
            }
            Swal.showLoading();
            var bodyFormData = new FormData();
            bodyFormData.set('identificador', $("#identificador").val());
            bodyFormData.set('detalle', $("#detalle").val());
            bodyFormData.append('imagen', $('#btnfoto[type=file]')[0].files[0]);
            let that = this;
            axios({
                method: 'post',
                url: window.siteRoutes['enviar'],
                data: bodyFormData,
                responseType: 'json',
                headers: {'Content-Type': 'multipart/form-data' }
            })
            .then(function (res) {
                Swal.close();
                if (res.data.status == "success") {
                    that.resetearImagen();
                    $("#identificador").val("");
                    $("#detalle").val("");
                    window.mensaje_rapido(res.data.message,'success');
                } else if(res.data.status == "error") {
                    $('.imagen-grupo-subir').removeClass('is-hidden');
                    window.mensaje_grande(res.data.message,"Error al enviar imagen",'error')
                } else {
                    window.mensaje_bloqueador("Error critico al enviar imagen",'error');
                }
            });
        },
        listadoDeImagenes: function (estado){
            let that = this;
            that.estado = estado;
            $('.listaEstados').addClass('is-outlined');
            $('.listaEstado-'+estado).removeClass('is-outlined');
            axios.get(window.siteRoutes['lista']+estado)
                .then(res => that.lista = res.data);
        },
        resetearImagen:function (){
            $('#btnfoto').val("");
            $('#imagenSubida').attr('src',"pictures.png");
            $('.imagen-grupo-tomar').removeClass('is-hidden');
            $('.imagen-grupo-subir').addClass('is-hidden');
        },
        vaciar:function (){

            Swal.fire({
                title: 'Vaciar',
                text: "Seguro quiere vaciar el listado de imagenes?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, vaciar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    axios({
                        method: 'post',
                        url: window.siteRoutes['vaciar'],
                        responseType: 'json',
                    })
                        .then(function (res) {
                            Swal.close();
                            if (res.data.status == "success") {

                                window.mensaje_rapido(res.data.message,'success');
                            } else if(res.data.status == "error") {

                                window.mensaje_grande(res.data.message,"Error al vaciar imagenes",'error')
                            } else {
                                window.mensaje_bloqueador("Error critico al vaciar imagenes",'error');
                            }
                        });

                }
            });



        },
        verImagen: function (objeto){
            this.imagen = objeto;
            $('#modalDetalleDeImagen').addClass('is-active');
        },
        cambiarEstado(nuevoEstado){
            let that = this;
            Swal.showLoading();
            axios.post(window.siteRoutes['cambiarestado'], {
                estado: nuevoEstado,
                imagen: that.imagen.imagen,
            })
                .then(function (res) {
                    Swal.close();
                    if(res.data.status == "success"){

                        that.imagen.estado = nuevoEstado;
                        that.listadoDeImagenes(that.estado);
                        window.mensaje_rapido('Estado cambiado','success');
                    }
                    else if(res.data.status == "error"){
                        window.mensaje_grande(res.data.message,"Error al cambiando estado",'error');
                    }else{
                        window.mensaje_bloqueador("Error critico al cambiando estado",'error');
                    }
                })
                .catch(function () {
                    Swal.close();
                    window.mensaje_bloqueador("Error critico al cambiando estado",'error');
                });


        },
        ajustar:function (){
            $('#fullImage').first().css('max-width','100%');

            if(this.ajustarImagen == "1")
                $('#fullImage').first().css('max-width','unset');

        },
        hue:function (){
            $('#filtroHue').css('filter','hue-rotate('+$('#hueSlide').val()+'deg)')
        },
        invertir:function (){
            $('#fullImage').css('filter','invert('+$('#invertirSlide').val()+'%)')
        },
        contraste:function (){
            $('#filtroContraste').css('filter','contrast('+$('#contrastSlide').val()+'%)')
        },
        brillo:function (){
            $('#filtroBrillo').css('filter','brightness('+$('#brilloSlide').val()+'%)')
        },
        resetearFiltros:function (){
            this.ajustarImagen = '0';
            $('#hueSlide').val('0');
            $('#contrastSlide').val('100');
            $('#brilloSlide').val('100');
            $('#invertirSlide').val('0');
            this.hue();
            this.invertir();
            this.contraste();
            this.brillo();
            this.ajustar();
            $('#fullImage').first().css('max-width','unset');
        },
        volverALaLista: function (){
            $('#modalDetalleDeImagen').removeClass('is-active');
            this.resetearFiltros();
        },
        mostrarOcultarOpciones(){
            $('#opcionesDeImagen').toggleClass('collapsed');
        }
    }
}
</script>

<style scoped>

.message-fix{
    width: fit-content!important;
}
.message-body{

    overflow:hidden;
    transition:max-height 0.3s ease-out;
height:auto;
    max-height:600px;
}

.message-body.collapsed {
    max-height:0;
}


</style>
