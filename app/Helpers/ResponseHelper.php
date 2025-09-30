<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => [
                'code' => $code,
                'isSuccess' => true
            ],
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Error', $code = 400, $errors =  null)
    {
        $response = [
            'status' => [
                'code' => $code,
                'isSuccess' => false
            ],
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
