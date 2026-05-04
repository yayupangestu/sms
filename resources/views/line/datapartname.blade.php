@extends('layouts.app')

@section('content')
<style>
  .nav-tabs .nav-item .btn {
        border: none;
        padding: 5px 15px;
        margin: 0 5px;
        font-weight: 500;
        color: #000000;
        background-color: transparent;
        border-radius: 25px;
    }

    .nav-tabs .nav-item .btn.active {
        background-color: #f0f0f0;
        color: #000000;
    }

    .form-control {
        border-radius: 20px;
    }

    .btn-outline-secondary {
        border-radius: 25px;
        padding: 5px 15px;
        font-weight: 500;
    }

    .card-header {
        background: #fff;
        border-bottom: 1px solid #e3e3e3;
        padding: 15px;
    }
       /* Custom styling for active state */
       .btn.active {
        background-color: #000000; /* Matching the secondary background color */
        color: white; /* Optional: to change text color */
    }
</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data Part Number</h1>
      </div>
      <div class="col-sm-6">

      </div>
    </div>
  </div>
</div>

<section class="content">
    <div class="container-fluid" style="background-color: rgb(255, 255, 255)" >
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(to bottom right, #00ff00 24%, #ffff00 100%);">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <!-- Tabs for status filters -->
                        <ul class="nav nav-tabs flex-wrap">
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="A1,A2,B1,B2,B3,C1,C2">All</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-info line-filter-btn" data-line-id="A1">LINE A1</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-info line-filter-btn" data-line-id="A2">LINE A2</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-info line-filter-btn" data-line-id="A3">LINE A3</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-info line-filter-btn" data-line-id="B1">LINE B1</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-info line-filter-btn" data-line-id="B2">LINE B2</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="B3">LINE B3</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="C1">LINE C1</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="C2">LINE C2</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="TCF-2">TCF-2</button>
                            </li>
                            <li class="nav-item">
                                <button class="btn btn-outline-info line-filter-btn" data-line-id="TRANSFERS">TRANSFERS</button>
                            </li>
                        </ul>
                
                        <!-- Search and Action Buttons -->
                        <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center mt-2 mt-md-0">
                            <input type="text" class="form-control" placeholder="Search" style="width: 150px; margin-right: 10px;">
                            <form id="importForm" action="{{ route('partname.importDp') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                                @csrf
                                <input type="file" id="fileInput" name="file" class="form-control me-2" style="width: auto;" required>
                                <button id="importButton" class="btn btn-outline-secondary" type="submit" disabled>Import</button>
                            </form>
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exportModal">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>
                
                
                <div class="card-body;table-responsive ">
                    <div class="table-responsive">
                        <table id="example1" class="table  table-bordered table-striped">
                            <thead style="background: linear-gradient(to bottom right, #00ff00 24%, #ffff00 100%);">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>No Rak</th>
                                    <th>Costumer</th>
                                    <th>Suplier</th>
                                    <th>Job No</th>
                                    <th>Part No</th>
                                    <th>Part Name</th>
                                    <th>Variant</th>
                                    <th>Grouping Model</th>
                                    <th>Spec</th>
                                    <th>T</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>Bq</th>
                                    <th>Kg</th>
                                    <th>Pcs</th>
                                    <th>Qty/Pallet</th>
                                    <th>Qty Min</th>
                                    <th>Lead Time</th>
                                    <th>Home Line</th>
                                    <th>UploadBy</th>
                                    <th style="background-color: #0000002a">Time Upload</th>
                                    <th>Action</th>
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
  </div>
</section>

<!-- Export Filter Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div style="background-color: #adadad" class="modal-header">
          <h5 class="modal-title" id="exportModalLabel">Export Data Filter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="exportForm" action="{{ route('partname.export') }}" method="GET">
            <div class="form-group">
              <select id="filterLine" name="line" class="form-control">
                <option value="A1,A2,B1,B2,C1,C2">All</option>
                <option value="A1">Line A1</option>
                <option value="A2">Line A2</option>
                <option value="B1">Line B1</option>
                <option value="B2">Line B2</option>
                <option value="B3">Line B3</option>
                <option value="C1">Line C1</option>
                <option value="C2">Line C2</option>
                <option value="TRANSFERS">TRANSFERS</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="exportForm" class="btn btn-primary">Export</button>
        </div>
      </div>
    </div>
  </div>
  

<div class="modal fade" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="title1">Tambah Product</h4>
          <h4 class="modal-title" id="title2">Edit Product</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                <label class="col-sm-3 col-form-label">Part Name:</label>
                <div class="col-sm-9">
                    <input type="hidden" id="id" class="form-control" required>
                    <input type="text" id="part_name" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">Part NO:</label>
                <div class="col-sm-9">
                    <input type="text" id="part_no" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">Job No:</label>
                <div class="col-sm-9">
                    <input type="text" id="job_no" class="form-control form-control-sm" required>
                </div>

                <label class="col-sm-3 col-form-label">Model :</label>
                <div class="col-sm-9">
                    <input type="text" id="model" class="form-control form-control-sm" required>
                </div>
                
                <label class="col-sm-3 col-form-label">Home Line:</label>
                <div class="col-sm-9">
                    <input type="text" id="home_line" class="form-control form-control-sm" required>
                </div>

                
                <label class="col-sm-3 col-form-label">Costumer:</label>
                <div class="col-sm-9">
                    <input type="text" id="customer" class="form-control form-control-sm" required>
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

$('#exportModal').on('show.bs.modal', function (event) {
        // You can add additional logic here if needed when the modal is about to be shown
    });

            // Select all buttons with the 'line-filter-btn' class
                const buttons = document.querySelectorAll('.line-filter-btn');

                    buttons.forEach(button => {
                    // Add click event listener to each button
                    button.addEventListener('click', function() {
                        // Remove the 'active' class from all buttons
                        buttons.forEach(btn => btn.classList.remove('active'));
                        
                        // Add 'active' class to the clicked button
                        this.classList.add('active');
                    });
                });
        
                 // Menyimpan referensi ke elemen
                const fileInput = document.getElementById('fileInput');
                    const importButton = document.getElementById('importButton');
                    // Menonaktifkan tombol jika tidak ada file yang dipilih
                     fileInput.addEventListener('change', function() {
                        if (fileInput.files.length > 0) {
                            importButton.disabled = false; // Aktifkan tombol jika ada file yang dipilih
                        } else {
                            importButton.disabled = true; // Nonaktifkan tombol jika tidak ada file
                        }
                });
        
                document.getElementById('importForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Mencegah pengiriman formulir default
                    
                    // Tampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengimpor DN?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, impor!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // Kirim formulir jika pengguna mengonfirmasi
                        }
                    });
                });


                function importData() {
                    let formData = new FormData();
                    formData.append('file', document.getElementById('fileInput').files[0]);

                    $.ajax({
                        url: "{{ route('partname.importDp') }}", // Replace with your route name
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                        console.log(response); // Add this line
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },

                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengimpor data.'
                            });
                        }
                    });
                }

             // Menambahkan event listener untuk konfirmasi sebelum mengirim formulir
           
             $(document).ready(function() {
                list(); // Inisialisasi DataTable tanpa filter

                // Event listener untuk tombol filter berdasarkan line
                $('.line-filter-btn').on('click', function() {
                    var homeLine = $(this).data('line-id'); // Ambil nilai home_line dari data-line-id
                    list(homeLine); // Panggil fungsi list dengan filter home_line
                });
            });

            // Fungsi untuk memuat ulang DataTable dengan filter home_line
            function list(homeLine = '') {
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
                        url: "{{ route('partname.list') }}",
                        data: {
                            home_line: homeLine.split(',') // Ubah string home_line menjadi array jika ada koma
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
                            data: 'no_rak',
                            name: 'no_rak'
                        },
                        {
                            data: 'customer',
                            name: 'customer'
                        },
                        {
                            data: 'suplier',
                            name: 'suplier'
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
                            data: 'part_name',
                            name: 'part_name'
                        },
                        {
                            data: 'variant',
                            name: 'variant'
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
                            data: 'spec_t',
                            name: 'spec_t'
                        },
                        {
                            data: 'spec_p',
                            name: 'spec_p'
                        },
                        {
                            data: 'spec_l',
                            name: 'spec_l'
                        },
                        {
                            data: 'spec_bq',
                            name: 'spec_bq'
                        },
                        {
                            data: 'spec_kg',
                            name: 'spec_kg'
                        },
                        {
                            data: 'pcs',
                            name: 'pcs'
                        },
                        {
                            data: 'qty_palet',
                            name: 'qty_palet'
                        },
                        {
                            data: 'qty_min',
                            name: 'qty_min'
                        },
                        {
                            data: 'lead_time',
                            name: 'lead_time'
                        },
                        {
                            data: 'home_line',
                            name: 'home_line'
                        },
                        {
                            data: 'createdby',
                            name: 'createdby'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
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



        $(document).on("click", "#btn_edit", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('partname.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#part_name').val(result.part_name);
                        $('#part_no').val(result.part_no);
                        $('#job_no').val(result.job_no);
                        $('#model').val(result.model);
                        $('#variant').val(result.variant);
                        $('#name_material').val(result.name_material);
                        $('#spec_t').val(result.spec_t);
                        $('#spec_p').val(result.spec_p);
                        $('#spec_l').val(result.spec_l);
                        $('#spec_bq').val(result.spec_bq);
                        $('#spec_kg').val(result.spec_kg);
                        $('#pcs').val(result.pcs);
                        $('#qty_palet').val(result.qty_palet);
                        $('#qty_min').val(result.qty_min);
                        $('#lead_time').val(result.lead_time);
                        $('#home_line').val(result.home_line).trigger('change');
                        $('#customer').val(result.customer).trigger('change');
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
            $("#part_name").val('');
            $("#part_no").val('');
            $("#job_no").val('');
            $('#model').val('').trigger('change');
            $("#variant").val('');
            $("#name_material").val('');
            $("#spec_t").val('');
            $('#spec_p').val('').trigger('change');
            $('#spec_l').val('').trigger('change');
            $('#spec_bq').val('').trigger('change');
            $("#pcs").val('');
            $("#qty_palet").val('');
            $("#qty_min").val('');
            $("#lead_time").val('');
            $('#home_line').val('').trigger('change');
            $('#customer').val('').trigger('change');

            
        }

        $(document).on("click", ".Update", function () {
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('partname.update')}}",
                    data: {
                            id: id.value,
                            part_name: part_name.value,
                            part_no: part_no.value,
                            job_no: job_no.value,
                            model: model.value,
                            variant: variant.value,
                            name_material: name_material.value,
                            spec_t: spec_t.value,
                            spec_p: spec_p.value,
                            spec_l: spec_l.value,
                            spec_bq: spec_bq.value,
                            spec_kg: spec_kg.value,
                            pcs: pcs.value,
                            qty_palet: qty_palet.value,
                            qty_min: qty_min.value,
                            lead_time: lead_time.value,
                            home_line: home_line.value,
                            customer: customer.value,
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
            if(customer.value != ''){
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
                    url: "{{route('partname.destroy')}}",
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
