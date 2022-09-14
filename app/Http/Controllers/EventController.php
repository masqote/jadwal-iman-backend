<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\Jadwal;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiResponse;

class EventController extends Controller
{
    use ApiResponse;
    public function index(Request $req)
    {
        $event = Event::with('address');

        $event->orderBy('pinned','desc');
        $event->orderBy('start_date','desc');
        

        $dataEvent = $event->get();
        
        return $this->success('','',$dataEvent);
    }

}
