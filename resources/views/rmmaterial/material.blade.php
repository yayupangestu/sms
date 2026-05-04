@extends('layouts.app')

@section('content')

<style>
     
        .breadcrumb {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .breadcrumb li {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border: 1px solid #ffffff;
            border-right: none;
            background-color: #f9f9f9;
            color: #ffffff;
            position: relative;
        }
        .breadcrumb li:last-child {
            border-right: 1px solid #ffffff;
        }
        .breadcrumb li::after {
            content: '';
            position: absolute;
            top: 0;
            right: -10px;
            width: 0;
            height: 0;
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent;
            border-left: 10px solid #6e6e6e52;
            z-index: 1;
        }
        .breadcrumb li::before {
            content: '';
            position: absolute;
            top: 0;
            right: -11px;
            width: 0;
            height: 0;
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent;
            border-left: 10px solid #ddd;
            z-index: 0;
        }
        .btn-secondary:hover {
        background-color: #2f6081;
        border-color: #122d3f2e;
    }
        .breadcrumb li.active {
            background-color: #15508fad;
            color: white;
        }
        .breadcrumb li.active::after {
            border-left-color: #00ff11;
        }
        .breadcrumb li.active::before {
            border-left-color: #0056b3;
        }
        .breadcrumb li.unassigned {
            background-color: #f8d7da;
            color: #721c24;
        }
        .breadcrumb li.unassigned::after {
            border-left-color: #f8d7da;
        }
        .breadcrumb li.unassigned::before {
            border-left-color: #f5c6cb;
        }
        .breadcrumb li i {
            margin-left: 10px;
        }
    .card {
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 10px;
    }

    .table thead th {
        background-color: #122d3f;
        color: #ffffff;
        font-weight: bold;
        text-align: center;
    }

    .table tbody tr {
        transition: background-color 0.3s;
    }

    .table tbody tr:hover {
        background-color: #adadad96;
    }

    .table tbody td {
        text-align: center;
        border-color: #e3dfdf;
    }

    .btn-edit {
        background-color: #ede434;
        border-color: #245a7e;
    }

    .btn-info {
        background-color: #245a7e;
        border-color: #245a7e;
    }

    .btn-info:hover {
        background-color: #92d2fd;
        border-color: #122d3f;
    }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data Material</h1>
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
                <div class="modal-header" style="background-color: #245a7e; color:#ffffff">
                  <h3 class="card-title">List Data Material</h3>
                  <div class="card-tools">
                    <button class="btn btn-info btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <div class="card-body">
                    <div class="breadcrumb">
                        <div class="d-flex justify-content-start align-items-center">
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE A1">LINE A1</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE A2">LINE A2</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE B1">LINE B1</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE B2">LINE B2</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE B3">LINE B3</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="LINE C1">LINE C1</button></li>
                          <li><button class="btn btn-secondary line-filter-btn" data-line-id="TRANSFERS">LINE TRANSFERS</button></li>
                        </div>
                      </div>
                      <br>
                    <table id="example1"  class="table table-bordered table-striped;centered-text">
                        <thead class="table" style="background-color: #122d3f; color:#ffffff">
                        <tr class="text-center">
                            <th width="50">No</th>
                            <th>Part NO</th>
                            <th>Model</th>
                            <th>Spec Material</th>
                            <th>Tebal</th>
                            <th>Panjang</th>
                            <th>Lebar</th>
                            <th>Supplier</th>
                            <th>No Rak</th>
                            <th width="100">Action</th>
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
        <div class="modal-content">
            <div class="modal-header" style="background-color: #426484; color:#ffffff">
                <h4 class="modal-title" id="title1">Add Material</h4>
                <h4 class="modal-title" id="title2">Edit Material</h4>
                <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12" id="alert"></div>
                    <label class="col-sm-3 col-form-label">Name Material :</label>
                    <div class="col-sm-9">
                        <input type="hidden" id="id" class="form-control" required>
                        <input type="text" id="name_material" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Part Name:</label>
                    <div class="col-sm-9">
                        <input type="text" id="spek" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">T:</label>
                    <div class="col-sm-2">
                        <input type="text" id="spek_t" class="form-control form-control-sm" required>
                    </div>
                    <label class="col-sm-1 col-form-label">P:</label>
                    <div class="col-sm-2">
                        <input type="text" id="spek_p" class="form-control form-control-sm" required>
                    </div>
                    <label class="col-sm-1 col-form-label">L:</label>
                    <div class="col-sm-2">
                        <input type="text" id="spek_l" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Model :</label>
                    <div class="col-sm-9 mb-1">
                        <select style="width: 100%;" id="model" class="form-control select2" required>
                            <option value="" selected>- pilih -</option>
                            @foreach ($data_models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="col-sm-3 col-form-label">Supplier :</label>
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

                    <label class="col-sm-3 col-form-label">No Rak:</label>
                    <div class="col-sm-3">
                        <input type="text" id="no_rak" class="form-control form-control-sm" required>
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
    // Event listener for line filter buttons
    $('.line-filter-btn').on('click', function() {
        var lineId = $(this).data('line-id');  // Get the line_id from the button

        // AJAX request to filter data
        $.ajax({
            type: 'GET',
            url: "{{ route('material.filter') }}",  // Ensure the route is correct and there's a comma
            data: { line_id: lineId },  // Send the line_id data
            success: function(response) {
                // Clear the table body
                $('#example1 tbody').empty();

                // Loop through the response data and append rows to the table
                $.each(response.materials, function(index, material) {
                    var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${material.name_material}</td>
                        <td>${material.spek}</td>
                        <td>${material.spek_t}</td>
                        <td>${material.spek_p}</td>
                        <td>${material.spek_l}</td>
                        <td>${material.model}</td>
                        <td>${material.supplier}</td>
                        <td>
                            <button class="btn btn-sm btn-info btn-edit" data-id="${material.id}">Edit</button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${material.id}">Delete</button>
                        </td>
                    </tr>`;
                    $('#example1 tbody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
          });
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
                        url: "{{ route('material.list') }}"
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
                            data: 'spek',
                            name: 'spek'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'name_material',
                            name: 'name_material'
                        },
                        {
                            data: 'spek_t',
                            name: 'spek_t'
                        },
                        {
                            data: 'spek_p',
                            name: 'spek_p'
                        },
                        {
                            data: 'spek_l',
                            name: 'spek_l'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },
                        {
                            data: 'no_rak',
                            name: 'no_rak'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm">Edit'+
                                        '</a>'+
                                        '<a href="#" id="btn_delete" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1">Delete'+
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
                url: "{{route('material.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#name_material').val(result.name_material);
                        $('#spek').val(result.spek);
                        $('#spek_t').val(result.spek_t);
                        $('#spek_p').val(result.spek_p);
                        $('#spek_l').val(result.spek_l);
                        $('#model').val(result.model).trigger('change');
                        $('#supplier').val(result.supplier).trigger('change');
                        $('#no_rak').val(result.no_rak).trigger('change');
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
            $("#name_material").val('');
            $("#spek").val('');
            $("#spek_t").val('');
            $("#spek_p").val('');
            $("#spek_l").val('');
            $('#model').val('').trigger('change');
            $('#supplier').val('').trigger('change');
            $('#no_rak').val('').trigger('change');
        }

        // $(document).on("click", ".Save", function () {
        //     $("#alert").html('');
        //     $("#alert").show();
        //     if(validasi()){
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{route('material.store')}}",
        //             data: {
        //                 name_material: name_material.value,
        //                 spek: spek.value,
        //                 spek_t: spek_t.value,
        //                 spek_p: spek_p.value,
        //                 spek_l: spek_l.value,
        //                 model: model.value,
        //                 supplier: supplier.value,
        //                 _token: '{{csrf_token()}}'
        //                 },
        //             success: function(result) {
        //                 if(result.success){
        //                     $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+result.msg+'</div>');
        //                     list();
        //                     clear();
        //                     setTimeout(() => { $("#alert").hide(); }, 1500);
        //                 }else{
        //                     $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+result.msg+'</div>');
        //                     setTimeout(() => { $("#alert").hide(); }, 1500);
        //                 }
        //             }
        //         });
        //     }
        // });

        $(document).on('click', '.Save', function () {
                var name_material = $('#name_material').val();
                var spek = $('#spek').val();
                var spek_t = $('#spek_t').val();
                var spek_p = $('#spek_p').val();
                var spek_l = $('#spek_l').val();
                var model = $('#model').val();
                var supplier = $('#supplier').val();
                var no_rak = $('#no_rak').val();

                $.ajax({
                    url: "{{route('material.store')}}",
                    method: 'POST',
                    data: {
                        name_material: name_material,
                        spek: spek,
                        spek_t: spek_t,
                        spek_p: spek_p,
                        spek_l: spek_l,
                        model: model,
                        supplier: supplier,
                        no_rak: no_rak,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response.status === 'error') {
                            Swal.fire('Error', response.message, 'error');
                        } else if (response.status === 'success') {
                            Swal.fire('Success', response.message, 'success');
                            $('#myModal2').modal('hide');
                            // Optionally reload or update the table data here
                        }
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'There was an error processing the request.', 'error');
                    }
                });
        });

        $(document).on("click", ".Update", function () {
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('material.update')}}",
                    data: {
                            id: id.value,
                            name_material: name_material.value,
                            spek: spek.value,
                            spek_t: spek_t.value,
                            spek_p: spek_p.value,
                            spek_l: spek_l.value,
                            model: model.value,
                            supplier: supplier.value,
                            no_rak: no_rak.value,
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
            if(name_material.value != '' && supplier.value != '' && spek_t.value !='' &&spek_p.value !='' && spek_l.value !=''){
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
                    url: "{{route('material.destroy')}}",
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
