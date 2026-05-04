@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --secondary: #64748b;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --background: #f1f5f9; /* Darker slate background */
        --surface: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --border: #e2e8f0;
        --radius: 12px;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --green-gradient: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        font-size: 0.875rem;
        background-color: var(--background) !important;
        color: var(--text-main);
    }

    .content-wrapper {
        background-color: var(--background) !important;
    }

    /* Modern Card Styling */
    .card {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        background: var(--surface);
        margin-bottom: 1.5rem;
    }
    .card-header {
        background: transparent;
        border-bottom: 1px solid var(--border);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--text-main);
        margin-bottom: 0;
    }

    /* Modern Table Design */
    .table-container {
        padding: 0;
        border-radius: var(--radius);
        overflow: hidden;
    }
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead th {
        background: #f1f5f9;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 0.75rem 1rem;
        border-bottom: 2px solid var(--border);
        border-top: none;
    }
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
        color: var(--text-main);
    }
    .table-hover tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    /* Modal Wide Layout */
    .modal-xl {
        max-width: 98% !important;
        margin: 10px auto;
    }

    /* DataTable Scroll Fixes */
    .dataTables_scrollHeadInner,
    .dataTables_scrollHeadInner table {
        width: 100% !important;
        margin: 0 !important;
    }
    .dataTables_scrollBody {
        border-top: none !important;
    }

    /* Import Section Refinement */
    .import-zone {
        background: #f1f5f9;
        border: 2px dashed var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        transition: all 0.2s;
    }
    .import-zone:hover {
        border-color: var(--primary);
        background: #eff6ff;
    }

    /* Button Refinement */
    .btn-custom {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
    }
    .btn-primary-custom {
        background: var(--primary);
        color: white;
    }
    .btn-primary-custom:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        color: white;
    }
    .btn-outline-custom {
        background: white;
        border: 1px solid var(--border);
        color: var(--text-main);
    }
    .btn-outline-custom:hover {
        background: #f1f5f9;
        border-color: var(--secondary);
    }

    /* Modal Modernization */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
    }
    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 16px 16px 0 0;
    }
    .modal-title {
        font-weight: 800;
        color: var(--text-main);
    }

    /* Utility */
    .badge-modern {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        border-radius: 6px;
    }

    /* Works Overview Integration */
    .overview-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        background: #ffffff;
        margin-bottom: 2rem;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    .overview-header {
        padding: 1.25rem 2rem;
        background: var(--green-gradient);
        border-bottom: 1px solid #bbf7d0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .overview-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #065f46;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .icon-circle-lg {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0; /* Removed margin auto */
        flex-shrink: 0;
    }
    .stat-value {
        margin-bottom: 0.25rem;
    }
    .stat-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Updated Soft Background Colors for Green Theme */
    .bg-soft-primary { background-color: #f0fdf4; color: #10b981; }
    .bg-soft-warning { background-color: #fffbeb; color: #fbbf24; }
    .bg-soft-success { background-color: #f0fdf4; color: #10b981; }
    .bg-soft-danger { background-color: #fef2f2; color: #ef4444; }

    .badge-soft-success { background-color: #f0fdf4; color: #10b981; border: 1px solid #dcfce7; }
    .badge-soft-primary { background-color: #f0fdf4; color: #10b981; border: 1px solid #dcfce7; }

    /* Refined Legend & Activity UI */
    .chart-legend-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 0.5rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
    }
    .chart-legend-item {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
        transition: all 0.2s;
    }
    .chart-legend-item:hover { color: var(--text-main); }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
        box-shadow: 0 0 0 2px #fff, 0 0 0 3px rgba(0,0,0,0.05);
    }

    .activity-list { padding: 0.5rem; }
    .activity-item {
        position: relative;
        padding-left: 24px;
        padding-bottom: 1.25rem;
        border-left: 2px solid #e2e8f0;
        margin-left: 8px;
    }
    .activity-item:last-child { border-left-color: transparent; padding-bottom: 0; }
    .activity-dot {
        position: absolute;
        left: -7px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary);
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px #e2e8f0;
    }
    .activity-content { padding-left: 8px; }
    .activity-time { font-size: 0.7rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 2px; display: block; }
    .activity-text { font-size: 0.85rem; font-weight: 600; color: var(--text-main); display: block; text-decoration: none !important; }
    .activity-text:hover { color: var(--primary); }

    /* Tim Prepare Styling */
    .tim-prepare-container {
        margin-top: 0.5rem;
        padding: 0.6rem 0.8rem;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
    }
    .tim-prepare-header {
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #475569;
        letter-spacing: 0.05em;
        margin-bottom: 0.6rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tim-team-label {
        font-size: 0.75rem;
        font-weight: 800;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
        text-align: center;
    }
    .tim-member-grid {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        gap: 10px;
        width: 100%;
    }
    .tim-member {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        flex: 1;
    }
    .tim-member img {
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .tim-member span {
        font-size: 0.95rem;
        font-weight: 800;
        color: #1e293b;
        white-space: nowrap;
    }
    .tim-member .badge {
        font-size: 0.85rem;
        padding: 4px 8px;
        border-radius: 6px;
        background: #fff;
        color: #1e293b;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .border-right-lg {
        border-right: 1px solid #e2e8f0;
    }
    @media (max-width: 991.98px) {
        .border-right-lg { border-right: none; }
    }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-sm-6">
        <h1 class="m-0 font-weight-bold" style="color: #0f172a; letter-spacing: -0.025em;">REKAP ORDER TOYOTA</h1>
        <p class="text-muted mb-0">Manage and upload your rekap orders with arrival schedules.</p>
      </div>
      <div class="col-sm-6 text-right">
        <span class="badge badge-soft-success p-2">
            <i class="far fa-calendar-alt mr-1"></i> Today: {{ date('d M Y') }}
        </span>
      </div>
    </div>
  </div>
</div>
  <section class="content">
    <div class="container-fluid py-3">
        <!-- Works Overview Widget -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12">
                <div class="overview-card">
                    <div class="overview-header">
                        <h5 class="overview-title">Works Overview</h5>
                        <div class="d-flex align-items-center">
                            <label for="cycleArrivalFilter" class="mr-2 mb-0 font-weight-bold text-dark" style="font-size: 0.9rem;">Filter Date:</label>
                            <input type="date" id="cycleArrivalFilter" class="form-control form-control-sm" style="width: auto;">
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Stats Column -->
                            <div class="col-lg-5 border-right-lg">
                                <div class="row">
                                    <!-- Stats Row 1: Total & Done Not Scan -->
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-item d-flex align-items-center">
                                            <div class="icon-circle-lg bg-soft-primary mr-3">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="text-left">
                                                <div class="stat-label">Total work orders</div>
                                                <div id="total_work_orders" class="stat-value">0</div>
                                                <div class="small text-muted font-weight-bold">
                                                    <i class="fas fa-chart-bar mr-1"></i> Orders
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-item d-flex align-items-center">
                                            <div class="icon-circle-lg bg-soft-danger mr-3" style="background: #fef2f2; color: #ef4444;">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div class="text-left">
                                                <div class="stat-label">Done not scan</div>
                                                <div id="not_scanned_count" class="stat-value">0</div>
                                                <div class="small text-muted font-weight-bold">
                                                    <i class="fas fa-info-circle mr-1"></i> Waiting
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stats Row 2: Estimated & Approved -->
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-item d-flex align-items-center">
                                            <div class="icon-circle-lg bg-soft-warning mr-3">
                                                <i class="fas fa-pause"></i>
                                            </div>
                                            <div class="text-left">
                                                <div class="stat-label">Estimated Kanban</div>
                                                <div id="estimated_kanban" class="stat-value">0</div>
                                                <div class="small text-muted font-weight-bold">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="stat-item d-flex align-items-center">
                                            <div class="icon-circle-lg bg-soft-success mr-3">
                                                <i class="fas fa-check-double"></i>
                                            </div>
                                            <div class="text-left">
                                                <div class="stat-label">Approved works</div>
                                                <div id="approved_works_count" class="stat-value">0</div>
                                                <div class="small text-muted font-weight-bold">
                                                    <i class="fas fa-check mr-1"></i> Done
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tim Prepare Section Moved Below Stats -->
                                    <div class="col-md-12">
                                        <div class="tim-prepare-container">
                                            <div class="tim-prepare-header">
                                                <i class="fas fa-users"></i> TIM PREPARE
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-6 pr-2 border-right">
                                                    <span class="tim-team-label">PALLET BESI</span>
                                                    <div class="tim-member-grid">
                                                        <div class="tim-member">
                                                            <span>Ajun <span id="count_Ajun" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                        </div>
                                                        <div class="tim-member">
                                                            <span>Fikri <span id="count_Fikri" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-2">
                                                    <span class="tim-team-label text-center">PALLET BOX</span>
                                                    <div class="tim-member-grid">
                                                        <div class="tim-member">
                                                            <span>Abi <span id="count_Abi" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                        </div>
                                                        <div class="tim-member">
                                                            <span>Emif <span id="count_Emif" class="badge badge-light border ml-1">0</span></span>
                                                            <img src="sbadmin/img/undraw_profile.svg" alt="User Avatar" width="40" height="40" class="rounded-circle mr-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart Column -->
                            <div class="col-lg-4 border-right-lg mt-4 mt-lg-0">
                                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row">
                                    <div style="position: relative; height: 240px; width: 240px;">
                                        <canvas id="worksOverviewChart"></canvas>
                                        <div id="chartCenterText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                                            <div id="chartPercent" style="font-size: 3rem; font-weight: 800; color: #1e293b; line-height: 1;">0%</div>
                                            <div style="font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Done</div>
                                        </div>
                                    </div>
                                    <div class="ml-sm-4 mt-3 mt-sm-0 chart-legend-container">
                                        <!-- Legend generated by JS -->
                                    </div>
                                </div>
                            </div>

                            <!-- Activity List Column -->
                            <div class="col-lg-3 mt-4 mt-lg-0">
                                <div class="activity-list">
                                    <h6 class="text-uppercase text-muted font-weight-bold mb-4" style="font-size: 0.7rem; letter-spacing: 0.1em; opacity: 0.8;">Recent Actions</h6>

                                    <div class="activity-item">
                                        <div class="activity-dot shadow-sm" style="background-color: var(--info);"></div>
                                        <div class="activity-content">
                                            <span class="activity-time">1 Days Ago</span>
                                            <a href="#" class="activity-text">Prepare Estimate</a>
                                        </div>
                                    </div>

                                    <div class="activity-item">
                                        <div class="activity-dot shadow-sm" style="background-color: var(--primary);"></div>
                                        <div class="activity-content">
                                            <span class="activity-time">2 Days Ago</span>
                                            <a href="#" class="activity-text">Review Documentation</a>
                                        </div>
                                    </div>

                                    <div class="activity-item">
                                        <div class="activity-dot shadow-sm" style="background-color: var(--warning);"></div>
                                        <div class="activity-content">
                                            <span class="activity-time">Action Needed</span>
                                            <a href="#" class="activity-text" style="color: var(--warning) !important;">Identify Planner</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Upload & Database</h3>
                        <div class="card-tools">
                            <form id="importForm" action="{{ route('importRekap') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <div class="import-zone mr-3 py-1 px-3 d-flex align-items-center">
                                    <i class="fas fa-file-excel text-success mr-2"></i>
                                    <input type="file" id="fileInput" name="file" class="form-control-file" style="width: auto;" required>
                                </div>
                                <button id="importButton" class="btn btn-primary-custom btn-custom" type="submit" disabled>
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>Import DN
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="60">No</th>
                                        <th>Tanggal Upload</th>
                                        <th>Schedule Arrival 1</th>
                                        <th>Schedule Arrival 2</th>
                                        <th>Arrival 3 (Misc)</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data dinamis -->
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
        <div class="modal-header d-flex justify-content-between align-items-center">
          <div>
              <h4 class="modal-title" id="title1"><i class="fas fa-file-invoice text-primary mr-2"></i>LIST ITEM DN</h4>
              <h4 class="modal-title" id="title2"><i class="fas fa-file-invoice text-primary mr-2"></i>LIST ITEM DN</h4>
          </div>
          <button type="button" class="btn btn-outline-custom btn-custom shadow-sm" data-dismiss="modal" aria-label="Close">
              <i class="fas fa-times mr-2"></i>Close
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-12" id="alert"></div>
                <div class="col-sm-6 d-flex align-items-center">
                    <button id="saveChanges" class="btn btn-primary-custom btn-custom shadow-sm mr-2">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <button id="btn_export_pdf" class="btn btn-outline-custom btn-custom shadow-sm">
                        <i class="fas fa-file-pdf text-danger mr-2"></i>Export PDF
                    </button>
                </div>
                <div class="col-sm-6 d-flex justify-content-end">
                    <div class="d-flex align-items-center bg-white border rounded px-3 py-1 shadow-sm" style="min-width: 200px;">
                        <div class="text-center mr-3 pr-3 border-right">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Total Data</div>
                            <div id="summary_total_data" class="h5 mb-0 font-weight-bold text-primary">-</div>
                        </div>
                        <div class="text-center">
                            <div class="text-muted small text-uppercase font-weight-bold" style="font-size: 10px;">Cycle 1-9 (Qty 0)</div>
                            <div id="summary_zero_qty" class="h5 mb-0 font-weight-bold text-danger">-</div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        <div class="table-responsive p-0">
            <table id="example2" class="table table-hover table-bordered mb-0" style="width:100%; border-collapse: collapse !important; margin-top: -1px !important;">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">NO DN</th>
                            <th rowspan="2" class="align-middle">PART NAME</th>
                            <th rowspan="2" class="align-middle">PART NO</th>
                            <th rowspan="2" class="align-middle">JOB NO</th>
                            <th rowspan="2" class="align-middle">Cycle Date</th>
                            <th rowspan="2" class="align-middle">QTY KANBAN</th>
                            <th colspan="9" class="p-1">QTY PER CYCLE</th>
                            <th rowspan="2" class="align-middle">Action</th>
                        </tr>
                        <tr id="cycle-detail-row">
                            @for ($i = 1; $i <= 9; $i++)
                            <th class="p-2" style="background: #f8fafc !important; border-bottom: 2px solid var(--primary) !important;">
                                <span class="d-block mb-1 text-muted small font-weight-bold">Cycle {{ $i }}</span>
                                <button type="button" class="btn btn-xs btn-outline-primary btn-block btn-cycle-detail shadow-sm" data-cycle="{{ $i }}">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data tabel akan diisi di sini -->
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
<!-- Small Modal Detail Cycle -->
<div class="modal fade" id="cycleDetailModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-danger text-white py-2">
                <h6 class="modal-title font-weight-bold"><i class="fas fa-sync-alt mr-2"></i>Reset Cycle Qty</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <div id="cycleDetailContent" class="text-center">
                    <p class="mb-3 font-weight-bold">Reset Qty Order for Cycle <span id="targetCycleNum"></span></p>
                    <form id="resetCycleForm">
                        <input type="hidden" id="resetCycleInput">
                        <div class="form-group">
                            <input type="password" class="form-control text-center" id="resetPassword" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control text-center" id="resetConfirm" placeholder="Type 'RESET' to overwrite">
                        </div>
                        <button type="submit" class="btn btn-danger btn-block font-weight-bold shadow-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>RESET CYCLE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal PDF Preview (Print View style) -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-xl" style="max-width: 90% !important;">
        <div class="modal-content shadow-lg border-0" style="height: 90vh;">
            <div class="modal-header bg-dark text-white py-2 d-flex justify-content-between align-items-center">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-file-pdf mr-2"></i>PREVIEW REKAP ORDER</h5>
                <div>
                    <button id="modalDownloadPdf" class="btn btn-success btn-sm mr-2 shadow-sm"><i class="fas fa-download mr-1"></i>Download PDF</button>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body p-0 bg-secondary position-relative" style="height: calc(100% - 40px);">
                <iframe id="pdfPreviewFrame" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="created_at">
@endsection

@push('scripts')
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
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
        var worksOverviewChart;
        $(document).ready(function() {
            // Set default date to today
            var today = new Date().toISOString().split('T')[0];
            $('#cycleArrivalFilter').val(today);

            // --- Works Overview Donut Chart ---
            var ctx = document.getElementById('worksOverviewChart').getContext('2d');
            worksOverviewChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 75,
                    legend: { display: false },
                    tooltips: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleFontColor: '#1e293b',
                        bodyFontColor: '#475569',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true,
                        cornerRadius: 8
                    },
                    animation: { animateScale: true, animateRotate: true }
                }
            });

            // Initial Load
            updateChart();
            list();

            // Update on filter change
            $('#cycleArrivalFilter').on('change', function() {
                updateChart();
            });
        });

        function updateChart() {
            var cycleArrivalDate = $('#cycleArrivalFilter').val();
            $.ajax({
                url: "{{ route('uploadrekap.getChartData') }}",
                method: "GET",
                data: { cycle_arrival_date: cycleArrivalDate },
                success: function(response) {
                    if(response.success) {
                        // Update Chart
                        worksOverviewChart.data.labels = response.labels;
                        worksOverviewChart.data.datasets[0].data = response.data;
                        worksOverviewChart.data.datasets[0].backgroundColor = response.colors;
                        worksOverviewChart.update();

                        // Update Center Text
                        $('#chartPercent').text(response.percentage + '%');

                        // Update Team Counts
                        if (response.team_counts) {
                            Object.keys(response.team_counts).forEach(member => {
                                $(`#count_${member}`).text(response.team_counts[member]);
                            });
                        }

                        // Update Legend
                        var legendHtml = '';
                        response.labels.forEach((label, index) => {
                            var color = response.colors[index];
                            var value = response.data[index];
                            legendHtml += `
                                <div class="chart-legend-item">
                                    <span class="legend-dot" style="background-color: ${color};"></span>
                                    <span>${label}: <strong>${value}</strong></span>
                                </div>
                            `;
                        });
                        $('.chart-legend-container').html(legendHtml);

                        // Update Stats
                        $('#total_work_orders').text(response.total_works || 0);
                        $('#not_scanned_count').text(response.not_scanned_count || 0);
                        $('#estimated_kanban').text(response.pending_works || 0);
                        $('#approved_works_count').text(response.approved_works || 0);
                    }
                }
            });
        }

        function list(){
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                order: [[1, 'desc']],
                ajax: {
                    url: "{{ route('uploadrekap.list') }}"
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
                    { data: 'created_at', name: 'created_at' },
                    { data: 'arrival1', name: 'arrival1' },
                    { data: 'arrival2', name: 'arrival2' },
                    { data: 'arrival3', name: 'arrival3' },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data) {
                            return '<div class="d-flex justify-content-center">'+
                                '<a href="#" id="btn_edit" title="Edit" data-id="'+data+'" class="btn btn-primary btn-sm btn-custom text-white mr-2">'+
                                '<i class="fas fa-search"></i>'+
                                '</a>'+
                                '<a href="#" id="btn_delete" title="Delete" data-id="'+data+'" class="btn btn-outline-danger btn-sm btn-custom">'+
                                    '<i class="far fa-trash-alt"></i>'+
                                    '</a>'+
                                '</div>';
                        }
                    }
                ],
                columnDefs: [{ "targets": [0, 2], "orderable": false }],
                oLanguage: {
                    sProcessing: '<img src="{{asset('dist/img/Hourglass.gif')}}">Loading . . .'
                }
            });
        }

        function listdetail(){
            var table = $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 20,
                scrollX: true,
                scrollCollapse: true,
                orderCellsTop: true,
                ajax: {
                    url: "{{ route('uploadrekap.listdetail') }}",
                    data: { created_at: $('#created_at').val() }
                },
                columns: [
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'manifest', name: 'manifest' },
                    { data: 'part_name', name: 'part_name' },
                    { data: 'part_no', name: 'part_no' },
                    { data: 'uniqNo', name: 'uniqNo' },
                    {
                        data: 'cycle_arrival',
                        name: 'cycle_arrival',
                        render: function(data, type, row) {
                            if (!data) return '';
                            const date = new Date(data);
                            const today = new Date();
                            date.setHours(0,0,0,0);
                            today.setHours(0,0,0,0);

                            let cls = '';
                            if (date.getTime() === today.getTime()) {
                                cls = 'bg-soft-success';
                            } else if (date < today) {
                                cls = 'bg-soft-danger';
                            }

                            return `<div class="${cls}" style="padding: 4px; border-radius: 4px; font-weight: 600;">${data}</div>`;
                        }
                    },
                    { data: 'qty_kanban', name: 'qty_kanban' },
                    {
                        data: 'cycle1',
                        name: 'cycle1',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 1 && row.cycle != '1') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle2',
                        name: 'cycle2',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 2 && row.cycle != '2') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle3',
                        name: 'cycle3',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 3 && row.cycle != '3') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle4',
                        name: 'cycle4',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 4 && row.cycle != '4') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle5',
                        name: 'cycle5',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 5 && row.cycle != '5') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle6',
                        name: 'cycle6',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 6 && row.cycle != '6') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle7',
                        name: 'cycle7',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 7 && row.cycle != '7') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle8',
                        name: 'cycle8',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 8 && row.cycle != '8') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 16px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'cycle9',
                        name: 'cycle9',
                        className: 'text-center p-1',
                        render: function(d, type, row){
                            if(row.cycle != 9 && row.cycle != '9') return '';
                            let tp = (row.type_pallet || '').toUpperCase();
                            let cls = tp == 'BOX' ? 'cycle-box-box' : (tp == 'BESI' ? 'cycle-box-besi' : '');
                            let op = d > 0 ? `<div style="font-weight: 800; font-size: 16px;">${d}</div>` : '';
                            let cp = row.createdby ? `<div class="created-by-tag" style="font-size: 20px; color: #28a745; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i>${row.createdby}</div>` : '';
                            return `<div class="cycle-box ${cls}">${op}${(op && cp ? `<hr style="margin: 2px 0; width: 100%; border-top: 1px solid #ccc;">` : '')}${cp}</div>`;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `<a href="#" id="btn_pdf" title="Generate" data-id="${data}" class="btn btn-info btn-xs shadow-sm"><i class="fas fa-qrcode"></i></a>`;
                        }
                    },
                ],
                columnDefs: [{ "targets": [0, 15], "orderable": false }],
                oLanguage: {
                    sProcessing: '<img src="{{asset('dist/img/Hourglass.gif')}}">Loading . . .'
                }
            });
            $('#myModal2').on('shown.bs.modal', function () { table.columns.adjust(); });
        }

        function fetchSummary(createdAt) {
            $.ajax({
                url: "{{ route('uploadrekap.getSummary') }}",
                method: "GET",
                data: { created_at: createdAt },
                success: function(response) {
                    if(response.success) {
                        $('#summary_total_data').text(response.total_data);
                        $('#summary_zero_qty').text(response.zero_qty_count);
                    }
                }
            });
        }

        // --- Event Listeners ---
        $(document).on("click", "#btn_edit", function() {
            $("#title1").hide();
            $("#title2").show();
            var id = $(this).data('id');
            $('#created_at').val(id);
            fetchSummary(id);
            listdetail();
            $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
        });

        $(document).on("click", ".btn-cycle-detail", function(e) {
            e.stopPropagation();
            var cycle = $(this).data('cycle');
            $('#targetCycleNum').text(cycle);
            $('#resetCycleInput').val(cycle);
            $('#resetPassword').val('');
            $('#resetConfirm').val('');
            $('#cycleDetailModal').modal('show');
        });

        $(document).on("click", "#btn_export_pdf", function() {
            var createdAt = $('#created_at').val();
            if (!createdAt) {
                Swal.fire({ icon: 'warning', title: 'Warning', text: 'No record selected!' });
                return;
            }
            var previewUrl = "{{ route('uploadrekap.exportPdf') }}?created_at=" + encodeURIComponent(createdAt);
            $('#pdfPreviewFrame').attr('src', previewUrl);
            $('#pdfPreviewModal').modal('show');
        });

        $('#modalDownloadPdf').on('click', function() {
            var createdAt = $('#created_at').val();
            window.location.href = "{{ route('uploadrekap.exportPdf') }}?created_at=" + encodeURIComponent(createdAt) + "&download=1";
        });

        $('#resetCycleForm').on('submit', function(e) {
            e.preventDefault();
            var cycle = $('#resetCycleInput').val();
            var password = $('#resetPassword').val();
            var confirmText = $('#resetConfirm').val();
            var createdAt = $('#created_at').val();

            if (password !== '572') {
                Swal.fire({ icon: 'error', title: 'Access Denied', text: 'Incorrect Password!', timer: 1500, showConfirmButton: false });
                return;
            }
            if (confirmText !== 'RESET') {
                Swal.fire({ icon: 'warning', title: 'Invalid Confirmation', text: 'Please type "RESET" to confirm.', timer: 1500, showConfirmButton: false });
                return;
            }

            $.ajax({
                url: "{{ route('uploadrekap.resetCycle') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", cycle: cycle, created_at: createdAt },
                success: function(response) {
                    $('#cycleDetailModal').modal('hide');
                    if(response.success) {
                        Swal.fire({ icon: 'success', title: 'Success', text: response.msg }).then(() => {
                            fetchSummary(createdAt);
                            listdetail();
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Failed', text: response.msg });
                    }
                }
            });
        });

        $(document).on("click", "#btn_delete", function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this record will permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('uploadrekap.destroy')}}",
                        data: {created_at: id,  _token: '{{csrf_token()}}'},
                        success: function(result) {
                            Swal.fire({ icon: result.success ? 'success' : 'error', title: result.success ? 'Deleted!' : 'Error', text: result.msg, timer: 1500, showConfirmButton: false });
                            list();
                        }
                    });
                }
            })
        });

        $('#saveChanges').on('click', function() {
            let dataToSend = [];
            $('.actual-sheet').each(function() {
                dataToSend.push({ id: $(this).data('id'), actual_sheet: $(this).val() });
            });
            $.ajax({
                url: "{{ route('uploadrekap.update') }}",
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", data: dataToSend },
                success: function() { Swal.fire({ title: 'Sukses!', text: 'Data diperbarui.', icon: 'success', timer: 1500, showConfirmButton: false }); },
                error: function(xhr, status, error) { Swal.fire({ title: 'Error!', text: error, icon: 'error' }); }
            });
        });

        document.getElementById('fileInput').addEventListener('change', function () {
            document.getElementById('importButton').disabled = !this.files.length;
        });

        document.getElementById('importForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Import data sekarang?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'Ya, impor!'
            }).then((result) => { if (result.isConfirmed) this.submit(); });
        });

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('success') }}', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal', text: '{{ session('error') }}', toast: true, position: 'top-end', showConfirmButton: false, timer: 5000 });
        @endif
    </script>
@endpush

@push('stylesheets')
<style>
    .centered-text {
      text-align: center;
  }


  tr:nth-child(even) {
    background-color:
    #efefeff8

  ;
  }

    .cycle-box {
        padding: 5px;
        border-radius: 6px;
        min-width: 70px;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .cycle-box-box {
        background-color: #e3f2fd !important; /* Light blue smooth */
        color: #1565c0 !important;
    }
    .cycle-box-besi {
        background-color: #212121 !important; /* Black smooth */
        color: #fafafa !important;
    }
    .cycle-box-besi hr {
        border-top-color: rgba(255,255,255,0.2) !important;
    }
    .cycle-box-besi .created-by-tag {
        color: #4ade80 !important; /* Brighter green for dark bg */
    }
  </style>
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush


