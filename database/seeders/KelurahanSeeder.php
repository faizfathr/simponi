<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/master_kelurahan.csv'), "r");

        while( $data = fgetcsv($csvFile, 200, ",") ) {
            Kelurahan::insert([
                'id_kel' => $data['1'],
                'kelurahan' => $data['1'],
                'id_kec' => $data['2'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
