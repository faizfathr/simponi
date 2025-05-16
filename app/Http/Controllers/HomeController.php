<?php

namespace App\Http\Controllers;

use Exception;
use Google\Client;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_File;
use Google\Service\Sheets\Spreadsheet as Google_Service_Sheets_Spreadsheet;
use Google\Service\Sheets as Google_Service_Sheets;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $sheetsService;
    protected $driveService;

    public function createSheet()
    {
        $client = new Client;
        $client->setAuthConfig(storage_path('googleApiCredentials.json'));
        $client->addScope([
            Google_Service_Sheets::SPREADSHEETS,
            Google_Service_Drive::DRIVE,
        ]);
        $this->sheetsService = new Google_Service_Sheets($client);
        $this->driveService = new Google_Service_Drive($client);

        $folderId = '1jR2be-DaP3O0JzA2dN82A_uy6M6A4ELE';

        try {

            $spreadsheet = new Google_Service_Sheets_Spreadsheet([
                'properties' => [
                    'title' => "Kegiatan Pertanian"
                ]
            ]);
            $spreadsheet = $this->sheetsService->spreadsheets->create($spreadsheet, [
                'fields' => 'spreadsheetId'
            ]);
            $spreadsheetId = $spreadsheet->spreadsheetId;
            // Pindahkan spreadsheet ke folder tertentu
            $file = new Google_Service_Drive_File();
            $file->setParents([$folderId]);

            $this->driveService->files->update($spreadsheetId, $file, [
                'addParents' => $folderId,
                'removeParents' => '',
                'fields' => 'id, parents'
            ]);

            return $spreadsheetId;
        } catch (\Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function run()
    {
        $request = HTTP::post('https://sso.bps.go.id/auth/realms/pegawai-bps/protocol/openid-connect/auth?client_id=account', [
            'username' => 'faiz.fathur',
            'password' => 'Tupaikeren21'
        ]);

        $response = json_decode($request->body(), TRUE);
        // dd($data);
    }
}
