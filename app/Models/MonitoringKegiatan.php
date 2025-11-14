<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringKegiatan extends Model
{
    protected $table = 'monitoring_kegiatan';

    protected $fillable = [
        'id_tabel',
        'tahun',
        'waktu',
        'pcl',
        'pml',
        'status',
        'ket_sampel',
        'proses',
        'created_at',
        'updated_at',
    ];

    public function joinPcl()
    {
        return $this->belongsTo(Mitra::class, 'pcl', 'id');
    }

    public function joinPml()
    {
        return $this->belongsTo(Mitra::class, 'pml', 'id');
    }

    public function joinKegiatan()
    {
        return $this->belongsTo(KegiatanSurvei::class, 'id_tabel', 'id');
    }
}
