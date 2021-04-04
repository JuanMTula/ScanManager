<?php

namespace App\Http\Controllers;

use App\constants;
use App\functions;
use App\scans;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;

class maincontroller extends Controller
{

    public function enviar(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // identificador
        $toValidate['fields']['identificador']     = $request['identificador'];
        $toValidate['constrains']['identificador'] = 'required|string|min:1';

        // detalle
        $toValidate['fields']['detalle']     = $request['detalle'];
        $toValidate['constrains']['detalle'] = 'nullable|string|max:50';

        // imagen
        $toValidate['fields']['imagen']     = $request['imagen'];
        $toValidate['constrains']['imagen'] = 'required|file';

        if(!functions::checkPhpCodeInImage($_FILES['imagen']))
            functions::returnErrorAsObject('Archivo de imagen posee codigo mal intencionado.',true);

        if(!functions::validImageExtension(functions::getNameExtension($_FILES['imagen']['name'])))
            functions::returnErrorAsObject('Archivo de imagen posee una extencion invalida.');

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);

        $niceNames = array(
            'identificador'   => 'Identificador de imagen',
            'detalle'         => 'Detalle de imagen',
            'imagen'          => 'Archivo de imagen',
        );

        $validator->setAttributeNames($niceNames);

        if ($validator->fails())
        {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            functions::returnErrorAsObject($resp);
        }

        $archivo = functions::get_guid_for_file_names().'.'.functions::getNameExtension($_FILES['imagen']['name']);

        $objeto = new scans;
        $objeto->identificador = $request['identificador'];
        $objeto->detalle = $request['detalle'];
        $objeto->imagen = $archivo;
        $objeto->estado = constants::SCAN_ESTADO_PENDIENTE;

        $store = $this->storeimage($request['imagen'],constants::IMAGES_SECURE_STORAGE,$archivo);
        if( $store === true)
            $objeto->save();
        else
            functions::returnErrorAsObject($store);

        functions::returnSuccessAsObject('Imagen subida');
    }

    public static function storeimage($image,$dir,$nombre){

        $request = request();
        $file = $request['imagen'];
        if(exif_imagetype($file)) {
            $max_width = constants::IMAGES_UPLOAD_MAX_WIDTH;

            $width = Image::make($file)->width();
            $res = Image::make($file);

            if(!functions::validImageMimes($res->mime()))
                return "Error, tipo de imagen invalido.";

            if ($width >= $max_width)
                $res->resize($max_width, null, function ($constraint) { $constraint->aspectRatio(); });

            $filename = $dir.$nombre ;
            $res->save(storage_path($filename));
            chmod(storage_path($filename), 0755);
            return true;
        }else{
            return "Error, imagen subida invalida.";
        }
    }

    public function imagen($nombre){

        if (!file_exists(storage_path(constants::IMAGES_SECURE_STORAGE.$nombre)))
            functions::returnErrorAsObject("Archivo no encontrado");

        return Image::make(storage_path(constants::IMAGES_SECURE_STORAGE.$nombre))->response();
    }

    public function imagen_sm($nombre){

        if (!file_exists(storage_path(constants::IMAGES_SECURE_STORAGE.$nombre)))
            functions::returnErrorAsObject("Archivo no encontrado");

        return Image::make(storage_path(constants::IMAGES_SECURE_STORAGE.$nombre))
            ->resize(400, null, function ($constraint) {    $constraint->aspectRatio(); })
            ->response();
    }

    public function lista($estado){

        functions::jsonResponse(scans::where('estado',$estado)->select('identificador','detalle','imagen','estado')->get());
    }

    public function vaciar(){

        DB::table('scans')->delete();
        $file = new Filesystem;
        $file->cleanDirectory(storage_path(constants::IMAGES_SECURE_STORAGE));
        functions::returnSuccessAsObject("Imagenes borradas");
    }

    public function cambiarestado(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // estado
        $toValidate['fields']['estado']     = $request['estado'];
        $toValidate['constrains']['estado'] = 'required|in:1,2,3';

        // imagen
        $toValidate['fields']['imagen']     = $request['imagen'];
        $toValidate['constrains']['imagen'] = 'required|exists:scans,imagen';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);

        $niceNames = array(
            'estado'   => 'Estado de imagen',
            'imagen'   => 'Archivo de imagen',
        );

        $validator->setAttributeNames($niceNames);

        if ($validator->fails())
        {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            functions::returnErrorAsObject($resp);
        }

        if(scans::where('imagen', $request['imagen'])
            ->update(['estado' =>  request('estado')]))
            functions::returnSuccessAsObject("Estado cambiado");
        else
            functions::returnErrorAsObject("Error cambiando estado");

    }

}
