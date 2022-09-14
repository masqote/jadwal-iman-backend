<?php

namespace App\Http\Controllers\Master;

use App\Models\Event;
use App\Models\Waktu;
use App\Models\Jadwal;
use App\Models\Ustadz;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'title' => 'required',
            'pinned' => 'required|in:0,1',
            'address_id' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function eventIndex(){
        return DataTables::of(Event::orderBy('created_at','desc')->get())
        ->editColumn('start_date', function ($event) 
         {
             //change over here
             return date('d F Y', strtotime($event->start_date) );
         })
         ->editColumn('end_date', function ($event) 
         {
             //change over here
             return date('d F Y', strtotime($event->end_date) );
         })
         ->editColumn('pinned', function ($event) 
         {
            return $event->pinned  === 0 ? '<span class="badge bg-gradient-primary">No</span>' : '<span class="badge bg-gradient-success">Yes</span>';
         })
         ->addColumn('action', function($row){
             $btn = '<div class="d-flex flex-row" style="gap:5px;">';
             $btn = $btn.'<h6><a href="/master/event/edit/'. $row->id .'"><button type="button" class="btn btn-xs bg-gradient-warning">Edit</button></a></h6>';
             $btn = $btn.'<h6><button type="button" class="btn btn-xs bg-gradient-danger" onclick="deleteData('.$row->id.')">Delete</button></h6>';
             $btn = $btn.'</div>';
 
             return $btn;
         })
         ->addIndexColumn()
         ->rawColumns(['pinned','action'])
         ->toJson();
    }

    public function index(Request $req)
    {
        return view('master.event.event');
    }

    public function add()
    {
        $address = Address::orderBy('name','ASC')->get();
        return view('master.event.event_add',compact('address'));
    }

    public function store(Request $req)
    {
        $validator = $req->validate($this->rules);
        $start_date = explode("T",$req->start_date);
        $end_date = explode("T",$req->end_date);

        try {
            
            $data = new Event;
            $data->title = $req->title;
            $data->setSlugAttribute($req->title);
            $data->start_date = $req->start_date;
            $data->end_date = $req->end_date;
            $data->address_id = $req->address_id;
            $data->pinned = $req->pinned;
            $data->description = $req->description ?? '';
            
            if ($req->foto) {
                $imageName = time().'.'.$req->foto->extension();
                $req->foto->move(public_path('/api/event'.'/'.$start_date[0]), $imageName);

                $data->foto = 'event'.'/'.$start_date[0].'/'.$imageName;
            }
            
            $data->save();
            return redirect()->route('event')->with('Success', 'Berhasil tambah Event!');

        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
       

    //    return redirect()->back();
    }

    public function edit(Request $req, $id)
    {
        $event = Event::findOrFail($id);
        $address = Address::orderBy('name','ASC')->get();

        return view('master.event.event_edit',compact('address','event'));
    }

    public function update(Request $req,$id)
    {
        $validator = $req->validate($this->rules);
        $start_date = explode("T",$req->start_date);
        $end_date = explode("T",$req->end_date);

        try {
            $data = Event::findOrFail($id);
            $data->title = $req->title;
            $data->start_date = $req->start_date;
            $data->end_date = $req->end_date;
            $data->address_id = $req->address_id;
            $data->pinned = $req->pinned;
            $data->description = $req->description ?? '';
            

            if ($req->foto) {
                $path = public_path().'/api/';
                $file_old = $path.$data->foto;
                
                if ($data->foto) {
                    unlink($file_old);
                }
                
                $imageName = time().'.'.$req->foto->extension();
                
                $req->foto->move(public_path('/api/event'.'/'.$start_date[0]), $imageName);

                $data->foto = 'event'.'/'.$start_date[0].'/'.$imageName;
            }
            
            $data->save();
            return redirect()->route('event')->with('Success', 'Berhasil update event!');

        } catch (\Exception $e) {
            return redirect()->back()->with('Error', $e->getMessage());
        }
    }

    public function deleteData(Request $req)
    {

        $data = Event::findOrFail($req->id);

        $path = public_path().'/api/';
        $file_old = $path.$data->foto;

        if ($data->foto) {
            unlink($file_old);
        }

        $data->delete();

        return redirect()->route('event')->with('Success', 'Berhasil delete Event!');
    }

}
