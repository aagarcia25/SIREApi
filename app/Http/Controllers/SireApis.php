<?php

namespace App\Http\Controllers;

use App\Traits\ApiKeyTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
class SireApis extends Controller {

    use ApiKeyTrait;

public function ConsultaPresupuesto(Request $request){


    $SUCCESS = true;
    $NUMCODE = 0;
    $STRMESSAGE = 'Exito';
    $response = "";
    try {

       // print(    $request );

        if($request->mes ===""){
            throw new Exception("El Parámetro mes es Obligatorio");
        }

        if($request->anio ===""){
            throw new Exception("El Parámetro anio es Obligatorio");
        }
        date_default_timezone_set('America/Mexico_City');
        $date = date("YmdHis");
        $public  =  env('APP_SIRE_API_PUBLIC');
        $private =  env('APP_SIRE_API_SECRET');
        $firma =  $this->generaHMAC($public,$private,'RConsultaClavesPresupuestales');

        $enero       ='"N"';
        $febrero     ='"N"';
        $marzo       ='"N"';
        $abril       ='"N"';
        $mayo        ='"N"';
        $junio       ='"N"';
        $julio       ='"N"';
        $agosto      ='"N"';
        $septiembre  ='"N"';
        $octubre     ='"N"';
        $noviembre   ='"N"';
        $diciembre   ='"N"';

        switch ($request->mes) {
            case 'Enero':
                $enero ='"S"';
                break;
            case 'Febrero':
                $febrero ='"S"';
                break;
            case 'Marzo':
                $marzo ='"S"';
                break;
            case 'Abril':
                 $abril ='"S"';
                 break;
            case 'Mayo':
                 $mayo ='"S"';
                 break;
            case 'Junio':
                  $junio ='"S"';
                  break;
            case 'Julio':
                  $julio ='"S"';
                  break;
            case 'Agosto':
                  $agosto ='"S"';
                  break;
            case 'Septiembre':
                  $septiembre ='"S"';
                  break;
            case 'Octubre':
                  $octubre ='"S"';
                  break;
            case 'Noviembre':
                  $noviembre ='"S"';
                  break;
             case 'Diciembre':
                  $diciembre ='"S"';
                  break;
        }



      $body = '{
    "Input": {
      "Request": {
        "Acceso": {
          "ApiPublic":"'.$public.'",
          "Firma":"'.$firma.'",
          "Fecha":"'.$date.'"
        },
        "ConsultaDatosClaves": {
          "TipoCvePresupuestal": "'.env('APP_SIRE_API_EJERCICIO').'" ,
          "Periodo": '.$request->anio.',
          "CargarSaldos": "S",
          "CodigosClasificadores": {
            "Clasificador1": "'.  $request->clasificador1.'",
            "Clasificador2": "'.  $request->clasificador2.'",
            "Clasificador3": "'.  $request->clasificador3.'",
            "Clasificador4": "'.  $request->clasificador4.'",
            "Clasificador5": "'.  $request->clasificador5.'",
            "Clasificador6": "'.  $request->clasificador6.'",
            "Clasificador7": "'.  $request->clasificador7.'",
            "Clasificador8": "'.  $request->clasificador8.'",
            "Clasificador9": "'.  $request->clasificador9.'",
            "Clasificador10":"'.  $request->clasificador10.'",
            "Clasificador11":"'.  $request->clasificador11.'"
          },
          "MomentosContables": {
            "Estimado": "N",
            "Aprobado": "N",
            "Ampliacion": "N",
            "Reduccion": "N",
            "Transferencia_Aumento": "N",
            "Transferencia_Reduccion": "N",
            "Saldo": "N",
            "PreComprometer": "N",
            "Disponible": "N",
            "Comprometido": "S",
            "PreComprometido_Sin_Comprometer": "N",
            "Para_PreComprometer": "N",
            "Devengado": "N",
            "No_Devengado": "N",
            "PreComprometido_Sin_Deven": "N",
            "Ejercido": "N",
            "Recaudado": "N",
            "Devengado_Sin_Ejerc": "N",
            "Pagado": "N",
            "Ejercido_Sin_Pagar": "N",
            "PorPagar": "N"
          },
          "Meses": {
            "Enero":      '.$enero.' ,
            "Febrero":    '.$febrero.' ,
            "Marzo":      '.$marzo.' ,
            "Abril":      '.$abril.' ,
            "Mayo":       '.$mayo.' ,
            "Junio":      '.$junio.' ,
            "Julio":      '.$julio.' ,
            "Agosto":     '.$agosto.' ,
            "Septiembre": '.$septiembre.' ,
            "Octubre":    '.$octubre.' ,
            "Noviembre":  '.$noviembre.' ,
            "Diciembre":  '.$diciembre.'
          }
        }
      }
    }
  }';

       // print(    $body );
      //  print(    $date );

        $client = new Client();
        $headers = [
                   'Content-Type' => 'application/json'
                   ];
         $req = new Psr7Request('POST', env('APP_SIRE_URL').'/apirest/catalogos/RConsultaClavesPresupuestales', $headers, $body);
         $res = $client->sendAsync($req)->wait();
         $data = json_decode($res->getBody()->getContents());
         $response =  $data;
    } catch (\Exception $e) {
        $NUMCODE = 1;
        $STRMESSAGE = $e->getMessage();
        $SUCCESS = false;
    }

    return response()->json(
        [
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS
        ]
    );

}



}
