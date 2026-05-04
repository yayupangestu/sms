@extends('layouts.app')

@section('content')
<style>
    .centered-text {
      text-align: center;
  }
  
  
  tr:nth-child(even) {
    background-color:   
    #e6e6e6

  }

  .actual{
    background-color: rgb(0, 255, 64);
  }

  .minimal{
    background-color: yellow;
  }
  </style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Stok Nut Standart Part</h1>
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
                <div class="card" id="CardHead">
                    <div class="card-header" style="background-color:  rgb(140, 198, 203)">
                        <h3 class="card-title">
                        <i class="fas fa-store"></i>
                            List Stok Item Standart PART
                        </h3>
                      <div class="card-tools">
                        <button class="btn btn-warning btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                        {{-- <a href="{{route("stoknut.export")}}" class="btn btn-success btn-sm"><i class="fa 	fas fa-file-excel"></i> Export Excel</a> --}}
                      </div>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body" style="font-family: 'Times New Roman', Times, serif">
                            <table id="example1" class="table  table-bordered table-striped; centered-text">
                                <thead class="table" style="background-color: rgb(154, 198, 202)">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Items Name</th>
                                        <th width="100">Category</th>
                                        <th class="minimal" width="100">MinimalStok</th>
                                        <th class="actual" width="100">Actual Stok</th>
                                        <th width="50">Action</th>
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
      </div>
</section>

<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title1">Add Item</h4>
                <h4 class="modal-title" id="title2">Edit Item</h4>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12" id="alert"></div>

                    <label class="col-sm-3 col-form-label">Items Name:</label>
                    <div class="col-sm-9 mb-1">
                        <input type="hidden" id="id">
                        <select style="width: 100%;" id="part_nut" class="form-control select2" required>
                            <option value="" selected>- pilih -</option>
                            @foreach ($rm_standart_nuts as $item)
                                <option value="{{ $item->id }}">{{ $item->part_nut }}/{{ $item->supplier_id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="col-sm-3 col-form-label">Category :</label>
                    <div class="col-sm-9">
                        <select style="width: 100%;" id="category" class="form-control select2" required>
                            <option value="" selected>- pilih -</option>
                            <option value="Standart Part">Standart Part</option>
                        </select>
                    </div>

                    <label class="col-sm-3 col-form-label">Minimal :</label>
                    <div class="col-sm-9">
                        <input type="text" id="minimal" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Actual :</label>
                    <div class="col-sm-9">
                        <input type="text" id="actual" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary Update">Update</button>
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
                        url: "{{ route('stoknut.list') }}"
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
                            data: 'part_nut',
                            name: 'part_nut'
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'minimal',
                            name: 'minimal'
                        },
                        {
                            data: 'actual',
                            name: 'actual'
                        }, 
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm">'+
                                            '<i class="	fas fa-edit"></i>'+
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
                url: "{{route('stoknut.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#part_nut').val(result.part_nut).trigger('change');
                        $('#category').val(result.category).trigger('change');
                        $('#minimal').val(result.minimal).trigger('change');
                        $('#actual').val(result.actual).trigger('change');
                        // $('#satuan').val(result.satuan).trigger('change');
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
            $("#part_nut").val('');
            $("#category").val('');
            $('#minimal').val('').trigger('change');
            $('#actual').val('').trigger('change');
            // $('#satuan').val('').trigger('change');

        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('stoknut.store')}}",
                    data: {
                        part_nut: part_nut.value,
                        category: category.value,
                        minimal: minimal.value,
                        actual: actual.value,
                        // satuan: satuan.value,
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
                    url: "{{route('stoknut.update')}}",
                    data: {
                            id: id.value,
                            part_nut: part_nut.value,
                            category: category.value,
                            minimal: minimal.value,
                            actual: actual.value,
                            // satuan: satuan.value,
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
            if(part_nut.value != '' && category.value != '' && minimal.value != '' && actual.value != ''){
                return true;
            }else{
                $("#alert").html('<div class="alert alert-info"><i class="fa fa-info"></i>all column cannot be empty.</div>');
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
                    url: "{{route('stoknut.destroy')}}",
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