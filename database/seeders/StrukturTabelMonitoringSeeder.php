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
                'ket_sampel' => $data['1'],
                'proses' => $data['2'],
                'status' => $data['3'],
                'pcl' => $data['4'],
                'pml' => $data['5'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
