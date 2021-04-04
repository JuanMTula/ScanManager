<?php

Route::get('/', function () {return view('home');});

Route::post('enviar', 'maincontroller@enviar')->name('enviar');
Route::get('lista/{estado?}', 'maincontroller@lista')->name('lista');
Route::get('imagen/{nombre?}', 'maincontroller@imagen')->name('imagen');
Route::get('imagen_sm/{nombre?}', 'maincontroller@imagen_sm')->name('imagen_sm');
Route::post('vaciar', 'maincontroller@vaciar')->name('vaciar');
Route::post('cambiarestado', 'maincontroller@cambiarestado')->name('cambiarestado');
