<?php

namespace Database\Seeders;

use App\Models\KegiatanSurvei;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            StrukturTabelMonitoringSeeder::class,
            KegiatanSurveiSeeder::class,
            MitraSeeder::class,
            SubsektorSeeder::class,
            UsersSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
