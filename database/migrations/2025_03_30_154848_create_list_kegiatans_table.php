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
        Schema::create('list_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('id_kegiatan')->require();
            $table->unsignedSmallInteger('tahun')->require();
            $table->string('periode')->require();
            $table->unsignedSmallInteger('waktu')->require();
            $table->smallInteger('target')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_kegiatan');
    }
};
