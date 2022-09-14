@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4 text-white">
        <div class="card p-4">
            <div class="mb-3">
                <h4>Add Event</h4>
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
            <form role="form" action="{{url('/master/event/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="title">Foto ( Optional )</label>
                        <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="inputGroupFile01">
                        @error('foto')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Judul Event</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukan Judul Kajian" value="{{old('title')}}"  required  autofocus>
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
                            <label for="tanggal">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Tanggal Kajian"  value="{{old('start_date')}}" required>
                            @error('start_date')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Selesai</label>
                            <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" placeholder="Tanggal Kajian"  value="{{old('end_date')}}" required>
                            @error('end_date')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="address_id">Alamat</label>
                            <select class="form-control @error('address_id') is-invalid @enderror" name="address_id">
                                <option value="">-- Pilih Alamat --</option>
                                @foreach($address as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                            @error('address_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="pinned">Pinned ?</label>
                            <select class="form-control" name="pinned" >
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('pinned')
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
                            <label for="description">Deskripsi</label>
                            <textarea class="ckeditor form-control" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Tambah Jadwal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
@endsection