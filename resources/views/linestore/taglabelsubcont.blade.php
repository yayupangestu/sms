@extends('layouts.app')

@section('content')
    <style>
        /* ===== Container & Section ===== */
        section.content {
            background-color: #f5f6f7;
            /* abu-abu muda netral */
            padding: 15px;
        }

        .container-fluid {
            background-color: transparent;
        }

        /* ===== Card ===== */
        .card {
            border-radius: 8px;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* ===== Card Header ===== */
        .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 15px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: #5c6bc0;
            /* Biru SAP-style */
            margin-right: 8px;
        }

        /* ===== Table ===== */
        /* ===== Full Table Grid Style (SAP-like) ===== */
        table.table {
            border-collapse: collapse;
            /* menyatukan border jadi grid */
            width: 100%;
            background-color: #fff;
            font-size: 13px;
            /* kecil tapi tetap terbaca */
            line-height: 1.4;
            border: 1px solid #ccc;
            /* border luar tabel */
        }

        /* Header tabel */
        #example1 thead th {
            font-weight: bold;
            font-size: 16px;
            /* ubah sesuai kebutuhan */
        }

        /* Body tabel */
        #example1 tbody td {
            font-weight: bold;
            font-size: 16px;
            /* ubah sesuai kebutuhan */
        }

        table.table thead th {
            border: 1px solid #ccc;
            /* garis grid */
            padding: 6px 8px;
            /* kecilkan padding */
            text-align: center;
            font-weight: 700;
            color: #295b8c;
            white-space: nowrap;
        }

        /* Body */
        table.table tbody td {
            border: 1px solid #ccc;
            /* garis grid */
            padding: 5px 8px;
            /* kecilkan padding */
            vertical-align: middle;
            color: #333;
        }

        /* Hover effect */
        table.table tbody tr:hover {
            background-color: #e6f0ff;
            /* highlight ringan */
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

        .form-control {
            font-size: 18px;
            font-weight: bold;
            color: rgb(0, 0, 0);
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">CRETE LABEL SUBCONT</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid" style="background-color: rgb(0, 0, 0)">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: rgb(0, 11, 68); color:white">
                            <h3 class="card-title">
                                <i class="fas fa-border-none"></i>
                                List
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table id="example1" class="table table-hover table-striped align-middle mb-0">
                                <thead style="background-color: #f1f3f5;">
                                    <tr>
                                        <th width="50" class="text-center">No</th>
                                        <th class="text-center">Part Name</th>
                                        <th class="text-center">Part No</th>
                                        <th class="text-center">Job No</th>
                                        <th class="text-center">Model</th>
                                        <th class="text-center">Supplier</th>
                                        <th class="text-center">Count</th>
                                        <th width="80" class="text-center">Action</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div c class="modal-header" style="background-color: rgb(0, 11, 68); color:white">
                    <h4 class="modal-title" id="title1">Create Your Kanban</h4>
                    <h4 class="modal-title" id="title2">Edit Your Kanban</h4>
                    <div class="col-sm-6 text-right">
                        {{-- <button class="btn btn-primary btn-sm" id="btn_submit">Save</button> --}}
                        {{-- <button class="btn btn-default btn-sm" id="btn_cancel">Cancel</button> --}}
                        <button type="button" class="close; btn btn-secondary" data-dismiss="modal"
                            aria-label="Close">Close</button>
                    </div>
                </div>
                <div class="modal-body bg-light">
                    <div class="col-12" id="alert"></div>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Part Name</label>
                            <input type="text" class="form-control border-primary" id="part_name" readonly>
                        </div>
                        <div class="col-md-1.5">
                            <label class="form-label fw-bold">Part No</label>
                            <input type="text" class="form-control border-primary" id="part_no" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Job No</label>
                            <input type="text" class="form-control border-primary" id="job_no" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Model</label>
                            <input type="text" class="form-control border-primary" id="model" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="Line" class="form-label fw-bold">line</label>
                            <select id="line" class="form-control border-primary" required>
                                <option value="" selected>- pilih -</option>
                                <option value="ASI">ASI</option>
                            </select>
                        </div>
                    </div>
                    <form id="insertForm" action="/your-endpoint" method="POST">

                        <label class="col-sm-1 col-form-label">-</label>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Qty</label>
                            <select class="form-control border-success" id="qty_act" required>
                                <!-- option akan diisi secara dinamis via JS -->
                            </select>
                        </div>



                        <hr class="mt-4">


                        <div class="col-sm-7"></div>
                        <div class="col-sm-7">
                            <button type="submit" class="btn btn-success btn-sm Save">Insert</button>
                            {{-- <button type="button" class="btn btn-warning btn-sm Update">Edit</button> --}}
                        </div>

                    </form>
                    <!-- Tabel untuk menampilkan data yang di-insert -->
                    <div class="table-responsive mt-3">
                        <button id="btn_generate_all" class="btn btn-primary">Generate Selected QR Codes</button>

                        <table id="example2" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll"> {{-- checkbox untuk select semua --}}
                                    </th>
                                    <th width="50px" class="text-center">No</th>
                                    <th width="100px" class="text-center">Part Name</th>
                                    <th width="100px" class="text-center">Part No</th>
                                    <th width="50px" class="text-center">Job No</th>
                                    <th width="50px" class="text-center">Model</th>
                                    <th width="50px" class="text-center">Actual</th>
                                    <th width="120px" class="text-center">Update Time</th>
                                    <th class="text-center" style="width: 100px">Status</th>
                                    <th class="text-center" style="width: 100px">Action</th>
                                    {{-- <th class="text-center">UniqNo</th>
                                    <th class="text-center">Status</th> --}}
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Data akan dimasukkan secara dinamis di sini -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="uniqNo" name="uniqNo">
    <input type="hidden" id="part_no2" name="part_no2">
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

        document.getElementById('insertForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            console.log('Form submitted');

            // Ambil data form menggunakan FormData
            let formData = new FormData(this);

            // Gantilah '/your-endpoint' dengan URL tujuan yang sesuai
            fetch('/your-endpoint', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Lakukan sesuatu dengan responnya
                })
                .catch(error => console.error('Error:', error));
        });


        $(document).on('click', '#selectAll', function() {
            const isChecked = this.checked;

            $('.dataCheckbox').each(function() {
                const sts = $(this).data('sts');
                if (sts != 1) {
                    $(this).prop('checked', isChecked);
                } else {
                    $(this).prop('checked', false); // jangan check jika sudah scan
                }
            });
        });




        $(document).on('click', '#btn_generate_all', function(e) {
            e.preventDefault();

            const selectedIds = [];
            $('.dataCheckbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Pilih setidaknya satu data untuk generate QR Code!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            // ✅ Tampilkan loading saat proses
            Swal.fire({
                title: 'Generating QR Codes...',
                html: `<img src="{{ asset('dist/img/Hourglass.gif') }}" width="50"><br>Silakan tunggu...`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('taglabelsubcont.generateMultipleQrCodes') }}",
                method: 'POST',
                xhrFields: {
                    responseType: 'blob' // penting agar file binary (PDF) bisa diproses
                },
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.close(); // ❌ Tutup loading

                    const blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'LabelSubcont' + new Date().toISOString().slice(0, 10) + '.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr) {
                    Swal.close();

                    let errorMsg = 'Terjadi kesalahan saat memproses data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        showConfirmButton: true
                    });
                }
            });
        });



        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 15,
                ajax: {
                    url: "{{ route('taglabelsubcont.list') }}"
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
                        name: 'part_name',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },
                    {
                        data: 'part_no',
                        name: 'part_no',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            });
                        }
                    },
                    {
                        data: 'job_no',
                        name: 'job_no',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            });
                        }
                    },
                    {
                        data: 'model',
                        name: 'model',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            });
                        }
                    },
                    {
                        data: 'supplier',
                        name: 'supplier',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            });
                        }
                    },

                    {
                        data: 'part_count',
                        name: 'part_count',
                        className: 'text-center',
                        render: function(data) {
                            return `<span class="badge bg-info" style="font-size: 1rem; padding: 6px 12px;">${data}</span>`;
                        }
                    },


                    {
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                            <a href="#" class="btn_edit btn btn-warning btn-sm"
                            data-id="${data}"
                            data-jobNo="${row.job_no}"
                            title="Edit">
                            <i class="fas fa-search"></i> Edit
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
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });
        }

        $(document).on("click", ".btn_edit", function() {
            // Tampilkan tombol Save & Update, sembunyikan title1, tampilkan title2
            $(".Save").show();
            $(".Update").show();
            $("#title1").hide();
            $("#title2").show();

            // Ambil data dari atribut tombol
            var id = $(this).data('id');
            var jobNo = $(this).data('jobno');

            console.log('jobNo diklik:', jobNo); // Debugging

            // Panggil AJAX untuk mengambil data berdasarkan job_no
            $.ajax({
                type: 'GET',
                url: "{{ route('taglabelsubcont.getdatabypart') }}",
                data: {
                    job_no: jobNo
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });

                        $('#id').val(result.id);
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#part_no2').val(result.part_no2).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#model').val(result.model).trigger('change');
                        $('#qty_kanban').val(result.qty_kanban).trigger('change');
                        $('#uniqNo').val(result.uniqNo).trigger('change');
                        $('#keterangan').val(result.keterangan).trigger('change');

                        // --- isi dropdown Qty langsung dengan nilai qty_kanban ---
                        var qtySelect = $('#qty_act');
                        qtySelect.empty(); // kosongkan dulu
                        qtySelect.append('<option value="' + result.qty_kanban + '">' + result
                            .qty_kanban + '</option>');

                        listdetail(result.job_no);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(err) {
                    console.error('AJAX error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengambil data!',
                        showConfirmButton: true
                    });
                }
            });
        });


        function listdetail(job_no) {
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('taglabelsubcont.listdetail') }}",
                    type: "GET",
                    data: {
                        job_no: job_no
                    }
                },
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="dataCheckbox" value="${data}" data-sts="${row.sts}">`;
                        }
                    },

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'part_name',
                        name: 'part_name',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },
                    {
                        data: 'part_no',
                        name: 'part_no',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },
                    {
                        data: 'job_no',
                        name: 'job_no',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },
                    {
                        data: 'model',
                        name: 'model',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },
                    {
                        data: 'qty_act',
                        name: 'qty_act',
                        render: function(data) {
                            return `<span style="background-color: lightgreen; color: black; padding: 10px 8px; border-radius: 4px; display: inline-block; font-size: 20px">${data}</span>`;
                        }
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '20px' // ubah sesuai kebutuhan
                            });
                        }
                    },

                    {
                        data: 'sts',
                        name: 'sts',
                        render: function(data) {
                            return data == 1 ?
                                `<span style="font-size: 20px" class="badge bg-success">Sudah Scan</span>` :
                                `<span style="font-size: 20px" class="badge bg-warning text-dark">Belum Scan</span>`;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            const disabled = row.sts == 1 ? 'disabled' : '';
                            return `
                        <a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ${disabled}">
                            <i class="far fa-trash-alt"></i>
                        </a>`;
                        }
                    }
                ],
                columnDefs: [{
                    targets: [0],
                    orderable: false
                }],
                oLanguage: {
                    sProcessing: '<img src="/dist/img/Hourglass.gif"> Loading . . .'
                }
            });
        }




        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();

            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('taglabelsubcont.store') }}",
                    data: {
                        part_name: part_name.value,
                        part_no: part_no.value,
                        part_no2: part_no2.value,
                        job_no: job_no.value,
                        model: model.value,
                        qty_act: qty_act.value,
                        line: line.value,
                        uniqNo: uniqNo.value,
                        line: line.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            // Tambahkan SweetAlert success
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: result.msg,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Refresh listdetail dengan part_no yang baru saja diinput
                            listdetail(job_no.value);

                            // Bersihkan form dan alert
                            list();
                            clear();
                            $("#alert").hide();
                        } else {
                            // SweetAlert untuk error
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: result.msg,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $("#alert").html(
                                '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                                result.msg + '</div>'
                            );
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        }
                    }
                });
            }
        });

        function clear() {
            $("#id").val('');

            $("#qty_act").val('');
            // $("#qty_ng").val('');
            // $('#material_id').val('').trigger('change');
        }


        function validasi() {
            if (qty_act.value !== '' && line.value !== '') {
                return true;
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Tolong isi Kolomnya',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                return false;
            }
        }


        $(document).on("click", "#btn_delete_line", function() {
            var id = $(this).data('id');
            var job_no = $('#job_no').val(); // Ambil nilai part_no yang sedang aktif

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
                        url: "{{ route('taglabelsubcont.destroyline') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }

                            // ✅ Pastikan part_no dikirim ke fungsi listdetail
                            listdetail(job_no);
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
