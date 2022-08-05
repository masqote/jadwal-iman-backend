<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $period = CarbonPeriod::create(today(), Carbon::now()->addDays(8));

        // Convert the period to an array of dates
        $dates = $period->toArray();
        $dataDate = [];
        $resourceDate = [];

        foreach ($dates as $date) {
            $dateFormat = $date->translatedFormat('d-F-Y-l-Y-m-d');
            array_push($dataDate,$dateFormat);
        }

        
        foreach ($dataDate as $data) {
            $resourceData = explode("-",$data);
           
            $resource['tanggal'] = $resourceData[0];
            $resource['bulan'] = $resourceData[1];
            $resource['tahun'] = $resourceData[2];
            $resource['hari'] = $resourceData[3] == 'Minggu' ? 'Ahad' : $resourceData[3];
            $resource['full'] = $resourceData[4].'-'.$resourceData[5].'-'.$resourceData[6];
            array_push($resourceDate, $resource);
        }
        
        return response()->json([
            'data'=> $resourceDate
        ]);
    }
}
