<?php

namespace Database\Seeders;

use App\Models\KontakWa;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KontakWaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarKontak = [
            [
                'nomor' => '6281334474300,6285213125549,6289529499616,6285328048880,6289660080751,6282126843578,6281234566560,6289698275738,6285774127172,6282336601186,6281333551976,6282152750137,6285219011014,6285180801078,6281345277660,6285821296260,6289526027235,628125711607',
                'nama' => 'Pegawai BPS Kota Singkawang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289529499616,6285774127172,6282123345593,628215713850',
                'nama' => 'Tim Statistik Produksi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285219011014,6282336601186,6289526027235',
                'nama' => 'Tim Statistik Sosial',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285213125549,6285180801078,6285821296260',
                'nama' => 'Tim Statistik NWAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6282126843578,6282152750137,6289689341546',
                'nama' => 'Tim Statistik IPDS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289698275738,6281333551976,6285348646016,6281345277660',
                'nama' => 'Tim Statistik Distribusi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '628125711607',
                'nama' => 'Yanuar Lestariadi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6281334474300',
                'nama' => 'Irwan Agustian',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6281234566560',
                'nama' => 'Wangsit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289660080751',
                'nama' => 'Hafiq',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285328048880',
                'nama' => 'Faisal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285219011014',
                'nama' => 'Sevriel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6282336601186',
                'nama' => 'Megananda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289526027235',
                'nama' => 'Sutopo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289529499616',
                'nama' => 'Elysa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285774127172',
                'nama' => 'Maudy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6282123345593',
                'nama' => 'Faiz',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '628215713850',
                'nama' => 'Harmanto',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285213125549',
                'nama' => 'Sakuntala Devi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285180801078',
                'nama' => 'Salsavira',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285821296260',
                'nama' => 'Ripin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6282126843578',
                'nama' => 'Jaka Eben H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6282152750137',
                'nama' => 'Sari Asnuri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289689341546',
                'nama' => 'Eliana Putri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6289698275738',
                'nama' => 'Ester',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6281333551976',
                'nama' => 'Siti Ainia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6285348646016',
                'nama' => 'Mutia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nomor' => '6281345277660',
                'nama' => 'Endi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        collect($daftarKontak)->map(function($kontak){
            KontakWa::insert($kontak);
        });
    }
}
