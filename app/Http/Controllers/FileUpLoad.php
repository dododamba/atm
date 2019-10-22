<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUpLoad extends Controller
{
    // La fonction qui en enregistrer les fichiers de base 64

    public static function uf_base64($base64_file , $path) {


        $pool = 'KSHDJSHDKQH257322SDUZTDUYT86E83E9837E3EGYETTZDGJZTD65E37TE83E58E6JGJSGZSZ257Z762Z';

        $file = $base64_file;

        $check_base64 = strrpos($file , 'base64'); // teste si le fichier est un fichier base 64

        if ($check_base64 > 0 ) {

            $explode = explode("," , $file);

            // $explode[0] contient l'information de la base 64
            // $explode[1] contient le fichier base 64

            // decode le fichier base64

            $decoded_file = base64_decode($explode[1]);

            $date = date('dmyYHis');
            $random_string = substr(str_shuffle(str_repeat($pool, 5)), 0 , 10);

            $file_extension = self::uf_get_base64_file_extension($explode[0]);

             // création du nom du fichier

            $filename = $date. $random_string.'.'.$file_extension;


            // maintenant stockons l'image

            Storage::disk('public')->put($path."/".$filename, $decoded_file, 'public');

            // Retournons le chemin
            $url = Storage::url($path."/".$filename);
            return $url;
        } else {
            return $file;
        }


    }


    public static function remove_base64_file($url) {
        Storage::disk('public')->delete($url);
    }

    public static function uf_get_base64_file_extension($base64_row_info) {

        // $base64_row_info peut etre data:image/jpeg;base64

        // On recupère le type de fichier dans la ligne de base 64

        $mime = str_replace(';base64', '' , $base64_row_info);
        $mime = str_replace('data:', '' , $mime);



        $extension_arr = [
            "audio/acc" => "aac",
            "image/bmp" => "bmp",
            "image/jpg" => "jpg",
            "image/jpeg" => "jpeg",
            "image/png" => "png",
            "image/gif" => "gif",
            "image/x-icon" => "ico",
            "video/3gpp" => "3gp",
            "application/pdf" => "pdf"
        ];

        return $extension_arr[$mime];
    }
}
