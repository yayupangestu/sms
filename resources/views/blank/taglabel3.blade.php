@extends('layouts.app')

@section('content')

<style>
    /* Tambahkan efek halus */
.table thead th {
    vertical-align: middle;
    font-weight: bold;
    /* background-color: #c3e6fd; */
    /* background-color: rgb(0, 11, 68); color:white; */
    border-bottom: 2px solid #0080ff;
}

.table tbody td {
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background-color: #43719553;
    transition: background-color 0.2s ease;
}

.rounded {
    border-radius: 0.5rem !important;
}

.shadow-sm {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

</style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">LIST PART NO</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid  py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-3">
                        <div class="card-header text-white" style="background-color: #00174d;">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list-alt me-2"></i>
                                <strong>List Data Part</strong>
                            </h5>
                        </div>
                        <div class="card-body bg-light rounded-bottom">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-hover table-sm align-middle mb-0 shadow-sm">
                                    <thead class="table-dark text-center text-white">
                                        <tr>
                                            <th scope="col" style="width: 50px;">No</th>
                                            <th scope="col">Part Name</th>
                                            <th scope="col">Part RH/LH</th>
                                            <th scope="col">Part NO</th>
                                            <th scope="col">Job No</th>
                                            <th scope="col">Model</th>
                                            <th scope="col">Spesifikasi</th>
                                            <th scope="col">T</th>
                                            <th scope="col">W</th>
                                            <th scope="col">L</th>
                                            <th scope="col">KG</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Qty Label</th>
                                            <th scope="col" style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center text-dark">
                                        <!-- Isi data disini -->
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div c class="modal-header" style="background-color: rgb(0, 11, 68); color:white">
                    <h4 class="modal-title" id="title1">Create Your Label</h4>
                    <h4 class="modal-title" id="title2">Edit Your Label</h4>
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
                        <div class="col-md-1.5">
                            <label class="form-label fw-bold">Part No</label>
                            <input type="text" class="form-control border-primary" id="part_no2" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Job No</label>
                            <input type="text" class="form-control border-primary" id="job_no" readonly>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label fw-bold">Model</label>
                            <input type="text" class="form-control border-primary" id="model_id" readonly>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        {{-- <div class="col-md-2">
                            <label class="form-label fw-bold">Part No</label>
                            <input type="text" class="form-control border-primary" id="part_no" readonly>
                        </div> --}}
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Spek Material</label>
                            <input type="text" class="form-control border-primary" id="spek" readonly>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label fw-bold">T</label>
                            <input type="text" class="form-control border-primary" id="spek_t" readonly>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label fw-bold">W</label>
                            <input type="text" class="form-control border-primary" id="spek_w" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailL" class="form-label fw-bold">L</label>
                            <input type="text" class="form-control border-primary" id="spek_l" readonly>
                        </div>
                        <div class="col-md-1">
                            <label  class="form-label fw-bold">KG</label>
                            <input type="text" class="form-control border-primary" id="spek_kg" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="Supplier" class="form-label fw-bold">Mesin</label>
                            <select id="supplier" class="form-control border-primary" required>
                                <option value="" selected>- pilih -</option>
                                <option value="KOMATSU-1">KOMATSU</option>
                                <option value="FUKUI">FUKUI</option>
                                <option value="AMINO">AMINO</option>
                                <option value="ASI-2">ASI-2</option>
                                <option value="TCF">TCF</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Mesin</label>
                            <select id="category" class="form-control border-primary" required>
                                <option value="" selected>- pilih -</option>
                                <option value="1">KOMATSU</option>
                                <option value="2">FUKUI</option>
                                <option value="3">AMINO</option>
                            </select>
                        </div>

                    </div>

                    <form id="insertForm" action="/your-endpoint" method="POST">

                    <label class="col-sm-1 col-form-label">-</label>
                    <div class="col-md-1">
                        <label class="form-label fw-bold">Qty</label>
                        <input type="numeric" class="form-control border-success" id="actual_sheet" required>
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
                                    <th class="text-center">No</th>
                                    {{-- <th width="100px" class="text-center">Part Name</th> --}}
                                    <th  class="text-center">Doc PO</th>
                                    <th width="100px" class="text-center">Part No</th>
                                    <th width="100px" class="text-center">Part No2</th>
                                    {{-- <th class="text-center">Model</th> --}}
                                    <th class="text-center">Actual</th>
                                    <th width class="text-center">Spec</th>
                                    <th class="text-center">KG Actual</th>
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
    <input type="hidden" id="actual_kg" name="actual_kg">
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


        $(document).on('click', '#selectAll', function () {
    const isChecked = this.checked;

    $('.dataCheckbox').each(function () {
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
        url: "{{ route('taglabel3.generateMultipleQrCodes') }}",
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

            const blob = new Blob([response], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'labelOpsional_' + new Date().toISOString().slice(0, 10) + '.pdf';
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
                    url: "{{ route('taglabel3.list') }}"
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
                        name: 'part_no',
                        render: function (data) {
                            return `<span style="background-color:#e4f0e0; color:black; padding:4px; border-radius:4px;">${data}</span>`;
                        }
                    },
                    {
                        data: 'part_no2',
                        name: 'part_no2',
                        render: function (data) {
                            return `<span style="background-color:#c9c9c9; color:black; padding:4px; border-radius:4px;">${data}</span>`;
                        }
                    },
                    {
                        data: 'job_no',
                        name: 'job_no'
                    },
                    {
                        data: 'model_id',
                        name: 'model_id'
                    },
                    // {
                    //     data: 'category_id',
                    //     name: 'category_id'
                    // },
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
                        data: 'spek_kg',
                        name: 'spek_kg'
                    },
                    {
                        data: 'home_line',
                        name: 'home_line',
                        className: 'text-center',
                        render: function(data) {
                            if (data == 2) {
                                return '<span class="badge bg-danger">Rundout</span>';
                            } else {
                                return '<span class="badge bg-success">Aktif</span>';
                            }
                        }
                    },
                    {
                        data: 'part_count',
                        name: 'part_count',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <div style="display: inline-flex; gap: 6px;">
                                    <span class="badge bg-info" style="font-size: 1.0rem; padding: 6px 12px;">${data.count1}</span>
                                
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                            <a href="#" id="btn_edit" title="Edit"
                            data-id="${data}"
                            data-partno2="${row.part_no2}"
                            class="btn btn-warning btn-sm"><i class="fas fa-search"></i>
                                Edit
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

        $(document).on("click", "#btn_edit", function() {
            $(".Save").show();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();

            var id = $(this).data('id');
            var partNo2 = $(this).data('partno2');

            $.ajax({
                type: 'GET',
                url: "{{ route('taglabel3.getdatabypart') }}",
                data: {
                    part_no2: partNo2
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });

                        $('#id').val(result.id);
                        // $('#material_id').val(result.material_id).trigger('change');
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#part_no2').val(result.part_no2).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#spek').val(result.spek).trigger('change');
                        $('#spek_t').val(result.spek_t).trigger('change');
                        $('#spek_w').val(result.spek_w).trigger('change');
                        $('#spek_l').val(result.spek_l).trigger('change');
                        $('#spek_kg').val(result.spek_kg).trigger('change');
                        $('#uniqNo').val(result.uniqNo).trigger('change');
                        $('#home_line').val(result.home_line).trigger('change');

                        listdetail(result.part_no2);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });





        function listdetail(part_no2) {
    $('#example2').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        searching: true,
        bLengthChange: true,
        destroy: true,
        pageLength: 100,
        ajax: {
            url: "{{ route('taglabel3.listdetail') }}",
            type: "GET",
            data: {
                part_no2: part_no2
            }
        },
        order: [[8, 'desc']],
        columns: [
            {
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
            { data: 'doc_po', name: 'doc_po' },
            { data: 'part_no', name: 'part_no' },
            { data: 'part_no2', name: 'part_no2' },
            {
                data: 'actual_sheet',
                name: 'actual_sheet',
                render: function(data) {
                    return `<span style="background-color: lightgreen; color: black; padding: 4px 8px; border-radius: 4px; display: inline-block;">${data}</span>`;
                }
            },
            { data: 'spek', name: 'spek' },
            { data: 'actual_kg', name: 'actual_kg' },
            { data: 'tanggal', name: 'tanggal' },
            {
                data: 'sts',
                name: 'sts',
                render: function(data) {
                    return data == 1
                        ? `<span class="badge bg-success">Sudah Scan</span>`
                        : `<span class="badge bg-warning text-dark">Belum Scan</span>`;
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
        columnDefs: [
            { targets: [0], orderable: false }
        ],
        oLanguage: {
            sProcessing: '<img src="/dist/img/Hourglass.gif"> Loading . . .'
        }
    });
} 




        $(document).on("click", ".Save", function () {
    $("#alert").html('');
    $("#alert").show();

    if (validasi()) {
        $.ajax({
            type: 'POST',
            url: "{{ route('taglabel3.store') }}",
            data: {
                part_name: part_name.value,
                part_no: part_no.value,
                part_no2: part_no2.value,
                job_no: job_no.value,
                model_id: model_id.value,
                spek: spek.value,
                spek_t: spek_t.value,
                spek_w: spek_w.value,
                spek_l: spek_l.value,
                spek_kg: spek_kg.value,
                actual_sheet: actual_sheet.value,
                uniqNo: uniqNo.value,
                supplier: supplier.value,
                actual_kg: actual_kg.value,
                category: category.value,
                _token: '{{ csrf_token() }}'
            },
            success: function (result) {
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
                    listdetail(part_no2.value);

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

            $("#actual_sheet").val('');
            // $("#qty_ng").val('');
            // $('#material_id').val('').trigger('change');
        }




        function validasi() {
    if (actual_sheet.value !== '' && category.value !== '' && supplier.value !== '') {
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


        $(document).on("click", "#btn_delete_line", function () {
    var id = $(this).data('id');
    var part_no2 = $('#part_no2').val(); // Ambil nilai part_no yang sedang aktif

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
                url: "{{ route('taglabel3.destroyline') }}",
                data: { id: id, _token: '{{ csrf_token() }}' },
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
                    listdetail(part_no2);
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
