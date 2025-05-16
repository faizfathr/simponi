<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets\SpreadSheet;


class GoogleSheetService
{
    protected $service;
    protected $client;

    public function __construct()
    {
        // Inisialisasi Google Client
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/public/googleApiCredentials.json')); // Path ke file kredensial
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS); // Tambahkan scope untuk Google Sheets API
        $this->client->setAccessType('offline'); // Mendukung refresh token
        $this->client->setPrompt('select_account consent'); // Meminta izin pengguna

        // Cek apakah token sudah disimpan sebelumnya
        $tokenPath = storage_path('app/public/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $this->client->setAccessToken($accessToken);
        }

        // Jika token expired, refresh token
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $newAccessToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($newAccessToken)); // Simpan token baru
            } else {
                // Redirect ke URL autentikasi untuk mendapatkan token
                $authUrl = $this->client->createAuthUrl();
                echo "Buka URL ini untuk autentikasi: <a href='$authUrl'>$authUrl</a>";
                exit;
            }
        }

        // Inisialisasi layanan Google Sheets
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function createSpreadsheet()
    {
        try {
            // Data untuk membuat spreadsheet baru
            $spreadsheet = new Google_Service_Sheets_Spreadsheet([
                'properties' => [
                    'title' => 'Survei SP Lahan 2024'
                ]
            ]);

            // Membuat spreadsheet baru
            $spreadsheet = $this->service->spreadsheets->create($spreadsheet);

            // Mengembalikan ID spreadsheet yang baru dibuat
            return $spreadsheet->spreadsheetId;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function oauthCallback($code)
    {
        try {
            // Tukarkan kode autentikasi dengan token akses
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);

            // Cek jika ada error
            if (isset($accessToken['error'])) {
                throw new \Exception($accessToken['error']);
            }

            // Simpan token ke file
            $tokenPath = storage_path('app/public/token.json');
            file_put_contents($tokenPath, json_encode($accessToken));

            return 'Autentikasi berhasil! Token disimpan.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
