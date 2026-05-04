@extends('layouts.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">DN INPUT</h1>
      </div>
      <div class="col-sm-6">

      </div>
    </div>
  </div>
</div>

<section class="content" style="background-color: rgb(130, 129, 129)">
    {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header" style="background-color: rgb(97, 255, 113)">
                  <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">List Planning Line B3</b></h3>
                  <div class="card-tools">
                    <form action="{{ route('importDn') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-success" type="submit">Import DN</button>
                      </form>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-hover table-striped">
                    <thead class="table" style="background-color: #c0bcbcf8">
                        <tr>
                            <th width="50">No</th>
                            <th>Date</th>
                           
                            <th width="80">Action</th>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(97, 255, 113)">
          <h4 class="modal-title" id="title1">Tambah Planning Line B3</h4>
          <h4 class="modal-title" id="title2">Edit Planning Line B3</h4>
          <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>              
                <div class="col-sm-7"></div>
                    <div class="col-sm-7">
                        <button type="button" class="btn btn-success btn-sm Save">Insert</button>
                        <button type="button" class="btn btn-warning btn-sm Update">Edit</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <table id="example2" class="table table-hover">
                    <thead>
                        <tr cl\>
                            <th width="50">No</th>
                            <th>Part No</th>
                            <th>Kanban</th>
                            <th>Model</th>
                            <th>Spec</th>
                            <th>T</th>
                            <th>W</th>
                            <th>L</th>
                            <th>Kg</th>
                            <th>Order Qty</th>
                            <th>Order Kg</th>
                            <th>Actual Sheet</th>
                            <th>Actual KG</th>
                            <th>Blance sheet</th>
                            <th>Blance Weight</th>
                            <th width="80">Action</th>
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
<input type="hidden" id="doc_dn">
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
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
                        url: "{{ route('rmdnincoming.list') }}"
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
                            data: 'doc_dn',
                            name: 'doc_dn'
                        },
                        {
                            data: 'doc_dn',
                            name: 'doc_dn',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">'+
                                            '<i class="fas fa-search"></i>'+
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

        function listdetail(){
            var table = $('#example2').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 10,
                    ajax: {
                        url: "{{ route('rmdnincoming.listdetail') }}",
                        data: {
                            doc_dn: doc_dn.value,
                        }
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
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'kanban',
                            name: 'kanban'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'spec',
                            name: 'spec'
                        },
                        {
                            data: 'spec_t',
                            name: 'spec_t'
                        },
                        {
                            data: 'spec_w',
                            name: 'spec_w'
                        },
                        {
                            data: 'spec_l',
                            name: 'spec_l'
                        },
                        {
                            data: 'actual_sheet',
                            name: 'actual_sheet'
                        },
                        { 
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_delete_line" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1">'+
                                            '<i class="far fa-trash-alt"></i>'+
                                        '</a>'+
                                        '<a href="#" id="btn_edit_line" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm ml-1">'+
                                            '<i class="fas fa-pencil-alt"></i>'+
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

        $(document).on("click", "#btn_edit_line", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('rmdnincoming.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#kanban').val(result.kanban).trigger('change');
                        $('#spec').val(result.spec).trigger('change');
                        $('#spec_t').val(result.spec_t).trigger('change');
                        $('#spec_w').val(result.spec_w).trigger('change');
                        $('#spec_l').val(result.spec_l).trigger('change');
                        // $('#description').val(result.description);
                    }else{
                        SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                    }
                }
                });
        });

        $(document).on("click", "#btn_edit", function () {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var doc_dn = id;
           
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $('#doc_dn').val(doc_dn);
        
            listdetail();
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
            list();
        });

        function clear(){
            $("#id").val('');
            $("#doc_dn").val('');
            $('#kanban').val('').trigger('change');
            $('#model').val('').trigger('change');
            $("#spec").val('');
            $("#spec_t").val('');
            $("#spec_w").val('');
            $("#spec_l").val('');
            // $('#material_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('rmdnincoming.store')}}",
                    data: {
                        doc_dn: doc_dn.value,
                        part_no: part_no.value,
                        kanban: kanban.value,
                        model: model.value,
                        spec: spec.value,
                        spec_t: time_end.value,
                        spec_w: spec_w.value,
                        spec_l: spec_l.value,
                        _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+result.msg+'</div>');
                            listdetail();
                            $('#part_no').val('').trigger('change');
                            $("#kanban").val('');
                            $("#model").val('');
                            $("#spec").val('');
                            $("#spec_t").val('');
                            $("#spec_w").val('');
                            $("#spec_l").val('');
                            // $('#material_id').val('').trigger('change');
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
                    url: "{{route('rmdnincoming.update')}}",
                    data: {
                            id: id.value,
                            part_no: part_no.value,
                            kanban: kanban.value,
                            model: model.value,
                            spec: spec.value,
                            spec_t: spec_t.value,
                            spec_w: spec_w.value,
                            spec_l: spec_l.value,
                            // description: description.value,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(result) {
                            if(result.success){
                            SweetAlert.fire({
                            icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            
                            listdetail();
                            $('#part_no').val('').trigger('change');
                            $("#kanban").val('');
                            $("#model").val('');
                            $("#spec").val('');
                            $("#spec_t").val('');
                            $("#spec_w").val('');
                            $("#spec_l").val('');
                            // $('#material_id').val('').trigger('change');
                            setTimeout(() => { $("#alert").hide(); }, 150);
                        }else{
                            SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 2500
                        });
                        }
                    }
                });
            }
        });

        $(document).on("click", "#btn_delete_line", function () {
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
                    url: "{{route('rmdnincoming.destroyline')}}",
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
                        listdetail();
                    }
                });
                }
            })
        });

        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            var doc_dn = id.substr(0, 10);
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
                    url: "{{route('rmdnincoming.destroy')}}",
                    data: {doc_dn: doc_dn,  _token: '{{csrf_token()}}'},
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
<style>
    .centered-text {
      text-align: center;
  }
  
  
  tr:nth-child(even) {
    background-color:   
    #efefeff8
  
  ;
  }

  </style>
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
