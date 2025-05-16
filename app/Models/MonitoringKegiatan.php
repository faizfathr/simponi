<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringKegiatan extends Model
{
    protected $table = 'monitoring_kegiatan';

    public function joinPcl()
    {
        return $this->belongsTo(Mitra::class, 'pcl', 'id');
    }

    public function joinPml()
    {
        return $this->belongsTo(Mitra::class, 'pml', 'id');
    }
}
