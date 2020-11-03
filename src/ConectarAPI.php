<?php

namespace Rchaname\Utilidades;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConectarAPI{

    public function dniApiPeru($dni){
        $token = getenv('TOKEN_APIPERUDEV');
        $url = 'https://apiperu.dev/api/dni/' . $dni;
        $respuesta = Http::withToken($token)->get($url);
        if($respuesta->successful()){
            if($respuesta['success'] === true){
                $data = $respuesta['data'];
                $datos = [
                    'apellido_paterno' => $data['apellido_paterno'],
                    'apellido_materno' => $data['apellido_materno'],
                    'nombres' => $data['nombres']
                ];
                return $datos;
            }else{
                Log::error($respuesta['message']);
                return [];
            }
        }else{
            Log::error("Error conectado con api dev peru");
            return [];
        }
    }

    public function dniOptimizePeru($dni){
        $url = 'https://dni.optimizeperu.com/api/persons/' . $dni;
        $respuesta = Http::get($url);
        if($respuesta->successful()){
            $datos = [
                'nombres' => $respuesta['name'],
                'apellido_paterno' => $respuesta['first_name'],
                'apellido_materno' => $respuesta['last_name'],
            ];
            return $datos;
        }else{
            Log::error("Error conectando con optmize peru");
            return [];
        }
    }
}