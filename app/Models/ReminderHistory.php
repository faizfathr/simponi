<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderHistory extends Model
{
    protected $table = 'reminder';

    public function joinKontak()
    {
        return $this->belongsTo(KontakWa::class, 'no_tujuan', 'nomor');
    }
}
