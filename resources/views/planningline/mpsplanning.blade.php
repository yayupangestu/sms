@extends('layouts.app')

@section('content')
  <style>
    .centered-text {
      text-align: center;
    }


    tr:nth-child(even) {
      background-color:
        #efefeff8;
    }

    .machine-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(85px, 1fr));
      gap: 12px;
      margin-top: 5px;
      max-height: 150px;
      overflow-y: auto;
      padding: 15px;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      background: #f8f9fa;
    }

    .box-item {
      cursor: pointer;
      border: 1px solid #ced4da;
      border-radius: 6px;
      padding: 10px 5px;
      text-align: center;
      font-size: 13px;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      background: #fff;
      color: #495057;
      font-weight: 500;
    }

    .box-item:hover {
      border-color: #0d6efd;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(13, 110, 253, 0.15);
      color: #0d6efd;
    }

    .box-item.active {
      background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;
      color: white !important;
      border-color: #0a58ca !important;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(13, 110, 253, 0.4);
      transform: translateY(-2px);
    }

    .line-selector {
      display: flex;
      gap: 12px;
      margin-bottom: 20px;
    }

    .line-box {
      flex: 1;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 15px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .line-box i {
      font-size: 24px;
      margin-bottom: 8px;
      color: #64748b;
      transition: all 0.3s;
    }

    .line-box small {
      display: block;
      font-weight: 700;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .line-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      border-color: #38bdf8;
    }

    .line-box.active {
      background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
      border-color: #0ea5e9;
    }

    .line-box.active i,
    .line-box.active small {
      color: #fff;
    }

    .line-box.active i {
      transform: scale(1.1);
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    .card-header-custom {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      border-bottom: 3px solid #0ea5e9;
      color: white;
      padding: 15px 20px;
    }

    .main-title {
      font-size: 20px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #fff;
      display: flex;
      align-items: center;
    }

    .main-title i {
      color: #38bdf8;
      text-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
    }

    .modal-header-custom {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      border-bottom: 2px solid #0ea5e9;
      padding: 15px 25px;
    }

    .card-header-custom {
      background: linear-gradient(90deg, #1e293b 0%, #334155 100%);
      color: white;
      border-bottom: 2px solid #0ea5e9;
    }

    .status-card {
      border-radius: 12px;
      cursor: pointer;
      overflow: hidden;
      position: relative;
      background: #fff;
      border: 1px solid #f1f5f9;
      transition: all 0.3s;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .status-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .status-card.active {
      border: 2px solid #0ea5e9 !important;
      background: #f0f9ff !important;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05) !important;
    }

    .status-all.active {
      border: 2px solid #334155 !important;
      background: #f8fafc !important;
    }

    .status-all .icon-box {
      background: linear-gradient(135deg, #334155 0%, #0f172a 100%);
      box-shadow: 0 4px 10px rgba(15, 23, 42, 0.4);
    }

    .status-robot::before {
      background: #0ea5e9;
    }

    .status-robot .icon-box {
      background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
      box-shadow: 0 4px 10px rgba(14, 165, 233, 0.4);
    }

    .status-manual .icon-box {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      box-shadow: 0 4px 10px rgba(245, 158, 11, 0.4);
    }

    .status-ssw .icon-box {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      box-shadow: 0 4px 10px rgba(16, 185, 129, 0.4);
    }

    .status-ssw h4 {
      color: #10b981;
      font-size: 28px;
      line-height: 1;
    }

    .status-ssw.active {
      border: 2px solid #10b981 !important;
      background: #f0fff4;
    }

    .btn-action {
      border-radius: 6px;
      width: 30px;
      height: 30px;
      padding: 0;
      line-height: 30px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .icon-box {
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .badge-line {
      font-size: 11px;
      padding: 6px 14px;
      border-radius: 4px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table-custom-main thead th {
      background: #f1f5f9;
      color: #475569;
      border-bottom: 2px solid #e2e8f0;
      font-weight: 800;
      font-size: 13px;
      padding: 15px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .table-custom-main tbody td {
      font-size: 16px;
      vertical-align: middle !important;
      color: #1e293b;
      padding: 12px;
      border-bottom: 1px solid #f1f5f9;
    }

    .table-custom-main tbody tr:hover {
      background-color: #f8fafc !important;
      box-shadow: inset 4px 0 0 #0ea5e9;
      transform: scale(1.001);
    }

    .resume-header {
      background: #0f172a;
      border-bottom: 2px solid #0ea5e9;
      padding: 15px 25px;
    }

    .total-badge {
      background: rgba(14, 165, 233, 0.1);
      border: 1px solid rgba(14, 165, 233, 0.3);
      border-radius: 6px;
      padding: 5px 15px;
      color: #38bdf8;
      font-weight: 700;
      font-size: 12px;
      text-transform: uppercase;
    }

    @media (min-width: 1200px) {
      .modal-xl-custom {
        max-width: 95% !important;
      }
    }

    .performance-card {
      background: #0f172a;
      color: #fff;
      border-radius: 12px;
      padding: 15px;
      height: 100%;
      border: 1px solid #1e293b;
    }

    .stat-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 5px solid #1e293b;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
      position: relative;
    }

    .stat-circle::after {
      content: '';
      position: absolute;
      top: -5px;
      left: -5px;
      right: -5px;
      bottom: -5px;
      border-radius: 50%;
      border: 5px solid transparent;
      border-top-color: #0ea5e9;
      transform: rotate(45deg);
    }

    .stat-value {
      font-size: 20px;
      font-weight: 800;
    }

    .performance-item {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 10px;
      border-left: 3px solid transparent;
    }

    .perf-robot {
      border-left-color: #0ea5e9;
    }

    .perf-manual {
      border-left-color: #f59e0b;
    }

    .perf-ssw {
      border-left-color: #10b981;
    }

    .progress-thin {
      height: 4px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 2px;
      margin-top: 5px;
    }

    .sidebar-list-item {
      background: rgba(255, 255, 255, 0.03);
      border-radius: 6px;
      padding: 12px;
      margin-bottom: 8px;
      border-left: 4px solid #38bdf8;
      transition: all 0.2s;
      width: 100%;
      box-sizing: border-box;
    }

    .sidebar-list-item:hover {
      background: rgba(255, 255, 255, 0.08);
      border-left-color: #0ea5e9;
    }

    .sidebar-job-no {
      font-size: 16px;
      font-weight: 800;
      color: #fff;
    }

    .sidebar-qty-val {
      font-size: 18px;
      font-weight: 800;
      color: #38bdf8;
    }
  </style>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0">Production Monitoring MPS</h1>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div>
  </div>

  <section class="content" style="background-color: rgb(130, 129, 129)">
    {{-- <div class="container-fluid" style="background-image: url(dist/img/wave.svg)"> --}}
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header card-header-custom d-flex align-items-center">
              <h3 class="main-title mb-0">
                <i class="fa fa-robot mr-3"></i> PRODUCTION MONITORING MPS
              </h3>
              <div class="card-tools ml-auto">
                <button class="btn btn-success btn-sm px-3 shadow-sm font-weight-bold" id="btn_add">
                  <i class="fa fa-plus mr-1"></i> ADD NEW PLAN
                </button>
              </div>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-custom-main w-100">
                <thead>
                  <tr>
                    <th width="60" class="text-center">NO</th>
                    <th class="text-center">PLANNING DATE</th>
                    <th width="150" class="text-center">MANAGEMENT CONTROL</th>
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
    <div class="modal-dialog modal-xl modal-xl-custom">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-header modal-header-custom p-3">
          <h4 class="modal-title text-white font-weight-bold" id="title1"><i
              class="fa fa-tachometer-alt mr-2 text-info"></i> PRODUCTION PLANNING MPS MONITORING</h4>
          <h4 class="modal-title text-white font-weight-bold" id="title2"><i class="fa fa-edit mr-2 text-warning"></i>
            UPDATE PRODUCTION PLAN - MPS MONITORING</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light p-3">
          <div class="row">
            <!-- Left Content: Form & Resume -->
            <div class="col-md-8">
              <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                <div class="card-body p-3">
                  <div class="form-group row mb-0">
                    <div class="col-12" id="alert"></div>

                    <div class="col-sm-12 mb-2">
                      <div class="line-selector" style="margin-bottom: 5px;">
                        <div class="line-box p-1" data-value="ROBOT RSW">
                          <i class="fa fa-robot mb-0" style="font-size: 1.2rem;"></i><br><small>LINE ROBOT</small>
                        </div>
                        <div class="line-box p-1" data-value="PSW MANUAL">
                          <i class="fa fa-cogs mb-0" style="font-size: 1.2rem;"></i><br><small>LINE MANUAL</small>
                        </div>
                        <div class="line-box p-1" data-value="SSW">
                          <i class="fa fa-industry mb-0" style="font-size: 1.2rem;"></i><br><small>LINE SSW</small>
                        </div>
                      </div>
                      <input type="hidden" id="line_id" required>
                      <input type="hidden" id="status" required>
                    </div>

                    <div class="col-sm-12 mb-3">
                      <div class="row align-items-center">
                        <label class="col-sm-1 col-form-label font-weight-bold text-secondary text-left">Date :</label>
                        <div class="col-sm-3">
                          <input type="hidden" id="id" class="form-control" required>
                          <input type="date" id="date_plan" class="form-control" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12 mb-3">
                      <div class="row">
                        <label class="col-sm-1 col-form-label font-weight-bold text-secondary text-left">Machine :</label>
                        <div class="col-sm-11">
                          <div id="machine_container" class="machine-grid p-2 bg-white">
                            <div class="text-muted text-center w-100 py-1"><small><i class="fa fa-info-circle"></i> Please
                                select a Line above first</small></div>
                          </div>
                          <input type="hidden" id="machine" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12 mb-3">
                      <div class="row align-items-center">
                        <label class="col-sm-1 col-form-label font-weight-bold text-secondary text-left">Part :</label>
                        <div class="col-sm-7">
                          <select style="width: 100%;" id="part_no" class="form-control select2" required>
                            <option value="" selected>- pilih part -</option>
                            @foreach ($data_weldings as $part)
                              <option value="{{ $part->id }}">{{ $part->job_no }} | {{ $part->part_no }} |
                                {{ $part->part_name }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <label class="col-sm-1 col-form-label font-weight-bold text-secondary text-right">Qty :</label>
                        <div class="col-sm-1">
                          <input type="number" id="qty_plan" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-sm-2">
                          <button type="button" class="btn btn-primary shadow-sm Save w-100"><i class="fa fa-save"></i>
                            Save</button>
                          <button type="button" class="btn btn-warning shadow-sm Update text-white w-100"
                            style="display:none;"><i class="fa fa-edit"></i> Update</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 12px;">
                <div class="resume-header d-flex align-items-center">
                  <h5 class="mb-0 text-white font-weight-bold"><i class="fa fa-chart-pie mr-2 text-warning"></i> RESUME
                    PLANNING</h5>
                  <div class="ml-auto">
                    <div class="total-badge" id="total_qty_plan">Total Qty: 0</div>
                  </div>
                </div>
                <div class="card-body bg-white p-2">
                  <div class="row no-gutters">
                    <div class="col-md-3 px-1">
                      <div class="card status-card status-all mb-1 border-0 shadow-none" onclick="filterByStatus(null)">
                        <div class="card-body p-2">
                          <div class="d-flex align-items-center">
                            <div class="icon-box mr-3" style="width: 32px; height: 32px;">
                              <i class="fa fa-list-ul text-white fa-xs"></i>
                            </div>
                            <div>
                              <h4 class="mb-0 font-weight-bold" id="count_all">0</h4>
                              <small class="text-muted text-uppercase font-weight-bold"
                                style="font-size: 9px; letter-spacing: 0.5px;">All Categories</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="card status-card status-robot mb-1 border-0 shadow-none" onclick="filterByStatus(1)">
                        <div class="card-body p-2">
                          <div class="d-flex align-items-center">
                            <div class="icon-box mr-3" style="width: 32px; height: 32px;">
                              <i class="fa fa-robot text-white fa-xs"></i>
                            </div>
                            <div>
                              <h4 class="mb-0 font-weight-bold" id="count_robot">0</h4>
                              <small class="text-muted text-uppercase font-weight-bold"
                                style="font-size: 9px; letter-spacing: 0.5px;">Robot Line</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="card status-card status-manual mb-1 border-0 shadow-none" onclick="filterByStatus(2)">
                        <div class="card-body p-2">
                          <div class="d-flex align-items-center">
                            <div class="icon-box mr-3" style="width: 32px; height: 32px;">
                              <i class="fa fa-hand-paper text-white fa-xs"></i>
                            </div>
                            <div>
                              <h4 class="mb-0 font-weight-bold" id="count_manual">0</h4>
                              <small class="text-muted text-uppercase font-weight-bold"
                                style="font-size: 9px; letter-spacing: 0.5px;">Manual Line</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="card status-card status-ssw mb-1 border-0 shadow-none" onclick="filterByStatus(3)">
                        <div class="card-body p-2">
                          <div class="d-flex align-items-center">
                            <div class="icon-box mr-3" style="width: 32px; height: 32px;">
                              <i class="fa fa-industry text-white fa-xs"></i>
                            </div>
                            <div>
                              <h4 class="mb-0 font-weight-bold" id="count_ssw">0</h4>
                              <small class="text-muted text-uppercase font-weight-bold"
                                style="font-size: 9px; letter-spacing: 0.5px;">SSW Line</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <table id="example2" class="table table-hover table-bordered table-striped w-100">
                        <thead class="thead-dark">
                          <tr>
                            <th width="50">No</th>
                            <th>Job No</th>
                            <th>Part NO</th>
                            <th>Model</th>
                            <th>Qty</th>
                            <th>Line</th>
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

            <!-- Right Sidebar: Performance Monitoring -->
            <div class="col-md-4 mb-3">
              <div class="performance-card shadow-lg">
                <div class="d-flex align-items-center mb-4">
                  <i class="fa fa-bolt text-warning mr-2"></i>
                  <h6 class="mb-0 font-weight-bold text-uppercase" style="letter-spacing: 1px;">Live Performance</h6>
                </div>

                <div class="text-center mb-4">
                  <div class="stat-circle">
                    <span class="stat-value" id="overall_perf">0%</span>
                  </div>
                  <small class="text-muted text-uppercase">Overall Efficiency</small>
                </div>

                <div class="performance-item perf-robot">
                  <div class="d-flex justify-content-between mb-1">
                    <small class="font-weight-bold">ROBOT LINE</small>
                    <small class="text-info" id="perf_robot_val">0%</small>
                  </div>
                  <div class="progress-thin">
                    <div class="progress-bar bg-info progress-bar-glow" id="perf_robot_bar" style="width: 0%"></div>
                  </div>
                </div>

                <div class="performance-item perf-manual">
                  <div class="d-flex justify-content-between mb-1">
                    <small class="font-weight-bold">MANUAL LINE</small>
                    <small class="text-warning" id="perf_manual_val">0%</small>
                  </div>
                  <div class="progress-thin">
                    <div class="progress-bar bg-warning progress-bar-glow" id="perf_manual_bar" style="width: 0%"></div>
                  </div>
                </div>

                <div class="performance-item perf-ssw">
                  <div class="d-flex justify-content-between mb-1">
                    <small class="font-weight-bold">SSW LINE</small>
                    <small class="text-success" id="perf_ssw_val">0%</small>
                  </div>
                  <div class="progress-thin">
                    <div class="progress-bar bg-success progress-bar-glow" id="perf_ssw_bar" style="width: 0%"></div>
                  </div>
                </div>

                <div class="mt-4 pt-3 border-top border-secondary">
                  <div class="row text-center no-gutters mb-3">
                    <div class="col-4 border-right border-secondary">
                      <small class="text-muted d-block" style="font-size: 9px;">TARGET</small>
                      <h5 class="mb-0 font-weight-bold text-info" id="total_target">0</h5>
                    </div>
                    <div class="col-4 border-right border-secondary">
                      <small class="text-muted d-block" style="font-size: 9px;">ACTUAL</small>
                      <h5 class="mb-0 font-weight-bold text-success" id="total_actual">0</h5>
                    </div>
                    <div class="col-4">
                      <small class="text-muted d-block" style="font-size: 9px;">BALANCE</small>
                      <h5 class="mb-0 font-weight-bold text-danger" id="total_balance">0</h5>
                    </div>
                  </div>

                  <div id="sidebar_list_section" style="display: none;">
                    <h6 class="text-muted small text-uppercase font-weight-bold mb-3 border-bottom border-secondary pb-2"
                      style="font-size: 11px; letter-spacing: 1px;">
                      <i class="fa fa-list mr-2 text-info"></i> <span id="sidebar_list_title">Details</span>
                    </h6>
                    <div id="sidebar_list_content" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
                      <!-- Items will be injected here -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
    <script>
      $(document).ready(function () {
        list();

        // Handle Line Selection
        $(document).on('click', '.line-box', function () {
          $('.line-box').removeClass('active');
          $(this).addClass('active');
          var line = $(this).data('value');
          $('#line_id').val(line);

          var status = 0;
          if (line === 'ROBOT RSW') {
            status = 1;
          } else if (line === 'PSW MANUAL') {
            status = 2;
          } else if (line === 'SSW') {
            status = 3;
          }
          $('#status').val(status);

          renderMachines(line);
        });

        // Handle Machine Selection
        $(document).on('click', '.box-item', function () {
          // Since we probably only want one machine at a time for planning
          $('.box-item').removeClass('active');
          $(this).addClass('active');
          $('#machine').val($(this).data('value'));
          listdetail();
        });

        function renderMachines(line) {
          var container = $('#machine_container');
          container.empty();
          $('#machine').val('');

          var prefix = '';
          var count = 0;
          var format = '';

          if (line === 'ROBOT RSW') {
            prefix = 'ROBOT-';
            count = 22;
          } else if (line === 'PSW MANUAL') {
            prefix = 'PSW-M';
            count = 20;
          } else if (line === 'SSW') {
            prefix = 'SSW-';
            count = 20;
          }

          if (count > 0) {
            for (var i = 1; i <= count; i++) {
              var val = prefix + i;
              container.append('<div class="box-item" data-value="' + val + '">' + val + '</div>');
            }
          } else {
            container.append('<div class="text-muted text-center w-100">No machines found</div>');
          }
        }
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
            url: "{{ route('mpsplanning.list') }}"
          },
          columns: [{
            data: null,
            sortable: false,
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
              return '<div class="text-center font-weight-bold" style="color: #64748b;">' + (meta.row + meta.settings._iDisplayStart + 1) + '</div>';
            }
          },
          {
            data: 'date_plan',
            name: 'date_plan',
            render: function (data) {
              return '<div class="text-center py-2"><div class="d-inline-flex align-items-center px-4 py-2" style="background: #e0f2fe; color: #0369a1; border-radius: 50px; font-weight: 800; font-size: 16px; border: 1px solid #bae6fd;"><i class="fa fa-calendar-alt mr-3"></i>' + data + '</div></div>';
            }
          },
          {
            data: 'mix_id',
            name: 'mix_id',
            render: function (data) {
              return '<div class="text-center">' +
                '<a href="#" id="btn_edit" title="Control Center" data-id="' + data + '" class="btn btn-info btn-sm shadow-sm px-4 py-2 mr-2" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); border: none; border-radius: 8px;">' +
                '<i class="fas fa-desktop mr-2"></i> MONITORING' +
                '</a>' +
                '<a href="#" id="btn_delete" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm shadow-sm px-3 py-2" style="background: #ef4444; border: none; border-radius: 8px;">' +
                '<i class="far fa-trash-alt"></i>' +
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
            url: "{{ route('mpsplanning.listdetail') }}",
            data: function (d) {
              d.date_plan = $('#date_plan').val();
              d.line_id = $('#machine').val();
              d.status_filter = window.currentStatusFilter;
            }
          },
          columns: [{
            data: null,
            sortable: false,
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
              return '<div class="text-center font-weight-bold" style="color: #64748b;">' + (meta.row + meta.settings._iDisplayStart + 1) + '</div>';
            }
          },
          {
            data: 'job_no',
            name: 'job_no',
            render: function (data) {
              return '<div class="d-flex align-items-center"><div style="width: 3px; height: 20px; background: #0ea5e9; margin-right: 10px; border-radius: 2px;"></div><span class="font-weight-bold" style="color: #0f172a; font-size: 16px; letter-spacing: -0.5px;">' + data + '</span></div>';
            }
          },
          {
            data: 'part_no',
            name: 'part_no',
            render: function (data, type, row) {
              return '<div class="font-weight-bold" style="color: #334155;">' + data + '</div><div class="text-muted" style="font-size: 11px; font-weight: 500; text-transform: uppercase;">' + row.part_name + '</div>';
            }
          },
          {
            data: 'model',
            name: 'model',
            render: function (data) {
              return '<div class="text-center"><span class="badge badge-light border font-weight-bold px-2 py-1" style="color: #475569; background: #f8fafc;">' + data + '</span></div>';
            }
          },
          {
            data: 'qty_plan',
            name: 'qty_plan',
            render: function (data) {
              return '<div class="text-center"><span class="badge px-3 py-1" style="font-size: 15px; font-weight: 800; background: #1e293b; color: #38bdf8; border-radius: 6px;">' + data + '</span></div>';
            }
          },
          {
            data: 'line_id',
            name: 'line_id',
            render: function (data, type, row) {
              var badgeStyle = 'background: #f1f5f9; color: #64748b;';
              if (row.status == 1) badgeStyle = 'background: #e0f2fe; color: #0369a1; border-left: 3px solid #0ea5e9;';
              else if (row.status == 2) badgeStyle = 'background: #fef3c7; color: #b45309; border-left: 3px solid #f59e0b;';
              else if (row.status == 3) badgeStyle = 'background: #dcfce7; color: #15803d; border-left: 3px solid #10b981;';

              return '<div class="text-center"><span class="badge badge-line shadow-sm" style="' + badgeStyle + '">' + data + '</span></div>';
            }
          },
          {
            data: 'id',
            name: 'id',
            render: function (data) {
              return '<div class="d-flex justify-content-center">' +
                '<a href="#" id="btn_edit_line" title="Edit" data-id="' + data + '" class="btn btn-warning btn-sm btn-action text-white mr-1" style="background: #f59e0b; border: none;">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a href="#" id="btn_delete_line" title="Delete" data-id="' + data + '" class="btn btn-danger btn-sm btn-action" style="background: #ef4444; border: none;">' +
                '<i class="far fa-trash-alt"></i>' +
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
          },
          drawCallback: function (settings) {
            var json = settings.json;
            if (json) {
              $('#count_all').text((json.robot_count || 0) + (json.manual_count || 0) + (json.ssw_count || 0));
              $('#count_robot').text(json.robot_count || 0);
              $('#count_manual').text(json.manual_count || 0);
              $('#count_ssw').text(json.ssw_count || 0);
              $('#total_qty_plan').text('Total Qty: ' + (json.total_qty || 0));

              // Performance Calculations (Example Logic)
              var targetDaily = 2000; // Placeholder target
              var overall = Math.min(Math.round((json.total_qty / targetDaily) * 100), 100);
              $('#overall_perf').text(overall + '%');
              $('#total_target').text(targetDaily);

              // Per line performance
              var robotPerf = Math.min(Math.round((json.robot_count * 100) / 10), 100); // 10 plans as target
              var manualPerf = Math.min(Math.round((json.manual_count * 100) / 10), 100);
              var sswPerf = Math.min(Math.round((json.ssw_count * 100) / 10), 100);

              $('#perf_robot_val').text(robotPerf + '%');
              $('#perf_robot_bar').css('width', robotPerf + '%');
              $('#perf_manual_val').text(manualPerf + '%');
              $('#perf_manual_bar').css('width', manualPerf + '%');
              $('#perf_ssw_val').text(sswPerf + '%');
              $('#perf_ssw_bar').css('width', sswPerf + '%');

              // Update Balance
              var balance = Math.max(targetDaily - json.total_qty, 0);
              $('#total_balance').text(balance);

              // Update Sidebar List if filtered
              updateSidebarList(json.data);
            }
          }
        });
      }

      function updateSidebarList(data) {
        var content = '';
        var section = $('#sidebar_list_section');

        if (window.currentStatusFilter) {
          section.fadeIn();
          var title = window.currentStatusFilter === 1 ? 'Robot Line Items' : (window.currentStatusFilter === 2 ? 'Manual Line Items' : 'SSW Line Items');
          $('#sidebar_list_title').text(title);

          if (data && data.length > 0) {
            data.forEach(function (item) {
              content += '<div class="sidebar-list-item">' +
                '<div class="d-flex justify-content-between align-items-start mb-2">' +
                '<div class="sidebar-job-no">' + item.job_no + '</div>' +
                '<div class="text-right">' +
                '<div class="sidebar-qty-val">' + item.qty_plan + '</div>' +
                '<div class="text-muted" style="font-size: 15px;">PLAN</div>' +
                '</div>' +
                '</div>' +
                '<div class="mb-2" style="font-size: 15px; color: #94a3b8;">' + item.part_no + '</div>' +
                '<div class="d-flex justify-content-between align-items-center pt-2 border-top border-secondary" style="opacity: 0.8;">' +
                '<div style="font-size: 15px; color: #38bdf8;"><i class="fa fa-microchip mr-1"></i>' + (item.line_id || '-') + '</div>' +
                '<div class="text-right">' +
                '<div class="font-weight-bold text-success" style="font-size: 20px;">0</div>' +
                '<div class="text-muted" style="font-size: 15px;">ACTUAL</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            });
          } else {
            content = '<div class="text-center text-muted py-3">No data for this category</div>';
          }
        } else {
          section.fadeOut();
        }
        $('#sidebar_list_content').html(content);
      }

      window.currentStatusFilter = null;
      function filterByStatus(status) {
        if (status === null || window.currentStatusFilter === status) {
          window.currentStatusFilter = null;
          $('.status-card').removeClass('active');
          $('.status-all').addClass('active');
        } else {
          window.currentStatusFilter = status;
          $('.status-card').removeClass('active');
          var cardClass = status === 1 ? '.status-robot' : (status === 2 ? '.status-manual' : '.status-ssw');
          $(cardClass).addClass('active');
        }
        $('#example2').DataTable().ajax.reload();
      }

      $(document).on("click", "#btn_add", function () {
        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
        $("#title2").hide();
        $(".Update").hide();
        $("#title1").show();
        clear();
      });

      $(document).on("click", "#btn_edit", function () {
        $("#title1").hide();
        $("#title2").show();
        var id = $(this).data('id');
        var date_plan = id;
        $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
        $('#date_plan').val(date_plan);

        // Setup the Line Box and Machine Grid
        $('#line_id').val('');
        $('.line-box').removeClass('active');

        // Render machines based on the selected line
        var container = $('#machine_container');
        container.empty();
        container.append('<div class="text-muted text-center w-100">Please select a line first</div>');
        $('#machine').val('');

        listdetail();
      });

      $(document).on("click", "#btn_edit_line", function () {
        $(".Save").hide();
        $("#title1").hide();
        $(".Update").show();
        $("#title2").show();
        var id = $(this).data('id');
        $.ajax({
          type: 'GET',
          url: "{{route('mpsplanning.edit')}}",
          data: {
            id: id,
            _token: '{{csrf_token()}}'
          },
          success: function (result) {
            if (result.success) {
              $('#myModal2').modal({ backdrop: 'static', keyboard: false, show: true });
              $('#id').val(result.id);
              $('#part_no').val(result.part_no).trigger('change');
              $('#qty_plan').val(result.qty_plan).trigger('change');
              // $('#description').val(result.description);
            } else {
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
        list();
      });

      function clear() {
        $("#id").val('');
        $("#date_plan").val('');
        $('.line-box').removeClass('active');
        $('#line_id').val('');
        $('#machine_container').html('<div class="text-muted text-center w-100 py-1"><small><i class="fa fa-info-circle"></i> Please select a Line above first</small></div>');
        $('#machine').val('');
        $('#status').val('');
        $('#part_no').val('').trigger('change');
        $("#qty_plan").val('');

        // Reset Performance & Counts UI
        $('#count_robot, #count_manual, #count_ssw').text('0');
        $('#total_qty_plan').text('Total Qty: 0');
        $('#overall_perf').text('0%');
        $('#total_actual').text('0');
        $('#total_balance').text('0');
        $('#perf_robot_val, #perf_manual_val, #perf_ssw_val').text('0%');
        $('#perf_robot_bar, #perf_manual_bar, #perf_ssw_bar').css('width', '0%');

        // Reset Filter State
        window.currentStatusFilter = null;
        $('.status-card').removeClass('active');
        $('.status-all').addClass('active');
        $('#sidebar_list_section').fadeOut();
        $('#sidebar_list_content').empty();

        // Clear Table Detail
        if ($.fn.DataTable.isDataTable('#example2')) {
          $('#example2').DataTable().clear().draw();
        }
      }

      $(document).on("click", ".Save", function () {
        $("#alert").html('');
        $("#alert").show();
        if (validasi()) {
          $.ajax({
            type: 'POST',
            url: "{{route('mpsplanning.store')}}",
            data: {
              date_plan: date_plan.value,
              line_id: line_id.value,
              machine: $('#machine').val(),
              part_no: part_no.value,
              qty_plan: qty_plan.value,
              status: $('#status').val(),
              _token: '{{csrf_token()}}'
            },
            success: function (result) {
              if (result.success) {
                $("#alert").html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + result.msg + '</div>');
                listdetail();
                $('#part_no').val('').trigger('change');
                $("#qty_plan").val('');
                // $('#material_id').val('').trigger('change');
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
            url: "{{route('mpsplanning.update')}}",
            data: {
              id: id.value,
              part_no: part_no.value,
              machine: $('#machine').val(),
              qty_plan: qty_plan.value,
              status: $('#status').val(),
              // description: description.value,
              _token: '{{csrf_token()}}'
            },
            success: function (result) {
              if (result.success) {
                SweetAlert.fire({
                  icon: 'success', title: 'Success', text: result.msg, showConfirmButton: false, timer: 1500
                });

                listdetail();
                $('#part_no').val('').trigger('change');
                $("#qty_plan").val('');
                // $('#material_id').val('').trigger('change');
                setTimeout(() => { $("#alert").hide(); }, 150);
              } else {
                SweetAlert.fire({
                  icon: 'warning', title: 'Warning', text: result.msg, showConfirmButton: false, timer: 2500
                });
              }
            }
          });
        }
      });

      function validasi() {
        $("#alert").show();
        if (date_plan.value != '' && $('#line_id').val() != '' && $('#machine').val() != '' && part_no.value != '' && qty_plan.value != '') {
          return true;
        } else {
          $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> all columns cannot be empty.</div>');
          setTimeout(() => { $("#alert").hide(); }, 1500);
        }
      }

      $(document).on("click", "#btn_delete_line", function () {
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
              url: "{{route('mpsplanning.destroyline')}}",
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
                listdetail();
              }
            });
          }
        })
      });

      $(document).on("click", "#btn_delete", function () {
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
              url: "{{route('mpsplanning.destroy')}}",
              data: { date_plan: date_plan, idline: idline, _token: '{{csrf_token()}}' },
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
    </script>
  @endpush

  @push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  @endpush