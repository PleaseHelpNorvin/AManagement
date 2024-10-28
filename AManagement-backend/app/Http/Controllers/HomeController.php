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
            // Ensure user is authenticated
            $user = $request->user();
            if (!$user || !$user->isUser()) {
                return $this->forbiddenResponse(null, 'Forbidden');
            }

            // $clientInfo = ClientInformation::where('user_id', $user->id)->first();
            $clientInfo = $user->clientInformation; 

            \Log::info('User Info: ', [
                'nickname' => $clientInfo ? $clientInfo->nickname : null,
                'middlename' => $clientInfo ? $clientInfo->middlename : null,
                'lastname' => $clientInfo ? $clientInfo->lastname : null,
                'gender' => $clientInfo ? $clientInfo->gender : null,
                'address' => $clientInfo ? $clientInfo->address : null,
                'contact_number' => $clientInfo ? $clientInfo->contact_number : null,
                'gcash_number' => $clientInfo ? $clientInfo->gcash_number : null,
            ]);

            return $this->successResponse([

                
                // 'redirect_url' => url('/home/user'),
                'User Info' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nickname' => $clientInfo ? $clientInfo->nickname : null,
                    'middlename' => $clientInfo ? $clientInfo->middlename : null,
                    'lastname' => $clientInfo ? $clientInfo->lastname : null,
                    'gender' => $clientInfo ? $clientInfo->gender : null,
                    'address' => $clientInfo ? $clientInfo->address : null,
                    'contact_number' => $clientInfo ? $clientInfo->contact_number : null,
                    'gcash_number' => $clientInfo ? $clientInfo->gcash_number : null,
                    ],
                ], 'User redirect URL provided');


        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('User Home Error: ' . $e->getMessage());
            return $this->internalServerErrorResponse(null, 'Something went wrong');
        }
    }
}
