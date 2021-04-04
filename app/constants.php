<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class constants extends Model
{

    CONST SCAN_ESTADO_PENDIENTE   = 1;
    CONST SCAN_ESTADO_VERIFICADO  = 2;
    CONST SCAN_ESTADO_BORRADO     = 3;

    CONST IMAGES_UPLOAD_MAX_WIDTH = 5000;
    CONST IMAGES_SECURE_STORAGE = "securestorage/";

    const ALLOWED_IMAGE_TYPES =
        [
            'png',
            'jpg',
            'jpeg',
            'bmp',
        ];

    const ALLOWED_IMAGE_MIMES =
        [
            "image/png",
            "image/jpg",
            "image/jpeg",
            "image/jpe",
            "image/bmp",
        ];

}
