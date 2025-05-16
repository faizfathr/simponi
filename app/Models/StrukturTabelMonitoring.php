<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturTabelMonitoring extends Model
{
    protected $table = 'struktur_tabel_monitoring';

    protected $fillable = [];

    public function toKegiatan()
    {
        return $this->belongsTo(KegiatanSurvei::class, 'struktur_tabel_monitoring.id', 'kegiatan_survei.id');
    }
}
