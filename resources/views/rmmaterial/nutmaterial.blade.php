@extends('layouts.app')

@section('content')
<style>

.text-center td, .text-center th {
    text-align: center;
}

.warna-merah {
    background-color: #ff6666; /* Warna merah muda */
    color: #000000; /* Teks putih */
}
.warna-kuning {
    background-color: #ffff99; /* Warna kuning pucat */
    color: #000000; /* Teks hitam */
}
.warna-biru {
    background-color: #99ccff; /* Warna biru muda */
    color: #000000; /* Teks putih */
}
.warna-hijau {
    background-color: #66ff66; /* Warna hijau muda */
    color: #000000; /* Teks putih */
}
.warna-hitam {
    background-color: #333333; /* Warna hitam */
    color: #ffffff; /* Teks putih */
}

</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data Material NUT</h1>
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
                <div class="card-header" style="background-color: #2c4358; color:#ffffff">
                  <h3 class="card-title">List Data Material NUT</h3>
                  <div class="card-tools">
                    <button class="btn btn-success btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered  table-striped ">
                    <thead class="table" style="background-color: #2c4358; color:#ffffff">
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th >Part NO</th>
                            <th>Job NO</th>
                            <th width="70">Model</th>
                            <th width="70">Spec NUT</th>
                            <th width="90">Warna Nut</th>
                            <th>Type</th>
                            <th>Supplier</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
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
      <div class="modal-content" style="background-color:#ffffff">
        <div class="modal-header" style="background-color: #2c4358; color: rgb(255, 255, 255);">
          <h4 class="modal-title" id="title1">Add Material NUT</h4>
          <h4 class="modal-title" id="title2">Edit Material NUT</h4>
          <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
        </button>
            {{-- <span aria-hidden="true">&times;</span> --}}
          {{-- </button> --}}
        </div>
        <div class="modal-body">
            <div class="form-group row mb-2">
                <div class="col-12" id="alert"></div>
                <label class="col-sm-2 col-form-label">Part NO :</label>
                <div class="col-sm-9">
                    <input type="hidden" id="id" class="form-control" required>
                    <select style="width: 100%;" id="part_no" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($data_part_names as $product)
                            <option value="{{ $product->id }}" data-job_no="{{ $product->job_no }}" data-model="{{ $product->model }}">
                                {{ $product->part_name }} / {{ $product->job_no}} / {{ $product->model}}
                            </option>
                        @endforeach
                    </select>   
                </div>
            </div>
        
            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Job No:</label>
                <div class="col-sm-4">
                    <select style="width: 100%;" id="job_no" class="form-control select2" disabled>
                        <option value=""></option>
                        @foreach ($data_part_names as $product)
                            <option value="{{ $product->job_no }}">{{ $product->job_no }}</option>
                        @endforeach
                    </select>
                </div>
        
                <label class="col-sm-2 col-form-label">Model:</label>
                <div class="col-sm-3">
                    <select style="width: 100%;" id="model_id" class="form-control" disabled>
                        <option></option>
                        @foreach ($data_part_names as $product)
                        <option value="{{ $product->model }}">{{ $product->model }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-2">
                <label class="col-sm-2 col-form-label">Nut:</label>
                <div class="col-sm-4">
                    <select style="width: 100%;" id="spec_nut" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="M6">M6</option>
                        <option value="M6 SP">M6 SP</option>
                        <option value="M7">M7</option>
                        <option value="M7/16">M7/16</option>
                        <option value="M7/17">M7/16</option>
                        <option value="M8">M8</option>
                        <option value="M8 SP">M8 SP</option>
                        <option value="M8 Spesial">M8 Spesial</option>
                        <option value="M9">M7</option>
                        <option value="M10">M10</option>
                        <option value="M12">M12</option>
                        <option value="BOLT M6">BOLT M6</option>
                    </select>
                </div>
                  
                <label class="col-sm-2 col-form-label">Warna:</label>
                <div class="col-sm-3">
                    <select style="width: 100%;" id="warna_nut" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="Merah">Merah</option>
                        <option value="Kuning">Kuning</option>
                        <option value="Biru">Biru</option>
                        <option value="Hijau">Hijau</option>
                        <option value="Hitam">Hitam</option>
                    </select>
                </div>
            </div>
                          
            <div class="form-group row mb-2"> <!-- Menambahkan margin bawah -->
                <label class="col-sm-2 col-form-label">Type:</label>
                <div class="col-sm-9">
                    <select style="width: 100%;" id="type_id" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($rm_standart_nuts as $type)
                            <option value="{{ $type->id }}">{{ $type->part_nut }}</option>
                        @endforeach
                    </select>
                </div>


            {{-- <div class="form-group row mb-2"> <!-- Menambahkan margin bawah --> --}}
                <label class="col-sm-2 col-form-label">Supplier:</label>
                <div class="col-sm-9">
                    <select style="width: 100%;" id="supplier" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        <option value="TTMI">PT.TTMI</option>
                        <option value="POSCO">PT.POSCO</option>
                        <option value="POSCO-IJPC">PT.POSCO-IJPc</option>
                        <option value="MULTI STELL DILUCH">PT.MULTI STEEL DILUCH</option>
                        <option value="STEEL CENTER INDONESIA">PT.STEEL CENTER INDONESIA</option>
                        <option value="SARANA STEEL">PT.SARANA STEEL</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-info Update">Update</button>
            <button type="button" class="btn btn-info Save">Save</button>
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
    $('#part_no').change(function() {
        var selectedOption = $(this).find('option:selected');
        var jobNo = selectedOption.data('job_no');
        var model = selectedOption.data('model');

        // Set value of job_no
        $('#job_no').val(jobNo).trigger('change');

        // Set value of model_id
        $('#model_id').val(model).trigger('change');
    });
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
                        url: "{{ route('materialnut.list') }}"
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
                            data: 'job_no',
                            name: 'job_no'
                        },
                        {
                            data: 'model_id',
                            name: 'model_id'
                        },
                        {
                            data: 'spec_nut',
                            name: 'spec_nut'
                        },
                        {
                            data: 'warna_nut',
                            name: 'warna_nut'
                        },
                        {
                            data: 'type_id',
                            name: 'type_id'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
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

                    createdRow: function(row, data, dataIndex) {
                        // Tentukan kelas warna berdasarkan nilai 'warna_nut'
                        if (data.warna_nut === 'Merah') {
                            $('td', row).eq(5).addClass('warna-merah');
                        } else if (data.warna_nut === 'Kuning') {
                            $('td', row).eq(5).addClass('warna-kuning');
                        } else if (data.warna_nut === 'Biru') {
                            $('td', row).eq(5).addClass('warna-biru');
                        } else if (data.warna_nut === 'Hijau') {
                            $('td', row).eq(5).addClass('warna-hijau');
                        } else if (data.warna_nut === 'Hitam') {
                            $('td', row).eq(5).addClass('warna-hitam');
                        }
                    },
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
                url: "{{route('materialnut.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#spec_nut').val(result.spec_nut).trigger('change');
                        $('#warna_nut').val(result.warna_nut).trigger('change');
                        $('#type_id').val(result.type_id).trigger('change');
                        $('#supplier').val(result.supplier).trigger('change');

                        
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
            $("#part_no").val('').trigger('change');
            $("#job_no").val('').trigger('change');
            $('#model_id').val('').trigger('change');
            $('#spec_nut').val('').trigger('change');
            $('#warna_nut').val('').trigger('change');
            $('#type_id').val('').trigger('change');
            $('#supplier').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('materialnut.store')}}",
                    data: {
                        part_no: part_no.value,
                        job_no: job_no.value,
                        model_id: model_id.value,
                        spec_nut: spec_nut.value,
                        warna_nut: warna_nut.value,
                        type_id: type_id.value,
                        supplier: supplier.value,
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
                    url: "{{route('materialnut.update')}}",
                    data: {
                            id: id.value,
                            part_no: part_no.value,
                            job_no: job_no.value,
                            model_id: model_id.value,
                            spec_nut: spec_nut.value,
                            warna_nut: warna_nut.value,
                            type_id: type_id.value,
                            supplier: supplier.value,
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
            if(part_no.value != '' && job_no.value != '' && model_id.value != '' && type_id.value != '' && supplier.value != '' && spec_nut.value != '' ){
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
                    url: "{{route('materialnut.destroy')}}",
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
