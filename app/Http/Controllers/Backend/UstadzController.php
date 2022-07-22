<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UstadzController extends Controller
{
    public function index(Request $req)
    {
        
        $ustadz = Ustadz::active()->where('name', 'LIKE', $req->q.'%')->get();
        
        return response()->json([
            'ustadz'=> $ustadz
        ]);
    }

}
