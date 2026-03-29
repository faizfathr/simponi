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
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('nomor_surat_rujukan')->nullable();
            $table->string('perihal');
            $table->string('kepala_surat_rujukan');
            $table->smallInteger('subtim');
            $table->date('tanggal_penandatanganan');
            $table->string('id_petugas');
            $table->string('tujuan_tugas');
            $table->string('tempat');
            $table->string('waktu_pelaksanaan');
            $table->string('penandatangan');
            $table->string('kegiatan');
            $table->string('pembebanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};
