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
            ->post(config('services.fonte.url') . '/send', [
                'target' => $phoneNumber,
                'message' => $message,
                'schedule' => $time,
            ]);
        return $response->json();
    }

    public function deleteMessage($idMessage)
    {
        $response = Http::asForm()->withHeaders([
                'Authorization' => config('services.fonte.token'),
            ])
            ->post(config('services.fonte.url') . '/delete-message', [
                'id' => $idMessage,
            ]);
        return $response->json();
    }

    public function getInfo()
    {
        $response = Http::withHeaders([
                'Authorization' => config('services.fonte.token'),
            ])
            ->get(config('services.fonte.url') . '/me');
        return $response->json();
    }
}