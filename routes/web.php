<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    //requerimentos
    if(true){

        //php 7.2
        $M_php_version_req = 7.2;
            if(floatval(substr(phpversion(),0,3)) < $M_php_version_req) {
            die("Requisito necesario : php ".$M_php_version_req." o superior.");
        }

        //Modulos requeridos de php

        $M_php_lib_req = array("gd","mysqli", "mbstring","json");
            foreach ($M_php_lib_req as &$M_php_lib) {

            if(array_search($M_php_lib, get_loaded_extensions()) == false){
             die("Requisito necesario : libreria '".$M_php_lib."' instalada.");
            }

        }

        }

    return view('home');

});


Route::post('enviar', 'maincontroller@enviar')->name('enviar');
Route::get('imagen/{nombre?}', 'maincontroller@imagen')->name('imagen');
Route::get('imagen_sm/{nombre?}', 'maincontroller@imagen_sm')->name('imagen_sm');

Route::get('lista/{estado?}', 'maincontroller@lista')->name('lista');

Route::post('cambiarestado', 'maincontroller@cambiarestado')->name('cambiarestado');

Route::get('vaciar', 'maincontroller@vaciar')->name('vaciar');