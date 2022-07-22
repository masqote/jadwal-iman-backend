<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ustadz extends Model
{
    protected $table = 'ustadz';
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('isActive' , 1);
    }
}
