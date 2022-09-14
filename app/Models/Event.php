<?php

namespace App\Models;

use App\Models\City;
use App\Models\Waktu;
use App\Models\Ustadz;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    protected $table = 'events';
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['province_name','city_name'];


    public function getProvinceNameAttribute()
    {
        return $this->address->province->name ?? '';
    }


    public function getCityNameAttribute()
    {
        return $this->address->city->name ?? '';
    }


    public function address()
    {
        return $this->hasOne(Address::class,'id','address_id');
    }


    public function setSlugAttribute($value) {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
    
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug) {

        $original = $slug;
    
        $count = 2;
    
        while (static::whereSlug($slug)->exists()) {
    
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    
    }

   
}
