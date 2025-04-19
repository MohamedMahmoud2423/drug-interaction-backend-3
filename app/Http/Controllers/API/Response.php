<?php

namespace App\Http\Controllers\API;

trait Response
{
    public function ResponseAPI($data = null , $status = 200 , $msg = null){
        $array = [
            'data' => $data ,
            'message' => $msg ,
            'status' => $status,
        ];
        return response($array , $status);
    }
}
