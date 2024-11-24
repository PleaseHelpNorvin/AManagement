<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Success Response
    protected function successResponse($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // Error Response
    protected function errorResponse($data = null, $message = 'Error', $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // Forbidden Response
    protected function forbiddenResponse($data = null, $message = 'Forbidden', $status = 403)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // Internal Server Error Response
    protected function internalServerErrorResponse($data = null, $message = 'Internal Server Error', $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    // Not Found Response
    protected function notFoundResponse($data = null, $message = 'Not Found', $status = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // Validation Error Response
    protected function validationErrorResponse($errors, $message = 'Validation Error', $status = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
