<?php

namespace App\Trait;

trait TraitApi
{
    public function apiResource($data=null , $message=null , $status=null)
    {
        $array = [
            'data' => $data,
            'message' => $message,
            'status' => $status
        ];

        return response($array);
    }

}
