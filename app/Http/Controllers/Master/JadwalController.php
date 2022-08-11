<?php

namespace App\Http\Controllers\Master;

use App\Models\Waktu;
use App\Models\Jadwal;
use App\Models\Ustadz;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'date_at' => 'required',
            'ustadz_id' => 'required',
            'title' => 'required',
            'tipe_kajian' => 'required|in:0,1',
            'url_kajian' => 'nullable',
            'address' => 'required_if:tipe_kajian,=,0',
            'waktu' => 'nullable',
        ];
    }

    public function jadwalIndex(){
        return DataTables::of(Jadwal::orderBy('created_at','desc')->get())
        ->editColumn('date_at', function ($jadwal) 
         {
             //change over here
             return date('d F Y', strtotime($jadwal->date_at) );
         })
         ->editColumn('tipe_kajian', function ($jadwal) 
         {
            return $jadwal->tipe_kajian  === 0 ? '<span class="badge bg-gradient-primary">Offline</span>' : '<span class="badge bg-gradient-success">Online</span>';
         })
         ->addColumn('action', function($row){
             $btn = '<div class="d-flex flex-row" style="gap:5px;">';
             $btn = $btn.'<h6><a href="/master/jadwal/edit/'. $row->id .'"><button type="button" class="btn btn-xs bg-gradient-warning">Edit</button></a></h6>';
             $btn = $btn.'<h6><button type="button" class="btn btn-xs bg-gradient-danger" onclick="deleteData('.$row->id.')">Delete</button></h6>';
             $btn = $btn.'</div>';
 
             return $btn;
         })
         ->addIndexColumn()
         ->rawColumns(['tipe_kajian','action'])
         ->toJson();
    }

    public function index(Request $req)
    {
        return view('master.jadwal');
    }

    public function add()
    {
        $ustadz = Ustadz::orderBy('name','ASC')->active()->get();
        $address = Address::orderBy('name','ASC')->get();
        $waktu = Waktu::orderBy('name','ASC')->get();
        return view('master.jadwal_add',compact('ustadz','address','waktu'));
    }

    public function store(Request $req)
    {
        $validator = $req->validate($this->rules);

        try {
            $date = explode("T",$req->date_at);
            $data = new Jadwal;
            $data->title = $req->title;
            $data->setSlugAttribute($req->title);
            $data->date_at = $date[0];
            $data->time_at = $date[1];
            $data->ustadz_id = $req->ustadz_id;
            $data->tipe_kajian = $req->tipe_kajian;
            $data->address_id = $req->address;
            $data->url_kajian = $req->url_kajian;
            $data->waktu_id = $req->waktu;
            $data->deskripsi = $req->deskripsi ?? '';
            
            $data->save();
            return redirect()->route('jadwal')->with('Success', 'Berhasil tambah jadwal!');

        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
       

    //    return redirect()->back();
    }

    public function edit(Request $req, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $ustadz = Ustadz::orderBy('name','ASC')->active()->get();
        $address = Address::orderBy('name','ASC')->get();
        $waktu = Waktu::orderBy('name','ASC')->get();

        return view('master.jadwal_edit',compact('ustadz','address','waktu','jadwal'));
    }

    public function update(Request $req,$id)
    {
        $validator = $req->validate($this->rules);

        try {
            $date = explode("T",$req->date_at);
            $data = Jadwal::findOrFail($id);
            $data->title = $req->title;
            $data->setSlugAttribute($req->title);
            $data->date_at = $date[0];
            $data->time_at = $date[1];
            $data->ustadz_id = $req->ustadz_id;
            $data->tipe_kajian = $req->tipe_kajian;
            $data->address_id = $req->address;
            $data->url_kajian = $req->url_kajian;
            $data->waktu_id = $req->waktu;
            $data->deskripsi = $req->deskripsi ?? '';
            
            $data->save();
            return redirect()->route('jadwal')->with('Success', 'Berhasil update jadwal!');

        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function deleteData(Request $req)
    {

        $jadwal = Jadwal::findOrFail($req->id);
        $jadwal->delete();

        return redirect()->route('jadwal')->with('Success', 'Berhasil delete jadwal!');
    }

}
