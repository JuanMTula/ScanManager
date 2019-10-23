<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class maincontroller extends Controller
{

    public function enviar(){


        $uid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));

        $data = explode(',', request('imagen'));
        $content = base64_decode($data[1]);
        Storage::put( $uid.'.png', $content);


        $scans = new \App\scans;

        $scans->nombre = request('nombre');
        $scans->titulo = request('titulo');
        $scans->uid = $uid ;
        $scans->estado = 0;

        $res = $scans->save();

        if($res){
            return 1;
        }else{
            return 0;

        }

        return "Error, fuera de respuestas posibles.";

    }

    public function cambiarestado(){

        $res = \App\scans::where('uid', request('uid'))
                  ->update(['estado' =>  request('estado')]);


        if($res){

            return 1;

        }else{

            return 'error';

        }

        return "Error, fuera de respuestas posibles.";

    }

    public function imagen($nombre){

        $contents = Storage::get($nombre.'.png');

        $image = Image::make($contents);

        return $image->response('jpg');

    }

    public function imagen_sm($nombre){

        $contents = Storage::get($nombre.'.png');

        $image_resize = Image::make($contents);

        $image_resize->resize(100, null, function ($constraint) {    $constraint->aspectRatio(); });

        return $image_resize->response('jpg');

    }

    public function lista($estado){

        //Estados 0 pendientes, 1 aprobados, 2 borrados

        $res = \App\scans::where('estado',$estado)->select('nombre','titulo','uid','estado')->get();

        if(count($res) == 0){
            return 'empty';
        }else{
            return $res;
        }

        return "Error, fuera de respuestas posibles.";

    }

    public function vaciar(){

        //Estados 0 pendientes, 1 aprobados, 2 borrados

        DB::table('scans')->delete();

        $files =   Storage::allFiles();

        Storage::delete($files);

        return "1";

    }

}
