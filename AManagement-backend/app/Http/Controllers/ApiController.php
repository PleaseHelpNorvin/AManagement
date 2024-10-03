<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //  messages
    protected function successResponse($data, $message='Success', $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
    
    protected function errorResponse ($data = null, $message='Error', $status = 401)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function forbiddenResponse ($data = null, $message='Forbidden', $status = 403)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }
    public function InternalServerErrorResponse($data = null, $message = 'Error', $statusCode = 500)
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'data'    => $data
    ], $statusCode);
}
}
