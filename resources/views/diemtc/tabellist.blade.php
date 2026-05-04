@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      background-color: #ffffff;
    }

    #example1 thead th {
      font-size: 13.5px;
      letter-spacing: 0.3px;
      font-weight: 600;
    }

    #example1 tbody td {
      font-size: 13px;
      color: #555;
      vertical-align: middle;
    }

    #example1 tbody tr:hover {
      background-color: #f6f8fa !important;
      transition: 0.3s;
    }

    .select2-container .select2-selection--single {
      height: 38px !important;
      border-radius: 8px !important;
      border: 1px solid #ced4da !important;
    }

    .modal-content {
      background-color: #ffffff;
    }

    .btn {
      border-radius: 6px;
      font-size: 13px;
    }

    .btn-outline-secondary:hover {
      background-color: #e9ecef;
    }


    .select2-container {
    width: 100% !important;
}

.select2-search__field {
    width: 100% !important;
}
  </style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Data List DIES Tool Service</h1>
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

          <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h3 class="card-title mb-0 text-secondary fw-bold">
                <i class="fas fa-list me-2"></i> List Data Dies
              </h3>
            </div>

            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center mt-2 mt-md-0">
              <form id="importForm" action="{{ route('tabellistdies.importDp') }}" method="POST"
                  enctype="multipart/form-data" class="d-flex align-items-center mb-2 mb-md-0">
                  @csrf
                  <input type="file" id="fileInput" name="file" class="form-control form-control-sm me-2"
                      style="width: auto; border-radius: 6px;" required>
                  <button id="importButton" class="btn btn-outline-primary btn-sm" type="submit" disabled>
                      <i class="fas fa-upload"></i> Import
                  </button>
              </form>
            <!-- Tombol untuk membuka modal -->
          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
              <i class="fas fa-file-export"></i> Export
          </button>
          <button class="btn btn-sm btn-outline-secondary" id="btn_add" data-bs-toggle="modal" data-bs-target="#myModal2">
            <i class="fa fa-plus"></i> Add
          </button>
          </div>

            <div class="card-body bg-light">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover align-middle mb-0">
                  <thead class="text-center" style="background-color: #f2f3f5; color: #555;">
                    <tr>
                      <th width="50">No</th>
                      <th>Part Name</th>
                      <th>Job No</th>
                      <th>Part No</th>
                      <th>Model</th>
                      <th>Line</th>
                      <th>Std Stroke</th>
                      <th>Proses</th>
                      <th width="100">Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-center bg-white">
                    <!-- Data loaded dynamically -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

<!-- Modal Dies List -->
<div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content shadow-lg" style="border-radius:16px;">

      <!-- Header -->
      <div class="modal-header" style="background:#f8f9fa; border-bottom:1px solid #e1e1e1;">
        <h4 class="modal-title fw-bold text-secondary" id="title1">Add Dies List</h4>
        <h4 class="modal-title fw-bold text-secondary d-none" id="title2">Edit Dies List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                style="font-size:28px; font-weight:300;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 py-3">
        <div id="alert" class="mb-3"></div>

        <!-- Part No -->
        <div class="mb-3">
          <label class="form-label text-secondary fw-semibold">Part No</label>
          <input type="text" id="tampil_part_no" class="form-control form-control-sm bg-light" readonly>
        </div>

        <!-- Item -->
        <div class="mb-3">
          <label class="form-label text-secondary fw-semibold">Item</label>
          <select id="product_id" class="form-control select2" style="width: 100%;" required>
            <option value="">- pilih -</option>
            @foreach ($data_part_names as $part)
              <option value="{{ $part->id }}"
                data-job_no="{{ $part->job_no }}"
                data-part_no="{{ $part->part_no }}"
                data-part_no2="{{ $part->part_no2 }}"
                data-model_id="{{ $part->model }}"
                data-part_name="{{ $part->part_name }}"
                data-categoy="{{ $part->category }}"
                data-spec="{{ $part->spec }}"
                data-spec_bq="{{ $part->spec_bq }}">
                ({{ $part->part_no2 }}) | ({{ $part->model }}) | {{ $part->part_name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Line -->
        <div class="mb-3">
          <label class="form-label text-secondary fw-semibold">Line</label>
          <select id="line_id" class="form-control select2" style="width:100%;" required>
            <option value="">- pilih -</option>
            <option value="LINE A1">LINE A1</option>
            <option value="LINE A2">LINE A2</option>
            <option value="LINE B1">LINE B1</option>
            <option value="LINE B2">LINE B2</option>
            <option value="LINE B3">LINE B3</option>
          </select>
        </div>

        <!-- Stroke & Proses -->
        <div class="row">
          <div class="col-sm-6 mb-3">
            <label class="form-label text-secondary fw-semibold">Std Stroke</label>
            <input type="number" id="std_stroke" class="form-control form-control-sm">
          </div>
          <div class="col-sm-6 mb-3">
            <label class="form-label text-secondary fw-semibold">Proses</label>
            <select id="proses" class="form-control select2" style="width: 100%;" required>
              <option value="">- pilih -</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
          </div>
        </div>

        <!-- Tabel Detail Proses -->
        <div class="row mt-2" id="area_tabel_proses" style="display: none;">
          <div class="col-12">
            <label class="form-label text-secondary fw-semibold">List Detail Data Proses</label>
            <div class="table-responsive">
              <table class="table table-bordered table-sm text-center mb-0" id="tabel_proses">
                <thead class="bg-light">
                  <tr>
                    <th width="30" class="text-secondary text-center align-middle">
                        <input type="checkbox" id="checkAllOps">
                    </th>
                    <th width="50" class="text-secondary text-center">#</th>
                    <th class="text-secondary text-center">OP</th>
                    <th class="text-secondary text-center">Part No</th>
                    <th class="text-secondary text-center">Job No</th>
                    <th class="text-secondary text-center">Model</th>
                    <th width="120" class="text-secondary text-center">QRCode Label</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <!-- Baris ter-generate otomatis -->
                </tbody>
              </table>
            </div>

            <div class="mt-2 text-right" id="area_btn_download_selected" style="display: none;">
                <button type="button" class="btn btn-sm btn-danger font-weight-bold" id="btn_download_selected_ops">
                    <i class="fas fa-file-pdf"></i> Download Selected PDF
                </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer" style="background:#f8f9fa; border-top:1px solid #e1e1e1;">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
          <i class="fa fa-times"></i> Close
        </button>
        <div>
          <button type="button" class="btn btn-primary Save">
            <i class="fa fa-save"></i> Save
          </button>
          <button type="button" class="btn btn-success Update d-none">
            <i class="fa fa-sync-alt"></i> Update
          </button>
        </div>
      </div>

    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content shadow-sm border-0 rounded-3">

          <!-- Header -->
          <div class="modal-header bg-secondary text-white py-2 rounded-top">
              <h6 class="modal-title fw-bold" id="myModalLabel">Export Data</h6>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <!-- Body -->
          <div class="modal-body text-center p-3">
              <p class="mb-3 text-muted small">Pilih jenis download yang Anda inginkan:</p>

              <a href="{{ route('formatlistdies.export') }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                  <i class="fas fa-download mr-1"></i> Download Format
              </a>

              <a href="{{ route('datalistdies.export') }}" class="btn btn-outline-primary btn-sm w-100 mb-3">
                  <i class="fas fa-download mr-1"></i> Download Data
              </a>

              <!-- Close Button in Body -->
              <button type="button" class="btn btn-outline-secondary btn-sm w-100" data-dismiss="modal">
                  <i class="fas fa-times mr-1"></i> Close
              </button>
          </div>

      </div>
  </div>
</div>

<!-- Modal QRCode -->
<div class="modal fade" id="modalQRCode" tabindex="-1" aria-labelledby="modalQRCodeLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content shadow-sm border-0 rounded-3">
          <!-- Header -->
          <div class="modal-header bg-secondary text-white py-2 rounded-top">
              <h6 class="modal-title fw-bold" id="modalQRCodeLabel">QRCode Part No</h6>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <!-- Body -->
          <div class="modal-body text-center p-3">
              <p id="qrcode_part_no_text" class="mb-2 fw-bold text-dark"></p>
              <div class="mb-3 d-flex justify-content-center" style="overflow-x: auto;">
                  <div id="qrcode"></div>
              </div>
              <button type="button" id="btn_download_pdf" class="btn btn-primary btn-sm w-100 mb-2">
                  <i class="fas fa-file-pdf mr-1"></i> Download PDF
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm w-100" data-dismiss="modal">
                  <i class="fas fa-times mr-1"></i> Close
              </button>
          </div>
      </div>
  </div>
</div>
<input type="hidden" id="id">

    <input type="hidden" id="job_no" name="job_no">
    <input type="hidden" id="part_no" name="part_no">
    <input type="hidden" id="part_no2" name="part_no2">
    <input type="hidden" id="model_id" name="model_id">
    <input type="hidden" id="part_name" name="part_name">
    <input type="hidden" id="spec_bq" name="spec_bq">
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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



    // FIX untuk Select2 dalam Bootstrap Modal
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

    $(document).ready(function () {

        // Select2 untuk ITEM
        $('#product_id').select2({
            width: "100%",
            dropdownParent: $("#myModal2")
        });

        // Select2 untuk LINE
        $('#line_id').select2({
            width: "100%",
            dropdownParent: $("#myModal2")
        });

        // Select2 untuk PROSES
        $('#proses').select2({
            width: "100%",
            dropdownParent: $("#myModal2")
        });

        // Generate baris tabel otomatis saat nilai proses berubah
        $('#proses').on('change', function() {
            var val = parseInt($(this).val());
            var tbody = $('#tabel_proses tbody');
            tbody.empty();

            var part_no_val = $('#part_no').val() || '';
            var job_no_val = $('#job_no').val() || '';
            var model_val = $('#model_id').val() || '';

            if (val > 0 && !isNaN(val)) {
                for (var i = 1; i <= val; i++) {
                    tbody.append(`
                        <tr>
                            <td class="align-middle text-center">
                                <input type="checkbox" class="check-op" data-op="OP${i}" data-partno="${part_no_val}" data-container="qrcode_row_${i}" style="transform: scale(1.2);">
                            </td>
                            <td class="fw-bold align-middle text-secondary text-center">${i}</td>
                            <td class="align-middle">
                                <input type="text" class="form-control form-control-sm text-center bg-light fw-bold text-primary" value="OP${i}" readonly>
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control form-control-sm text-center bg-light" value="${part_no_val}" readonly>
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control form-control-sm text-center bg-light" value="${job_no_val}" readonly>
                            </td>
                            <td class="align-middle">
                                <input type="text" class="form-control form-control-sm text-center bg-light" value="${model_val}" readonly>
                            </td>
                            <td class="align-middle text-center p-2">
                                <div id="qrcode_row_${i}" class="d-flex justify-content-center mt-1"></div>
                                <div style="font-size: 11px; font-weight: bold; margin-top: 6px; line-height: 1.3;">
                                    ${part_no_val}<br>
                                    <span class="text-primary">OP${i}</span>
                                </div>
                                <button type="button" class="btn btn-xs btn-outline-danger mt-2 btn-download-op-pdf"
                                        data-op="OP${i}" data-partno="${part_no_val}" data-container="qrcode_row_${i}" title="Download Label PDF">
                                    <i class="fas fa-file-pdf"></i> Download
                                </button>
                            </td>
                        </tr>
                    `);
                }
                $('#area_tabel_proses').fadeIn();

                // Render QRCode di setiap baris (terlewat sedetik agar DOM di render)
                setTimeout(function() {
                    for (var i = 1; i <= val; i++) {
                        var qrContainer = document.getElementById("qrcode_row_" + i);
                        if (qrContainer && part_no_val) {
                            new QRCode(qrContainer, {
                                text: part_no_val + "OP" + i,
                                width: 50,
                                height: 50,
                                colorDark : "#000000",
                                colorLight : "#ffffff",
                                correctLevel : QRCode.CorrectLevel.H
                            });
                            // Menghapus atribut title bawaan jsqrcode agar tidak muncul tooltip kotak hitam
                            $(qrContainer).removeAttr("title");
                        }
                    }
                }, 50);

            } else {
                $('#area_tabel_proses').fadeOut();
            }

            // Reset state checkbox dan tombol
            $('#checkAllOps').prop('checked', false);
            $('#area_btn_download_selected').hide();
        });

        // Fitur Check All / Uncheck All
        $(document).on('change', '#checkAllOps', function() {
            $('.check-op').prop('checked', $(this).prop('checked'));
            toggleDownloadSelectedBtn();
        });

        // Fitur Individual Check
        $(document).on('change', '.check-op', function() {
            toggleDownloadSelectedBtn();
            if ($('.check-op:checked').length === $('.check-op').length && $('.check-op').length > 0) {
                $('#checkAllOps').prop('checked', true);
            } else {
                $('#checkAllOps').prop('checked', false);
            }
        });

        function toggleDownloadSelectedBtn() {
            if ($('.check-op:checked').length > 0) {
                $('#area_btn_download_selected').fadeIn();
            } else {
                $('#area_btn_download_selected').fadeOut();
            }
        }

        // Logic fitur Download Selected PDF (Multiple pages)
        $(document).on('click', '#btn_download_selected_ops', function() {
            var selectedOps = $('.check-op:checked');
            if (selectedOps.length === 0) return;

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                format: [60, 60]
            });

            var isFirstPage = true;
            var finalPartNo = "";

            selectedOps.each(function() {
                var containerId = $(this).data('container');
                var partNo = $(this).data('partno');
                var op = $(this).data('op');
                finalPartNo = partNo;

                var canvas = $('#' + containerId + ' canvas')[0] || $('#' + containerId + ' img')[0];
                if (canvas) {
                    var imgData = canvas.tagName.toLowerCase() === 'canvas' ? canvas.toDataURL('image/png') : canvas.src;

                    // Tambahkan halaman baru jika ini bukan QRCode yang pertama
                    if (!isFirstPage) {
                        doc.addPage([60, 60], "portrait");
                    }

                    doc.addImage(imgData, 'PNG', 10, 5, 40, 40);
                    doc.setFontSize(10);
                    doc.text(partNo, 30, 50, { align: "center" });
                    doc.setFontSize(10);
                    doc.text(op, 30, 55, { align: "center" });

                    isFirstPage = false; // Mark bahwa slide pertama sudah dibuat
                }
            });

            if (!isFirstPage) {
                doc.save("QRCodes_" + finalPartNo + "_Multiple.pdf");
            } else {
                Swal.fire('Error', 'Gagal memproses QRCode terpilih!', 'error');
            }
        });

        // Event listener rilis untuk mengunduh pdf QRCode OP (Individual)
        $(document).on("click", ".btn-download-op-pdf", function() {
            var containerId = $(this).data('container');
            var partNo = $(this).data('partno');
            var op = $(this).data('op');

            var canvas = $('#' + containerId + ' canvas')[0] || $('#' + containerId + ' img')[0];
            if (!canvas) {
                Swal.fire('Error', 'Gambar QRCode gagal dimuat/belum dirender!', 'error');
                return;
            }

            var imgData = canvas.tagName.toLowerCase() === 'canvas' ? canvas.toDataURL('image/png') : canvas.src;

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                format: [60, 60]
            });

            // QRCode Image (40x40), dtengahkan
            doc.addImage(imgData, 'PNG', 10, 5, 40, 40);

            // Teks Part No
            doc.setFontSize(10);
            doc.text(partNo, 30, 50, { align: "center" });

            // Teks OP
            doc.setFontSize(10);
            doc.text(op, 30, 55, { align: "center" });

            doc.save("QRCode_" + partNo + "_" + op + ".pdf");
        });
    });


        $('#product_id').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var job_no = selectedOption.data('job_no');
            var part_no = selectedOption.data('part_no');
            var model_id = selectedOption.data('model_id');
            var spek = selectedOption.data('spek');
            var part_no2 = selectedOption.data('part_no2');
            var part_name = selectedOption.data('part_name');
            var spec_bq = selectedOption.data('spec_bq');

            // Assign the values to hidden inputs or directly to an AJAX request payload
            $('#job_no').val(job_no);
            $('#part_no').val(part_no);
            $('#tampil_part_no').val(part_no);
            $('#model_id').val(model_id);
            $('#spek').val(spek);
            $('#part_no2').val(part_no2);
            $('#part_name').val(part_name);
            $('#spec_bq').val(spec_bq);

            // Refresh tabel dinamis proses jika item berubah
            $('#proses').trigger('change');
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
                        url: "{{ route('tabellistdies.list') }}"
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
                            data: 'line_id',
                            name: 'line_id'
                        },
                        {
                            data: 'std_stroke',
                            name: 'std_stroke'
                        },
                        {
                            data: 'proses',
                            name: 'proses'
                        },
                        {
                            data: 'id',
                            name: 'id',
                            render: function (data, type, row) {
                                return '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-info btn-sm">'+
                                            '<i class="fas fa-pencil-alt"></i>'+
                                        '</a>'+
                                        '<a href="#" id="btn_qrcode" title="QRCode" data-part_no="'+row.part_no+'" class="btn btn-warning btn-sm ml-1 text-white">'+
                                            '<i class="fas fa-qrcode"></i>'+
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

        $(document).on("click", "#btn_edit", function (e) {
            e.preventDefault();
            // Sembunyikan tombol Save dan title Add
            $(".Save").addClass("d-none");
            $("#title1").addClass("d-none");

            // Tampilkan tombol Update dan title Edit
            $(".Update").removeClass("d-none");
            $("#title2").removeClass("d-none");

            var table = $('#example1').DataTable();
            var tr = $(this).closest('tr');
            if (tr.hasClass('child')) {
                tr = tr.prev('.parent');
            }
            var rowData = table.row(tr).data();

            if (rowData) {
                // Gunakan cara instansiasi Bootstrap Modal yang sebelumnya ada jika diinginkan, namun cara jQuery biasanya berfungsi
                try {
                    const modalEl = document.getElementById('myModal2');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                } catch(err) {
                    $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                }

                $('#id').val(rowData.id);
                $('#line_id').val(rowData.line_id).trigger('change');
                $('#std_stroke').val(rowData.std_stroke);

                // Cocokkan data dropdown Item (product_id) dengan data di tabel
                var matchedOption = $('#product_id option').filter(function() {
                    return $(this).data('part_no') == rowData.part_no && $(this).data('part_name') == rowData.part_name;
                }).first();

                if (matchedOption.length > 0) {
                    $('#product_id').val(matchedOption.val()).trigger('change');
                } else {
                    $('#product_id').val('').trigger('change');
                }

                // Jalankan value proses setelah part ter-load
                setTimeout(function() {
                     $('#proses').val(rowData.proses).trigger('change');
                }, 100);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Data baris tidak ditemukan!',
                });
            }
        });

        var currentPartNo = '';
        var qrcodeInstance = null;

        $(document).on("click", "#btn_qrcode", function (e) {
            e.preventDefault();
            var part_no = $(this).data('part_no');
            if (part_no) {
                currentPartNo = part_no;
                $('#qrcode_part_no_text').text('Part No: ' + part_no);

                $('#qrcode').empty();

                qrcodeInstance = new QRCode(document.getElementById("qrcode"), {
                    text: part_no,
                    width: 150,
                    height: 150,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
                $('#modalQRCode').modal('show');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Part No is empty!',
                });
            }
        });

        $(document).on("click", "#btn_download_pdf", function () {
            if (!currentPartNo) return;

            var canvas = $('#qrcode canvas')[0] || $('#qrcode img')[0];
            if (!canvas) {
                Swal.fire('Error', 'QRCode belum di-generate!', 'error');
                return;
            }

            var imgData;
            if (canvas.tagName.toLowerCase() === 'canvas') {
                imgData = canvas.toDataURL('image/png');
            } else {
                imgData = canvas.src;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({
                orientation: "portrait",
                unit: "mm",
                format: [60, 60]
            });

            // Ukuran kertas dibuat pas 60x60 supaya tidak ada spasi putih berlebih.
            // QRCode (40x40) ditengah dengan x=10 dan margin atas y=5.
            doc.addImage(imgData, 'PNG', 10, 5, 40, 40);

            // Teks Part No persis di bawah QRCode
            doc.setFontSize(10);
            doc.text("Part No: " + currentPartNo, 30, 52, { align: "center" });

            doc.save("QRCode_" + currentPartNo + ".pdf");
        });


        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
        });

        function clear(){
            $("#id").val('');
            $("#part_name").val('').trigger('change');
            $("#job_no").val('').trigger('change');
            $("#part_no").val('').trigger('change');
            // $('#model_id').val('').trigger('change');
            $('#spec_id').val('').trigger('change');
            $('#line_id').val('').trigger('change');
            $('#std_stroke').val('').trigger('change');
            $('#proses').val('').trigger('change');

        }

        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();
            if(validasi()){
                $.ajax({
                    type: 'POST',
                    url: "{{route('tabellistdies.store')}}",
                    data: {
                        part_name: part_name.value,
                        job_no: job_no.value,
                        part_no: part_no.value,
                        model_id: model_id.value,
                        line_id: line_id.value,
                        std_stroke: std_stroke.value,
                        proses: proses.value,
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
    if (validasi()) {
        $.ajax({
            type: 'POST',
            url: "{{ route('tabellistdies.update') }}",
            data: {
                id: $('#id').val(),
                part_name: $('#part_name').val(),
                job_no: $('#job_no').val(),
                part_no: $('#part_no').val(),
                model_id: $('#model_id').val(),
                line_id: $('#line_id').val(),
                std_stroke: $('#std_stroke').val(),
                proses: $('#proses').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function (result) {
                if (result.success) {
                    $('#myModal2').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: result.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    list();
                    clear();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem!'
                });
            }
        });
    }
});


        function validasi(){
            $("#alert").show();
            if(job_no.value != '' && part_no.value != '' && model_id.value != '' && line_id.value !=''){
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
                    url: "{{route('tabellistdies.destroy')}}",
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
                text: 'Apakah Anda yakin ingin mengimpor Data?',
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
                url: "{{ route('tabellistdies.importDp') }}", // Replace with your route name
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
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
