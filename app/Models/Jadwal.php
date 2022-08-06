<?php

namespace App\Models;

use App\Models\City;
use App\Models\Waktu;
use App\Models\Ustadz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['ustadz_name','province_name','city_name'];


    public function getProvinceNameAttribute()
    {
        return $this->address->province->name;
    }

    public function getUstadzNameAttribute()
    {
        return $this->ustadz->name;
    }

    public function getCityNameAttribute()
    {
        return $this->address->city->name;
    }

    public function ustadz()
    {
        return $this->hasOne(Ustadz::class,'id','ustadz_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class,'id','address_id');
    }

    public function waktu()
    {
        return $this->hasOne(Waktu::class,'id','waktu_id');
    }

   
}
