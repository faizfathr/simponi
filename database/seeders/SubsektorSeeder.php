<?php

namespace Database\Seeders;

use App\Models\Subsektor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubsektorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'STATISTIK INDUSTRI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'STATISTIK PERTAMBANGAN, ENERGI, DAN KONSTRUKSI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'STATISTIK PETERNAKAN, PERIKANAN, DAN KEHUTANAN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'STATISTIK TANAMAN PANGAN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'STATISTIK HORTIKULTURA DAN PERKEBUNAN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        collect($data)->map(function($subsektor){
            Subsektor::insert($subsektor);
        });
    }
}
