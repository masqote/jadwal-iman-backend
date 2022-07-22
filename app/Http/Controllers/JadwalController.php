<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Jadwal;
use App\Models\Ustadz;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $req)
    {
        $jadwal = Jadwal::with('ustadz')
        ->whereHas('ustadz', function($q){
            $q->active();
        });
        
        if ($req->day) {
            $jadwal->where('date_at',$req->day);
        }

        if ($req->province) {
            $jadwal->where('province_id',$req->province);
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

    public function slug(Request $req, $slug)
    {
        $data = Jadwal::where('slug',$slug)->firstOrFail();
        return response()->json([
            'data'=> $data
        ]);
    }
}
