<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Log;

use App\cs_visibilidades;

class functions extends Model
{

    public static function get_guid_for_file_names(){
        return sprintf('%04X%04X%04X%04X%04X%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function jsonResponse($data){
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    public static function returnErrorAsObject($message,$storeError=false){
        if($storeError) Log::error($message,['user'=>Session::get('UserID'),'request'=>request()]);
        $message = ['status'=>'error','message'=>$message];
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($message);
        exit();
    }

    public static function returnSuccessAsObject($message){
        $message = ['status'=>'success','message'=>$message];
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($message);
        exit();
    }

    public static function checkPhpCodeInImage($file){
        $fileContent = file_get_contents($file['tmp_name']);
        if(strpos($fileContent,"<?php") !== false ||
           strpos($fileContent,"< ?php") !== false ||
           strpos($fileContent,"<? php") !== false )
            return false;

            return true;
    }

    public static function getNameExtension($name){
       return explode('.',$name)[count(explode('.',$name))-1];
    }

    public static function validImageExtension($ext){
        return in_array($ext,constants::ALLOWED_IMAGE_TYPES);
    }

    public static function validImageMimes($ext){
        return in_array($ext,constants::ALLOWED_IMAGE_MIMES);
    }

    public static function storeErrorInLog($Message){
        Log::error($Message,['user'=>Session::get('UserID'),'request'=>request()]);

    }


}
