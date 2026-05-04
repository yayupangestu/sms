@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data standartnut</h1>
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
                <div class="card-header">
                  <h3 class="card-title">List Data standartnut</h3>
                  <div class="card-tools">
                    <button class="btn btn-info btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered  table-striped ">
                        <thead class="table" style="background-color: #426484; color:#ffffff">
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th>Part Nut</th>
                            <th>Name Nut</th>
                            <th>Supplier</th>
                            <th>Packing Box (Pcs)</th>
                            <th>Packing Kantong (Pcs)</th>
                            <th>line</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" style="background-color:  ">
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
        <div class="modal-header" style="background-color: #426484; color:#ffffff">
          <h4 class="modal-title" id="title1">Add Material</h4>
          <h4 class="modal-title" id="title2">Edit Material</h4>
          <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
        </button>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                
                <label class="col-sm-3 col-form-label">Part NUT:</label>
                <div class="col-sm-9">
                    <input type="hidden" id="id" class="form-control" required>
                    <input type="text" id="part_nut" class="form-control form-control-sm" required>
                </div>
            </div>
        
            <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label">Nut Name:</label>
                <div class="col-sm-3">
                    <select style="width: 100%;" id="name_nut" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="NUT-WELD">NUT-WELD</option>
                        <option value="WELDING-NUT">WELDING-NUT</option>
                        <option value="NUT WELD M10">NUT WELD M10</option>
                        <option value="BOLT-WELD">BOLT-WELD</option>
                        <option value="NUT-SQURE">NUT-SQURE</option>
                        <option value="NUT WELD M6">NUT WELD M6</option>
                    </select>
                </div>
        
                <label class="col-sm-2 col-form-label">Supplier:</label>
                <div class="col-sm-4">
                    <select style="width: 100%;" id="supplier_id" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="ADM Supply">ADM Supply</option>
                        <option value="AOYAMA">AOYAMA</option>
                        <option value="GARMET">GARMET</option>
                        <option value="SUGIN">SUGIN</option>
                        <option value="TMS">TMS</option>
                        <option value="TTI">TTI</option>
                    </select>
                </div>
            </div>
        
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Packing Box:</label>
                <div class="col-sm-9">
                    <input type="text" id="packing_box" class="form-control form-control-sm" required>
                </div>
            </div>
        
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Packing Kantong:</label>
                <div class="col-sm-9">
                    <input type="text" id="packing_kantong" class="form-control form-control-sm" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">line:</label>
                <div class="col-sm-9">
                    <select style="width: 100%;" id="line" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="SSW 1">SSW 1</option>
                        <option value="SSW 2">SSW 2</option>
                        <option value="SSW 3">SSW 3</option>
                        <option value="SSW 4">SSW 4</option>
                        <option value="SSW 5">SSW 5</option>
                        <option value="SSW 6">SSW 6</option>
                        <option value="SSW 7">SSW 7</option>
                        <option value="SSW 8">SSW 8</option>
                        <option value="SSW 9">SSW 9</option>
                        <option value="SSW 10">SSW 10</option>
                        <option value="SSW 11">SSW 11</option>
                        <option value="SSW 12">SSW 12</option>
                    </select>
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
                        url: "{{ route('standartnut.list') }}"
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
                            data: 'name_nut',
                            name: 'name_nut'
                        },
                        {
                            data: 'supplier_id',
                            name: 'supplier_id'
                        },
                        {
                            data: 'packing_box',
                            name: 'packing_box'
                        },
                        {
                            data: 'packing_kantong',
                            name: 'packing_kantong'
                        },
                        {
                            data: 'line',
                            name: 'line'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">'+
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
                url: "{{route('standartnut.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#part_nut').val(result.part_nut);
                        $('#name_nut').val(result.name_nut).trigger('change');
                        $('#supplier_id').val(result.supplier_id).trigger('change');
                        $('#packing_box').val(result.packing_box).trigger('change');
                        $('#packing_kantong').val(result.packing_kantong).trigger('change');
                        $('#line').val(result.line).trigger('change');
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
            $("#name_nut").val('').trigger('change');
            $('#supplier_id').val('').trigger('change');
            $('#packing_box').val('').trigger('change');
            $('#packing_kantong').val('').trigger('change');
            $('#line').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('standartnut.store')}}",
                    data: {
                        part_nut: part_nut.value,
                        name_nut: name_nut.value,
                        supplier_id: supplier_id.value,
                        packing_box: packing_box.value,
                        packing_kantong: packing_kantong.value,
                        line: line.value,
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
                    url: "{{route('standartnut.update')}}",
                    data: {
                            id: id.value,
                            part_nut: part_nut.value,
                            name_nut: name_nut.value,
                            supplier_id: supplier_id.value,
                            packing_box: packing_box.value,
                            packing_kantong: packing_kantong.value,
                            line: line.value,
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
            if(part_nut.value != '' && name_nut.value != '' && supplier_id.value != '' && packing_box.value != '' && line.value){
                return true;
            }else{
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
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
                    url: "{{route('standartnut.destroy')}}",
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
