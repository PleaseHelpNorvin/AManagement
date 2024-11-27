<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PayMongoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/',
            'verify' => false,
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                'content-type' => 'application/json',
            ]
        ]);
    }

    public function createCheckoutSession($amount, $description, $remarks)
    {
        try {
            $response = $this->client->post('links', [
                'body' => json_encode([
                    'data' => [
                        'attributes' => [
                            'amount' => (int)$amount,
                            'description' => $description,
                            'remarks' => $remarks
                        ]
                    ]
                ])
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Remove the outer "data" array and return only the inner data
            return isset($data['data']) ? $data['data'] : $data;

        } catch (RequestException $e) {
            // Log detailed error for debugging
            Log::error('PayMongo Request Error', [
                'message' => $e->getMessage(),
                'request' => $e->getRequest()->getBody()->getContents(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);

            return ['error' => 'An error occurred while creating a checkout session.'];
        } catch (\Exception $e) {
            Log::error('PayMongo General Error', ['message' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }
}
