<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Mitra;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MitraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/mitra.csv'), 'r');
        while($data = fgetcsv($csvFile, 100, ',')) {
            Mitra::insert([
                'id' => (string) Str::uuid(),
                'nama' => $data['0'],
                'no_rek' => $data['1'],
                'status' => $data['2'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
