@extends('layouts.app')

@section('content')
<style>
  .centered-text {
    text-align: center;
  }

  tr:nth-child(even) {
    background-color: #ccd2d5;
    color: #000000;
  }

  .actual {
    background-color: #00ff40;
  }

  .minimal {
    background-color: yellow;
  }

  /* Table Header Styling */
  thead th {
    background-color: #28425e;
    color: white;
  }

  /* Card Styling */
  .card {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Modal Header Styling */
  .modal-header {
    background-color: #28425e;
    color: white;
    border-bottom: none;
  }

  /* Modal Body Styling */
  .modal-body {
    background-color: #f9f9f9;
    padding: 20px;
  }

  /* Buttons */
  .btn-primary {
    background-color: #28425e;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }

  .btn-success {
    background-color: #28a745;
    border-color: #2c6e3c;
  }

  .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
  }

  .btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
  }

  .btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
  }

  /* Input Fields */
  .form-control {
    border-radius: 10%;
    box-shadow: none;
    border: 1px solid #242525;
  }

  .form-control:focus {
    border-color: #506479;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
  }

  /* Modal Form Group Styling */
  .form-group {
    margin-bottom: 15px;
  }

  /* Spacing for Inputs */
  .modal-body .form-group input,
  .modal-body .form-group select {
    margin-bottom: 10px;
  }

  /* Additional Custom Styling */
  .table {
    margin-top: 20px;
  }

  .card-title {
    font-weight: bold;
  }

  .card-header {
    background-color: #f8f9fa;
  }

  .table-bordered {
    border: 1px solid #dee2e6;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">List Material In</h1>
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
            <h3 class="card-title">List Material IN</h3>
            <div class="card-tools">
              <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
            </div>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th class="text-center">Doc DN</th></th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">SUPPLIER</th>
                  <th class="text-center" width="100">ACTION</th>
                </tr>
              </thead>
              <tbody class="centered-text">
                <!-- Dynamic Rows Here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal for Adding/Editing Material -->
  <div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <div class="row justify-content-between">
              <div class="col-sm-5">
                  <h4 class="modal-title" id="title1"><b>Add Item Out</b></h4>
                  <h4 class="modal-title" id="title2"><b>Edit Item Out</b></h4>
                </div>
                <div class="col-sm-6 text-right" style="">
                  <button class="btn btn-primary btn-sm" id="btn_submit">Save</button>
                  <button class="btn btn-default btn-sm" id="btn_cancel">Cancel</button>
                  <button type="button" class="close; btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Close
              </div>
            </div>
          <hr>
        
          <div class="form-group row">
            <div class="col-12" id="alert"></div>
            
            <label for="qty" class="col-sm-2 col-form-label">No SPB :</label>
            <div class="col-sm-6">
                <input style="width: 100%" type="text" id="doc_no" class="form-control form-control-sm" readonly>
            </div>
            <div class="col-sm-12"></div> 

            <label class="col-sm-2 col-form-label">Date :</label>
            <div class="col-sm-3 mb-1">
              <input type="hidden" id="id" class="form-control" required>
              <input type="date" id="date_plan" class="form-control form-control-sm" required>
            </div>

            <label class="col-sm-2 col-form-label">Supplier :</label>
            <div class="col-sm-5 mb-1">
              <select style="width: 100%;" id="suplai_id"  class="form-control form-control-sm" required>
                <option value="" selected>- pilih -</option>
                @foreach ($rm_supplier_nuts as $suplai)
                <option value="{{ $suplai->id }}">{{ $suplai->name_suplai }} / {{$suplai->pt}}</option>
                @endforeach
              </select>
            </div>

            <label class="col-sm-2 col-form-label">Material :</label>
            <div class="col-sm-3 mb-2">
              <select style="width: 100%;" id="material_id"  class="form-control form-control-sm" required>
                <option value="" selected>- pilih -</option>
                @foreach ($rm_standart_nuts as $material)
                <option value="{{ $material->id }}">{{ $material->part_nut }}</option>
                @endforeach
              </select>
            </div>

            <label class="col-sm-2 col-form-label">Category :</label>
            <div class="col-sm-2">
              <select style="width: 100%;" id="category_id"  class="form-control form-control-sm" required>
                <option value="" selected>- pilih -</option>
                <option value="STD PART">STANDART PART</option>
              </select>
            </div>

            <label class="col-sm-1 col-form-label">Qty:</label>
            <div class="col-sm-2">
              <input type="text" id="qty_plan" class="form-control form-control-sm" required>
            </div>

            <label class="col-sm-2 col-form-label">Qty Input:</label>
            <div class="col-sm-2">
              <input type="text" id="qty_in" class="form-control form-control-sm" required>
            </div>

            <label class="col-sm-2 col-form-label">Keterangan:</label>
            <div class="col-sm-6">
              <input type="text" id="keterangan" class="form-control form-control-sm" required>
            </div>

            <div class="col-sm-7 mt-2">
              <button type="button" class="btn btn-success btn-sm Save">Insert</button>
              <button type="button" class="btn btn-warning btn-sm Update">Edit</button>
            </div>
          </div>
          <div class="col-sm-12 mt-4">
                  <table id="example2" class="table table-hover centered-text">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>Supplier</th>
                        <th>Category</th>
                        <th class="text-center">Material</th>
                        <th>Qty Plan</th>
                        <th>Qty IN</th>
                        <th class="text-center" width="90">Action</th>
                        <th class="text-center">Material NO</th> <!-- New Column Header -->
                      </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows Here -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
</section>  

<div class="modal fade" id="modal_konfirmasi">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(195, 255, 249)">
          <h4 class="modal-title"><b>Are you sure you want to cancel the transaction?</b></h4>
      </div>
      <div class="modal-body" style="background-color: rgb(255, 255, 255)">
          <button class="btn btn-success btn-sm" id="btn_tidak">Yes</button>
          <button class="btn btn-warning btn-sm" id="btn_ya">No</button>
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
                $("#example1").show();
                list();
                getDoc();

            });


        function getDoc(){
                var d = new Date(),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                $.ajax({
                    type: 'GET',
                    url: "{{route('innut.getdoc')}}",
                    success: function(result) {
                        $("#id").val('');
                        $("#doc_no").val("DN/ASI/SP"+year+month+"/");
                        $("#date_plan").val('');
                        $('#suplai_id').val('');
                        $('#category_id').val('');
                        $("#material_id").val('');
                        $('#qty_plan').val('');
                        $('#qty_in').val('');
                        $('#keterangan').val('');
                        $('#no').val('');
                    }
                });
        }

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
                        url: "{{ route('innut.list') }}"
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
                            data: 'doc_no',
                            name: 'doc_no'
                        },
                        {
                        
                            data: 'date_plan',
                            name: 'date_plan'
                        },
                        {
                            data: 'suplai',
                            name: 'suplai'
                        },
                        {
                            data: 'mix_id',
                            name: 'mix_id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-warning btn-sm">'+
                                            '<i class="fas fa-pencil-alt"></i>'+
                                        '</a>'+
                                        '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm ml-1">'+
                                            '<i class="fas fa-solid fa-print"></i>'+
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

        function listdetail() {
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
                      url: "{{ route('innut.listdetail') }}",
                      data: {
                          doc_no: doc_no.value,
                          date_plan: date_plan.value,
                          suplai_id: suplai_id.value,
                      }
                  },
                  columns: [
                      {
                          data: null,
                          sortable: false,
                          searchable: false,
                          orderable: false,
                          render: function(data, type, row, meta) {
                              return meta.row + meta.settings._iDisplayStart + 1;
                          }
                      },
                      {
                          data: 'suplai_id',
                          name: 'suplai_id'
                      },
                      {
                          data: 'category_id',
                          name: 'category_id'
                      },
                      {
                          data: 'material_id',
                          name: 'material_id'
                      },
                      {
                          data: 'qty_plan',
                          name: 'qty_plan'
                      },
                      {
                        data: 'qty_in',
                        name: 'qty_in'
                      },
                      {
                          data: 'id',
                          name: 'id',
                          render: function(data) {
                              return `
                                  <a href="#" id="btn_edit_line" title="Edit" data-id="${data}" class="btn btn-warning btn-sm">
                                      <i class="far fa-edit"></i>
                                  </a>
                                  <a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm">
                                      <i class="far fa-trash-alt"></i>
                                  </a>
                                  <a href="/innut/rmmaterial/cetak/${data}" target="_blank" id="btn_pdf" title="Generate" class="btn btn-info btn-sm">
                                      <i class="fas fa-solid fa-qrcode"></i>
                                  </a>
                              `;
                          }
                      },
                      {
                          data: 'no',
                          name: 'no'
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
            $("#title2").hide();
            $("#title1").show();
            clear();
            getDoc();
        });


        $(document).on("click", "#btn_edit", function () {
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
            $("#title1").hide();
            $("#title2").show();
            var doc_no = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('innut.edit')}}",
                data: {
                    doc_no: doc_no,
                    _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    $('#doc_no').val(doc_no);
                    $('#date_plan').val(result.date_plan);
                    $('#suplai_id').val(result.suplai_id);
                    listdetail();
                  
                }
            });
            // getDoc();
        });

        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
            list();
            getDoc();
        });

        function clear(){
            $("#id").val('');
            $('#doc_no').val('');
            $("#date_plan").val('');
            $('#suplai_id').val('');
            $('#category_id').val('');
            $('#material_id').val('');
            $("#qty_plan").val('');
            $('#qty_in').val('');
            $('#keterangan').val('');
            // $('#no').val('').trigger('change');
        }

        function updt_submit(){
                $("#alert").html('');
                $("#alert").show();
                $.ajax({
                    type: 'POST',
                    url: "{{route('innut.submit')}}",
                    data: {
                        doc_no: doc_no.value,
                        _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $('#modal_header').modal('hide');
                            SweetAlert.fire({
                                icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            list();
                        }else{
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+result.msg+'</div>');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }
                    }
                });
            }

            $(document).on("click", "#btn_submit", function () {
                updt_submit();
            });

            $(document).on("click", "#btn_cancel", function () {
                $('#modal_konfirmasi').modal({ backdrop: 'static', keyboard: false, show: true });
            });

            $(document).on("click", "#btn_tidak", function () {
                $('#modal_konfirmasi').modal('hide');
                $('#modal_header').modal('hide');
                delete_draft()
            });
            
            document.getElementById('btn_tidak').addEventListener('click', function() {
                location.reload();
            });

            $(document).on("click", "#btn_ya", function () {
                $('#modal_konfirmasi').modal('hide');
                updt_submit();
            });

            function delete_draft(){
                    $.ajax({
                        type: 'POST',
                        url: "{{route('strout2.delete_draft')}}",
                        data: {
                            doc_no: doc_no.value,
                            _token: '{{csrf_token()}}'
                            },
                        success: function(result) {
                            //
                        }
                    });
            }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('innut.store')}}",
                    data: {
                        doc_no: doc_no.value,
                        date_plan: date_plan.value,
                        suplai_id: suplai_id.value,
                        category_id: category_id.value,
                        material_id: material_id.value,
                        qty_plan: qty_plan.value,
                        qty_in: qty_in.value,
                        keterangan: keterangan.value,
                        // no: no.value,
                        _token: '{{csrf_token()}}'
                        },
                    success: function(result) {
                        if(result.success){
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+result.msg+'</div>');
                            listdetail();
                            $('#item_id').val('').trigger('change');
                            $("#category_id").val('').trigger('change');;    
                            $("#qty_plan").val('');
                            $("#qty_in").val('');
                            $("#keterangan").val('');
                            // $('#no').val('').trigger('change');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }else{
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+result.msg+'</div>');
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", "#btn_edit_line", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('innut.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#material_id').val(result.material_id).trigger('change');
                        $('#qty_plan').val(result.qty_plan).trigger('change');
                        $('#qty_in').val(result.qty_in).trigger('change');
                        $('#category_id').val(result.category_id).trigger('change');
                        $('#keterangan').val(result.keterangan).trigger('change');
                    }else{
                        SweetAlert.fire({
                            icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 1500
                        });
                    }
                }
                });
        });

        $(document).on("click", ".Update", function () {
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('innut.update')}}",
                    data: {
                            id: id.value,
                            material_id: material_id.value,
                            qty_plan: qty_plan.value,
                            qty_in: qty_in.value,
                            category_id: category_id.value,
                            keterangan: keterangan.value,
                            // no: no.value,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(result) {
                            if(result.success){
                            SweetAlert.fire({
                            icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                            });
                            
                            listdetail();
                            $('#material_id').val('').trigger('change');
                            $("#qty_plan").val('');
                            $("#qty_in").val('');
                            $("#category_id").val('').trigger('change');
                            $('#keterangan').val('').trigger('change');
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

        function validasi(){
            $("#alert").show();
            if(date_plan.value != '' && suplai_id.value != '' && material_id.value != '' && qty_plan.value != ''){
                return true;
            }else{
                $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>All Column Cannot be Empty.</div>');
                
                
                setTimeout(() => { $("#alert").hide(); }, 2000);
            }
        }

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
                    url: "{{route('innut.destroyline')}}",
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
            var doc_no = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't remove!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{route('innut.destroy')}}",
                    data: { doc_no:doc_no, _token: '{{csrf_token()}}'},
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
                        getDoc();
        
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
