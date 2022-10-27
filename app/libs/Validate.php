<?php

class Validate
{
    public static function number($string)
    {
        $search = [' ', '€', '$', ','];
        $replace = ['', '', '', ''];

        return str_replace($search, $replace, $string);
    }

    public static function date($string)
    {
        $date = explode('-', $string);

        if(count($date) == 1) {
            return false;
        }

        return checkdate($date[1], $date[2], $date[0]);
    }

    public static function dateDif($string)
    {
        $now = new DateTime();
        $date = new DateTime($string);

        return ($date > $now);
    }

    public static function file($string)
    {
        $search = [' ', '*', '!', '@', '?', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü', '¿', '¡'];
        $replace = ['-', '', '', '', '', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U', '', ''];
        //$file = str_replace($search,$replace, $string);

        //return $file;
        return str_replace($search,$replace, $string);
    }

    public static function resizeImage($image, $newWidth)
    {
        $file = 'img/' . $image;

        // Esta función devuelve un array numérico donde en la posicion 0 está la altura y en la 1 la anchura
        $info = getimagesize($file);
        $width = $info[0];
        $height = $info[1];

        // El tipo mime es el tipo de la imagen; jpg, png...
        $type = $info['mime'];

        $factor = $newWidth / $width;
        $newHeight = round($factor * $height, 0, PHP_ROUND_HALF_DOWN);

        $imageArray = getimagesize($file);
        $imageType = $imageArray[2];

        if($imageType == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($file);
        } elseif($imageType == IMAGETYPE_PNG) {
            $image = imagecreatefromPNG($file);
        }

        // Crea una plantilla
        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        // Redimensiona la imagen
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        imagejpeg($canvas, $file, 80);
    }

    // Método para evitar la inyección de código en los campos
    public static function text($string)
    {
        $search = ['^', 'delete', 'drop', 'truncate', 'exec', 'system'];
        $replace = ['-', 'dele*te', 'dr*op', 'trunca*te', 'ex*ec', 'syst*em'];
        $string = str_replace($search, $replace, $string);
        $string = addslashes(htmlentities($string));

        return $string;
    }

    public static function imageFile($file)
    {
        // Hacer una comprobación de si $file es null

        $imageArray = getimagesize($file);
        $imageType = $imageArray[2];

        return (bool)(in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG]));
    }
}