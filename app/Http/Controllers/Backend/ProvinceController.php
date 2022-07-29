<?php

namespace App\Http\Controllers\Backend;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ApiResponse;

class ProvinceController extends Controller
{
    use ApiResponse;
    public function index()
    {
        try {
            $province = Province::all();
            return $this->success('','',$province);
        } catch (\Throwable $th) {
           return $this->fail('',$th->getMessage());
        }
    }
}
