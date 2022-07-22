<?php

namespace App\Http\Controllers\Backend;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    public function index()
    {
        $province = Province::all();

        return response()->json([
            'province' => $province
        ]);
    }
}
