@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --success-color: #1cc88a;
        --danger-color: #e74a3b;
        --background-bg: #f8f9fc;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    body {
        background-color: var(--background-bg);
        font-family: 'Nunito', sans-serif;
    }

    .main-container {
        padding: 2rem;
    }

    /* Table Card */
    .table-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border: none;
        height: 100%;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e3e6f0;
        background: #fff;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .table-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Scanner Card */
    .scanner-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        border: none;
        transition: transform 0.2s;
        /* Turunkan dikit sesuai request */
        margin-top: 3rem;
    }

    .scanner-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        text-align: center;
        color: white;
    }

    .scanner-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 1px;
    }

    .scanner-header p {
        margin-top: 0.5rem;
        opacity: 0.8;
        font-size: 0.9rem;
    }

    .scanner-body {
        padding: 2rem;
    }

    /* Input Stylish */
    .input-group-modern {
        position: relative;
        margin-bottom: 2rem;
    }

    .input-modern {
        width: 100%;
        padding: 1.2rem 1.5rem;
        padding-left: 3.5rem;
        border: 2px solid #e3e6f0;
        border-radius: 1rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        background: #f8f9fc;
        color: #5a5c69;
    }

    .input-modern:focus {
        border-color: var(--primary-color);
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .input-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #d1d3e2;
        font-size: 1.5rem;
        transition: color 0.3s;
    }

    .input-modern:focus + .input-icon {
        color: var(--primary-color);
    }

    /* Result Card (Shopping Cart Style) */
    .result-card {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        animation: slideUp 0.4s ease-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .result-icon {
        width: 60px;
        height: 60px;
        background: rgba(28, 200, 138, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--success-color);
        font-size: 1.8rem;
        margin-right: 1.5rem;
    }

    .result-details {
        flex: 1;
    }

    .result-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #858796;
        letter-spacing: 0.5px;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .result-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2e59d9;
        margin-bottom: 0;
    }

    .result-meta {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #5a5c69;
    }

    .meta-tag {
        background: #f1f3f9;
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        color: #b7b9cc;
        padding: 2rem;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* History Section within Scanner */
    .history-section {
        margin-top: 2rem;
    }

    .history-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #858796;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-left: 0.5rem;
    }

    .history-list {
        list-style: none;
        padding: 0;
        /* Scrollable logic: approx height for 10 items */
        max-height: 500px;
        overflow-y: auto;
    }

    .history-item {
        background: white;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border-radius: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }

    .history-item:hover {
        transform: translateX(5px);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .d-none { display: none !important; }

    /* Animation Classes */
    .row-success {
        background-color: #1cc88a !important;
        color: #fff !important;
        transition: all 0.5s ease;
    }

    .row-success td, .row-success span, .row-success small {
        color: #fff !important;
    }

    .row-fade-out {
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.5s ease;
    }
</style>

<div class="main-container">
    <div class="row">
        <!-- LEFT COLUMN: Table Data -->
        <div class="col-md-8">
            <div class="table-card">
                <div class="table-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-list-alt mr-2"></i> Pending Items (TagLabelWelding)</h5>
                    <span class="badge badge-primary badge-pill" id="pending_count">{{ $waitingItems->count() }} Items</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="height: calc(100vh - 180px); overflow-y: auto;">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="sticky-top">Part No</th>
                                    <th class="sticky-top">Job No</th>
                                    <th class="sticky-top">Qty</th>
                                    <th class="sticky-top">Unique No</th>
                                    <th class="sticky-top">Created At</th>
                                </tr>
                            </thead>
                            <tbody id="pending_table_body">
                                @forelse($waitingItems as $item)
                                <tr id="row-{{ $item->uniqNo }}">
                                    <td><span class="font-weight-bold text-dark">{{ $item->part_no }}</span></td>
                                    <td>{{ $item->job_no }}</td>
                                    <td>{{ $item->qty_act }}</td>
                                    <td><small class="text-muted">{{ $item->uniqNo }}</small></td>
                                    <td><small>{{ $item->created_at->format('d M Y H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i><br>
                                        No pending items found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Scanner -->
        <div class="col-md-4">
            <!-- Main Scanner Card -->
            <div class="scanner-card">
                <div class="scanner-header">
                    <h1><i class="fas fa-barcode mr-2"></i>Scanner Pro</h1>
                    <p>Scan part barcode to record entry</p>
                </div>

                <div class="scanner-body">

                    <!-- Input Area -->
                    <div class="input-group-modern">
                        <input type="text" id="scan_input" class="input-modern" placeholder="Tap here to scan..." autofocus autocomplete="off">
                        <i class="fas fa-qrcode input-icon"></i>
                    </div>

                    <!-- Dynamic Result Area -->
                    <div id="result_container">
                        <!-- Empty State -->
                        <div class="empty-state" id="empty_state">
                            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                            <p>Ready to scan. Waiting for input...</p>
                        </div>

                        <!-- Success Result (Template) -->
                        <div class="result-card d-none" id="success_card">
                            <div class="result-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="result-details">
                                <div class="result-title">Item Recorded</div>
                                <h2 class="result-value" id="res_part_no">--</h2>
                                <div class="result-meta">
                                    <span class="meta-tag"><i class="fas fa-hashtag mr-1"></i> <span id="res_job_no">--</span></span>
                                    <span class="meta-tag"><i class="fas fa-cubes mr-1"></i> Qty: <span id="res_qty">--</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Error Result (Template) -->
                        <div class="result-card d-none" id="error_card" style="border-color: #e74a3b;">
                            <div class="result-icon" style="background: rgba(231, 74, 59, 0.1); color: #e74a3b;">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="result-details">
                                <div class="result-title" style="color: #e74a3b;">Error</div>
                                <h4 class="result-value" style="color: #5a5c69; font-size: 1.1rem;" id="err_msg">Invalid Barcode</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 text-center">
                        <button class="btn btn-light text-secondary btn-sm rounded-pill px-4" id="clear_btn">
                            <i class="fas fa-redo-alt mr-1"></i> Reset Scanner
                        </button>
                    </div>

                </div>
            </div>

            <!-- Recent History -->
            <div class="history-section d-none" id="history_section" data-has-items="{{ $todaysScans->count() > 0 ? 'true' : 'false' }}">
                <h3 class="history-title">Session History (Today)</h3>

                <!-- Search Input -->
                <div class="input-group mb-3">
                    <input type="text" id="history_search" class="form-control" placeholder="Search history..." style="border-radius: 20px;">
                    <div class="input-group-append" style="position: absolute; right: 10px; top: 7px; z-index: 10;">
                        <i class="fas fa-search text-muted"></i>
                    </div>
                </div>

                <ul class="history-list" id="history_list">
                    @foreach($todaysScans as $history)
                    <li class="history-item">
                        <div class="history-info">
                            <strong style="font-size: 1.1rem; color: #4e73df;">{{ $history->part_no }}</strong><br>
                            <span class="text-dark">{{ $history->job_no }}</span> <span class="text-muted">| {{ $history->uniqNo }}</span>
                        </div>
                        <div class="history-time" style="font-weight: bold; color: #858796;">
                            {{ $history->created_at->format('H:i') }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Fallback if sweetalert2 in layout is missing/commented out -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('scan_input');
        const emptyState = document.getElementById('empty_state');
        const successCard = document.getElementById('success_card');
        const errorCard = document.getElementById('error_card');

        // Fields
        const resPart = document.getElementById('res_part_no');
        const resJob = document.getElementById('res_job_no');
        const resQty = document.getElementById('res_qty');
        const errMsg = document.getElementById('err_msg');

        // History
        const historySection = document.getElementById('history_section');
        const historyList = document.getElementById('history_list');

        // Show history if data exists on load
        if (historySection.getAttribute('data-has-items') === 'true') {
            historySection.classList.remove('d-none');
        }

        let isProcessing = false;

        // Auto focus
        if(input) {
            input.focus();
            document.addEventListener('click', () => {
                if (document.activeElement !== document.getElementById('history_search')) {
                    input.focus();
                }
            });

            // Handle Input
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (isProcessing) return;

                    const value = input.value.trim();
                    if (value) {
                        processScan(value);
                    }
                }
            });
        }

        // History Search
        const historySearch = document.getElementById('history_search');
        if (historySearch) {
            historySearch.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const items = historyList.getElementsByTagName('li');

                Array.from(items).forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Polling for Pending Items
        setInterval(fetchPendingItems, 5000);

        function fetchPendingItems() {
            // Jangan update jika sedang ada animasi row (opsional) atau user sedang interaksi
            // Untuk simple-nya, kita hajar saja update html-nya
            fetch("{{ route('scaninpswelding2.pending') }}") // Pastikan route ini ada
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('pending_table_body');
                const badge = document.getElementById('pending_count');

                if (tbody && data.html) {
                    // Update hanya jika berbeda (opsional, tapi timpa aja langsung gpp)
                    // Note: This resets any local animation state.
                    // To be safe, we might only check count or do diffing, but user asked for simple update.

                    // Check if we are currently animating a removal?
                    // If yes, maybe skip update? Or update and re-apply animation?
                    // Simplified: Just update content.
                    tbody.innerHTML = data.html;
                }
                if (badge && data.count !== undefined) {
                    badge.innerText = data.count + ' Items';
                }
            })
            .catch(err => console.error('Polling error:', err));
        }

        if(document.getElementById('clear_btn')) {
            document.getElementById('clear_btn').addEventListener('click', function() {
                resetUI();
                input.value = '';
                input.focus();
            });
        }

        function resetUI() {
            successCard.classList.add('d-none');
            errorCard.classList.add('d-none');
            emptyState.classList.remove('d-none');
        }

        function showLoading() {
            emptyState.innerHTML = '<div class="spinner-border text-primary" role="status"></div><p class="mt-2">Verifying...</p>';
        }

        function restoreEmpty() {
            emptyState.innerHTML = '<div class="empty-icon"><i class="fas fa-box-open"></i></div><p>Ready to scan. Waiting for input...</p>';
        }

        function processScan(code) {
            isProcessing = true;
            resetUI();
            emptyState.classList.remove('d-none'); // Show empty state as loader container
            showLoading();

            fetch("{{ route('scaninpswelding2.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                restoreEmpty();
                emptyState.classList.add('d-none');

                if (data.success) {
                    showSuccess(data.data);
                    addToHistory(data.data);
                    // Optional: Reload table to remove scanned item from pending list?
                    // For now, we leave it as is, user can refresh page.
                } else {
                    showError(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                restoreEmpty();
                emptyState.classList.add('d-none');
                showError("Network Error. Please try again.");
            })
            .finally(() => {
                input.value = '';
                input.focus();
                isProcessing = false;
            });
        }

        function showSuccess(data) {
            // Populate
            resPart.innerText = data.part_no || 'N/A';
            resJob.innerText = data.job_no || 'N/A';
            resQty.innerText = data.qty_act || '0';

            // Reduce Badge Count
            const badge = document.querySelector('.badge-primary');
            if (badge) {
                const currentCount = parseInt(badge.innerText) || 0;
                if (currentCount > 0) badge.innerText = (currentCount - 1) + ' Items';
            }

            // Remove Row from Table with Animation
            if (data.uniqNo) {
                const row = document.getElementById('row-' + data.uniqNo);
                if (row) {
                    const tbody = row.parentNode;
                    // Get current index among rows
                    const rowsArr = Array.from(tbody.children);
                    const rowIndex = rowsArr.indexOf(row);

                    // Logic: Jika data di bawah (index >= 5), naikkan dulu.
                    // Jika di atas (index < 5), hilingkan langsung di tempat.
                    if (rowIndex >= 1) {
                        // 1. Pindahkan ke paling atas
                        tbody.prepend(row);

                        // 2. Scroll ke paling atas
                        const tableContainer = document.querySelector('.table-responsive');
                        if(tableContainer) tableContainer.scrollTop = 0;
                    }

                    // 3. Ubah warna jadi hijau (Highlight) pakai Class
                    // Gunakan sedikit delay agar perpindahan DOM (jika ada) selesai dirender
                    requestAnimationFrame(() => {
                        row.classList.add('row-success');
                    });

                    // 4. Hilangkan setelah jeda
                    setTimeout(() => {
                        row.classList.remove('row-success');
                        row.classList.add('row-fade-out');

                        // Hapus dari DOM setelah animasi fade selesai
                        setTimeout(() => row.remove(), 500);
                    }, 1000); // Tahan 1 detik
                }
            }

            // SweetAlert Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: 'Data Saved & Removed from List'
            });
        }

        function showError(message) {
            errMsg.innerText = message;
            errorCard.classList.remove('d-none');
        }

        function addToHistory(data) {
            historySection.classList.remove('d-none');

            const li = document.createElement('li');
            li.className = 'history-item';
            // Animation for new item
            li.style.animation = 'slideUp 0.4s ease-out';

            li.innerHTML = `
                <div class="history-info">
                    <strong style="font-size: 1.1rem; color: #4e73df;">${data.part_no}</strong><br>
                    <span class="text-dark">${data.job_no}</span> <span class="text-muted">| ${data.uniqNo}</span>
                </div>
                <div class="history-time" style="font-weight: bold; color: #858796;">
                    ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                </div>
            `;

            historyList.prepend(li);
        }
    });
</script>
@endpush
