<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ApiResponse;

class AddressController extends Controller
{
    use ApiResponse;
    public function index(Request $req)
    {
        try {
            $city = Address::get();
        } catch (\Throwable $th) {
            return $this->fail('',$th->getMessage());
        }
        
    }
}
