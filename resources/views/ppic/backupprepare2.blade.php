@extends('layouts.app')

@section('content')
<style>
    .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-box {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ddd;
  margin-bottom: 10px;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.2em;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5em;
  cursor: pointer;
}

.modal-content {
  font-size: 1em;
}

@media (max-width: 576px) {
    div.dataTables_length label,
    div.dataTables_filter label {
        width: 100%;
    }

    div.dataTables_length select,
    div.dataTables_filter input {
        width: 100%;
        margin-top: 0.25rem;
    }

    .dataTables_wrapper .d-flex {
        flex-direction: column;
        align-items: stretch;
    }
}

</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Planning Line B3</h1>
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
                <div class="card-header">
                  <h3 class="card-title">List Planning Line B3</h3>
                  <div class="card-tools">
                    <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th>Date</th>
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


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Ubah ke modal-xl agar lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Dokumen: <span id="modalDocDN"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- <input type="text" id="scanResult" class="form-control" readonly> --}}
                <small id="scanAlert" class="text-danger font-weight-bold"></small>
                <!-- Kamera QR -->
                <div class="text-center mb-3">
                    <div id="my-qr-reader" style="width: 50%; max-width: 200px; margin: auto;"></div>
                </div>
            
                <!-- Tombol Kontrol Kamera -->
                <div class="text-center mb-4">
                    <button id="startCameraBtn" class="btn btn-success btn-sm mx-1">Nyalakan Kamera</button>
                    <button id="stopCameraBtn" class="btn btn-danger btn-sm mx-1">Matikan Kamera</button>
                </div>

                <!-- Hasil Scan -->
<!-- Kanban CS -->
    <div class="form-group row align-items-center">
        <label for="scanResult" class="col-sm-2 col-form-label font-weight-bold">Kanban CS:</label>
        <div class="col-sm-9">
            <input type="text" id="scanResult" class="form-control form-control-sm" readonly placeholder="QR Code akan muncul di sini">
        </div>
        <div class="col-sm-1" id="checkMark1" style="font-size: 20px; color: green;"></div>
    </div>

    <!-- Kanban ASI -->
    <div class="form-group row align-items-center">
        <label for="scanResult2" class="col-sm-2 col-form-label font-weight-bold">Kanban ASI:</label>
        <div class="col-sm-9">
            <input type="text" id="scanResult2" class="form-control form-control-sm" readonly placeholder="QR Code akan muncul di sini">
        </div>
        <div class="col-sm-1" id="checkMark2" style="font-size: 20px; color: green;"></div>
    </div>
       <!-- Dropdown Filter -->
                <div class="form-group row">
                    <label for="cycleNumber" class="col-sm-2 col-form-label font-weight-bold">Cycle:</label>
                    <div class="col-sm-4">
                        <select id="cycleNumber" class="form-control form-control-sm">
                            <div class="alert alert-info" id="currentCycleText">-- Pilih Cycle --</div>
                            <option value="qty_1">Cycle 1</option>
                            <option value="qty_2">Cycle 2</option>
                            <option value="qty_3">Cycle 3</option>
                            <option value="qty_4">Cycle 4</option>
                            <option value="qty_5">Cycle 5</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="resetScan" class="btn btn-sm btn-info ml-2">Reset Scan</button>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="CekScan" class="btn btn-sm btn-success ml-2">Cek</button>
                    </div>
                </div>
                
            
                <!-- Tabel 4 Kolom -->
                <table id="editModalTable" class="table table-bordered table-striped">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 90px;">Item(Order)</th>
                            <th>Label Inter</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="scanTableBody" class="text-center">
                        <!-- Data scan akan ditambahkan di sini -->
                    </tbody>
                </table>                
            
            </div>
            
        </div>
    </div>
</div>


  <!-- Area hasil scan -->




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
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            list();
        });


        // list data 
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
                        url: "{{ route('listrekapd26.list') }}"
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
                            data: 'doc_dn',
                            name: 'doc_dn'
                        },

                        {
                            data: 'doc_dn',
                            name: 'doc_dn',
                            render: function (data) {
                                return `
                                    <a href="#" class="btn btn-primary btn-sm open-modal" data-docdn="${data}">
                                        Lihat
                                    </a>`;
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

        $(document).on('click', '.open-modal', function (e) {
    e.preventDefault();

    var docDn = $(this).data('docdn');
    $('#modalDocDN').text(docDn);

    // Reset dropdown cycle
    $('#cycleNumber').val('');

    // Clear DataTable jika sudah pernah diinisialisasi
    if ($.fn.DataTable.isDataTable('#editModalTable')) {
        $('#editModalTable').DataTable().clear().draw();
    }

    // Tampilkan modal
    $('#editModal').modal({
        backdrop: 'static',
        keyboard: false
    });

    // Jangan panggil listdetail di sini!
});

$('#editModal').on('shown.bs.modal', function () {
    $('#scanResult').val('');
    $('#scanResult2').val('');
    $('#checkMark1').html('');
    $('#checkMark2').html('');
    scanStep = 1;
});

$('#resetScan').on('click', function () {
    $('#scanResult').val('');
    $('#scanResult2').val('');
    $('#checkMark1').html('');
    $('#checkMark2').html('');
    scanStep = 1;
});




$('#cycleNumber').on('change', function () {
    const selectedCycle = $(this).val();
    const selectedText = $(this).find('option:selected').text();
    $('#currentCycleText').text(selectedText); // Buat elemen ID ini di HTML

    const docDn = $('#modalDocDN').text();

    if (selectedCycle && docDn) {
        listdetail(docDn, selectedCycle);
    }
});



function listdetail(docDnValue, cycleField) {
    $('#editModalTable').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    autoWidth: false,
    responsive: true,
    pageLength: 5,
    order: [[0, 'desc']],
    dom: '<"d-flex justify-content-between align-items-center mb-2"lf>rt<"d-flex justify-content-between mt-2"ip>', 
    ajax: {
        url: "{{ route('listrekapd26.listdetail') }}",
        data: {
            doc_dn: docDnValue,
            cycle_field: cycleField
        }
    },
    columns: [
    {
        data: null,
        orderable: false,
        searchable: false,
        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    { data: 'part_no', name: 'part_no' },
    { data: 'job_no', name: 'job_no' },
    { data: 'qty', name: 'qty', className: "text-center" }, // ini kolom dinamis
],

    oLanguage: {
        sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}"> Loading...'
    }
});

} 




let qrScanner = null;
let scanStep = 1;
let isCameraRunning = false;

// Mulai kamera (hanya sekali)
function startScanner() {
    if (!qrScanner) {
        qrScanner = new Html5Qrcode("my-qr-reader");
    }

    qrScanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 200 },
        qrCodeMessage => {
            const selectedCycle = $('#cycleNumber').val();

            if (!selectedCycle) {
                $('#scanAlert').text('⚠️ Silakan pilih Cycle terlebih dahulu.');
                return;
            } else {
                $('#scanAlert').text(''); // Kosongkan alert jika sudah dipilih
            }

            if (scanStep === 1) {
                $('#scanResult').val(qrCodeMessage);
                $('#checkMark1').html('✅');
                scanStep = 2;
            } else if (scanStep === 2) {
                // Cek duplikat dengan scanResult 1
                if (qrCodeMessage === $('#scanResult').val()) {
                    $('#scanAlert').text('⚠️ QR Code sudah discan sebelumnya!');
                } else {
                    $('#scanResult2').val(qrCodeMessage);
                    $('#checkMark2').html('✅');
                }
            }
        },
        errorMessage => {
            // Tidak perlu tampilkan error terus-menerus
        }
    ).then(() => {
        isCameraRunning = true;
    }).catch(err => {
        console.error("Gagal nyalakan kamera:", err);
    });
}




        function stopScanner() {
            if (qrScanner && isCameraRunning) {
                qrScanner.stop().then(() => {
                    qrScanner.clear();
                    isCameraRunning = false;
                }).catch(err => {
                    console.error("Gagal matikan kamera:", err);
                });
            }
        }
        // Tombol: Nyalakan Kamera
        $('#startCameraBtn').on('click', function () {
            if (!isCameraRunning) {
                startScanner();
            }
        });
        // Tombol: Matikan Kamera
        $('#stopCameraBtn').on('click', function () {
            stopScanner();
        });
        // Tutup Modal: otomatis matikan kamera
        $('#editModal').on('hidden.bs.modal', function () {
            stopScanner();
        });

    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
