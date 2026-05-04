@extends('layouts.app')

@section('content')
<style>

table.table {
    border-collapse: collapse; /* menyatukan border jadi grid */
    width: 100%;
    background-color: #fff;
    font-size: 13px; /* kecil tapi tetap terbaca */
    line-height: 1.4;
    border: 1px solid #ccc; /* border luar tabel */
}

/* Header */
table.table thead {
    background-color: #f1f3f4; /* abu muda header */
}

table.table thead th {
    border: 1px solid #ccc; /* garis grid */
    padding: 6px 8px; /* kecilkan padding */
    text-align: center;
    font-weight: 600;
    color: #295b8c;
    white-space: nowrap;
}

/* Body */
table.table tbody td {
    border: 1px solid #ccc; /* garis grid */
    padding: 5px 8px; /* kecilkan padding */
    vertical-align: middle;
    color: #333;
}

/* Hover effect */
table.table tbody tr:hover {
    background-color: #e6f0ff; /* highlight ringan */
}

/* Responsive text kecil */
@media (max-width: 768px) {
    table.table {
        font-size: 12px;
    }
}

    /* ===== Buttons ===== */
    .btn {
        border-radius: 6px;
        font-size: 13px;
        padding: 5px 10px;
    }

    /* ===== Form Controls ===== */
    .form-control {
        font-size: 13px;
        height: 34px;
    }

    input[type="file"] {
        padding: 3px;
        font-size: 13px;
    }

    #example1 th {
        font-weight: 600;
        color: #295b8c;
        border-bottom: 2px solid #dee2e6;
    }

    #example1 td {
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    #example1 tbody tr:hover {
        background-color: #82a8cf;
        cursor: pointer;
    }

    .card {
        border-radius: 8px;
        overflow: hidden;
    }

    .btn-sm {
        border-radius: 6px;
    }

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
        <h1 class="m-0">Tabel STOK PART PC-STORE</h1>
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
                  <h3 class="card-title">Tabel Stok Master Part PC Store</h3>
                  <div class="card-tools">
                    {{-- <button class="btn btn-info btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button> --}}
                    <form id="importForm" action="{{ route('pcstoredirect.importData') }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                    @csrf
                    <input type="file" id="fileInput" name="file" class="form-control me-2"
                        style="width: auto;" required>
                    <button id="importButton" class="btn btn-outline-secondary" type="submit"
                        disabled>Import</button>
                        <a href="{{route("pcstoreexport.export")}}" class="btn btn-success btn-sm"><i style="font-size: 20px" class="ph-fill ph-microsoft-excel-logo"></i> Export Excel</a>
                </div>
                </form>

                </div>
                <div class="card-body p-0">
                    <table id="example1" class="table table-hover table-striped align-middle mb-0">
                        <thead style="background-color: #f1f3f5;">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th class="text-center">Part Name</th>
                                <th class="text-center">Part No</th>
                                {{-- <th class="text-center">Part No CS</th> --}}
                                <th class="text-center">Job No</th>
                                <th class="text-center">Model</th>
                                <th width="30" class="text-center">Qty Kanban</th>

                                <th width="80" class="text-center">Costumer</th>
                                <th width="120" class="text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan di-load di sini -->
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
      <div class="modal-content" style="background-color:#ffffff;">
        <div class="modal-header" style="background-color: #2c4358; color: #fff;">
          <h4 class="modal-title" id="title1">Add Material NUT</h4>
          <h4 class="modal-title" id="title2">Edit PART NO</h4>
          <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <div id="alert" class="mb-2 w-100"></div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Name Data FG:</label>
            <div class="col-sm-8">
              <input type="hidden" id="id">
              <input type="text" id="part_no" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Job No:</label>
            <div class="col-sm-8">
              <input type="text" id="job_no" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Volume Daily:</label>
            <div class="col-sm-8">
              <input type="text" id="daily_volume" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Actual Stock:</label>
            <div class="col-sm-8">
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

  {{-- <input type="hidden" id="home_line" name="home_line">
    <input type="hidden" id="monthly_volume" name="monthly_volume">
    <input type="hidden" id="part_no2" name="part_no2">
    <input type="hidden" id="qty_kanban" name="qty_kanban">
    <input type="hidden" id="part_name" name="part_name">
    <input type="hidden" id="strenght" name="strenght">
    <input type="hidden" id="pallet" name="pallet"> --}}
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

        //         $(document).ready(function() {
        //     $('#part_no').change(function() {
        //         var selectedOption = $(this).find('option:selected');
        //         var jobNo = selectedOption.data('job_no');
        //         var model = selectedOption.data('model_id');
        //         var lineid = selectedOption.data('home_line');

        //         // // Set value of job_no
        //         // $('#job_no').val(jobNo).trigger('change');

        //         // Set value of model_id
        //         $('#model_id').val(model).trigger('change');

        //         // // Set value of model_id
        //         // $('#home_line').val(lineid).trigger('change');
        //     });
        // });

        function list(){
            var table = $('#example1').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true,
                    pageLength: 20,
                    ajax: {
                        url: "{{ route('pcstoredirect.list') }}"
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
                            data: 'part_name',
                            name: 'part_name'
                        },
                        {
                            data: 'part_no',
                            name: 'part_no'
                        },
                        // {
                        //     data: 'part_no2',
                        //     name: 'part_no2'
                        // },
                        {
                            data: 'job_no',
                            name: 'job_no'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'qty_kanban',
                            name: 'qty_kanban'
                        },
                        {
                            data: 'customer',
                            name: 'customer'
                        },
                        // {
                        //     data: 'strenght',
                        //     name: 'strenght'
                        // },
                        // {
                        //     data: 'actual',
                        //     name: 'actual'
                        // },
                        // {
                        //     data: 'pallet',
                        //     name: 'pallet'
                        // },
                        // {
                        //     data: 'home_line',
                        //     name: 'home_line'
                        // },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">Edit'+
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
                url: "{{route('pcstoredirect.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#home_line').val(result.home_line).trigger('change');
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#part_no2').val(result.part_no2).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#monthly_volume').val(result.monthly_volume).trigger('change');
                        $('#daily_volume').val(result.daily_volume).trigger('change');
                        $('#qty_kanban').val(result.qty_kanban).trigger('change');
                        $('#actual').val(result.actual).trigger('change');
                        $('#strenght').val(result.strenght).trigger('change');
                        $('#pallet').val(result.pallet).trigger('change');
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
            $("#home_line").val('').trigger('change');
            $("#part_no").val('').trigger('change');
            $("#job_no").val('').trigger('change');
            $('#model_id').val('').trigger('change');
            $('#daily_volume').val('').trigger('change');
            $('#minimal').val('').trigger('change');
            $('#actual').val('').trigger('change');
        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('pcstoredirect.store')}}",
                    data: {
                            home_line: home_line.value,
                            part_name: part_name.value,
                            part_no: part_no.value,
                            part_no2: part_no2.value,
                            job_no: job_no.value,
                            monthly_volume: monthly_volume.value,
                            daily_volume: daily_volume.value,
                            qty_kanban: qty_kanban.value,
                            strenght: strenght.value,
                            actual: actual.value,
                            pallet: pallet.value,
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
                    url: "{{route('pcstoredirect.update')}}",
                    data: {
                            id: id.value,
                            home_line: home_line.value,
                            part_name: part_name.value,
                            part_no: part_no.value,
                            part_no2: part_no2.value,
                            job_no: job_no.value,
                            monthly_volume: monthly_volume.value,
                            daily_volume: daily_volume.value,
                            qty_kanban: qty_kanban.value,
                            strenght: strenght.value,
                            actual: actual.value,
                            pallet: pallet.value,
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
            if( part_no.value != '' && job_no.value != '' && actual.value !=''){
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
                    url: "{{route('pcstoredirect.destroy')}}",
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
        text: 'Apakah Anda yakin ingin mengimpor data?',
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
        url: "{{ route('pcstoredirect.importPcs') }}", // Replace with your route name
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
    console.log(response);
    if (response.success) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
        });
    } else {
        // Tampilkan daftar error jika ada
        let errorList = '';
        if (response.failures && response.failures.length > 0) {
            response.failures.forEach(function(failure) {
                errorList += `Baris ${failure.row}: ${failure.errors.join(', ')}\n`;
            });
        }

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Gagal import data',
            text: errorList || response.message,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });
    }
},
        error: function(error) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: 'Import Gagal',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
            });
        }
    });
}
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
