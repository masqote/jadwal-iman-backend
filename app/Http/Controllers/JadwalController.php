<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Jadwal;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiResponse;

class JadwalController extends Controller
{
    use ApiResponse;
    public function index(Request $req)
    {
        $jadwal = Jadwal::with('ustadz','address')
        ->whereHas('ustadz', function($q){
            $q->active();
        });
        
        if ($req->day) {
            $jadwal->where('date_at',$req->day);
        }

        if ($req->province) {
            $jadwal->whereHas('address', function($q) use($req) {
                $q->where('province_id', $req->province);
            });
        }

        if ($req->ustadz) {
           $jadwal->where('ustadz_id',$req->ustadz)->whereDate('date_at', '>=', now());
        }

        
        $jadwal->orderBy('date_at','asc')->orderBy('time_at','asc');

        $dataJadwal = $jadwal->get();
        
        return response()->json([
            'data'=> $dataJadwal
        ]);
    }

    public function jadwalUstadz(Request $req)
    {
        $jadwal = Jadwal::with('ustadz')
        ->whereHas('ustadz', function($q){
            $q->active();
        });
       
        if ($req->id) {
           $jadwal->where('ustadz_id',$req->id);
        }

        if ($req->day) {
            $jadwal->where('date_at',$req->day);
        }

        $jadwal->orderBy('date_at','asc')->orderBy('time_at','asc');

        try {
            $data = $jadwal->get();
            if (count($data) > 0) {
                return $this->success('','',$data);
            }
            return $this->success('','Data tidak ditemukan!');
        } catch (\Throwable $th) {
            return $this->fail('',$th->getMessage());
        }
    }

    public function slug(Request $req, $slug)
    {
        try {
            $data = Jadwal::where('slug',$slug)->firstOrFail();
            return $this->success('','',$data);
        } catch (\Throwable $th) {
            return $this->fail('',$th->getMessage());
        }
    }
}
