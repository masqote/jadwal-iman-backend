@extends('layouts.main')
@section('content')
    <div class="container-fluid py-4 text-white">
      <div>
        <h4 class="text-white px-2">Master Event</h4>
      </div>
      <div class="card">
        @if(session()->has('Success'))
            <div class="alert alert-success text-white alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Success!</strong> {{session('Success')}}</span>
                <button type="button" class="btn-close btn-lg" data-bs-dismiss="alert" aria-label="Close" style="padding: 14px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="pt-4 px-4">
          <a href="{{url('/master/event/add')}}">
            <button class="btn btn-icon btn-3 btn-primary" type="button">
              <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
              <span class="btn-inner--text">Add Event</span>
            </button>
          </a>
        </div>
        <div class="table-responsive  p-4">
          <table class="table table-bordered align-items-center mb-10" id="dataSource">
            <thead>
              <tr class="text-black font-weight-bold">
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7  ">Judul</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Start Date</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">End Date</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Alamat</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Pinned ?</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
              </tr>
            </thead>
            <tbody >
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
@section('css')
<style>

  th, td {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 400px;
  padding-top: 10px !important; 
  padding-bottom: 10px !important; 
  padding-left: 20px !important; 
  padding-right: 20px !important; 
}

</style>
@endsection
@section('js')


{{-- <script src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      $(document).ready(function(){
        
        $("#dataSource").DataTable({

          language: {
            'paginate': {
              'previous': '<span class="prev-icon"><</span>',
              'next': '<span class="next-icon">></span>'
            }
          },

          "responsive": true,
          "autoWidth": false,
          "lengthChange": false,

          "columnDefs": [
              {
                "defaultContent": "-",
                "targets": "_all"
              },
              { 
              "width": "5%", 
               "targets": 2 
              },
              { 
               "className": "text-center",
               "targets": 0
              }
            ],
          processing: true,
          serverSide: true,
          ajax: '{!! route('event.index') !!}',
          columns:[
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
              data:"title",
              name:"title"
            },
            {
              data:"start_date",
              name:"start_date"
            },
            {
              data:"end_date",
              name:"end_date"
            },
            {
              data:"address.name",
              name:"address.name"
            },
            {
              data:"pinned",
              name:"pinned"
            },
            
            {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
        })
      });

      function deleteData(id){
        Swal.fire({
          title: 'Apakah anda yakin menghapus data ini?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                  type: "POST",
                  url:"{{ route('jadwal.delete') }}",
                  data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                  },
                  success: function(msg){
                    location.reload();
                  }
            });
          }
        })
      }
    </script>
@endsection