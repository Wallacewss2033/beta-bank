<?php

namespace App\Services;

use App\Exceptions\ExternalException;
use Exception;
use Illuminate\Support\Facades\Http;

class ExternalService
{
    public static function Authorizer(array $attribute): bool
    {
        $url = env('URL_EXTERNAL_AUTHORIZER');

        $header = [
            'Authorization' => 'Bearer ' . env('TOKEN_EXTERNAL_AUTHORIZER'),
            'Content-Type' => 'application/json',
        ];

        $data = [
            'sender' => $attribute["sender"],
            'receiver' => $attribute["receiver"],
            'amount' => $attribute["value"],
        ];

        $response = Http::withHeaders($header)->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['authorized'];
        }

        throw new ExternalException($response->body(), $response->status());
    }
}
