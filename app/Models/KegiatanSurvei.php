<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSurvei extends Model
{
    protected $table = 'kegiatan_survei';

    protected $fillable = ['id','kegiatan', 'alias', 'periode', 'sektor', 'subsektor'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';
  
public $incrementing = false;

    public function joinTabel()
    {
        return $this->belongsTo(StrukturTabelMonitoring::class, 'kegiatan_survei.id', 'struktur_tabel_monitoring.id');
    }

    public function targets()
    {
        return $this->hasMany(ListKegiatan::class, 'id_kegiatan', 'id');
    }
}
