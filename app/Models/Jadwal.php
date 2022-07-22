<?php

namespace App\Models;

use App\Models\City;
use App\Models\Ustadz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['province_name','ustadz_name','city_name'];


    public function getProvinceNameAttribute()
    {
        return $this->province->name;
    }

    public function getUstadzNameAttribute()
    {
        return $this->ustadz->name;
    }

    public function getCityNameAttribute()
    {
        return $this->city->name;
    }

    public function ustadz()
    {
        return $this->hasOne(Ustadz::class,'id','ustadz_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class,'id','province_id');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }
   
}
