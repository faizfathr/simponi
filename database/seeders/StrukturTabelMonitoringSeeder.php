<?php

namespace Database\Seeders;

use App\Models\StrukturTabelMonitoring;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StrukturTabelMonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/struktur_tabel_monitoring.csv'), 'r');   
        while($data = fgetcsv($csvFile,200,",")){
            StrukturTabelMonitoring::insert([
                'id' => $data['0'],
                'no' => $data['1'],
                'ket_sampel' => $data['2'],
                'jadwal' => $data['3'],
                'proses' => $data['4'],
                'status' => $data['5'],
                'pcl' => $data['6'],
                'pml' => $data['7'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
