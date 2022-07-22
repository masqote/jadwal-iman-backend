<?php

namespace App\Http\Controllers\Backend;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function index(Request $req)
    {
        $jadwal = Jadwal::orderBy('date_at','desc')
        ->where('address','LIKE','%'. $req->search . '%')
        ->orWhere('title','LIKE','%'. $req->search . '%')
        ->orWhereHas('ustadz', function($q) use ($req){
            $q->where('name', 'LIKE', '%' . $req->search . '%');
        })
        ->orderBy('created_at','desc')
        ->paginate($req->loadPage);
        
        return response()->json([
            'jadwal'=> $jadwal
        ]);
    }

    public function addData(Request $req)
    {
        $validated = $req->validate([
            'title' => 'required|max:255',
            'address' => 'required|max:255',
            'jadwal' => 'required',
            'ustad' => 'required',
            'province' => 'required',
            'city' => 'required',
        ]);

        $date = $req['jadwal'];
        $date = (explode("T",$date));
        
        $data = new Jadwal;
        $data->date_at = $date[0];
        $data->time_at = $date[1];
        $data->address = $req['address'];
        $data->ustadz_id = $req['ustad'];
        $data->province_id = $req['province'];
        $data->city_id = $req['city'];
        $data->title = $req['title'];
        $data->slug = $this->createSlug($req['slug']);
        $data->save();

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function deleteData(Request $req)
    {
        $data = Jadwal::find($req->id);
        $data->delete();

        return response()->json([
            'message' => 'Success Delete Data!'
        ]);
    }

    public function createSlug($title, $id = 0)
    {
        $slug = str_slug($title);
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Jadwal::select('slug')->where('slug', 'like', $slug.'%')
        ->where('id', '<>', $id)
        ->get();
    }
}
