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
        Schema::create('kegiatan_survei', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->smallInteger('sektor');
            $table->smallInteger('subsektor');
            $table->smallInteger('periode');
            $table->string('kegiatan');
            $table->string('alias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_survei');
    }
};
