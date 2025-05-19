<?php

namespace Database\Seeders;

use App\Models\KegiatanSurvei;
use App\Models\StrukturTabelMonitoring;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KegiatanSurveiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/kegiatan_survei.csv'), 'r');

        while ($data = fgetcsv($csvFile,200,",")) {
            $hashedId = bin2hex(hash('sha256', $data[0], true));
            KegiatanSurvei::insert([
                'id' => $hashedId,
                'sektor' => $data['1'],
                'subsektor' => $data['2'],
                'periode' => $data['3'],
                'kegiatan' => $data['4'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $selectedField = StrukturTabelMonitoring::where('id', (string) $data['0'])->get();
            if($selectedField) {
                StrukturTabelMonitoring::where('id', (string) $data['0'])->update(['id' => $hashedId]);
            }
        }
    }
}
