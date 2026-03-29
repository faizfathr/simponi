<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PangkatGolongan extends Model
{
    protected $table = 'pangkat_golongans';

    protected $fillable = ['id', 'nama_golongan'];
}
