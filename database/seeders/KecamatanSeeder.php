<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_kec' => '010',
                'kecamatan' => '[010] SINGKAWANG SELATAN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_kec' => '020',
                'kecamatan' => '[020] SINGKAWANG TIMUR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_kec' => '030',
                'kecamatan' => '[030] SINGKAWANG UTARA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_kec' => '040',
                'kecamatan' => '[040] SINGKAWANG BARAT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_kec' => '050',
                'kecamatan' => '[050] SINGKAWANG TENGAH',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        collect($data)->map(function($kecamatan){
            return Kecamatan::insert($kecamatan);
        });
    }
}
