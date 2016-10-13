<?php

namespace App\DataStructures;

class JsonBuilder
{
    public static function data($data)
    {
        return [
            'data' => $data
        ];
    }

    public static function success($message, $code)
    {
        return [
            'message' => $message,
            'code' => $code
        ];
    }

    public static function message($message)
    {
        return [
            'message' => $message
        ];
    }

    public static function error($message, $code)
    {
        return [
            'message' => $message,
            'code' => $code
        ];
    }
}
