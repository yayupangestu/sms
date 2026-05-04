@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .orders-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .summary-item {
            background: linear-gradient(135deg, #f9f9f9, #ececec);
            border-radius: 8px;           /* lebih kecil */
            padding: 6px 8px;             /* perkecil padding */
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1 1 200px;              /* lebar minimum lebih kecil */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); 
            margin-bottom: 6px;           /* jarak antar card diperkecil */
        }

        .summary-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .summary-item h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .summary-item p {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
            color: #2c3e50;
        }

        .summary-item {
            flex: 1 1 300px;
            background: linear-gradient(135deg, #f9f9f9, #bababa);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            text-align: center;
        }

        .resume-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 10px;
        }

        .resume-box {
            flex: 1;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .resume-box h4 {
            margin-bottom: 5px;
            font-size: 0.85rem;
            color: #555;
        }

        .resume-box p {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .resume-box.total-part {
            background-color: #a5cde3;
            /* hijau aman dan soft */
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(102, 146, 187, 0.4);
            cursor: pointer;
        }

        .resume-box.total-part h3 {
            color: #000000;
        }

        .resume-box.total-part p {
            color: #000000;
        }

        .resume-box.total-part2 {
            background-color: #a5cde3;
            /* hijau aman dan soft */
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(102, 146, 187, 0.4);
            cursor: pointer;
        }

        .resume-box.total-part2 h3 {
            color: #000000;
        }

        .resume-box.total-part2 p {
            color: #000000;
        }

        .resume-box.stock-safe {
            background-color: #66bb6a;
            /* hijau aman dan soft */
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(102, 187, 106, 0.4);
            cursor: pointer;
        }

        .resume-box.stock-safe h4 {
            color: #e8f5e9;
        }

        .resume-box.stock-safe p {
            color: #fff;
        }

        .resume-box.stock-warning {
            background-color: #fff176;
            /* kuning lembut */
            color: #333;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(255, 235, 59, 0.4);
            cursor: pointer;
        }

        .resume-box.stock-warning h4 {
            color: #795548;
        }

        .resume-box.stock-warning p {
            color: #f57c00;
            /* orange tua untuk nilai angka */
        }

        .resume-box.stock-danger {
            background-color: #e57373;
            /* merah soft */
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(239, 83, 80, 0.4);
            cursor: pointer;
        }

        .resume-box.stock-danger h4 {
            color: #ffebee;
        }

        .resume-box.stock-danger p {
            color: #fff;
        }

        .orders-table {
  margin: 20px 0;
  overflow-x: auto;
}

.orders-data-table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

.orders-data-table th,
.orders-data-table td {
  border: 1px solid #dee2e6; /* grid / garis antar sel */
  padding: 8px 12px;
}

.orders-data-table th {
  background-color: #343a40; /* warna header */
  color: #ffffff;
  font-weight: bold;
  text-align: center;
}

.orders-data-table td {
  text-align: left;
  vertical-align: middle;
}

.orders-data-table td.text-end {
  text-align: right;
}

.orders-data-table td.text-center {
  text-align: center;
}

/* Kolom Stok diperkecil */
.orders-data-table th:nth-child(8),
.orders-data-table td:nth-child(8) {
  width: 60px;
}

/* Striping dan hover */
.orders-data-table tbody tr:nth-child(odd) {
  background-color: #f8f9fa;
}

.orders-data-table tbody tr:hover {
  background-color: #e9ecef;
  transition: background-color 0.2s;
}

/* Responsive */
@media (max-width: 768px) {
  .orders-data-table th,
  .orders-data-table td {
    padding: 6px 8px;
    font-size: 13px;
  }
}

.modal-dialog.modal-xl-custom {
    max-width: 1400px; /* Lebar modal */
    margin: 30px auto; /* Margin atas dan horizontal auto */
  }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Stok MODEL D26</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="orders-summary">
                <div class="summary-item">
                    <h3>INFORMATION PART D26 TMMIN</h3>
                    @php
                        $row = DB::table('pc_store_directs')
                            ->where('model', 'D26 TMMIN')
                            ->count();
                    @endphp
                    <p>{{ $row }}</p>
                    <div class="change">
                        <i class="fas fa-box-open"></i>
                    </div>
        
                    <div class="resume-section mt-3">
                        <div class="resume-box total-part2" style="cursor:pointer;">
                            <h3>Total Part</h3>
                            @php
                                $total = DB::table('pc_store_directs')
                                    ->where('model', 'D26 TMMIN')
                                    ->count('id');
                            @endphp
                            <p id="total-count">{{ $total }}</p>
                        </div>
                        <div class="resume-box stock-safe" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; text-align: center;">
                            <h4>Ready Stock</h4>
                            @php
                                $safe = DB::table('pc_store_directs')
                                    ->where('model', 'D26 TMMIN')
                                    ->where('strength', '>', 1.0)
                                    ->where('strength', '<', 2.0)
                                    ->count();
                        
                                $overCount = DB::table('pc_store_directs')
                                    ->where('model', 'D26 TMMIN')
                                    ->where('strength', '>=', 2.0)
                                    ->count();
                            @endphp
                            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 10px;">
                                <div style="background-color:#39bd00; color:#fff; padding:10px 20px; border-radius:4px; min-width:80px;">
                                    SAFE: {{ $safe }}
                                </div>
                                <div style="background-color:#e74c3c; color:#fff; padding:10px 20px; border-radius:4px; min-width:80px;">
                                    OVER: {{ $overCount }}
                                </div>
                            </div>
                        </div>
                        
                        
                        
                                          
                        <div class="resume-box stock-warning">
                            <h4>Warning Stock</h4>
                            @php
                                $warning = DB::table('pc_store_directs')
                                    ->where('model', 'D26 TMMIN')
                                    ->where('strength', '>=', 0.5)
                                    ->where('strength', '<', 1.0)
                                    ->count();
                            @endphp
                            <p>{{ $warning }}</p>
                        </div>
                        
                        
                        <div class="resume-box stock-danger">
                            <h4>DANGER</h4>
                            @php
                                $danger = DB::table('pc_store_directs')
                                    ->where('model', 'D26 TMMIN')
                                    ->where('strength', '<', 0.5)
                                    ->count();
                            @endphp
                            <p>{{ $danger }}</p>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        
            <div class="container-fluid mt-3">
                <div class="row">

                      <!-- Grafik 2 -->
                      <div class="col-md-12">
                        <div class="orders-chart text-left" 
                             style="padding:20px; background:#2c2c2c; border-radius:10px;">
                            <h5 style="color:#ffffff;">Stock Status Chart 2</h5>
                            <canvas id="stockChart2" style="max-height:250px;"></canvas>
                        </div>
                    </div>

                    {{-- <!-- Grafik 1 -->
                    <div class="col-md-5">
                        <div class="orders-chart text-left" 
                             style="padding:20px; background:#2c2c2c; border-radius:10px;">
                            <h5 style="color:#ffffff;">Stock Status Chart</h5>
                            <canvas id="stockChart" style="max-height:250px;"></canvas>
                        </div>
                    </div> --}}
            
                  
                </div>
            </div>
            
            
            
            
        </div>

        <!-- HTML: Tabel dan Modal -->
        <div class="orders-table table-responsive">
            <table class="orders-data-table table table-hover table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col" style="width: 50px;">No</th>
                        <th scope="col" style="min-width: 250px;" class="text-start">Part Name</th>
                        <th scope="col" style="min-width: 150px;" class="text-center">Part No</th>
                        <th scope="col" style="min-width: 120px;" class="text-center">Job No</th>
                        <th scope="col" style="min-width: 120px;" class="text-center">Model</th>
                        <th scope="col" class="text-end">Monthly Volume</th>
                        <th scope="col" class="text-end">Daily Volume</th>
                        <th scope="col" class="text-end">Strength</th>
                        <th scope="col" style="min-width: 150px;" class="text-start">Customer</th>
                        <th scope="col" class="text-end">Qty/Kanban</th>
                        <th scope="col" style="width: 80px;" class="text-center">Stok</th> 
                        <th scope="col" class="text-end">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diisi oleh jQuery -->
                </tbody>
            </table>
        </div>
        

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl-custom modal-top"> <!-- posisi di atas -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Three Side-by-Side Tables</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-row gap-3">
  
            <!-- Tabel 1: OUT WELDING -->
            <div class="flex-fill">
                <h4 style="background-color: #60305f; color:white" class="text-center mb-2">OUT STAMPING</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="outStampingTable">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Part No</th>
                                <th>Job No</th>
                                <th>Qty</th>
                                <th>Home Line</th>
                                <th>Created At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="5" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
          
  
            <!-- Tabel 2: IN PCSTORE -->
            <div class="flex-fill">
                <h4 style="background-color: #5f6030; color:white" class="text-center mb-2">OUT WELDING</h4>
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                  <thead class="table-secondary text-center">
                    <tr>
                      <th>Kolom 1</th>
                      <th>Kolom 2</th>
                      <th>Kolom 3</th>
                      <th>Kolom 4</th>
                      <th>Kolom 5</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Data 1</td>
                      <td>Data 2</td>
                      <td>Data 3</td>
                      <td>Data 4</td>
                      <td>Data 5</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  


    </section>
    <canvas id="stockChart2"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // === DataTable ===
            const table = $('.orders-data-table').DataTable({
                processing: true,
                searching: true,
                pageLength: 10,
                columns: [
                    { data: 'no' },
                    { data: 'part_name' },
                    { data: 'part_no' },
                    { data: 'job_no' },
                    { data: 'model' },
                    { data: 'monthly_volume' },
                    { data: 'daily_volume' },
                    {
                        data: 'strength',
                        render: function(data, type, row) {
                            return `<span style="background-color:LightGray; color:black; font-size:0.9rem; padding:6px 12px; border-radius:5px;">${data}</span>`;
                        }
                    },
                    { data: 'customer' },
                    { data: 'qty_kanban' }, 
                    { data: 'qty_act' },
                    {
                        data: 'strength',
                        render: function(data, type, row) {
                            let strengthValue = parseFloat(data);
                            let badgeHtml = '';

                            if (strengthValue >= 2.0) {
                            badgeHtml = '<span style="background-color:#e74c3c; color:#000000; padding:4px 8px; border-radius:4px;">O</span>';
                        } else if (strengthValue >= 1.0) {
                            badgeHtml = '<span style="background-color:#39bd00; color:#ffffff; padding:4px 8px; border-radius:4px;">SAFE</span>';
                        } else if (strengthValue >= 0.5) { // 0.5 <= x < 1.0
                            badgeHtml = '<span style="background-color:#f5a623; color:#ffffff; padding:4px 8px; border-radius:4px;">WARNING</span>';
                        } else if (strengthValue < 0.5) {
                            badgeHtml = '<span style="background-color:#e74c3c; color:#ffffff; padding:4px 8px; border-radius:4px;">DANGER</span>';
                        } else {
                            badgeHtml = '<span style="background-color:#6c757d; color:#ffffff; padding:4px 8px; border-radius:4px;">N/A</span>';
                        }
                            return badgeHtml;
                        }
                    }
                ],
                initComplete: function() {
                    // ambil container search
                    let searchContainer = $('.dataTables_filter');
        
                    // buat button
                    let buttonHtml = `<button id="showModalBtn" class="btn btn-primary btn-sm me-2">Show Modal</button>`;
        
                    // tambahkan button **di kiri search input**
                    searchContainer.prepend(buttonHtml);
        
                    // event klik untuk modal
                    $('#showModalBtn').on('click', function() {
                        $('#myModal').modal('show');
                    });
                }
            });
        
            // === Function loadData ===
            function loadData(url, statusFilter = null) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let data = response.data || response;
                        if (response.total !== undefined) {
                            $('#total-count').text(response.total);
                        }
        
                        let filteredData = data;
                        if (statusFilter) {
                            filteredData = data.filter(item => item.status === statusFilter);
                        }
        
                        const mappedData = filteredData.map((item, index) => {
                        let badgeHtml = '';
                        let strengthValue = parseFloat(item.strength);

                        if (strengthValue >= 1.0) {
                            badgeHtml = '<span class="badge bg-success">SAFE</span>';
                        } else if (strengthValue >= 0.5 && strengthValue < 1.0) {
                            badgeHtml = '<span class="badge bg-warning text-dark">WARNING</span>';
                        } else if (strengthValue < 0.5) {
                            badgeHtml = '<span class="badge bg-danger">DANGER</span>';
                        } else if (strengthValue > 2.0) {
                            badgeHtml = '<span class="badge bg-danger">Over</span>';
                        }
                        else {
                            badgeHtml = '<span class="badge bg-secondary">N/A</span>';
                        }

                        return {
                            no: index + 1,
                            part_name: item.part_name,
                            part_no: item.part_no,
                            part_no2: item.part_no2,
                            job_no: item.job_no,
                            monthly_volume: item.monthly_volume,
                            qty_kanban: item.qty_kanban,
                            customer: item.customer,
                            daily_volume: item.daily_volume,
                            strength: item.strength,
                            qty_act: item.qty_act,
                            model: item.model,
                            updateby: item.updateby,
                            time_update: item.time_update,
                            status: badgeHtml // pakai badge bootstrap
                        };
                    });

                        table.clear().rows.add(mappedData).draw();
                        if (mappedData.length === 0) {
                            table.clear().draw();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Failed to load data.');
                    }
                });
            }
        
            // === Event filter ===
            $('.total-part').on('click', function() {
                loadData("{{ route('dashboard1.totalPart') }}");
            });
            $('.total-part2').on('click', function() {
                loadData("{{ route('dashboard1.totalPart2') }}");
            });


            $('.stock-safe').on('click', function() {
    $.ajax({
        url: "{{ route('dashboard1.getMinimalOverActual') }}",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let data = response.data || response;

            // Filter strength > 1.0 dan model D26 TMMIN
            const filteredData = data.filter(item => parseFloat(item.strength) > 1.0 && item.model === "D26 TMMIN");

            const mappedData = filteredData.map((item, index) => {
                let strengthValue = parseFloat(item.strength);
                let badgeHtml = '';

                if (strengthValue >= 2.0) {
                    badgeHtml = '<span class="badge bg-danger">O</span>';
                } else if (strengthValue >= 1.0) {
                    badgeHtml = '<span class="badge bg-success">SAFE</span>';
                } else if (strengthValue >= 0.5) {
                    badgeHtml = '<span class="badge bg-warning text-dark">WARNING</span>';
                } else if (strengthValue < 0.5) {
                    badgeHtml = '<span class="badge bg-danger">DANGER</span>';
                } else {
                    badgeHtml = '<span class="badge bg-secondary">N/A</span>';
                }

                return {
                    no: index + 1,
                    part_name: item.part_name,
                    part_no: item.part_no,
                    job_no: item.job_no,
                    monthly_volume: item.monthly_volume,
                    daily_volume: item.daily_volume,
                    qty_kanban: item.qty_kanban,
                    customer: item.customer,
                    strength: item.strength,
                    qty_act: item.qty_act,
                    model: item.model,
                    updateby: item.updateby,
                    time_update: item.time_update,
                    status: badgeHtml
                };
            });

            table.clear().rows.add(mappedData).draw();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to load data.');
        }
    });
});


$('.stock-warning').on('click', function() {
    $.ajax({
        url: "{{ route('dashboard1.getWarning') }}",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let data = response.data || response;

            // Filter strength >= 0.5 dan < 1.0 **dan model D26 TMMIN**
            const filteredData = data.filter(item => {
                let strengthValue = parseFloat(item.strength);
                return strengthValue >= 0.5 && strengthValue < 1.0 && item.model === "D26 TMMIN";
            });

            const mappedData = filteredData.map((item, index) => {
                let strengthValue = parseFloat(item.strength);
                let badgeHtml = '';

                if (strengthValue >= 1.0) {
                    badgeHtml = '<span class="badge bg-success">SAFE</span>';
                } else if (strengthValue >= 0.5 && strengthValue < 1.0) {
                    badgeHtml = '<span class="badge bg-warning text-dark">WARNING</span>';
                } else if (strengthValue < 0.5) {
                    badgeHtml = '<span class="badge bg-danger">DANGER</span>';
                } else {
                    badgeHtml = '<span class="badge bg-secondary">N/A</span>';
                }

                return {
                    no: index + 1,
                    part_name: item.part_name,
                    part_no: item.part_no,
                    job_no: item.job_no,
                    monthly_volume: item.monthly_volume,
                    daily_volume: item.daily_volume,
                    qty_kanban: item.qty_kanban,
                    customer: item.customer,
                    strength: item.strength,
                    qty_act: item.qty_act,
                    model: item.model,
                    updateby: item.updateby,
                    time_update: item.time_update,
                    status: badgeHtml
                };
            });

            table.clear().rows.add(mappedData).draw();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to load data.');
        }
    });
});


$('.stock-danger').on('click', function() {
    $.ajax({
        url: "{{ route('dashboard1.getDanger') }}",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let data = response.data || response;

            // Filter strength < 0.5 **dan model D26 TMMIN**
            const filteredData = data.filter(item => parseFloat(item.strength) < 0.5 && item.model === "D26 TMMIN");

            const mappedData = filteredData.map((item, index) => {
                let strengthValue = parseFloat(item.strength);
                let badgeHtml = '';

                if (strengthValue >= 1.0) {
                    badgeHtml = '<span class="badge bg-success">SAFE</span>';
                } else if (strengthValue >= 0.5 && strengthValue < 1.0) {
                    badgeHtml = '<span class="badge bg-warning text-dark">WARNING</span>';
                } else if (strengthValue < 0.5) {
                    badgeHtml = '<span class="badge bg-danger">DANGER</span>';
                } else {
                    badgeHtml = '<span class="badge bg-secondary">N/A</span>';
                }

                return {
                    no: index + 1,
                    part_name: item.part_name,
                    part_no: item.part_no,
                    job_no: item.job_no,
                    monthly_volume: item.monthly_volume,
                    daily_volume: item.daily_volume,
                    qty_kanban: item.qty_kanban,
                    customer: item.customer,
                    strength: item.strength,
                    qty_act: item.qty_act,
                    model: item.model,
                    updateby: item.updateby,
                    time_update: item.time_update,
                    status: badgeHtml
                };
            });

            table.clear().rows.add(mappedData).draw();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to load data.');
        }
    });
});


            // === Modal OUT STAMPING ===
            $('#myModal').on('shown.bs.modal', function () {
                const tableBody = document.querySelector('#outStampingTable tbody');
        
                // tampilkan loading
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Loading...</td></tr>';
        
                fetch('{{ route("outStamping.data") }}')
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = ''; // clear loading
        
                    if(data.length === 0){
                        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                    } else {
                        data.forEach(item => {
                            const row = `<tr>
                        <td class="text-center">${item.part_no2}</td>
                        <td class="text-center">${item.job_no}</td>
                        <td class="text-center">${item.qty_act ?? '-'}</td>
                        <td class="text-center">${item.line_proses ?? '-'}</td>
                        <td class="text-center">${new Date(item.created_at).toLocaleString()}</td>
                        <td class="text-center">
                            ${item.sts_pcstore === null 
                                ? '<span class="badge bg-info">TRANSIT</span>'
                                : item.sts_pcstore == 1 
                                    ? '<span class="badge bg-success">DITERIMA</span>'
                                    : '-'}
                        </td>
                    </tr>`;

                            tableBody.innerHTML += row;
                        });
                    }
                })
                .catch(err => {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error load data</td></tr>';
                    console.error(err);
                });
            });
        
            // // === Grafik Chart.js ===
            // const ctx = document.getElementById('stockChart');
            // if (ctx) {
            //     new Chart(ctx, {
            //         type: 'bar',
            //         data: {
            //             labels: ['Total Part', 'Ready Stock', 'Warning', 'Danger'],
            //             datasets: [{
            //                 label: 'Jumlah',
            //                 data: [
            //                     {{ $total }},
            //                     {{ $safe }},
            //                     {{ $warning }},
            //                     {{ $danger }}
            //                 ],
            //                 backgroundColor: [
            //                     '#2196F3',
            //                     '#4CAF50',
            //                     '#FFC107',
            //                     '#F44336'
            //                 ],
            //                 borderRadius: 10
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             plugins: { 
            //                 legend: { display: false },
            //                 tooltip: {
            //                     titleColor: '#000',
            //                     bodyColor: '#000',
            //                     backgroundColor: '#333'
            //                 }
            //             },
            //             scales: {
            //                 x: {
            //                     ticks: { color: '#000' },
            //                     grid: { color: '#555' }
            //                 },
            //                 y: {
            //                     beginAtZero: true,
            //                     ticks: { stepSize: 1, color: '#000' },
            //                     grid: { color: '#555' }
            //                 }
            //             }
            //         }
            //     });
            // }
        
            async function loadStockChart() {
                const response = await fetch("{{ route('stock.chart.data') }}");
                const result = await response.json();
        
                const labels = result.map(item => item.job_no);
                const qtyAct = result.map(item => item.qty_act);
                const monthlyVolume = result.map(item => item.monthly_volume);
        
                const ctx2 = document.getElementById('stockChart2');
                if (ctx2) {
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'QTY KANBAN',
                                    data: qtyAct,
                                    backgroundColor: 'rgba(76, 175, 80, 0.7)'
                                },
                                {
                                    label: 'MONTHLY VOLUME',
                                    data: monthlyVolume,
                                    backgroundColor: 'rgba(33, 150, 243, 0.7)'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: { 
                                legend: { 
                                    labels: { color:'#fff' } 
                                } 
                            },
                            scales: {
                                x: { 
                                    ticks: { color:'#fff' }, 
                                    grid: { color:'#555' } 
                                },
                                y: { 
                                    ticks: { color:'#fff' }, 
                                    grid: { color:'#555' }, 
                                    beginAtZero: true 
                                }
                            }
                        }
                    });
                }
            }
        
            loadStockChart();
        });
        </script>
        
        
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endpush
