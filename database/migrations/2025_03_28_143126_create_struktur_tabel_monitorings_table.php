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
        Schema::create('struktur_tabel_monitoring', function (Blueprint $table) {
            $table->string('id');
            $table->string('no', 5);
            $table->string('ket_sampel');
            $table->string('jadwal', 10);
            $table->string('proses');
            $table->string('status');
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
        Schema::dropIfExists('struktur_tabel_monitoring');
    }
};
