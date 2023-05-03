<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ApiKeyTrait{
/*
  public  function generaHMAC($apiPublic, $apiSecret, $fechaHoraSolicitud, $metodoRemoto)
    {
        $resultado = ''; // Inicializa la variable resultado
        try {
            $cadena = trim($fechaHoraSolicitud) . trim($metodoRemoto) . trim($apiPublic); // Crea la cadena para firmar con la llave API
            $sha1 = hash('sha1', $cadena); // Se encripta la cadena
            $keyBytes = utf8_encode($apiSecret); // Convierte la llave API Secreta a bytes
            $signingKey = new \Illuminate\Support\Stringable($keyBytes); // Crea la instancia del objeto para firmar
            $mac = hash_hmac('sha1', $sha1, $signingKey); // Firma la cadena encriptada
            $resultado = base64_encode($mac); // Codifica y asigna el valor del HMAC a la variable resultado
        } catch (Exception $e) { // Regresa un error si es encontrado
            Log::error($e->getMessage());
        }
        return $resultado;
    }
*/


function generaHMAC($ApiPublic, $ApiSecret, $FechaHoraSolicitud, $MetodoRemoto)
{
    $Result = ''; // Inicializa la variable Result
    try {
       // $Cadena = trim($FechaHoraSolicitud) . trim($MetodoRemoto) . trim($ApiPublic); // Crea la cadena para firmar con la llave API
       // $hash = hash_hmac('sha1', $Cadena, $ApiSecret, true); // Genera el HMAC con la llave secreta
       // $Result = base64_encode($hash); // Codifica el HMAC en base64 y asigna el valor a la variable Result

        $cadena = trim($FechaHoraSolicitud) . trim($MetodoRemoto) . trim($ApiPublic);
        $cadena = hash('sha1', $cadena, false); // Se encripta la cadena utilizando SHA1
        $key = utf8_encode($ApiSecret);
        $ahmac = hash_hmac('sha1', $cadena, $key, true);
        $Result= base64_encode($ahmac); // Codifica y asigna el valor del HMAC a la variable ApiKeyAux


    } catch (Exception $e) {
        $Result = $e->getMessage(); // Regresa un error si es encontrado
    }
    return $Result;
}

}
