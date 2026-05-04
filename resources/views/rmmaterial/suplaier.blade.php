@extends('layouts.app')

@section('content')
<style>
     .btn-info {
        background-color: #245a7e;
        border-color: #245a7e;
    }

    .btn-info:hover {
        background-color: #9fafbb;
        border-color: #245a7e;
    }
</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0" style="font-family: 'Times New Roman', Times, serif">Data supplier Row Material</h1>
      </div>
      <div class="col-sm-6">

      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #245a7e; color: #ffff">
                  <h3 class="card-title" style="font-family: ">List Data Supplier</h3>
                  <div class="card-tools">
                    <button class="btn btn-info btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                    <a href="{{route("supplierrm.export")}}" class="btn btn-success btn-sm"><i class="fa 	fas fa-file-excel"></i> Export Excel</a>
                </div>
                </div>
                <div class="card-body" style="font-family: 'Times New Roman', Times, serif" >
                    <table id="example1" class="table table-striped  table-bordered" class="text-center">
                    <thead class="table">
                        <tr class="text-center" >
                            <th width="50">No</th>
                            <th>Name</th>
                            <th widht="40">PT</th>
                            <th>Alamat</th>
                            <th width="150">No Handphone</th>
                            <th width="90">PIC</th>
                            <th width="150">Description</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="title1">Tambah Suplier</h4>
          <h4 class="modal-title" id="title2">Edit Suplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                <label class="col-sm-3 col-form-label">Nama PT:</label>
                <div class="col-sm-9">
                    <input type="hidden" id="id" class="form-control" required>
                    <input type="text" id="name_suplai" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">PT :</label>
                <div class="col-sm-9">
                    <input type="text" id="pt" class="form-control form-control-sm" required>
                </div>
 
                <label class="col-sm-3 col-form-label">Alamat :</label>
                <div class="col-sm-9">
                    <input type="text" id="alamat" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">No hp :</label>
                <div class="col-sm-9">
                    <input type="text" id="hp" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">PIC :</label>
                <div class="col-sm-9">
                    <input type="text" id="pic" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">Description :</label>
                <div class="col-sm-9">
                    <input type="text" id="description" class="form-control form-control-sm" required>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-primary Update">Update</button>
            <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            <button type="button" class="btn btn-primary Save">Save</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            list();
        });

        $(document).ready(function() {
            list();
        });

        function list(){
            var table = $('#example1').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: {
                        url: "{{ route('supplierrm.list') }}"
                    },
                    columns: [{
                            data: null,
                            sortable: false,
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name_suplai',
                            name: 'name_suplai'
                        },
                        {
                            data: 'pt',
                            name: 'pt'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'hp',
                            name: 'hp'
                        },
                        {
                            data: 'pic',
                            name: 'pic'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm">'+
                                            '<i class="fas fa-pencil-alt"></i>'+
                                        '</a>'+
                                        '<a href="#" id="btn_delete" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1">'+
                                            '<i class="far fa-trash-alt"></i>'+
                                        '</a>';
                            }
                        }
                    ],
                    columnDefs: [{
                        "targets": [0],
                        "orderable": false,
                    }],
                    responsive: true,
                    fixedColumns: true,
                    oLanguage: {
                        sProcessing: '<img src="{{asset('dist/img/Hourglass.gif')}}">Loading . . .'
                    }
            });
        }

        $(document).on("click", "#btn_add", function () {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $(".Update").hide();
            $("#title2").hide();
            $(".Save").show();
            $("#title1").show();
        });

        $(document).on("click", "#btn_edit", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('supplierrm.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#name_suplai').val(result.name_suplai).trigger('change');   
                        $('#alamat').val(result.alamat).trigger('change');
                        $('#pt').val(result.pt).trigger('change');
                        $('#hp').val(result.hp);
                        $('#pic').val(result.pic);
                        $('#description').val(result.description);
                    }else{
                        SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                    }
                }
                });
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
        });

        function clear(){
            $("#id").val('');
            $("#name_suplai").val('');
            $("#alamat").val('');
            $("#pt").val('');
            $("#hp").val('');
            $("#pic").val('');
            $("#description").val('');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('supplierrm.store')}}",
                    data: {
                            name_suplai: name_suplai.value,
                            alamat: alamat.value,
                            pt: pt.value,
                            hp: hp.value,
                            pic: pic.value,
                            description: description.value,
                            _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+result.msg+'</div>');
                            list();
                            clear();
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }else{
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+result.msg+'</div>');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function () {
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('supplierrm.update')}}",
                    data: {
                            id: id.value,
                            name_suplai: name_suplai.value,
                            alamat: alamat.value,
                            pt: pt.value,
                            hp: hp.value,
                            pic: pic.value,
                            description: description.value,
                            _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $('#myModal2').modal('hide');
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            list();
                            clear();
                        }else{
                            SweetAlert.fire({
                                icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }
                    }
                });
            }
        });

        function validasi(){
            $("#alert").show();
            if(name_suplai.value != '' && alamat.value !=''){
                return true;
            }else{
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>column name cannot be empty.</div>');
                setTimeout(() => { $("#alert").hide(); }, 1500);
            }
        }

        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('supplierrm.destroy')}}",
                    data: {id: id, _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function(result) {
                        if(result.success){
                            SweetAlert.fire({
                            icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }else{
                            SweetAlert.fire({
                            icon: 'error', title: 'Error', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                        }
                        list();
                    }
                });
                }
            })
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush