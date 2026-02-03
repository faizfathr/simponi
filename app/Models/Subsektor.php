<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsektor extends Model
{
    protected $table = 'subsektor';

    protected $fillable = ['id', 'subsektor', 'sektor_id'];
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
}
