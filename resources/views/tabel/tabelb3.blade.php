@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data List Part Produksi B3</h1>
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
                  <h3 class="card-title">List Data Material</h3>
                  <div class="card-tools">
                    <button class="btn btn-warning btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table  table-bordered table-striped">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th>Job NO</th>
                            <th>PART NO</th>
                            <th>MODEL</th>
                            <th>RM Spec</th>
                            <th>RM Type</th>
                            <th>DESTINATION</th>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="title1">Add Material</h4>
          <h4 class="modal-title" id="title2">Edit Material</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                <label class="col-sm-3 col-form-label">Job NO :</label>
                <div class="col-sm-9 mb-1">
                    <input type="hidden" id="id">
                    <select style="width: 100%;" id="job_no" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($data_part_names as $product)
                            <option value="{{ $product->id }}">{{ $product->job_no }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-sm-3 col-form-label">Part NO :</label>
                <div class="col-sm-9 mb-1">
                    <select style="width: 100%;" id="part_no" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($data_part_names as $product)
                            <option value="{{ $product->id }}">{{ $product->part_name }}</option>
                        @endforeach
                    </select>
                </div>

                
                <label class="col-sm-3 col-form-label">Model :</label>
                <div class="col-sm-9">
                    <select style="width: 100%;" id="model_id" class="form-control select2" required>
                        <option value="" selected> - pilih - </option>
                        @foreach ($data_models as $model )
                            <option value="{{ $model->id }}"> {{ $model->name}}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-sm-3 col-form-label">Spec :</label>
                <div class="col-sm-9 mb-1">
                    <select style="width: 100%;" id="spec_id" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($rm_materials as $material)
                            <option value="{{ $material->id }}">{{ $material->name_material }}</option>
                        @endforeach
                    </select>
                </div>
                
                <label class="col-sm-3 col-form-label">RM Type :</label>
                <div class="col-sm-9">
                    <select style="width: 100%;" id="type_id" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="SHEET">SHEET</option>
                        <option value="COIL">COIL</option>
                    </select>
                </div>
                
                <label class="col-sm-3 col-form-label">Line :</label>
                <div class="col-sm-9 mb-1">
                    <select style="width: 100%;" id="line_id" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($line_stmps as $line)
                            <option value="{{ $line->id }}">{{ $line->name }}</option>
                        @endforeach
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

        $(document).ready(function() {
        $('#part_no').select2();
        $('#model_id').select2();
        $('#job_no').select2();
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
                        url: "{{ route('tabelb3.list') }}"
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
                            data: 'job_no',
                            name: 'job_no'
                        },
                        {
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'model_id',
                            name: 'model_id'
                        },
                        {
                            data: 'spec_id',
                            name: 'spec_id'
                        },
                        {
                            data: 'type_id',
                            name: 'type_id'
                        }, 
                        {
                            data: 'line_id',
                            name: 'line_id'
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
                url: "{{route('tabelb3.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#spec_id').val(result.spec_id).trigger('change');
                        $('#type_id').val(result.type_id).trigger('change');
                        $('#line_id').val(result.line_id).trigger('change');
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
            $("#job_no").val('').trigger('change');;
            $("#part_no").val('').trigger('change');;
            $('#model_id').val('').trigger('change');
            $('#spec_id').val('').trigger('change');
            $('#type_id').val('').trigger('change');
            $('#line_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('tabelb3.store')}}",
                    data: {
                        job_no: job_no.value,
                        part_no: part_no.value,
                        model_id: model_id.value,
                        spec_id: spec_id.value,
                        type_id: type_id.value,
                        line_id: line_id.value,
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
                    url: "{{route('tabelb3.update')}}",
                    data: {
                            id: id.value,
                            job_no: job_no.value,
                            part_no: part_no.value,
                            model_id: model_id.value,
                            spec_id: spec_id.value,
                            type_id: type_id.value,
                            line_id: line_id.value,
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
            if(job_no.value != '' && part_no.value != '' && model_id.value != '' && type_id.value !='' && line_id.value !='' && spec_id.avlue !=''){
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
                    url: "{{route('tabelb3.destroy')}}",
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
