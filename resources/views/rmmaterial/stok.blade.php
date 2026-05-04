@extends('layouts.app')

@section('content')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
    }

    .table th, .table td {
        /* vertical-align: middle; */
        padding: 10px;
    }

    .table thead th {
        background-color: #245a7e;
        color: #ffffff;
        font-weight: bold;
        text-align: center;
    }

    .table tbody tr {
        transition: background-color 0.3s;
    }

    .table tbody tr:hover {
        background-color: #0000002a;
    }

    .table tbody td {
        text-align: center;
        border-color: #e3dfdf;
    }

    .btn-info {
        background-color: #245a7e;
        border-color: #245a7e;
    }

    .btn-info:hover {
        background-color: #9fafbb;
        border-color: #245a7e;
    }
    .swal2-toast-error-custom {
    background-color: #f44336 !important; /* merah terang */
    color: white !important;
    border: 1px solid #d32f2f !important;
}

</style>


<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Stok Material </h1>
      </div>
      <div class="col-sm-6">

      </div>
    </div>
  </div>
</div>
<section class="content" style="background-color: #245a7e">
    {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
      <div class="row">
          <div class="col-12">
              <div class="card">
                <div class="modal-header" style="background-color: #245a7e; color:#ffffff">
                    <h3 class="card-title">List Data Material</h3>
                    <div class="card-tools">
                      <button class="btn btn-info btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                      <form id="importForm" action="{{ route('importStok') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                        @csrf
                        <input type="file" id="fileInput" name="file" class="form-control me-2" style="width: auto;" required>
                        <button id="importButton" class="btn btn-success" type="submit" disabled>Import Data Stok</button>
                    </form>
                    </div>
                  </div>
                <div class="card-body">
                    <table id="example1"  class="table table-bordered table-striped;centered-text">
                        <thead class="table" style="background-color: #122d3f; color:#ffffff">
                        <tr>
                            <th width="50">No</th>
                            <th>Part Name</th>
                            <th>Part No (G5)</th>
                            <th>Part No</th>
                            <th>Job NO</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Material</th>
                            <th>T</th>
                            <th>W</th>
                            <th>L</th>
                            <th>BQ</th>
                            <th>Supplier</th>
                            <th class="minimal" width="100">MinimalStok</th>
                            <th class="actual" width="100">Actual Sheet</th>
                            <th class="actual_kg" width="100">Actual Kg</th>
                            <th>NO RAK</th>
                            <th>Status</th>
                            <th width="150">Action</th>
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
                    <label class="col-sm-3 col-form-label">part Name</label>
                    <div class="col-sm-9">
                        <input type="hidden" id="id" class="form-control" required>
                        <input type="text" id="part_name" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Part No:</label>
                    <div class="col-sm-9">
                        <input type="text" id="part_no" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Job No:</label>
                    <div class="col-sm-4">
                        <input type="text" id="job_no" class="form-control form-control-sm" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Model:</label>
                    <div class="col-sm-3">
                        <input type="text" id="model_id" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Spek:</label>
                    <div class="col-sm-4">
                        <input type="numeric" id="spek" class="form-control form-control-sm" required>
                    </div>
                    <label class="col-sm-2 col-form-label">Minimal:</label>
                    <div class="col-sm-2">
                        <input type="text" id="minimal" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">Actual Kg:</label>
                    <div class="col-sm-3">
                        <input type="text" id="actual_kg" class="form-control form-control-sm" required>
                    </div>
                    <label class="col-sm-3 col-form-label">Actual Sheet:</label>
                    <div class="col-sm-3">
                        <input type="text" id="actual_sheet" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-3 col-form-label">No Rak:</label>
                    <div class="col-sm-4">
                        <input type="text" id="no_rak" class="form-control form-control-sm" required>
                    </div>

                    <label class="col-sm-2 col-form-label">BQ</label>
                    <div class="col-sm-2">
                        <input type="text" id="spek_bq" class="form-control form-control-sm" required>
                    </div>
                    
                    <label class="col-sm-3 col-form-label">Status:</label>
                    <div class="col-sm-4">
                        <select style="width: 100%;" id="keterangan" class="form-control select2" required>
                            <option value="" selected>- pilih -</option>
                            <option value="1">Aktif</option>
                            <option value="2">Randout</option>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).ready(function() {
            list();
        });

        $(document).ready(function() {
            $('#material_id').change(function() {
                var selectedOption = $(this).find('option:selected');
                var partName = selectedOption.data('spek');
                var modelId = selectedOption.data('model');


                // Set value of job_no
                $('#part_name').val(partName).trigger('change');

                // Set value of model_id
                $('#model_id').val(modelId).trigger('change');
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
                    pageLength: 20,
                    ajax: {
                        url: "{{ route('rmstok.list') }}"
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
                        {
                            data: 'part_no2',
                            name: 'part_no2'
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
                            data: 'category_id',
                            name: 'category_id'
                        },
                        {
                            data: 'spek',
                            name: 'spek'
                        },
                        {
                            data: 'spek_t',
                            name: 'spek_t'
                        },
                        {
                            data: 'spek_w',
                            name: 'spek_w'
                        },
                        {
                            data: 'spek_l',
                            name: 'spek_l'
                        },
                        {
                            data: 'spek_bq',
                            name: 'spek_bq'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
                        },

                        {
                            data: 'minimal',
                            name: 'minimal'
                        },
                        {
                            data: 'actual_sheet',
                            name: 'actual_sheet'
                        },
                        {
                            data: 'actual_kg',
                            name: 'actual_kg'
                        },
                        {
                            data: 'no_rak',
                            name: 'no_rak'
                        },
                        {
                        data: 'keterangan',
                        name: 'keterangan',
                        render: function(data) {
                            if (data == 2) {
                                return '<span class="badge badge-danger">Rundout</span>';
                            } else {
                                return '<span class="badge badge-success">Aktif</span>';
                            }
                        }
                        },
                        {
                                data: 'id',
                                name: 'id',
                                render: function(data) {
                                    return `
                                        <a href="#" id="btn_edit" title="Edit" data-id="${data}" class="btn btn-warning btn-sm">
                                           Edit
                                        </a>
                                        <a href="#" id="btn_delete" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ml-1">
                                           Delete
                                        </a>
                                        <a href="#" id="btn_detail" title="Detail" data-id="${data}" class="btn btn-info btn-sm ml-1">
                                            Info
                                        </a>
                                    `;
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

        $(document).ready(function() {
        list();

    // Handle detail button click
        $(document).on("click", "#btn_detail", function() {
            var materialId = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('rmstok.detail') }}",
                data: { id: materialId },
                success: function(result) {
                    if (result.success) {
                        // Populate the modal with details
                        let detailsHtml = '<table id="detailTable" class="table table-bordered">';
                        detailsHtml += `
                            <thead>
                                <tr>
                                    <th class="text-center">No Pallet</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Qty IN</th>
                                    <th class="text-center">Recipient</th>
                                    <th class="text-center">Time Material</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Recived</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">QTY Return</th>

                                </tr>
                            </thead>
                            <tbody>
                        `;

                        // Looping tanpa style khusus
                        result.data.forEach(material => {
                            detailsHtml += `
                                <tr>
                                    <td class="text-center">${material.no}</td>
                                    <td class="text-center">${material.suplai_id}</td>
                                    <td class="text-center">${material.material_id}</td>
                                    <td class="text-center">${material.category_id}</td>
                                    <td class="text-center">${material.qty_in}</td>
                                    <td class="text-center">${material.createdby}</td>
                                    <td class="text-center">${material.created_at}</td>
                                    <td class="text-center">${material.sts_2}</td>
                                    <td class="text-center">${material.user_out}</td>
                                    <td class="text-center">${material.status}</td>
                                    <td class="text-center">${material.qty_return}</td>
                                </tr>
                            `;
                        });

                        detailsHtml += '</tbody></table>';
                        $('#detailContent').html(detailsHtml);
                        // Initialize DataTables in the modal
                        $('#detailTable').DataTable({
                            searching: true, // Enable searching feature
                            responsive: true // Make the table responsive
                        });
                        // Show the modal
                        $('#detailModal').modal('show');
                    }
                }
                });
            });
        });

        $(document).on("click", "#btn_edit", function () {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{route('rmstok.edit')}}",
                data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                success: function(result) {
                    if(result.success){
                        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                        $('#id').val(result.id);
                        $('#material_id').val(result.material_id).trigger('change');
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#spek').val(result.spek).trigger('change');
                        $('#minimal').val(result.minimal).trigger('change');
                        $('#actual_sheet').val(result.actual_sheet);
                        $('#actual_kg').val(result.actual_kg);
                        $('#no_rak').val(result.no_rak);
                        $('#spek_bq').val(result.spek_bq);
                        $('#keterangan').val(result.keterangan).trigger('change');
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
            $("#material_id").val('');
            $("#part_name").val('');
            $("#model_id").val('');
            $("#category_id").val('');
            $('#minimal').val('').trigger('change');
            $('#actual').val('').trigger('change');
            // $('#qty_out').val('').trigger('change');

        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('rmstok.store')}}",
                    data: {

                        part_name: part_name.value,
                        part_no: part_no,
                        job_no: job_no,
                        spek: spek,
                        model_id: model_id.value,
                        minimal: minimal.value,
                        actual_sheet: actual_sheet.value,
                        actual_kg: actual_kg.value,
                        no_rak: no_rak.value,
                        spek_bq: spek_bq.value,
                        keterangan: keterangan.value,
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
                    url: "{{route('rmstok.update')}}",
                    data: {
                            id: id.value,

                            part_name: part_name.value,
                            part_no: part_no.value,
                            job_no: job_no.value,
                            spek: spek.value,
                            model_id: model_id.value,
                            minimal: minimal.value,
                            actual_sheet: actual_sheet.value,
                            actual_kg: actual_kg.value,
                            no_rak: no_rak.value,
                            spek_bq: spek_bq.value,
                            keterangan: keterangan.value,
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
            if(part_name.value != '' && part_no.value != '' && job_no.value != '' && actual_sheet.value != ''){
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
                    url: "{{route('rmstok.destroy')}}",
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

       // Aktifkan tombol jika file dipilih
    document.getElementById('fileInput').addEventListener('change', function () {
        document.getElementById('importButton').disabled = !this.files.length;
    });

    // Konfirmasi sebelum submit
    document.getElementById('importForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Cegah pengiriman form langsung

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengimport Data Stok?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, impor!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Submit jika disetujui
            }
        });
    });

     // Tampilkan toast sukses jika ada session 'success'
     @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    @endif

    // Tampilkan toast error jika ada session 'error'
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Upload Gagal',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        customClass: {
            popup: 'swal2-toast-error-custom'
        }
    });
    @endif




    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
