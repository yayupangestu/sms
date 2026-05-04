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

        .container {
            padding: 20px;
        }

        .orders-table tbody tr:hover {
            background-color: #0a0b0b5d;
        }

        .orders-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .orders-summary .summary-item {
            background-color: rgba(129, 129, 129, 0.503);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin-right: 20px;
        }

        .orders-summary .summary-item:last-child {
            margin-right: 0;
        }

        .orders-summary .summary-item h3 {
            margin: 0;
            font-size: 24px;
        }

        .orders-summary .summary-item p {
            margin: 5px 0 0;
            color: #6c757d;
            font-size: 200%;
        }

        .orders-summary .summary-item .change {
            display: flex;
            align-items: center;
            color: #004301;
        }

        .orders-summary .summary-item .change i {
            margin-right: 5px;
        }

        .orders-table {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .orders-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #272424;
        }

        .orders-table th {
            background-color: #dadcdf;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .orders-table .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        .orders-table .status.success {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 15px;
        }

        .orders-table .status.out {
            background-color: #34bdbd62;
            color: #000000;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 15px;
        }

        .orders-table .status.out2 {
            background-color: #46bd3462;
            color: #000000;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 15px;
        }

        .orders-table .status.return {
            background-color: #ffcdcd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 15px;
        }

        .line-filter-btn.active {
            background-color: #d4edda;
            color: #155724;
        }


    .orders-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .summary-item {
        background: linear-gradient(135deg, #f9f9f9, #ececec);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
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

    .change {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        margin-top: 10px;
        color: #888;
    }

    .change i {
        font-size: 16px;
        margin-right: 5px;
    }

    .change .fas fa-retweet {
        color: red;
    }

    .change .fa-arrow-up {
        color: green;
    }

    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Blank Stok</h1>
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
                            <h3 class="card-title">DaDashboard Blank Stok</h3>
                        </div>
                        <div class="orders-summary">
                            @php
                                $totalSafe = DB::table('tabel_stok_blanks')
                                    ->where('home_line', 'ASI-1')
                                    ->whereColumn('qty_kanban', '>', 'qty_min')
                                    ->count();

                                $totalCritical = DB::table('tabel_stok_blanks')
                                            ->whereColumn('qty_kanban', '<', 'qty_min')
                                            ->where('qty_kanban', '>', 0) // Hanya yang positif
                                            ->where('home_line', 'ASI-1')
                                            // ->where('keterangan', '!=', 2)  // Kecuali yang keterangan = 2
                                            ->count();

                                            $totalTa = DB::table('tabel_stok_blanks')
                                                ->where('home_line', 'ASI-1')
                                                ->where(function ($query) {
                                                    $query->whereNull('qty_kanban')
                                                        ->orWhere('qty_kanban', 0);
                                                })
                                                ->count();

                                                $totalSafe2 = DB::table('tabel_stok_blanks')
                                    ->where('home_line', 'ASI-2')
                                    ->whereColumn('qty_kanban', '>', 'qty_min')
                                    ->count();

                                $totalCritical2 = DB::table('tabel_stok_blanks')
                                            ->whereColumn('qty_kanban', '<', 'qty_min')
                                            ->where('qty_kanban', '>', 0) // Hanya yang positif
                                            ->where('home_line', 'ASI-2')
                                            // ->where('keterangan', '!=', 2)  // Kecuali yang keterangan = 2
                                            ->count();

                                            $totalTa2 = DB::table('tabel_stok_blanks')
                                                ->where('home_line', 'ASI-2')
                                                ->where(function ($query) {
                                                    $query->whereNull('qty_kanban')
                                                        ->orWhere('qty_kanban', 0);
                                                })
                                                ->count();

                            @endphp

                            

                            <div class="summary-item">
                                <div class="summary-item bg-success text-white p-4 rounded filter-sts" data-sts="null" style="cursor:pointer;">
                                    <h3 class="text-center">Part BLANK ASI-1</h3>
                                    <p class="text-center fs-4">{{ $totalAsi1 }} Item</p>

                                    <!-- Badge status sejajar tanpa scroll -->
                                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
                                        <!-- TOTAL -->
                                        <div class="text-center" onclick="showIncomingMaterials('data_total')">
                                            <span class="badge bg-primary text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Total
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-primary rounded py-1 px-2">
                                                {{ $totalAsi1 }} Item
                                            </span>
                                        </div>

                                        <!-- SAFE -->
                                        <div class="text-center" onclick="showIncomingMaterials2('safe_data')">
                                            <span class="badge bg-success text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Safe
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-success rounded py-1 px-2">
                                                {{ $totalSafe }} Item
                                            </span>
                                        </div>
                                        

                                        <!-- CRITICAL -->
                                        <div class="text-center" onclick="showIncomingMaterials3('critical_data')">
                                            <span class="badge bg-warning text-dark px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Critical
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-dark rounded py-1 px-2">
                                                {{ $totalCritical }} Item
                                            </span>
                                        </div>

                                        <!-- TA -->
                                        <div class="text-center" onclick="showIncomingMaterials4('data_ta')">
                                            <span class="badge bg-danger text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                TA
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-danger rounded py-1 px-2">
                                                {{ $totalTa }} Item
                                            </span>
                                        </div>
                                    </div>
                                    <div class="change text-center">
                                        <i class="fas fa-retweet fa-lg"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="summary-item">
                                <div class="summary-item bg-success text-white p-4 rounded filter-sts" data-sts="null" style="cursor:pointer;">
                                    <h3 class="text-center">Part BLANK ASI-2</h3>
                                    <p class="text-center fs-4">{{ $totalAsi2 }} Item</p>

                                    <!-- Badge status sejajar tanpa scroll -->
                                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
                                        <!-- TOTAL -->
                                        <div class="text-center" onclick="showIncomingMaterials1('data_total')">
                                            <span class="badge bg-primary text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Total
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-primary rounded py-1 px-2">
                                                {{ $totalAsi2 }} Item
                                            </span>
                                        </div>

                                        <!-- SAFE -->
                                        <div class="text-center" onclick="showIncomingMaterials5('safe_data')">
                                            <span class="badge bg-success text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Safe
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-success rounded py-1 px-2">
                                                {{ $totalSafe2 }} Item
                                            </span>
                                        </div>
                                        

                                        <!-- CRITICAL -->
                                        <div class="text-center" onclick="showIncomingMaterials6('critical_data')">
                                            <span class="badge bg-warning text-dark px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                Critical
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-dark rounded py-1 px-2">
                                                {{ $totalCritical2 }} Item
                                            </span>
                                        </div>

                                        <!-- TA -->
                                        <div class="text-center" onclick="showIncomingMaterials7('data_ta')">
                                            <span class="badge bg-danger text-white px-3 py-2 fs-5 fw-bold text-uppercase d-block" style="min-width: 130px;">
                                                TA
                                            </span>
                                            <span class="d-block mt-1 fs-6 fw-semibold bg-white text-danger rounded py-1 px-2">
                                                {{ $totalTa2 }} Item
                                            </span>
                                        </div>
                                    </div>
                                    <div class="change text-center">
                                        <i class="fas fa-retweet fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-item">
                                <div class="summary-item bg-success text-white p-3 rounded filter-sts" data-sts="all" style="cursor:pointer;">
                                <h3>Total Material BLANK ASI-1 & ASI-2</h3>
                                <p>{{ $totalAll }}</p>
                                <div class="change">
                                    <i class="fas fas fa-retweet"></i>
                                
                                </div>
                            </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-start align-items-center flex-wrap gap-2 mb-3">

                            <!-- Tombol Line Filter -->
                            <li><button class="btn btn-white line-filter-btn" data-line-id="ASI-1,ASI-2">All</button></li>
                            <li><button class="btn btn-white line-filter-btn" data-line-id="ASI-1">ASI-1</button></li>
                            <li><button class="btn btn-white line-filter-btn" data-line-id="ASI-2">ASI-2</button></li>
                            <li>
                        <a href="{{route("dashboardblank.export")}}" class="btn btn-success btn-sm"><i class="fa 	fas fa-file-excel"></i> Export Excel</a>
                            </li>
                        </div>
                        <div class="orders-table">
                            <table id="example1">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Home Line</th>
                                        <th>Part Name</th>
                                        <th>Part No</th>
                                        <th>Job No</th>
                                        <th>Qty Minimal</th>
                                        <th>Qty Actual</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="line-filter" value="">

    </section>
@endsection


@push('scripts')
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

function showIncomingMaterials(condition) {
    document.getElementById('example1').scrollIntoView({
    behavior: 'smooth'
 });

    $('#example1 tbody').empty(); // gunakan ID tabel yg benar

    if (condition === 'data_total') {
        $.ajax({
            url: "{{ route('dashboardblank.total') }}",
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;
                response.data.forEach(function(item) {
                    tableBody += `
                    <tr>
                        <td>${counter}</td>
                        <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                        <td>${item.part_name || '-'}</td>
                        <td>${item.part_no || '-'}</td>
                        <td>${item.job_no || '-'}</td>
                        <td>${item.qty_min || '-'}</td>
                      <td style="background-color:#3e92d1; color:#FFFFFF">${item.qty_kanban ?? '-'}</td>
                    </tr>`;
                    counter++;
                });
                $('#example1 tbody').append(tableBody);
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    }
}

function showIncomingMaterials1(condition) {
    document.getElementById('example1').scrollIntoView({
    behavior: 'smooth'
 });

    $('#example1 tbody').empty(); // gunakan ID tabel yg benar

    if (condition === 'data_total') {
        $.ajax({
            url: "{{ route('dashboardblank.total2') }}",
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;
                response.data.forEach(function(item) {
                    tableBody += `
                    <tr>
                        <td>${counter}</td>
                        <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                        <td>${item.part_name || '-'}</td>
                        <td>${item.part_no || '-'}</td>
                        <td>${item.job_no || '-'}</td>
                        <td>${item.qty_min || '-'}</td>
                      <td style="background-color:#3e92d1; color:#FFFFFF">${item.qty_kanban ?? '-'}</td>
                    </tr>`;
                    counter++;
                });
                $('#example1 tbody').append(tableBody);
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    }
}


function showIncomingMaterials2(condition) {
    document.getElementById('example1').scrollIntoView({
    behavior: 'smooth'
 });

    $('#example1 tbody').empty(); // gunakan ID tabel yg benar

    if (condition === 'safe_data') {
        $.ajax({
            url: "{{ route('dashboardblank.getSafeData') }}",
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;
                response.data.forEach(function(item) {
                    tableBody += `
                    <tr>
                        <td>${counter}</td>
                        <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                        <td>${item.part_name || '-'}</td>
                        <td>${item.part_no || '-'}</td>
                        <td>${item.job_no || '-'}</td>
                        <td>${item.qty_min || '-'}</td>
                      <td style="background-color:#8eff5f; color:#000000">${item.qty_kanban ?? '-'}</td>
                    </tr>`;
                    counter++;
                });
                $('#example1 tbody').append(tableBody);
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    }
}

function showIncomingMaterials3(condition, id) {
    document.getElementById('example1').scrollIntoView({
        behavior: 'smooth'
    });

    $('#example1 tbody').empty(); // Bersihkan isi tabel sebelumnya

    if (condition === 'critical_data') {
        $.ajax({
            url: "{{ route('dashboardblank.getCritcalData') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                            <td>${counter}</td>
                              <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.qty_min ?? '-'}</td>
                            <td style="background-color:#f7fa8f; color:#000000">${item.qty_kanban ?? '-'}</td>
                        </tr>`;
                    counter++;
                });

                // Tambahkan data ke dalam tbody
                $('#example1 tbody').append(tableBody);

                // Tampilkan modal jika ingin
                $('#incomingModal').modal('show');
            },
            error: function(xhr) {
                console.error('Gagal mengambil data critical:', xhr.responseText);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}

function showIncomingMaterials4(condition, id) {
    document.getElementById('example1').scrollIntoView({
        behavior: 'smooth'
    });

    $('#example1 tbody').empty(); // Bersihkan isi tabel sebelumnya

    if (condition === 'data_ta') {
        $.ajax({
            url: "{{ route('dashboardblank.getPartTa') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                            <td>${counter}</td>
                              <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.qty_min ?? '-'}</td>
                            <td style="background-color:#f5554a; color:#ffffff">${item.qty_kanban ?? '-'}</td>
                        </tr>`;
                    counter++;
                });

                // Tambahkan data ke dalam tbody
                $('#example1 tbody').append(tableBody);

                // Tampilkan modal jika ingin
                $('#incomingModal').modal('show');
            },
            error: function(xhr) {
                console.error('Gagal mengambil data ta:', xhr.responseText);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}



function showIncomingMaterials5(condition) {
    document.getElementById('example1').scrollIntoView({
    behavior: 'smooth'
 });

    $('#example1 tbody').empty(); // gunakan ID tabel yg benar

    if (condition === 'safe_data') {
        $.ajax({
            url: "{{ route('dashboardblank.getSafeData2') }}",
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;
                response.data.forEach(function(item) {
                    tableBody += `
                    <tr>
                        <td>${counter}</td>
                        <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                        <td>${item.part_name || '-'}</td>
                        <td>${item.part_no || '-'}</td>
                        <td>${item.job_no || '-'}</td>
                        <td>${item.qty_min || '-'}</td>
                      <td style="background-color:#8eff5f; color:#000000">${item.qty_kanban ?? '-'}</td>
                    </tr>`;
                    counter++;
                });
                $('#example1 tbody').append(tableBody);
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    }
}

function showIncomingMaterials6(condition, id) {
    document.getElementById('example1').scrollIntoView({
        behavior: 'smooth'
    });

    $('#example1 tbody').empty(); // Bersihkan isi tabel sebelumnya

    if (condition === 'critical_data') {
        $.ajax({
            url: "{{ route('dashboardblank.getCritcalData2') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                            <td>${counter}</td>
                              <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.qty_min ?? '-'}</td>
                            <td style="background-color:#f7fa8f; color:#000000">${item.qty_kanban ?? '-'}</td>
                        </tr>`;
                    counter++;
                });

                // Tambahkan data ke dalam tbody
                $('#example1 tbody').append(tableBody);

                // Tampilkan modal jika ingin
                $('#incomingModal').modal('show');
            },
            error: function(xhr) {
                console.error('Gagal mengambil data critical:', xhr.responseText);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}

function showIncomingMaterials7(condition, id) {
    document.getElementById('example1').scrollIntoView({
        behavior: 'smooth'
    });

    $('#example1 tbody').empty(); // Bersihkan isi tabel sebelumnya

    if (condition === 'data_ta') {
        $.ajax({
            url: "{{ route('dashboardblank.getPartTa2') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                            <td>${counter}</td>
                              <td style="background-color:#3e92d1; color:#FFFFFF">${item.home_line || '-'}</td>
                            <td>${item.part_name || '-'}</td>
                            <td>${item.part_no || '-'}</td>
                            <td>${item.job_no || '-'}</td>
                            <td>${item.qty_min ?? '-'}</td>
                            <td style="background-color:#f5554a; color:#ffffff">${item.qty_kanban ?? '-'}</td>
                        </tr>`;
                    counter++;
                });

                // Tambahkan data ke dalam tbody
                $('#example1 tbody').append(tableBody);

                // Tampilkan modal jika ingin
                $('#incomingModal').modal('show');
            },
            error: function(xhr) {
                console.error('Gagal mengambil data ta:', xhr.responseText);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}



    </script>
@endpush
