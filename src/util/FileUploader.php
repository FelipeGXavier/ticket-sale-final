<?php

namespace App\Util;

trait FileUploader
{

    public function upload($path, $ext)
    {
        $randomName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);;
        $uploadPath = PATH . "\bin\\" . $randomName . '.' . $ext;
        move_uploaded_file($path, $uploadPath);
        return $uploadPath;
    }

}