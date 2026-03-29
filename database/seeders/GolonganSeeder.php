<?php

namespace Database\Seeders;

use App\Models\PangkatGolongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_golongan' => 'Juru Muda - I/a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Juru Muda Tk I - I/b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Juru - I/c',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Juru Tk I - I/d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pengatur Muda - II/a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pengatur Muda Tk I - II/b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pengatur - II/c',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pengatur Tk I - II/d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Penata Muda - III/a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Penata Muda Tk I - III/b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Penata - III/c',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Penata Tk I - III/d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pembina - IV/a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pembina Tk I - IV/b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pembina Muda - IV/c',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pembina Madya - IV/d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_golongan' => 'Pembina Utama - IV/e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        collect($data)->map(function ($item) {
            PangkatGolongan::insert($item);
        });
    }
}
