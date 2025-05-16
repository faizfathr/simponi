<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSurvei extends Model
{
    protected $table = 'kegiatan_survei';

    protected $fillable = [];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function joinTabel()
    {
        return $this->belongsTo(StrukturTabelMonitoring::class, 'kegiatan_survei.id', 'struktur_tabel_monitoring.id');
    }
}
