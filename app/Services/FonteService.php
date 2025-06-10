<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

Class FonteService 
{
    public function sendMessage($phoneNumber, $message)
    {
        $response = Http::withHeaders([
                'Authorization' => config('services.fonte.token'),
            ])
            ->post(config('services.fonte.url'), [
                'target' => $phoneNumber,
                'message' => $message,
            ]);
        return $response->json();
    }
}