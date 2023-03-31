<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function success($data, $code = 200, $message = "success")
    {
        return response()->json([
            'code_response' => $code,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    protected function failed($code, $message, $data = null)
    {
        return response()->json([
            'code_response' => $code,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
