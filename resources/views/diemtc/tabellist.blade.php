@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-blue: #0284c7;
            --primary-hover: #0369a1;
            --secondary-blue: #f0f9ff;
            --accent-blue: #e0f2fe;
            --bg-main: #f8fafc;
            --text-main: #0f172a;
            /* Darker for better clarity */
            --text-muted: #475569;
            /* Darker muted text */
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .premium-card {
            background: white;
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* Table Styling - Grid Style */
        #example1 {
            width: 100% !important;
            border-collapse: collapse !important;
            border: 1px solid #e2e8f0;
            margin-top: 10px;
        }

        #example1 thead th {
            background-color: #f1f5f9;
            color: var(--text-main);
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 800;
            /* Bolder for clarity */
            letter-spacing: 0.025em;
            padding: 14px 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        #example1 tbody td {
            padding: 12px 10px;
            border: 1px solid #e2e8f0;
            /* Grid lines */
            vertical-align: middle;
            font-size: 13.5px;
            color: var(--text-main);
            font-weight: 500;
            /* Clearer text */
        }

        #example1 tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        #example1 tbody tr:hover {
            background-color: #f1f5f9 !important;
        }

        /* Action Buttons */
        .btn-premium {
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            font-size: 13px;
        }

        .btn-add {
            background: var(--primary-blue);
            color: white;
        }

        .btn-add:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            color: white;
        }

        .btn-export {
            background: #10b981;
            color: white;
        }

        .btn-export:hover {
            background: #059669;
            color: white;
        }

        .btn-import {
            background: #64748b;
            color: white;
        }

        .btn-import:hover {
            background: #475569;
            color: white;
        }

        .btn-choose {
            background: white;
            border: 1px solid #cbd5e1;
            color: var(--text-main);
        }

        .btn-choose:hover {
            background: #f8fafc;
        }

        /* Select2 */
        .select2-container--default .select2-selection--single {
            height: 44px !important;
            border-radius: 10px !important;
            border: 1px solid #cbd5e1 !important;
            background-color: white !important;
        }

        /* Modal */
        .modal-content-premium {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-lg);
            background: white;
        }

        .modal-header-premium {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }

        .form-label-premium {
            font-weight: 700;
            font-size: 13px;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-control-premium {
            border-radius: 10px !important;
            border: 1px solid #cbd5e1;
            padding: 12px;
            font-weight: 500;
        }

        .form-control-premium:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
        }
    </style>

    <div class="content-header px-4 pt-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold text-dark" style="letter-spacing: -1px; font-size: 28px;">Dies Tool Service</h1>
                    <p class="text-muted fw-medium small mb-0">Industrial management and tracking system for dies</p>
                </div>
                <div class="col-sm-6 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="#" class="text-primary fw-bold">Dashboard</a></li>
                            <li class="breadcrumb-item active fw-bold">Dies List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-4 pb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="premium-card">
                        <div
                            class="card-header bg-white border-0 pt-4 px-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white p-3 rounded-3 shadow-sm">
                                    <i class="fas fa-database fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark">Master Data Dies</h4>
                                    <span class="text-muted small fw-medium">Database of all registered dies
                                        components</span>
                                </div>
                            </div>

                            <!-- Pushed to the far right -->
                            <div class="d-flex flex-wrap gap-2 ms-lg-auto">
                                <form id="importForm" action="{{ route('tabellistdies.importDp') }}" method="POST"
                                    enctype="multipart/form-data" class="d-flex align-items-center">
                                    @csrf
                                    <input type="file" id="fileInput" name="file" class="d-none" required>
                                    <label for="fileInput" class="btn btn-premium btn-choose mb-0">
                                        <i class="fas fa-folder-open text-primary"></i> Choose File
                                    </label>
                                    <button id="importButton" class="btn btn-premium btn-import ms-2" type="submit"
                                        disabled>
                                        <i class="fas fa-file-import"></i> Import
                                    </button>
                                </form>
                                <button type="button" class="btn btn-premium btn-export" data-toggle="modal"
                                    data-target="#myModal">
                                    <i class="fas fa-file-excel"></i> Export
                                </button>
                                <button class="btn btn-premium btn-add" id="btn_add" data-bs-toggle="modal"
                                    data-bs-target="#myModal2">
                                    <i class="fa fa-plus-circle"></i> Add New Dies
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="example1" class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th width="60" class="text-center">NO</th>
                                            <th>PART NAME</th>
                                            <th>JOB NO</th>
                                            <th>PART NO</th>
                                            <th>MODEL</th>
                                            <th>LINE</th>
                                            <th class="text-center">STD STROKE</th>
                                            <th class="text-center">PROSES</th>
                                            <th width="140" class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-content-premium">

                <!-- Header -->
                <div class="modal-header modal-header-premium d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="title1">Add New Dies</h4>
                        <h4 class="modal-title fw-bold text-dark mb-0 d-none" id="title2">Edit Dies Information</h4>
                        <p class="text-muted small mb-0">Fill in the details below to manage dies data</p>
                    </div>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">Close</button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-4">
                    <div id="alert" class="mb-3"></div>

                    <div class="row">
                        <!-- Part No -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label-premium">Part Number (Read Only)</label>
                            <input type="text" id="tampil_part_no" class="form-control form-control-premium bg-light"
                                readonly placeholder="Auto-generated">
                        </div>

                        <!-- Item -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label-premium">Select Item / Product</label>
                            <select id="product_id" class="form-control select2" style="width: 100%;" required>
                                <option value="">- Choose Item -</option>
                                @foreach ($data_part_names as $part)
                                    <option value="{{ $part->id }}" data-job_no="{{ $part->job_no }}"
                                        data-part_no="{{ $part->part_no }}" data-part_no2="{{ $part->part_no2 }}"
                                        data-model_id="{{ $part->model }}" data-part_name="{{ $part->part_name }}"
                                        data-categoy="{{ $part->category }}" data-spec="{{ $part->spec }}"
                                        data-spec_bq="{{ $part->spec_bq }}">
                                        [{{ $part->part_no2 }}] {{ $part->part_name }} ({{ $part->model }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Line -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label-premium">Production Line</label>
                            <select id="line_id" class="form-control select2" style="width:100%;" required>
                                <option value="">- Select Line -</option>
                                <option value="LINE A1">LINE A1</option>
                                <option value="LINE A2">LINE A2</option>
                                <option value="LINE B1">LINE B1</option>
                                <option value="LINE B2">LINE B2</option>
                                <option value="LINE B3">LINE B3</option>
                            </select>
                        </div>

                        <!-- Stroke -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label-premium">Std Stroke</label>
                            <div class="input-group">
                                <input type="number" id="std_stroke" class="form-control form-control-premium"
                                    placeholder="0">
                                <span class="input-group-text bg-white border-start-0 text-muted small"
                                    style="border-radius: 0 12px 12px 0; border: 1px solid #e2e8f0;">mm</span>
                            </div>
                        </div>

                        <!-- Proses -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label-premium">OP (Steps)</label>
                            <select id="proses" class="form-control select2" style="width: 100%;" required>
                                <option value="">- Select -</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} OP </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Tabel Detail Proses -->
                    <div class="mt-2" id="area_tabel_proses" style="display: none;">
                        <div class="p-3 rounded-4 border" style="background: rgba(248, 250, 252, 0.5);">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-tasks me-2"></i>Process Sequence List
                                </h6>
                                <div id="area_btn_download_selected" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-danger px-3 rounded-pill fw-bold"
                                        id="btn_download_selected_ops">
                                        <i class="fas fa-file-pdf me-1"></i> Download PDF Selected
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-center mb-0" id="tabel_proses"
                                    style="font-size: 12px;">
                                    <thead class="bg-white">
                                        <tr>
                                            <th width="30">
                                                <input type="checkbox" id="checkAllOps" class="form-check-input">
                                            </th>
                                            <th width="40">#</th>
                                            <th width="80">OP</th>
                                            <th>Part No</th>
                                            <th>Job No</th>
                                            <th>Model</th>
                                            <th width="140">QRCode Label</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <!-- Baris ter-generate otomatis -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer modal-footer-premium justify-content-between">
                    <button type="button" class="btn btn-premium btn-light border" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <div>
                        <button type="button" class="btn btn-premium btn-primary Save">
                            <i class="fa fa-save"></i> Save Data
                        </button>
                        <button type="button" class="btn btn-premium btn-success Update d-none">
                            <i class="fa fa-sync-alt"></i> Update Changes
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <!-- Modal Export -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content modal-content-premium">
                <!-- Header -->
                <div class="modal-header modal-header-premium bg-primary text-white py-3">
                    <h6 class="modal-title fw-bold" id="myModalLabel"><i class="fas fa-file-export me-2"></i>Export Options
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center p-4">
                    <p class="mb-4 text-muted small">Choose the data format you want to download:</p>

                    <div class="d-grid gap-2">
                        <a href="{{ route('formatlistdies.export') }}"
                            class="btn btn-premium btn-light border text-success">
                            <i class="fas fa-file-excel"></i> Download Format
                        </a>

                        <a href="{{ route('datalistdies.export') }}" class="btn btn-premium btn-light border text-primary">
                            <i class="fas fa-database"></i> Download All Data
                        </a>
                    </div>

                    <hr class="my-4 opacity-50">

                    <button type="button" class="btn btn-premium btn-secondary w-100" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QRCode -->
    <div class="modal fade" id="modalQRCode" tabindex="-1" aria-labelledby="modalQRCodeLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content modal-content-premium">
                <!-- Header -->
                <div class="modal-header modal-header-premium bg-dark text-white py-3">
                    <h6 class="modal-title fw-bold" id="modalQRCodeLabel"><i class="fas fa-qrcode me-2"></i>Identification
                        Tag</h6>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <span class="badge-premium bg-light text-dark border" id="qrcode_part_no_text"></span>
                    </div>

                    <div class="mb-4 d-flex justify-content-center p-3 bg-white rounded-4 border shadow-sm mx-auto"
                        style="width: fit-content;">
                        <div id="qrcode"></div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" id="btn_download_pdf" class="btn btn-premium btn-primary">
                            <i class="fas fa-file-pdf"></i> Download Label PDF
                        </button>
                        <button type="button" class="btn btn-premium btn-light border" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
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
        $(document).ready(function () {
            list();
        });



        // FIX untuk Select2 dalam Bootstrap Modal
        $.fn.modal.Constructor.prototype._enforceFocus = function () { };

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
            $('#proses').on('change', function () {
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
                                            <input type="checkbox" class="check-op form-check-input" data-op="${i}" data-partno="${part_no_val}" data-container="qrcode_row_${i}">
                                        </td>
                                        <td class="fw-bold align-middle text-secondary text-center">${i}</td>
                                        <td class="align-middle">
                                            <input type="text" class="form-control form-control-premium text-center bg-light fw-bold text-primary" value="OP ${i}" readonly>
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" class="form-control form-control-premium text-center bg-light" value="${part_no_val}" readonly>
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" class="form-control form-control-premium text-center bg-light" value="${job_no_val}" readonly>
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" class="form-control form-control-premium text-center bg-light" value="${model_val}" readonly>
                                        </td>
                                        <td class="align-middle text-center p-2">
                                            <div id="qrcode_row_${i}" class="d-flex justify-content-center mt-1"></div>
                                            <div class="text-dark fw-bold mt-2 mb-2" style="font-size: 10px;">
                                                ${part_no_val} | <span class="text-primary">OP ${i}</span>
                                            </div>
                                            <button type="button" class="btn btn-xs btn-outline-primary rounded-pill px-3 btn-download-op-pdf"
                                                    data-op="${i}" data-partno="${part_no_val}" data-container="qrcode_row_${i}" title="Download Label PDF">
                                                <i class="fas fa-download me-1"></i> PDF
                                            </button>
                                        </td>
                                    </tr>
                                `);
                    }
                    $('#area_tabel_proses').fadeIn();

                    // Render QRCode di setiap baris (terlewat sedetik agar DOM di render)
                    setTimeout(function () {
                        for (var i = 1; i <= val; i++) {
                            var qrContainer = document.getElementById("qrcode_row_" + i);
                            if (qrContainer && part_no_val) {
                                new QRCode(qrContainer, {
                                    text: part_no_val + "." + "OP-" + i,
                                    width: 50,
                                    height: 50,
                                    colorDark: "#000000",
                                    colorLight: "#ffffff",
                                    correctLevel: QRCode.CorrectLevel.H
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
            $(document).on('change', '#checkAllOps', function () {
                $('.check-op').prop('checked', $(this).prop('checked'));
                toggleDownloadSelectedBtn();
            });

            // Fitur Individual Check
            $(document).on('change', '.check-op', function () {
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
            $(document).on('click', '#btn_download_selected_ops', function () {
                var selectedOps = $('.check-op:checked');
                if (selectedOps.length === 0) return;

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({
                    orientation: "landscape",
                    unit: "mm",
                    format: [40, 20]
                });

                var isFirstPage = true;
                var finalPartNo = "";

                selectedOps.each(function () {
                    var containerId = $(this).data('container');
                    var partNo = $(this).data('partno');
                    var op = $(this).data('op');
                    finalPartNo = partNo;

                    var canvas = $('#' + containerId + ' canvas')[0] || $('#' + containerId + ' img')[0];
                    if (canvas) {
                        var imgData = canvas.tagName.toLowerCase() === 'canvas' ? canvas.toDataURL('image/png') : canvas.src;

                        if (!isFirstPage) {
                            doc.addPage([40, 20], "landscape");
                        }

                        // QRCode on the top-left (left-aligned)
                        doc.addImage(imgData, 'PNG', 2, 1, 15, 15);

                        // Text directly below QRCode (left-aligned)
                        doc.setFont("helvetica", "bold");
                        doc.setFontSize(7);
                        doc.text(partNo + " | OP " + op, 2, 18);

                        isFirstPage = false;
                    }
                });

                if (!isFirstPage) {
                    doc.save("QRCodes_" + finalPartNo + "_Multiple.pdf");
                } else {
                    Swal.fire('Error', 'Gagal memproses QRCode terpilih!', 'error');
                }
            });

            // Event listener rilis untuk mengunduh pdf QRCode OP (Individual)
            $(document).on("click", ".btn-download-op-pdf", function () {
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
                    orientation: "landscape",
                    unit: "mm",
                    format: [40, 20]
                });

                // QRCode on the top-left
                doc.addImage(imgData, 'PNG', 2, 1, 15, 15);

                // Text directly below QRCode
                doc.setFont("helvetica", "bold");
                doc.setFontSize(7);
                doc.text(partNo + " | OP " + op, 2, 18);

                doc.save("QRCode_" + partNo + "_OP" + op + ".pdf");
            });
        });


        $('#product_id').on('change', function () {
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
                ajax: {
                    url: "{{ route('tabellistdies.list') }}"
                },
                columns: [{
                    data: null,
                    sortable: false,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, row, meta) {
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
                        return '<div class="d-flex justify-content-center gap-1">' +
                            '<a href="#" id="btn_edit" title="Edit" data-id="' + data + '" class="btn btn-primary btn-sm rounded-3 shadow-sm">' +
                            '<i class="fas fa-edit"></i>' +
                            '</a>' +
                            '<a href="#" id="btn_qrcode" title="QRCode" data-part_no="' + row.part_no + '" class="btn btn-dark btn-sm rounded-3 shadow-sm">' +
                            '<i class="fas fa-qrcode"></i>' +
                            '</a>' +
                            '<a href="#" id="btn_delete" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm rounded-3 shadow-sm">' +
                            '<i class="fas fa-trash-alt"></i>' +
                            '</a>' +
                            '</div>';
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
            $(".Update").addClass("d-none");
            $("#title2").addClass("d-none");
            $(".Save").removeClass("d-none");
            $("#title1").removeClass("d-none");
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
                } catch (err) {
                    $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
                }

                $('#id').val(rowData.id);
                $('#line_id').val(rowData.line_id).trigger('change');
                $('#std_stroke').val(rowData.std_stroke);

                // Cocokkan data dropdown Item (product_id) dengan data di tabel
                var matchedOption = $('#product_id option').filter(function () {
                    return $(this).data('part_no') == rowData.part_no && $(this).data('part_name') == rowData.part_name;
                }).first();

                if (matchedOption.length > 0) {
                    $('#product_id').val(matchedOption.val()).trigger('change');
                } else {
                    $('#product_id').val('').trigger('change');
                }

                // Jalankan value proses setelah part ter-load
                setTimeout(function () {
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
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
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
                orientation: "landscape",
                unit: "mm",
                format: [40, 20]
            });

            // QRCode on the top-left
            doc.addImage(imgData, 'PNG', 2, 1, 15, 15);

            // Text directly below QRCode
            doc.setFont("helvetica", "bold");
            doc.setFontSize(7);
            doc.text(currentPartNo, 2, 18);

            doc.save("QRCode_" + currentPartNo + ".pdf");
        });


        $(document).on("click", ".close", function () {
            clear();
            $("#alert").html('');
        });

        function clear() {
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
            if (validasi()) {
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
                    success: function (result) {
                        if (result.success) {
                            $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
                            list();
                            clear();
                            setTimeout(() => { $("#alert").hide(); }, 1500);
                        } else {
                            $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> ' + result.msg + '</div>');
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


        function validasi() {
            $("#alert").show();
            if (job_no.value != '' && part_no.value != '' && model_id.value != '' && line_id.value != '') {
                return true;
            } else {
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
                        data: { id: id, _token: '{{csrf_token()}}' },
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                                });
                            } else {
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
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                importButton.disabled = false; // Aktifkan tombol jika ada file yang dipilih
            } else {
                importButton.disabled = true; // Nonaktifkan tombol jika tidak ada file
            }
        });

        document.getElementById('importForm').addEventListener('submit', function (event) {
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
                success: function (response) {
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

                error: function (error) {
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