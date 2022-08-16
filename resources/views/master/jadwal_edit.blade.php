@extends('layouts.main')
@section('content')
<div class="container-fluid py-4 text-white">
    <div class="card p-4">
        <div class="mb-3">
            <h4>Edit Jadwal</h4>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger text-white alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="fa fa-warning"></i></span>
                <span class="alert-text"><strong>Validasi Error!</strong></span>
                <button type="button" class="btn-lg btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 14px;">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
        @endif
        <form role="form" action="{{url('/master/jadwal/update/'.$jadwal->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="title">Brosur Kajian ( Optional )</label>
                        <input type="file" name="brosur" class="form-control @error('brosur') is-invalid @enderror" id="inputGroupFile01" >
                        @error('brosur')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <img src="{{url('api')}}/{{$jadwal->brosur}}" style="width: 300px" height="400px" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Judul Kajian</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukan Judul Kajian" value="{{$jadwal->title}}" >
                        @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal">Tanggal Kajian</label>
                        <input type="datetime-local" name="date_at" class="form-control @error('date_at') is-invalid @enderror" placeholder="Tanggal Kajian"  value="{{$jadwal->date_at}}T{{$jadwal->time_at}}" required>
                        @error('date_at')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ustadz">Ustadz</label>
                        <select class="form-control @error('ustadz_id') is-invalid @enderror" name="ustadz_id" >
                            <option value="">-- Pilih Ustadz --</option>
                            @foreach($ustadz as $row)
                                <option value="{{$row->id}}" {{ $row->id == $jadwal->ustadz_id ? 'selected' : '' }}>{{$row->name}}</option>
                            @endforeach
                        </select>
                        @error('ustadz_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipe_kajian">Tipe Kajian</label>
                        <select class="form-control" name="tipe_kajian" >
                            <option value="0" {{$jadwal->tipe_kajian == 0 ? 'selected' : '' }}>Offline</option>
                            <option value="1" {{$jadwal->tipe_kajian == 1 ? 'selected' : '' }}>Online</option>
                        </select>
                        @error('tipe_kajian')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Url Kajian (optional)</label>
                        <input type="text" name="url_kajian" class="form-control @error('url_kajian') is-invalid @enderror" placeholder="URL Kajian"  value="{{$jadwal->url_kajian}}">
                        @error('url_kajian')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="address">Masjid</label>
                        <select class="form-control @error('address') is-invalid @enderror" name="address">
                            <option value="">-- Pilih Masjid --</option>
                            @foreach($address as $row)
                                <option value="{{$row->id}}" {{ $row->id == $jadwal->address_id ? 'selected' : '' }}>{{$row->name}}</option>
                            @endforeach
                        </select>
                        @error('address')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <select class="form-control" name="waktu">
                            <option value="">-- Pilih Waktu --</option>
                            @foreach($waktu as $row)
                                <option value="{{$row->id}}" {{ $row->id == $jadwal->waktu_id ? 'selected' : '' }}>{{$row->name}}</option>
                            @endforeach
                        </select>
                        @error('waktu')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi </label>
                        <textarea class="ckeditor form-control" name="deskripsi" >{{$jadwal->deskripsi}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-4 mb-0">Update Jadwal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
    <script src="//cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection