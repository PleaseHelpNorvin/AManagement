<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;


class HomeController extends ApiController
{
    //
    public function adminHome(Request $request)
    {
        try {
            // Check if the user is an admin
            if (!$request->user()->isAdmin()) {
                return $this->forbiddenResponse(null, 'Forbidden');
            }

            $user = $request->user();

            return $this->successResponse([
                'body' => $user,
                // 'redirect_url' => url('/home/admin')
            ], 'Admin redirect URL provided');

        } catch (\Exception $e) {
            return $this->InternalServerErrorResponse(null, 'Something went wrong');
        }
    }

    public function userHome(Request $request)
    {
        try {
            // Check if the user is a regular user
            if (!$request->user()->isUser()) {
                return $this->forbiddenResponse(null, 'Forbidden');
            }

            $user = $request->user();

            return $this->successResponse([
                'redirect_url' => url('/home/user')
            ], 'User redirect URL provided');

        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Something went wrong');
        }
    }
}
