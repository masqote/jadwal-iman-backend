<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index(Request $req)
    {
        $city = City::where('province_id',$req->province_id)->get();

        return response()->json([
            'city' => $city
        ]);
    }
}
