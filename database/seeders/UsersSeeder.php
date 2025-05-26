<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('/database/data/users.csv'), 'r');
        while($data = fgetcsv($csvFile,100,',')) {
            User::insert([
                'id' => $data['0'],
                'nama'=> $data['3'],
                'username' => $data['1'],
                'password' => Hash::make($data['2']),
                'id_role' => $data['4'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
