<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ApiResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UstadzController extends Controller
{
    use ApiResponse;
    public function index(Request $req)
    {
        try {
            $ustadz = Ustadz::active()->where('name', 'LIKE', $req->q.'%')->get();
            if (count($ustadz) > 0) {
                return $this->success('','',$ustadz);
            }else{
                return $this->success('','Ustadz '.$req->q.' tidak ditemukan',$ustadz);
            }
        } catch (\Throwable $th) {
           return $this->fail('',$th->getMessage());
        }

    }

    public function show(Request $req)
    {
        try {
            $ustadz = Ustadz::active()->where('slug',$req->slug)->firstOrFail();
            return $this->success('','',$ustadz);
        } catch (\Throwable $th) {
            return $this->fail('',$th->getMessage());
        }
        
    }

}
