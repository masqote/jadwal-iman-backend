<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ApiResponse;

class CityController extends Controller
{
    use ApiResponse;
    public function index(Request $req)
    {
        try {
            $city = City::where('province_id',$req->province_id)->get();
        } catch (\Throwable $th) {
            return $this->fail('',$th->getMessage());
        }
        
    }
}
