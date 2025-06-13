<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

Class FonteService 
{
    public function sendMessage($phoneNumber, $message, $time = '0')
    {
        $response = Http::asForm()->withHeaders([
                'Authorization' => config('services.fonte.token'),
            ])
            ->post(config('services.fonte.url'), [
                'target' => $phoneNumber,
                'message' => $message,
                'schedule' => $time,
            ]);
        return $response->json();
    }
}