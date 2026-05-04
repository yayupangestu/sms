@extends('layouts.app')

@section('content')
    <style>
        #incomingTable.table-hover tbody tr:hover {
            /* background: linear-gradient(to top, #003366 17%, #ffffff 99%); */
            background-color: rgba(129, 129, 129, 0.503);
            color: #ffffff;
            /* Warna teks saat hover (opsional) */
        }

        #insertedData:empty::before {
            content: none;
        }

        /* style="background: linear-gradient(to bottom, #EDEDED, #DADADA);  */
.custom-dashboard {
    background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
    font-family: 'Poppins', sans-serif;
    padding: 20px;
}

.dashboard-title {
    font-size: 26px;
    font-weight: bold;
    color: #ffffff;
}

.new-order-btn {
    background-color: #ff6b6b;
    color: #000000;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: 12px 25px;
    box-shadow: 0 6px 12px rgba(255, 107, 107, 0.3);
    transition: background-color 0.3s ease;
}

.new-order-btn:hover {
    background-color: #e55e5e;
}


.metric-card {
    background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
    border-radius: 40px;
    padding: 25px 20px;
    color: #ffffff;
    box-shadow: 5 10px 20px rgba(0, 0, 0, 0.84);
    text-align: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-left: 10px; /* Adjust as needed */
    display: inline-block; /* Keeps the badge in line with text */
}

.metric-card2 {
    background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
    border-radius: 20px;
    padding: 30px 20px;
    color: #ffffff;
    box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
    text-align: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-left: 10px; /* Adjust as needed */
    display: inline-block; /* Keeps the badge in line with text */
}

.metric-card3 {
    background: linear-gradient(to bottom right, #006699 0%, #00274d 100%);
    border-radius: 20px;
    padding: 30px 20px;
    color: #ffffff;
    box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
    text-align: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-left: 10px; /* Adjust as needed */
    display: inline-block; /* Keeps the badge in line with text */
}

.metric-card:hover {
    transform: translateY(-20px);
    box-shadow: 0 10px 30px rgba(58, 142, 214, 0.4);
}

.metric-card h5 {
    font-size: 18px;
    font-weight: 500;
    color: linear-gradient(to bottom right, #336699 0%, #01182f 100%);
    margin-bottom: 10px;
}

.metric-card h2 {
    font-size: 40px;
    font-weight: bold;
    color: #ffffff;
    margin: 0;
}

.carousel-container {
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
    max-width: 100%;
}

.carousel-content {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    scroll-behavior: smooth;
}

.carousel-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: #ffffff;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
}

.carousel-button.left {
    left: 0;
}

.carousel-button.right {
    right: 0;
}

.status-box-item {
    font-size: 15px;
    margin: 0;
    padding: 5px 10px; /* Adjust padding as needed */
    border: 1px solid #01010100; /* Define border color */
    border-radius: 20px; /* Rounded corners */
    /* background: linear-gradient(to bottom right, #ffffff 18%, #669999 77%); */
    cursor: pointer;
    text-align: center;
}

#performanceChart2 {
    width: 100%;
    height: 400px;
}

.row-green {
    background-color: #d4edda; /* Hijau muda */
}

.btn.disabled {
    pointer-events: none; /* Nonaktifkan klik */
    opacity: 0.6; /* Ubah transparansi tombol untuk menunjukkan bahwa itu dinonaktifkan */
}


.container {
            padding: 20px;
        }

        .orders-table tbody tr:hover {
            background-color: #93bbbb5d;
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
        background: linear-gradient(to bottom right, #0066999d 0%, #003366bd 100%);
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
        color: #ffffff;
    }

    .summary-item p {
        font-size: 24px;
        font-weight: bold;
        margin: 5px 0;
        color: #ffffff;
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
    /* CSS untuk membuat sliding effect */
.card {
    position: relative;
    overflow: hidden;
    width: 100%; /* Tentukan lebar sesuai kebutuhan */
}

.orders-summary {
    display: flex;
    transition: transform 0.5s ease; /* Animasi geser */
}

.orders-summary.slided {
    transform: translateX(-100%); /* Geser ke kanan */
}

.summary-item {
    flex: 0 0 auto; /* Membuat item tetap berukuran tetap */
    margin: 10px;
}

.status-box-item {
    padding: 10px;
    background-color: lightgrey;
    border-radius: 5px;
    cursor: pointer;
}

.status-box-item:hover {
    background-color: #e0e0e0;
}
</style>

    <div class="container-fluid py-4 custom-dashboard">
                    <!-- Top Header -->
                    <div style="background: linear-gradient(to bottom right, #0066999d 0%, #00162c 100%); " class="row mb-4 align-items-center">
                        <div class="col-md-6" style="position: relative;">
                            <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                                <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                            </div>
                            <h3 style="color: rgb(255, 255, 255); display: inline;">Dashboard PERFORMANCE SUPPLIER MONITORING</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <div style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom right, #0066999d 0%, #00162c 100%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                                <strong><h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="clock" class="text-right"></h3></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Metrics Row -->
                    <div class="row mb-4" id="material-section">
                        <div class="carousel-container">
                            <button class="carousel-button left" onclick="slideLeft()">‹</button>
                            <div class="carousel-content">
                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="ASI-2" onclick="selectSupplier('ASI-2')">
                                        <h3>ASI-2</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'ASI-2'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="TCF-2" onclick="selectSupplier('TCF-2')">
                                        <h3>TCF-2</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'TCF-2'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
        
                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="MAJ" onclick="selectSupplier('MAJ')">
                                        <h3>MAJ</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'MAJ'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="SWT" onclick="selectSupplier('SWT')">
                                        <h3>SWT</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'SWT'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="GIHO" onclick="selectSupplier('GIHO')">
                                        <h3>GIHO</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'GIHO'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-ms-3" class="info-box" style="cursor: zoom-in">
                                    <div class="summary-item" id="APP" onclick="selectSupplier('APP')">
                                        <h3>APP</h3>
                                        <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                @php
                                                    $supplier = 'APP'; // Sesuaikan dengan supplier yang diinginkan
                                                    $poClose = DB::table('line_store_uploads')
                                                        ->where('status', 'Close')
                                                        ->where('supplier', $supplier)
                                                        ->count();

                                                    $poOpen = DB::table('line_store_uploads')
                                                        ->whereNull('status')
                                                        ->where('supplier', $supplier)
                                                        ->count();
                                                @endphp
                                
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'Close'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO CLOSE ({{ $poClose }})
                                    </p>
                                  </strong>
                                  
                                  <strong>
                                    <p class="status-box-item openText status-text"
                                       style="font-size: 15px; margin: 0; cursor: pointer; background: rgba(93, 189, 255, 0.74);"
                                       onclick="event.stopPropagation(); fetchSupplierData('{{ $supplier }}', 'NULL'); updateSelectedSupplier('{{ $supplier }}')">
                                      PO OPEN ({{ $poOpen }})
                                    </p>
                                  </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-ms-3">
                                    <div class="summary-item">
                                        <h3>SUBCONT</h3>
                                        <div class="change">
                                             <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                <strong>
                                                    <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                                       onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">PO CLOSE</p>
                                                </strong>
                                                <strong>
                                                    <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                                    onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">PO OPEN</p>
                                                </strong>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-ms-3">
                                    <div class="summary-item">
                                        <h3>SUBCONT</h3>
                                        <div class="change">
                                             <div class="change">
                                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                                <strong>
                                                    <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35);"
                                                       onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">PO CLOSE</p>
                                                </strong>
                                                <strong>
                                                    <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74);"
                                                    onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">PO OPEN</p>
                                                </strong>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            <button class="carousel-button right" onclick="slideRight()">›</button>
                        </div>

                        <div class="carousel-container">
                            <div class="carousel-content">
                              <div class="col-md-13">
                                <div class="metric-card3">
                                  <div class="header" style="display: flex; align-items: center; justify-content: flex-start;">
                                    <h3 style="color: #ffffff; margin-right: 20px;">GRAFIK INFORMASI TRANSAKSI PER BULAN</h3>
                                  </div>
                                  <!-- Supplier name tampil disini -->
                                  <h4 id="selectedSupplierName" style="color: yellow; margin-top: 10px;">SUBCONT: -</h4>

                                  <div class="chart" style="width: 100%; overflow-x: auto; margin-top: 10px;">
                                    <div style="width: 4000px; height: 300px;">
                                        <canvas id="performanceChart2" width="4000" height="300"></canvas>
                                    </div>
                                </div>
                                
                                </div>
                              </div>
                            </div>
                            <button class="carousel-button right" onclick="slideRight()">›</button>
                          </div>


                          <div class="modal-body">
                            <div class="form-group row">
                                <div  class="col-12" id="alert"></div>
                                    <div style=" " class="col-sm-7">
                                     <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
                                        <i class="fas fa-file-excel"></i> Export Excel
                                    </button>
                                   <a href="scaninlabel"> <button class="btn btn-info"><i class="ph ph-barcode"></i> Scan IN Label</button></a>
                                   <a href="rmdnincoming"> <button class="btn btn-info"><i class="ph ph-barcode"></i>Import DN</button></a>
                                </div>
                            <div class="col-sm-5 text-right">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="display: inline-block; width: auto;">
                                <button id="searchButton" class="btn btn-secondary" style="display: inline-block;">Search</button>
                            </div>
                         <div class="table-responsive">
                            <table id="incomingTable" class="table table-hover table-bordered" style="table-layout: fixed;">
                                <thead style=" background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:white">
                                        <tr>
                                            <th style="width: 50px; text-align:center">No</th>
                                            <th style="width: 150px; text-align:center">Doc Dn</th>
                                            <th style=" text-align:center">Supplier</th>
                                            <th style=" text-align:center">Part No</th>
                                            <th style=" text-align:center">Order Qty</th>
                                            <th style=" text-align:center">Balance Qty</th>
                                            <th style=" text-align:center">Actual Qty</th>
                                            <th style=" text-align:center">Status</th>
                                            <th style=" text-align:center">Tgl Delivery</th>
                                            <th style=" text-align:center">Time</th>
                                            {{-- <th style=" text-align:center">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody  style="text-align: center;  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:white">
                                    <!-- Data tabel akan diisi di sini -->
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
                        

                       


                        

                        <!-- Bootstrap Modal -->
                     
                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content shadow-lg border-0">
                                    <div class="modal-header text-white" style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%);">
                                        <h5 class="modal-title d-flex align-items-center" id="detailModalLabel">
                                            <i class="bi bi-info-circle-fill me-2"></i> Info Detail PO
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">DOC PO</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalNoPo"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">DOC DN</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalNoDn"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">SUPPLIER</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalSupplier"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">ORDER PCS</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalOrderPart"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">Jadwal PENGIRIMAN</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalTglDelivery"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">BALANCE ORDER</label>
                                                            <div class="border border-gray p-2 bg-light text-center rounded" id="modalBalanceOrder"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-info text-white p-1 rounded">PART ORDER</label>
                                                            <div class="border border-info p-2 bg-light text-center rounded" id="modalPartNo"></div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-bold d-block text-center bg-gray text-white p-1 rounded">ACTUAL ORDER</label>
                                                            <!-- Ganti div dengan input untuk actual order -->
                                                            <input type="number" class="form-control" id="modalActualOrder" placeholder="Masukkan actual order">
                                                        </div>
                                                        <button type="button" class="btn btn-success" id="insertActualOrderBtn">Insert</button>
                                                    </div>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mt-3">
                                            <button id="btn_generate_all" class="btn btn-primary">Generate Selected QR Codes</button>
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" id="check_all" /> <!-- Checkbox untuk Check All -->
                                                        </th>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">No PO</th>
                                                        <th class="text-center">NO DN</th>
                                                        <th class="text-center">Part No</th>
                                                        <th class="text-center">Supplier</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Penerima</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="insertedData">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-white" style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%);">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                  
    
                <!-- Export Filter Modal -->
                        <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff" class="modal-header">
                                        <h5 class="modal-title" id="exportModalLabel">Export Data PO/DN Filter</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="exportForm" action="{{ route('dnIncoming.export') }}" method="POST">
                                            @csrf <!-- CSRF Token -->
    
                                            <div class="form-group">
                                                <label for="filterLine">SelectSupplier</label>
                                                <select id="filterLine" name="supplierFilter" class="form-control" onchange="toggleFields()">
                                                    <option value="">-Pilih-</option>
                                                    <option value="ALL">ALL</option>
                                                    <option value="POSCO-1">POSCO-1</option>
                                                    <option value="POSCO-2">POSCO-2</option>
                                                    <option value="TTMI">TTMI</option>
                                                    <option value="SSK">SSK</option>
                                                    <option value="SCI">SCI</option>
                                                    <option value="SCI-2">SCI-2</option>
                                                </select>
                                            </div>
    
                                            <!-- New input for DOC_PO filter -->
                                            <div class="form-group">
                                                <label for="doc_po">Enter DOC</label>
                                                <input type="text" id="docPoFilter" name="docPoFilter" class="form-control" placeholder="Enter DOC_PO" oninput="toggleFields()">
                                            </div>
    
                                            <div class="form-group">
                                                <label for="periodeFilter">Masukan Periode</label>
                                                <input type="text" id="periodeFilter" name="periodeFilter" class="form-control" placeholder="Masukan Periode" oninput="toggleFields()">
                                            </div>
    
                                        </form>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" form="exportForm" class="btn btn-primary" id="exportBtn">Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

                <script>
                    function updateClock() {
                        const clockElement = document.getElementById("clock");
                        const now = new Date();

                        // Get time
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');

                        // Get day of the week, month, and date
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September',
                            'Oktober', 'November', 'Desember'
                        ];

                        const dayName = days[now.getDay()];
                        const monthName = months[now.getMonth()];
                        const date = now.getDate();
                        const year = now.getFullYear();

                        // Format: Day, Month Date, Year HH:MM:SS
                        clockElement.innerText = `${dayName},  ${date} ${monthName} ${year}, ${hours}:${minutes}:${seconds}`;
                    }
                    setInterval(updateClock, 1000); // Memperbarui jam setiap detik
                    updateClock(); // Menampilkan jam langsung saat halaman dimua

                    function formatDate(dateString) {
                        const date = new Date(dateString);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
                        const day = String(date.getDate()).padStart(2, '0');
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const seconds = String(date.getSeconds()).padStart(2, '0');

                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }


                    function fetchSupplierData(supplier, status) {
                        $.ajax({
                            url: "{{ route('linestoreindex3.getSupplierData') }}",
                            type: 'GET',
                            data: {
                                supplier: supplier, // Hanya kirim supplier
                                status: status
                            },
                            success: function(response) {
                                updateTable(response);
                                updateChartFromData(response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching data:', error);
                            }
                        });
                    }

                    //Grafik

                    function selectSupplier(supplierName) {
                        console.log('selectSupplier dipanggil dengan:', supplierName);
                        const supplierNameEl = document.getElementById('selectedSupplierName');
                        if (supplierNameEl) {
                            supplierNameEl.textContent = 'SUBCONT: ' + supplierName;
                        } else {
                            console.error('Elemen #selectedSupplierName tidak ditemukan!');
                        }
                    }

                    function updateSelectedSupplier(supplierName) {
                        const supplierNameEl = document.getElementById('selectedSupplierName');
                        if (supplierNameEl) {
                            supplierNameEl.textContent = 'SUBCONT: ' + supplierName;
                        }
                    }

                    function updateChartFromData(data) {
                        let labels = data.map(item => item.part_no);
                        let planningData = data.map(item => item.order_part);
                        let actualData = data.map(item => item.actual_order);
                        let materialOutData = data.map(item => item.material_out); // ✅ Tambah ini
                        let gapData = planningData.map((val, i) => val - materialOutData[i]); // ✅ Hitung gap otomatis

                        updateChart(labels, planningData, actualData, materialOutData, gapData);
                    }

                    let performanceChart2; // Simpan instance Chart agar bisa diperbarui nanti
                    function updateChart(labels, planningData, actualData, materialOutData, gapData) {
                        if (performanceChart2) {
                            performanceChart2.data.labels = labels;
                            performanceChart2.data.datasets[0].data = planningData;
                            performanceChart2.data.datasets[1].data = actualData;
                            performanceChart2.data.datasets[2].data = materialOutData;
                            performanceChart2.data.datasets[3].data = gapData;
                            performanceChart2.update();
                        } else {
                            const ctx2 = document.getElementById('performanceChart2').getContext('2d');
                            performanceChart2 = new Chart(ctx2, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                            label: 'Planning Order (tons)',
                                            data: planningData,
                                            backgroundColor: 'rgba(0, 151, 255, 0.6)',
                                            borderColor: 'rgba(0, 151, 255, 1)',
                                            borderWidth: 2
                                        },
                                        {
                                            label: 'Actual Order (tons)',
                                            data: actualData,
                                            backgroundColor: 'rgba(0, 255, 141, 0.6)',
                                            borderColor: 'rgba(0, 255, 141, 1)',
                                            borderWidth: 2
                                        },
                                        {
                                            label: 'Material Out (tons)', // ✅ Bar ke-3
                                            data: materialOutData,
                                            backgroundColor: 'rgba(255, 165, 0, 0.6)',
                                            borderColor: 'rgba(255, 165, 0, 1)',
                                            borderWidth: 2
                                        },
                                        {
                                            label: 'Gap (Planning - Material Out)', // ✅ Bar ke-4
                                            data: gapData,
                                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 2
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 50,
                                                font: {
                                                    size: 14,
                                                    weight: 'bold'
                                                },
                                                color: '#ffffff'
                                            },
                                            grid: {
                                                color: 'rgba(255, 255, 255, 0.2)'
                                            },
                                            title: {
                                                display: true,
                                                text: 'Order Amount (tons)',
                                                font: {
                                                    size: 16,
                                                    weight: 'bold'
                                                },
                                                color: '#ffffff'
                                            }
                                        },
                                        x: {
                                            ticks: {
                                                font: {
                                                    size: 14,
                                                    weight: 'bold'
                                                },
                                                color: '#ffffff'
                                            },
                                            grid: {
                                                color: 'rgba(255, 255, 255, 0.2)'
                                            },
                                            title: {
                                                display: true,
                                                text: 'Part No',
                                                font: {
                                                    size: 16,
                                                    weight: 'bold'
                                                },
                                                color: '#ffffff'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            labels: {
                                                font: {
                                                    size: 14,
                                                    weight: 'bold'
                                                },
                                                color: '#ffffff'
                                            }
                                        },
                                        datalabels: {
                                            color: 'white',
                                            anchor: 'center',
                                            align: 'center',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            formatter: value => value
                                        }
                                    }
                                },
                                plugins: [ChartDataLabels]
                            });
                        }
                    }


                    // Bagian tabel bawah

                    function updateTable(data) {
                        let tableBody = $('#incomingTable tbody');
                        tableBody.empty();

                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="12">No data available</td></tr>');
                            return;
                        }

                        data.forEach((item, index) => {
                            let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${item.no_dn}</td>
                            <td>${item.supplier}</td>
                            <td>${item.part_no}</td>
                            <td style="background-color:rgba(223, 252, 0, 0.42)">${item.order_part}</td> 
                            <td>${item.balance_order || '0'}</td> 
                            <td style="background-color:rgba(0, 252, 35, 0.29)">${item.actual_order || '0'}</td> 
                            <td>${item.status || 'OPEN'}</td>
                            <td>${item.tgl_delivery}</td>
                            <td>${item.created_at}</td>
                            `;
                            tableBody.append(row);
                        });

                        // Simpan data untuk digunakan di modal
                        window.tableData = data;
                    }

                    $(document).on('click', '#btn_detail', function(e) {
                        e.preventDefault(); // Prevent default link behavior

                        let partNo = $(this).data('part_no');
                        let noPo = $(this).data('no_po');
                        let noDn = $(this).data('no_dn');
                        let supplier = $(this).data('supplier');
                        let balanceOrder = $(this).data('balance_order');
                        let orderPcs = $(this).data('order_part');
                        let tglDelivery = $(this).data('tgl_delivery');

                        console.log('Clicked button data:', partNo, noPo, noDn, supplier, balanceOrder, orderPcs);

                        // Fetch data from line_store_uploads
                        $.ajax({
                            url: "{{ route('linestoreindex3.getSupplierData') }}", // Replace with your actual route
                            type: 'GET',
                            data: {
                                part_no: partNo,
                                no_po: noPo,
                                no_dn: noDn,
                                supplier: supplier
                            },
                            success: function(response) {
                                let partsData = response || [];
                                console.log('Response:', partsData);

                                let fetchedSupplier = partsData.length > 0 ? partsData[0].supplier : supplier;
                                let fetchedBalanceOrder = partsData.length > 0 ? partsData[0].balance_order :
                                    balanceOrder;
                                let fetchedOrderPcs = partsData.length > 0 ? partsData[0].order_part : orderPcs;
                                let fetchedTglDelivery = partsData.length > 0 ? partsData[0].tgl_delivery :
                                    tglDelivery;

                                $('#modalNoPo').text(noPo);
                                $('#modalNoDn').text(noDn);
                                $('#modalPartNo').text(partNo);
                                $('#modalSupplier').text(fetchedSupplier);
                                $('#modalBalanceOrder').text(fetchedBalanceOrder || '-');
                                $('#modalOrderPart').text(fetchedOrderPcs || '-');
                                $('#modalTglDelivery').text(fetchedTglDelivery || '-');

                                let partTableBody = $('#detailPart tbody');
                                partTableBody.empty();

                                if (partsData.length === 0) {
                                    partTableBody.append('<tr><td colspan="8">No parts available</td></tr>');
                                } else {
                                    partsData.forEach((part, partIndex) => {
                                        let row = `<tr>
                                            <td><input type="checkbox" /></td>
                                            <td class="text-center">${partIndex + 1}</td>
                                            <td class="text-center">${part.no_po}</td>
                                            <td class="text-center">${part.no_dn}</td>
                                            <td class="text-center">${part.part_no}</td>
                                            <td class="text-center">${part.supplier}</td>
                                            <td class="text-center">${part.balance_order || 'N/A'}</td>
                                            <td class="text-center">${part.order_part}</td>
                                            <td class="text-center">${part.tgl_delivery}</td>
                                        </tr>`;
                                        partTableBody.append(row);
                                    });
                                }

                                // Fetch data from line_store_incoming_parts
                                $.ajax({
                                    url: "{{ route('linestoreindex3.getIncomingParts') }}", // Ganti dengan route yang benar
                                    type: 'GET',
                                    data: {
                                        no_po: noPo,
                                        no_dn: noDn,
                                        part_no: partNo
                                    },
                                    success: function(response) {
                                        let incomingParts = response || [];
                                        let incomingTableBody = $('#insertedData');
                                        incomingTableBody.empty();

                                        if (incomingParts.length === 0) {
                                            incomingTableBody.append(
                                                '<tr><td colspan="8" class="text-center">No incoming parts available</td></tr>'
                                                );
                                        } else {
                                            incomingParts.forEach((part, index) => {
                                                let row = `<tr>
                                                    <td><input type="checkbox" /></td>
                                                    <td class="text-center">${index + 1}</td>
                                                    <td class="text-center">${part.no_po}</td>
                                                    <td class="text-center">${part.no_dn}</td>
                                                    <td class="text-center">${part.part_no}</td>
                                                    <td class="text-center">${part.supplier}</td>
                                                    <td class="text-center">${part.actual_order}</td>
                                                    <td class="text-center">${part.created_by || 'N/A'}</td>
                                                </tr>`;
                                                incomingTableBody.append(row);
                                            });
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error fetching incoming parts:', error);
                                    }
                                });

                                $('#detailModal').modal('show');
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching parts data:', error);
                            }
                        });
                    });

                    // function loadTableData(supplier) {
                    //     $.ajax({
                    //         url: "{{ route('linestoreindex3.getLineStoreUploads') }}",
                    //         type: 'GET',
                    //         data: {
                    //             supplier: supplier
                    //         }, // Kirim supplier (jika ada)
                    //         success: function(response) {
                    //             let tableBody = $('#incomingTable tbody');
                    //             tableBody.empty();

                    //             if (response.length === 0) {
                    //                 tableBody.append('<tr><td colspan="10">No data available</td></tr>');
                    //                 return;
                    //             }

                    //             let labels = [];
                    //             let planningData = [];
                    //             let actualData = [];

                    //             // Simpan data agar bisa digunakan di viewDetails
                    //             window.tableData = response;

                    //             response.forEach((item, index) => {
                    //                 labels.push(item.part_no); // Label dari Part No
                    //                 planningData.push(item.order_part); // Data untuk Planning Order
                    //                 actualData.push(item.actual_order); // Data untuk Actual Order

                    //                 // Tambahkan data ke tabel
                    //                 tableBody.append(`
                    //                 <tr>
                    //                     <td>${index + 1}</td>
                    //                     <td>${item.no_po}</td>
                    //                     <td>${item.no_dn}</td>
                    //                     <td>${item.supplier}</td>
                    //                     <td>${item.part_no}</td>
                    //                     <td>${item.order_part}</td> 
                    //                     <td>${item.balance_order}</td> 
                    //                     <td>${item.actual_order || '0'}</td> 
                    //                     <td>${item.status || 'OPEN'}</td>
                    //                     <td>${item.tgl_delivery}</td>
                    //                     <td>${item.created_at ? new Date(item.created_at).toISOString().split('T')[0] : 'OPEN'}</td>
                    //                     <td>
                    //                         <a href="#" id="btn_detail" data-id="${item.id}" class="btn btn-warning btn-sm">
                    //                             <i class="fas fa-pencil-alt"></i>
                    //                         </a>
                    //                     </td>
                    //                 </tr>
                    //             `);
                    //             });

                    //             // Panggil fungsi untuk update Chart
                    //             updateChart(labels, planningData, actualData);
                    //         },
                    //         error: function(error) {
                    //             console.log("Error fetching data:", error);
                    //         }
                    //     });
                    // }

                    // $('#insertActualOrderBtn').on('click', function() {
                    //     var actualOrder = $('#modalActualOrder').val();
                    //     var partNo = $('#modalPartNo').text(); // Ambil part number dari modal
                    //     var supplier = $('#modalSupplier').text();
                    //     var noPo = $('#modalNoPo').text();
                    //     var noDn = $('#modalNoDn').text();

                    //     if (actualOrder && partNo) {
                    //         $.ajax({
                    //             url: "{{ route('linestoreindex3.store') }}", // Pastikan route ini sesuai dengan yang ada
                    //             method: 'POST',
                    //             data: {
                    //                 actual_order: actualOrder,
                    //                 part_no: partNo,
                    //                 supplier: supplier,
                    //                 no_po: noPo,
                    //                 no_dn: noDn,
                    //                 _token: '{{ csrf_token() }}' // Jangan lupa untuk menyertakan token CSRF
                    //             },
                    //             success: function(response) {
                    //                 if (response.success) {
                    //                     // Menggunakan SweetAlert untuk menampilkan pesan sukses
                    //                     Swal.fire({
                    //                         icon: 'success',
                    //                         title: 'Data berhasil disimpan',
                    //                         showConfirmButton: false,
                    //                         timer: 1500
                    //                     }).then(function() {
                    //                         // Kosongkan input actual_order
                    //                         $('#modalActualOrder').val('');
                    //                         // Tetap di modal, tidak menutup modal
                    //                     });
                    //                 } else {
                    //                     // Jika gagal, tampilkan pesan gagal
                    //                     Swal.fire({
                    //                         icon: 'error',
                    //                         title: 'Gagal menyimpan data',
                    //                         text: response.message || 'Terjadi kesalahan.'
                    //                     });
                    //                 }
                    //             },
                    //             error: function(xhr, status, error) {
                    //                 // Jika ada kesalahan pada AJAX request
                    //                 Swal.fire({
                    //                     icon: 'error',
                    //                     title: 'Terjadi kesalahan',
                    //                     text: error
                    //                 });
                    //             }
                    //         });
                    //     } else {
                    //         Swal.fire({
                    //             icon: 'warning',
                    //             title: 'Harap isi semua field yang diperlukan',
                    //             showConfirmButton: true
                    //         });
                    //     }
                    // });
                </script>
@endpush
