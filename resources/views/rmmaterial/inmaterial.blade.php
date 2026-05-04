@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .content {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            padding: 20px;
            color: rgb(0, 0, 0);
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: rgb(214, 214, 214);
        }

        .card-header {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            padding: 20px;
            color: white;
            font-weight: bold;
        }

        .card-title {
            font-family: 'Times New Roman', Times, serif;
            font-size: 1.25rem;
        }

        .btn-success {
            background-color: #218838;
            border: none;
            transition: 0.3s;
        }

        .btn-success:hover {
            background-color: #1e7e34;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #6b9696;
        }

        .yellow-toast {
            background-color: yellow !important;
            color: rgb(255, 255, 255) !important;
            /* Agar teks tetap terbaca */
            font-weight: bold;
        }

        .disabled-link {
    pointer-events: none;
    opacity: 0.5;
}

    </style>
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Bikin Label STO Material</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: rgb(97, 255, 113)">
                        <h3 class="card-title"><b style="font-family: 'Times New Roman', Times, serif">List Label STO Material</b></h3>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-hover table-striped">
                            <thead class="table"
                                style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:aliceblue">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:aliceblue">
                    <h4 class="modal-title" id="title1">Tambah Label Material</h4>
                    <h4 class="modal-title" id="title2">Edit Label Material</h4>
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-1 col-form-label">Date :</label>
                        <div class="col-sm-3">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="date" id="date_plan" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-8"></div>
                        <label class="col-sm-1 col-form-label">Supplier :</label>
                        <div class="col-sm-3 mb-1">
                            <select style="width: 100%;" id="line_id" class="form-control form-control-sm" required>
                                <option value="" selected>- pilih -</option>
                                <option value="POSCO-1">POSCO-1</option>
                                <option value="POSCO-2">POSCO-2</option>
                                <option value="TTMI">TTMI</option>
                                <option value="SSK">SSK</option>
                                <option value="FUKUI">FUKUI</option>
                                <option value="KOMATSU">KOMATSU</option>
                            </select>
                        </div>


                        <div class="col-sm-1"></div>
                        <label class="col-sm-1 col-form-label">Item:</label>
                        <div class="col-sm-6 mb-2">
                            <select style="width: 100%;" id="product_id" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                @foreach ($rm_stoks as $part)
                                    <option value="{{ $part->id }}" 
                                        data-part_no="{{ $part->part_no }}"
                                           data-model_id="{{ $part->model_id }}"
                                         data-spek="{{ $part->spek }}"
                                        data-spek_t="{{ $part->spek_t}}"
                                        data-spek_w="{{ $part->spek_w}}"
                                        data-spek_l="{{ $part->spek_l}}">
                                        {{ $part->part_no }} / {{ $part->model_id }} / {{ $part->spek}} / {{ $part->spek_t}} / {{ $part->spek_w }} / {{ $part->spek_l}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-1 col-form-label">Actual:</label>
                        <div class="col-sm-2 mb-1">
                            <input type="text" id="qty_act" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-2 mb-1">
                            <input type="hidden" id="uniqNo" class="form-control form-control-sm">
                        </div>

                        <div class="col-sm-7">
                            <button type="button" class="btn btn-success btn-sm Save">Insert</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-sm text-center">
                            <thead class="thead-dark">
                                <button id="btn_generate_all" class="btn btn-primary">Generate Selected QR Codes</button>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>No</th>
                                    <th>Part No</th>
                                    <th>Model</th>
                                    <th>Spec</th>
                                    <th>T</th>
                                    <th>W</th>
                                    <th>L</th>
                                    <th>Supplier</th>
                                    <th>Qty</th>
                                    <th>Unique No</th>
                                    <th>Status Scan</th>
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
    </div>

    <!-- Modal -->
<div class="modal fade" id="qtyModal" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div  class="modal-content">
            <div  style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%); color:white" class="modal-header">
                <h5 class="modal-title" id="sumQtyModalLabel">Jumlahkan Quantity Material</h5>
                <button type="button" class="close; btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <label for="km_part" class="form-label fw-bold">Part No</label>
                        <select class="form-control form-control-sm" id="km_part">
                            <option value="">Pilih Part No</option>
                        </select>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


    <input type="hidden" id="part_no" name="part_no">
    <input type="hidden" id="model_id" name="model_id">
    <input type="hidden" id="spek" name="spek">
    <input type="hidden" id="spek_t" name="spek_t">
    <input type="hidden" id="spek_w" name="spek_w">
    <input type="hidden" id="spek_l" name="spek_l">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            list();
        });


        $('#product_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var part_no = selectedOption.data('part_no');
            var model_id = selectedOption.data('model_id');
            var spek = selectedOption.data('spek');
            var spek_t = selectedOption.data('spek_t');
            var spek_w = selectedOption.data('spek_w');
            var spek_l = selectedOption.data('spek_l');

            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#part_no').val(part_no);
            $('#model_id').val(model_id);
            $('#spek_t').val(spek_t);
            $('#spek_w').val(spek_w);
            $('#spek_l').val(spek_l);
            $('#spek').val(spek);
            $('#model_id').val(model_id);
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
        pageLength: 10,
        order: [[1, 'desc']], // Urutkan berdasarkan kolom ke-1 (`date_plan`) dari yang terbaru
        ajax: {
            url: "{{ route('inmaterial.list') }}"
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
                data: 'date_plan',
                name: 'date_plan'
            },
            {
                data: 'line_id',
                name: 'line_id'
            },
            {
                data: 'mix_id',
                name: 'mix_id',
                render: function(data) {
                    return '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                        '" class="btn btn-info btn-sm">' +
                        '<i class="fas fa-search"></i>' +
                        '</a>';
                }
            }
        ],
        columnDefs: [
            {
                "targets": [0],
                "orderable": false,
            }
        ],
        responsive: true,
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
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
            url: "{{ route('inmaterial.listdetail') }}",
            data: {
                date_plan: date_plan.value,
                line_id: line_id.value,
            }
        },
        columns: [
    {
        data: null,
        sortable: false,
        searchable: false,
        orderable: false,
        render: function(data, type, row, meta) {
            return '<input type="checkbox" class="dataCheckbox" value="'+row.id+'">';
        }
    },
    {
        data: null,
        sortable: false,
        searchable: false,
        orderable: false,
        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    { data: 'part_no', name: 'part_no' },
    { data: 'model_id', name: 'model_id' },
    { data: 'spek', name: 'spek' },
    { data: 'spek_t', name: 'spek_t' },
    { data: 'spek_w', name: 'spek_w' },
    { data: 'spek_l', name: 'spek_l' },
    { data: 'line_id', name: 'line_id' },
    { data: 'qty_act', name: 'qty_act' },
    { data: 'uniqNo', name: 'uniqNo' },
    {
        data: 'sts_scan',
        name: 'sts_scan',
        render: function(data) {
            if (data == 1) {
                return '<span class="badge badge-success">Sudah Scan</span>';
            } else {
                return '<span class="badge badge-warning">Belum Scan</span>';
            }
        }
    },
    {
        data: 'id',
        name: 'id',
        render: function (data, type, row) {
            let disableClass = row.sts_scan == 1 ? 'disabled-link' : '';
            let disableStyle = row.sts_scan == 1 ? 'pointer-events: none; opacity: 0.5;' : '';

            return '<a href="#" id="btn_delete_line" title="Delete" data-id="'+data+'" class="btn btn-danger btn-sm ml-1 '+disableClass+'" style="'+disableStyle+'">'+
                        '<i class="far fa-trash-alt"></i>'+
                    '</a>'+
                    '<a href="#" id="btn_pdf" title="Generate" data-id="'+data+'" class="btn btn-info btn-sm ml-1">'+
                        '<i class="fas fa-qrcode"></i>'+
                    '</a>';
        }
    }
],
        columnDefs: [{
            "targets": [0, 1],
            "orderable": false,
        }],
        responsive: true,
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
        }
    });

    // Fungsi untuk check/uncheck semua checkbox di tabel
    $('#checkAll').on('change', function() {
        $('.rowCheck').prop('checked', this.checked);
    });
}


        $(document).on("click", "#btn_add", function() {
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $("#title2").hide();
            $(".Update").hide();
            $("#title1").show();
            clear();

            // Set tanggal hari ini secara otomatis
            let today = new Date().toISOString().split('T')[0];
            $("#date_plan").val(today);
        });


        $(document).on("click", "#btn_edit", function() {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#date_plan').val(date_plan);
            $('#line_id').val(idline).trigger('change');
            listdetail();
        });

        $(document).on("click", "#btn_edit_line", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('planninglineb3.edit') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                        $('#id').val(result.id);
                        $('#product_id').val(result.product_id);
                        $('#qty_act').val(result.qty_act);
                        // $('#description').val(result.description);
                    } else {
                        SweetAlert.fire({
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

        $(document).on("click", ".close", function() {
            clear();
            $("#alert").html('');
            list();
        });

        function clear() {
            $("#id").val('');
            $("#date_plan").val('');
            $('#line_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $("#qty_act").val('');
            $("#qty_ng").val('');
            // $('#material_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('inmaterial.store') }}",
                    data: {
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                        product_id: product_id.value,
                        model_id: model_id.value,
                        part_no: part_no.value,
                        spek: spek.value,
                        spek_t: spek_t.value,
                        spek_w: spek_w.value,
                        spek_l: spek_l.value,
                        qty_act: qty_act.value,
                        part_no: part_no.value,
                        uniqNo: uniqNo.value,
                        // spec: spec.value,
                        // material_id: material_id.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            $("#alert").html(
                                '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                result.msg + '</div>');
                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $("#qty_act").val('');
                            // $('#material_id').val('').trigger('change');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        } else {
                            $("#alert").html(
                                '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                                result.msg + '</div>');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".Update", function() {
            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('inmaterial.update') }}",
                    data: {
                        id: id.value,
                        date_plan: date_plan.value,
                        line_id: line_id.value,
                        product_id: product_id.value,
                        spek: spek.value,
                        spek_t: spek_t.value,
                        spek_w: spek_w.value,
                        spek_l: spek_l.value,
                        qty_act: qty_act.value,
                        part_no: part_no.value,
                        uniqNo: uniqNo.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.success) {
                            SweetAlert.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            listdetail();
                            $('#product_id').val('').trigger('change');
                            $('#qty_act').val('').trigger('change');
                            // $('#material_id').val('').trigger('change');
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 150);
                        } else {
                            SweetAlert.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: result.msg,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    }
                });
            }
        });

        $(document).on('click', '#btn_pdf', function(e) {
        e.preventDefault();

        // Ambil data-id dari tombol yang diklik
        var id = $(this).data('id');

        // Bangun URL untuk mencetak PDF
        var printUrl = "{{ route('inmaterial.cetak', ':id') }}".replace(':id', id);

        // Coba buka di tab baru
        var newWindow = window.open(printUrl, '_blank');

        // Fallback: jika tab baru diblokir oleh browser, buka di jendela saat ini
        if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
            window.location.href = printUrl;
        }
    });


        function validasi() {
            $("#alert").show();
            if (date_plan.value != '' && line_id.value != '' && product_id.value != '' && qty_act.value != '') {
                return true;
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>all column cannot be empty.</div>');
                setTimeout(() => {
                    $("#alert").hide();
                }, 1500);
            }
        }

        $(document).on('click', '#btn_generate_all', function (e) {
    e.preventDefault();

    const selectedIds = [];
    $('.dataCheckbox:checked').each(function () {
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

    // Kirim AJAX request untuk generate QR Code dalam bentuk PDF
    $.ajax({
        url: "{{ route('inmaterial.generateMultipleQrCodes') }}",
        method: 'POST',
        data: {
            ids: selectedIds,
            _token: '{{ csrf_token() }}'
        },
        xhrFields: {
            responseType: 'blob' // Supaya menerima file PDF sebagai response
        },
        success: function (response) {
            // Buat blob untuk download file PDF
            const blob = new Blob([response], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'Label Sto ' + new Date().toISOString().slice(0, 10) + '.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memproses data.',
                showConfirmButton: true
            });
        }
    });
});

// Fungsi untuk centang semua checkbox di tabel
$('#checkAll').on('change', function() {
    $('.dataCheckbox').prop('checked', this.checked);
});


        $(document).on("click", "#btn_delete_line", function() {
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
                        url: "{{ route('inmaterial.destroyline') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            listdetail();
                        }
                    });
                }
            })
        });

        $(document).on("click", "#btn_delete", function() {
            var id = $(this).data('id');
            var date_plan = id.substr(0, 10);
            var idline = id.substr(10);
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
                        url: "{{ route('inmaterial.destroy') }}",
                        data: {
                            date_plan: date_plan,
                            idline: idline,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
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
