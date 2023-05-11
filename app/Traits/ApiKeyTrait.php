<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ApiKeyTrait{



function generaHMAC($ApiPublic, $ApiSecret,  $MetodoRemoto)
{
    $resultado = ''; // Inicializa la variable Result
    try {
       //SE ESTABLECE LA ZONA HORARIA
       date_default_timezone_set('America/Mexico_City');
       //SE OBTIENE LA FECHA ACTUAL DEL SISTEMA
       $fechaActual = date('YmdHis');
       //SE CREA LA CADENA CONCATENDANDO LA FECHA ACTUAL, EL NOMBRE DEL MÉTODO Y LA API PÚBLICA
       $cadena = $fechaActual.trim($MetodoRemoto).trim($ApiPublic);
       //SE ENCRIPTA LA CADENA CON SHA1
       $cadenaHash = strtoupper(sha1($cadena));
       //SE OBTIENE LA FIRMA HMAC ENVIANDO LA CADENA ANTERIOR JUNTO CON LA API SECRETA
       $resultado = base64_encode(hash_hmac('sha1', $cadenaHash, trim($ApiSecret), true));
    } catch (Exception $e) {
        $resultado = $e->getMessage(); // Regresa un error si es encontrado
    }
    return $resultado;
}

}
