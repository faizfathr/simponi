<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitoring_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('id_tabel');
            $table->unsignedSmallInteger('no_baris');
            $table->unsignedSmallInteger('tahun');
            $table->unsignedSmallInteger('waktu'); //1=bulanan, 2=twiwulanan, 3=subround, 4=tahunan
            $table->string('ket_sampel');
            $table->string('proses');
            $table->smallInteger('status');
            $table->string('pcl');
            $table->string('pml');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_kegiatan');
    }
};
