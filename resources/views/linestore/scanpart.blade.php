@extends('layouts.app')

@section('content')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #06b6d4;
            --primary-glow: rgba(6, 182, 212, 0.3);
            --secondary: #10b981;
            --secondary-glow: rgba(16, 185, 129, 0.3);
            --dark-bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --danger: #ef4444;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: #020617;
            /* Extra dark depth */
        }

        .content-header h1 {
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(to right, #040404ff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        /* Simplified Card Design (Fix Flickering) */
        .glass-card {
            background: #1e293b;
            /* Solid color to prevent backdrop-filter flicker */
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .glass-card:hover {
            border-color: var(--primary);
        }

        .card-header-premium {
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header-premium h6 {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0;
            font-size: 0.85rem;
        }

        /* Scanner Styling - Simplified */
        #my-qr-reader-container {
            width: 100%;
            max-width: 400px;
            /* Reduced from 450px to 400px */
            margin: auto;
            position: relative;
            padding: 10px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 1.5rem;
            border: 2px solid var(--primary);
        }

        #my-qr-reader {
            width: 100% !important;
            border: none !important;
            border-radius: 1rem;
            overflow: hidden !important;
        }

        /* Table Styling */
        .premium-table {
            width: 100%;
            color: var(--text-main);
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .premium-table thead th {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 1rem;
            letter-spacing: 0.05em;
        }

        .premium-table tbody tr {
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.2s ease;
        }

        .premium-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: scale(1.005);
        }

        .premium-table td {
            padding: 1rem;
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            vertical-align: middle;
        }

        .premium-table td:first-child {
            border-left: 1px solid var(--glass-border);
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        .premium-table td:last-child {
            border-right: 1px solid var(--glass-border);
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        /* Badges */
        .badge-premium {
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-subcont {
            background: rgba(139, 92, 246, 0.15);
            color: #a78bfa;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .badge-internal {
            background: rgba(6, 182, 212, 0.15);
            color: #22d3ee;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        /* Buttons */
        .btn-premium-send {
            background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 15px var(--secondary-glow);
            transition: all 0.3s ease;
        }

        .btn-premium-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--secondary-glow);
            filter: brightness(1.1);
        }

        .btn-remove {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.3rem 0.6rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-remove:hover {
            background: var(--danger);
            color: white;
        }

        /* Scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        /* Swal Dark Theme Override */
        .swal2-popup {
            background: #1e293b !important;
            color: white !important;
            border-radius: 1.5rem !important;
            border: 1px solid var(--glass-border) !important;
        }

        .swal2-input {
            background: rgba(0, 0, 0, 0.2) !important;
            color: white !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 0.75rem !important;
        }

        .swal2-title {
            color: var(--primary) !important;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0"><i class="ph-bold ph-qr-code mr-2"></i>Scan Pengambilan Part</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Scanner Section -->
                <div class="col-lg-4 mb-4">
                    <div class="glass-card h-100 p-4 d-flex flex-column justify-content-center">
                        <div class="text-center mb-4">
                            <span class="badge badge-premium badge-internal mb-2">Live Scanning</span>
                            <p class="text-muted small">Posisikan QR code ke dalam frame</p>
                        </div>

                        <div id="my-qr-reader-container">
                            <div id="my-qr-reader"></div>
                        </div>

                        <div id="you-qr-result" class="mt-4"></div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="col-lg-8">
                    <div class="glass-card h-100">
                        <div class="card-header-premium">
                            <h6><i class="ph-bold ph-list-bullets mr-2"></i>Data Hasil Scan</h6>
                            <span id="scan-counter" class="badge badge-premium badge-internal">0 Items</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive" style="max-height: 500px;">
                                <table id="scan-results" class="premium-table">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 5%;">No</th>
                                            <th>Uniq No</th>
                                            <th>Job No</th>
                                            <th>Part No</th>
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Qty +</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <!-- Data hasil scan ditambahkan di sini -->
                                    </tbody>
                                </table>
                            </div>

                            <div id="empty-state" class="text-center py-5">
                                <i class="ph-bold ph-database text-muted display-4 mb-3 d-block"></i>
                                <p class="text-muted">Belum ada data yang discan</p>
                            </div>

                            <div class="text-right mt-4 pt-3 border-top border-glass">
                                <button id="btnSendData" class="btn btn-premium-send">
                                    <i class="ph-bold ph-paper-plane-tilt mr-2"></i>Kirim Data Transaksi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MPS Planning Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="glass-card">
                        <div class="card-header-premium">
                            <h6><i class="ph-bold ph-calendar-check mr-2"></i>MPS Planning Schedule</h6>
                            <div class="d-flex align-items-center">
                                <label for="plan_date" class="mb-0 mr-3 text-muted small">Select Date:</label>
                                <input type="date" id="plan_date" class="form-control form-control-sm" 
                                       style="background: rgba(0,0,0,0.2); border: 1px solid var(--glass-border); color: white; border-radius: 0.5rem; width: 150px;"
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive" style="max-height: 500px;">
                                <table id="mps-table" class="premium-table">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 5%;">No</th>
                                            <th>Part Name</th>
                                            <th>Job No</th>
                                            <th>Part No</th>
                                            <th>Model</th>
                                            <th>Qty Plan</th>
                                            <th>Line Robot</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="mps-empty-state" class="text-center py-5">
                                <i class="ph-bold ph-calendar-blank text-muted display-4 mb-3 d-block"></i>
                                <p class="text-muted">Tidak ada jadwal planning untuk tanggal ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BOM Selection Modal -->
    <div class="modal fade" id="bomModal" tabindex="-1" role="dialog" aria-labelledby="bomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background: #1e293b; color: white; border-radius: 1.5rem; border: 1px solid var(--glass-border);">
                <div class="modal-header border-glass">
                    <h5 class="modal-title" id="bomModalLabel"><i class="ph-bold ph-tree-structure mr-2"></i>BOM Structure for Job: <span id="modal-job-no" class="text-primary"></span></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="bom-table" class="premium-table">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Uniq No</th>
                                    <th>Job No (Child)</th>
                                    <th>Part No</th>
                                    <th>Model</th>
                                    <th>Part Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencies -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function domReady(fn) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        domReady(function () {
            var resultsTable = document.getElementById('scan-results').getElementsByTagName('tbody')[0];
            var scanCount = 0;
            var isScanning = false;

            function updateCounter() {
                const total = resultsTable.querySelectorAll('tr').length;
                document.getElementById('scan-counter').innerText = `${total} Items`;
                document.getElementById('empty-state').style.display = total > 0 ? 'none' : 'block';
            }

            function playSuccessSound() {
                var audio = new Audio('/sound/success_sound.mp3');
                audio.play().catch(e => console.log('Audio play blocked'));
            }

            function onScanSuccess(decodedText) {
                if (isScanning) return;

                isScanning = true;
                playSuccessSound();

                let qrDataArray = decodedText.split('.');
                let dataToSend = {};
                let isSubcont = false;

                if (qrDataArray.length === 10) {
                    dataToSend = {
                        part_no2: qrDataArray[0],
                        job_no: qrDataArray[1],
                        qty: qrDataArray[2],
                        id_data: qrDataArray[3],
                        uniqNo: qrDataArray[4],
                        model: qrDataArray[5],
                        part_no: qrDataArray[6],
                        date: qrDataArray[7],
                        kodeMaterial: qrDataArray[8],
                        qty_ng: qrDataArray[9],
                        additional_qty: 0
                    };
                } else if (qrDataArray.length === 5) {
                    dataToSend = {
                        part_no: qrDataArray[0],
                        job_no: qrDataArray[1],
                        qty: qrDataArray[2],
                        id_data: qrDataArray[3],
                        uniqNo: qrDataArray[4],
                        additional_qty: 0
                    };
                    isSubcont = true;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Invalid',
                        text: 'QR Code format tidak dikenali!',
                        confirmButtonColor: '#ef4444'
                    });
                    isScanning = false;
                    return;
                }

                $.ajax({
                    url: "{{ route('getQtyActStmp') }}",
                    method: 'GET',
                    data: {
                        uniqNo: dataToSend.uniqNo,
                        part_no: dataToSend.part_no
                    },
                    success: function (response) {
                        if (response.success) {
                            const qtyAct = response.qty_act || 0;
                            dataToSend.qty = qtyAct;

                            const modalTitle = isSubcont
                                ? '📦 Data Pallet (Subcont)'
                                : '📦 Data Pallet (Internal)';

                            Swal.fire({
                                title: modalTitle,
                                html: `
                                            <div style="text-align:left; font-size: 1rem; color: #cbd5e1;">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Uniq No</span>
                                                    <span class="text-white font-weight-bold">${dataToSend.uniqNo}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Part No</span>
                                                    <span class="text-white font-weight-bold">${dataToSend.part_no}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3 border-bottom border-glass pb-2">
                                                    <span>Stok Tersedia</span>
                                                    <span style="color:#10b981; font-weight: 700; font-size: 1.25rem;">${dataToSend.qty}</span>
                                                </div>
                                                <label class="font-weight-600 mb-2">Quantity Pengambilan</label>
                                                <input type="number" id="inputAdditionalQty" class="swal2-input w-100 m-0" placeholder="0">
                                            </div>
                                        `,
                                showCancelButton: true,
                                confirmButtonText: '<i class="ph-bold ph-plus-circle mr-2"></i> Tambahkan',
                                cancelButtonText: 'Batal',
                                confirmButtonColor: '#06b6d4',
                                didOpen: () => {
                                    setTimeout(() => {
                                        document.getElementById('inputAdditionalQty').focus();
                                    }, 300);
                                },
                                preConfirm: () => {
                                    const val = document.getElementById('inputAdditionalQty').value;
                                    const additionalQty = parseInt(val);
                                    if (isNaN(additionalQty) || additionalQty <= 0) {
                                        Swal.showValidationMessage('⚠️ Masukkan jumlah pengambilan > 0');
                                        return false;
                                    }
                                    if (additionalQty > dataToSend.qty) {
                                        Swal.showValidationMessage(`❌ Melebihi sisa Stok (${dataToSend.qty})`);
                                        return false;
                                    }
                                    return additionalQty;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    dataToSend.additional_qty = result.value;

                                    const existingRows = resultsTable.querySelectorAll('tr');
                                    let isDuplicate = false;
                                    existingRows.forEach(row => {
                                        const cellUniqNo = row.cells[1]?.textContent?.trim();
                                        if (cellUniqNo === dataToSend.uniqNo) {
                                            isDuplicate = true;
                                        }
                                    });

                                    if (isDuplicate) {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Data Duplikat',
                                            text: `Peringatan: Uniq No "${dataToSend.uniqNo}" sudah ada di daftar.`,
                                            confirmButtonColor: '#06b6d4'
                                        });
                                        isScanning = false;
                                        return;
                                    }

                                    scanCount++;
                                    const rowId = `scan-row-${scanCount}`;
                                    const categoryBadge = isSubcont
                                        ? '<span class="badge badge-premium badge-subcont">Subcont</span>'
                                        : '<span class="badge badge-premium badge-internal">Internal</span>';

                                    const newRow = `
                                                <tr id="${rowId}" class="fade-in">
                                                    <td>${scanCount}</td>
                                                    <td class="font-weight-bold text-white">${dataToSend.uniqNo}</td>
                                                    <td>${dataToSend.job_no}</td>
                                                    <td>${dataToSend.part_no}</td>
                                                    <td>${dataToSend.model || '-'}</td>
                                                    <td class="text-muted">${dataToSend.qty}</td>
                                                    <td class="text-info font-weight-bold">${dataToSend.additional_qty}</td>
                                                    <td>${categoryBadge}</td>
                                                    <td>
                                                        <button class="btn btn-remove" onclick="removeRow('${rowId}')">
                                                            <i class="ph ph-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `;
                                    resultsTable.insertAdjacentHTML('beforeend', newRow);
                                    updateCounter();
                                }
                                isScanning = false;
                            }).catch(() => {
                                isScanning = false;
                            });

                        } else {
                            Swal.fire('Error', response.message || 'Gagal mengambil data dari server.', 'error');
                            isScanning = false;
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Koneksi ke server terputus.', 'error');
                        isScanning = false;
                    }
                });
            }

            document.getElementById('btnSendData').addEventListener('click', function () {
                let allRows = resultsTable.querySelectorAll('tr');
                if (allRows.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Daftar Kosong',
                        text: 'Belum ada data untuk dikirim.',
                        confirmButtonColor: '#06b6d4'
                    });
                    return;
                }

                let dataArray = [];
                allRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    dataArray.push({
                        uniqNo: cells[1].innerText,
                        job_no: cells[2].innerText,
                        part_no: cells[3].innerText,
                        model: cells[4].innerText,
                        qty: parseInt(cells[5].innerText),
                        additional_qty: parseInt(cells[6].innerText)
                    });
                });

                Swal.fire({
                    title: 'Konfirmasi Pengiriman',
                    text: `Kirim ${dataArray.length} item transaksi ke sistem?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Proses',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#10b981',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show Loading
                        Swal.fire({
                            title: 'Memproses...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        $.ajax({
                            url: "{{ route('scanbps.storeBatch') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: { data: dataArray },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Transaksi Berhasil',
                                        text: 'Semua data telah tercatat di sistem.',
                                        confirmButtonColor: '#10b981'
                                    });
                                    resultsTable.innerHTML = '';
                                    scanCount = 0;
                                    updateCounter();
                                } else {
                                    Swal.fire('Gagal', response.message, 'error');
                                }
                            },
                            error: function (xhr) {
                                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                            }
                        });
                    }
                });
            });

            window.removeRow = function (rowId) {
                const row = document.getElementById(rowId);
                if (row) {
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        row.remove();
                        updateCounter();
                    }, 300);
                }
            }

            function loadMpsData(date) {
                $.ajax({
                    url: "{{ route('scanbps.mpsData') }}",
                    method: 'GET',
                    data: { date: date },
                    success: function(response) {
                        const tbody = $('#mps-table tbody');
                        tbody.empty();
                        
                        if (response.success && response.data.length > 0) {
                            $('#mps-empty-state').hide();
                            response.data.forEach((item, index) => {
                                const statusBadge = item.status == 1 
                                    ? '<span class="badge badge-success">Active</span>' 
                                    : '<span class="badge badge-secondary">Inactive</span>';
                                    
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.part_name || '-'}</td>
                                        <td class="font-weight-bold text-white">${item.job_no}</td>
                                        <td>${item.part_no}</td>
                                        <td>${item.model_id || '-'}</td>
                                        <td class="text-info font-weight-bold">${item.qty_plan}</td>
                                        <td>${item.line_robot || '-'}</td>
                                        <td>${statusBadge}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="openBomModal('${item.job_no}')">
                                                <i class="ph ph-list-plus"></i> Process
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tbody.append(row);
                            });
                        } else {
                            $('#mps-empty-state').show();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal memuat data planning.', 'error');
                    }
                });
            }

            window.openBomModal = function(jobNo) {
                $('#modal-job-no').text(jobNo);
                $('#bom-table tbody').empty();
                $('#bomModal').modal('show');
                
                $.ajax({
                    url: "{{ route('scanbps.bomData') }}",
                    method: 'GET',
                    data: { job_no: jobNo },
                    success: function(response) {
                        if (response.success) {
                            const tbody = $('#bom-table tbody');
                            response.data.forEach((item, index) => {
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td class="text-white font-weight-bold">${item.uniqNo}</td>
                                        <td>${item.part_no2}</td>
                                        <td>${item.part_no2}</td>
                                        <td>${item.model || '-'}</td>
                                        <td>${item.part_name2 || '-'}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="addToScanResultsFromBom('${item.uniqNo}', '${item.part_no2}', '${item.part_no2}', '${item.model}')">
                                                <i class="ph ph-plus-circle"></i> Add
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tbody.append(row);
                            });
                        }
                    }
                });
            }

            window.addToScanResultsFromBom = function(uniqNo, partNo, jobNo, model) {
                $.ajax({
                    url: "{{ route('getQtyActStmp') }}",
                    method: 'GET',
                    data: {
                        uniqNo: uniqNo,
                        part_no: partNo
                    },
                    success: function (response) {
                        if (response.success) {
                            const qtyAct = response.qty_act || 0;
                            
                            Swal.fire({
                                title: '📦 Add Part from BOM',
                                html: `
                                    <div style="text-align:left; font-size: 1rem; color: #cbd5e1;">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Uniq No</span>
                                            <span class="text-white font-weight-bold">${uniqNo}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Part No</span>
                                            <span class="text-white font-weight-bold">${partNo}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3 border-bottom border-glass pb-2">
                                            <span>Stok Tersedia</span>
                                            <span style="color:#10b981; font-weight: 700; font-size: 1.25rem;">${qtyAct}</span>
                                        </div>
                                        <label class="font-weight-600 mb-2">Quantity Pengambilan</label>
                                        <input type="number" id="inputBomQty" class="swal2-input w-100 m-0" placeholder="0">
                                    </div>
                                `,
                                showCancelButton: true,
                                confirmButtonText: 'Tambahkan',
                                confirmButtonColor: '#06b6d4',
                                preConfirm: () => {
                                    const val = document.getElementById('inputBomQty').value;
                                    const qty = parseInt(val);
                                    if (isNaN(qty) || qty <= 0) {
                                        Swal.showValidationMessage('Masukkan jumlah > 0');
                                        return false;
                                    }
                                    if (qty > qtyAct) {
                                        Swal.showValidationMessage(`Melebihi stok (${qtyAct})`);
                                        return false;
                                    }
                                    return qty;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const additional_qty = result.value;
                                    
                                    // Check duplicate
                                    let isDuplicate = false;
                                    $('#scan-results tbody tr').each(function() {
                                        if ($(this).find('td:eq(1)').text().trim() === uniqNo) {
                                            isDuplicate = true;
                                        }
                                    });

                                    if (isDuplicate) {
                                        Swal.fire('Warning', 'Data sudah ada di daftar.', 'warning');
                                        return;
                                    }

                                    scanCount++;
                                    const rowId = `scan-row-${scanCount}`;
                                    const newRow = `
                                        <tr id="${rowId}">
                                            <td>${scanCount}</td>
                                            <td class="font-weight-bold text-white">${uniqNo}</td>
                                            <td>${jobNo}</td>
                                            <td>${partNo}</td>
                                            <td>${model || '-'}</td>
                                            <td class="text-muted">${qtyAct}</td>
                                            <td class="text-info font-weight-bold">${additional_qty}</td>
                                            <td><span class="badge badge-premium badge-internal">BOM</span></td>
                                            <td>
                                                <button class="btn btn-remove" onclick="removeRow('${rowId}')">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    `;
                                    $('#scan-results tbody').append(newRow);
                                    updateCounter();
                                    $('#bomModal').modal('hide');
                                    Swal.fire('Success', 'Part ditambahkan ke daftar scan.', 'success');
                                }
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }

            $('#plan_date').on('change', function() {
                loadMpsData($(this).val());
            });

            // Initial load for today
            loadMpsData($('#plan_date').val());

            var htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                fps: 25,
                qrbox: { width: 250, height: 250 }, /* Reduced from 300 to 250 */
                aspectRatio: 1.0
            });

            htmlScanner.render(onScanSuccess);
            updateCounter();
        });
    </script>
@endsection

