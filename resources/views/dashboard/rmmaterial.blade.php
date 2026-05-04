@extends('layouts.app')

@section('content')
    <style>
        #incomingTable.table-hover tbody tr:hover {
            background: linear-gradient(to top, #003366 17%, #ffffff 99%) !important;
            color: #000000 !important;
            /* Warna teks saat hover */
            transition: background 0.3s ease-in-out;
        }

        /* Warna Header */
        #incomingTable thead tr {
            background-color: black;
            color: white;
        }

        #insertedData:empty::before {
            content: none;
        }


        .custom-dashboard {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 26px;
            font-weight: bold;
            color: #000000;
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
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 40px;
            padding: 25px 20px;
            color: #000000;
            box-shadow: 5 10px 20px rgba(0, 0, 0, 0.84);
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* margin-left: 10px; Removed to align to left edge */
            display: inline-block;
            /* Keeps the badge in line with text */
        }

        .metric-card2 {
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 20px;
            padding: 30px 20px;
            color: #000000;
            box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* margin-left: 10px; Removed to align to left edge */
            display: inline-block;
            /* Keeps the badge in line with text */
        }

        .metric-card3 {
            background: linear-gradient(to bottom right, #003366 0%, #006699 100%);
            border-radius: 20px;
            padding: 30px 20px;
            color: #000000;
            box-shadow: 0 6px 15px rgba(58, 142, 214, 0.3);
            text-align: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* margin-left: 10px; Removed to align to left edge */
            display: inline-block;
            /* Keeps the badge in line with text */
        }

        .metric-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 10px 30px rgba(58, 142, 214, 0.4);
        }

        .metric-card h5 {
            font-size: 18px;
            font-weight: 500;
            color: linear-gradient(to bottom right, #336699 0%, #003366 100%);
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
            width: 100%;
        }

        .carousel-content {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
            flex: 1;
            width: 100%;
            justify-content: space-between;
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
            padding: 5px 10px;
            /* Adjust padding as needed */
            border: 1px solid #01010100;
            /* Define border color */
            border-radius: 20px;
            /* Rounded corners */
            /* background: linear-gradient(to bottom right, #ffffff 18%, #669999 77%); */
            cursor: pointer;
            text-align: center;
        }

        #performanceChart2 {
            width: 100%;
            height: 400px;
        }

        .row-green {
            background-color: #d4edda;
            /* Hijau muda */
        }

        .btn.disabled {
            pointer-events: none;
            /* Nonaktifkan klik */
            opacity: 0.6;
            /* Ubah transparansi tombol untuk menunjukkan bahwa itu dinonaktifkan */
        }

        /* Background modal dengan gradient */
        .modal-content {
            background: linear-gradient(to bottom right, #006699 0%, #003366 100%);
            color: white;
            border-radius: 12px;
            border: 2px solid white;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Header dan Footer modal */
        .modal-header,
        .modal-footer {
            border: none;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Styling tombol close */
        .btn-close {
            filter: invert(1);
        }

        /* Animasi muncul modal */
        .modal.fade .modal-dialog {
            transform: translate(0, -50px);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }

        /* Tabel styling */
        .table {
            color: rgb(0, 0, 0);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* Header tabel */
        .table thead {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Warna border tabel */
        .table-bordered {
            border: 1px solid white;
        }

        /* Warna teks dalam tabel
        .table td {
            color: rgb(0, 0, 0) !important;
        } */

        /* Hover efek pada tabel */
        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        /* Styling untuk DataTables */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            border-radius: 5px;
            padding: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .dataTables_filter {
            display: none !important;
        }
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <!-- Top Header -->
        <div style="background: linear-gradient(to bottom, #003366 25%, #000000 78%);" class="row mb-4 align-items-center">
            <div class="col-md-6" style="position: relative;">
                <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                    <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                </div>
                <h5 style="color: white; display: inline;">Dashboard Informasi Incoming Material</h5>
            </div>
            <div class="col-md-6 text-right">
                <div
                    style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                    <strong>
                        <h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="clock" class="text-right"></h3>
                    </strong>
                </div>
            </div>
        </div>




        <!-- Metrics Row -->
        <div class="row mb-4" id="material-section">
            <div class="carousel-container">
                <button class="carousel-button left" onclick="slideLeft()">‹</button>
                <div class="carousel-content">
                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('POSCO-1')">
                            <h2>POSCO-1</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('POSCO-1', 'Close')">PO CLOSE
                                    </p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('POSCO-1', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('POSCO-2')">
                            <h2>POSCO-2</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('POSCO-2', 'Close')">PO CLOSE
                                    </p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('POSCO-2', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>


                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('TTMI')">
                            <h2>TTMI</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('TTMI', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('TTMI', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('SSK')">
                            <h2>SSK</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SSK', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SSK', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>


                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('SCI')">
                            <h2>SCI</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-ms-3">
                    <div class="metric-card" onclick="showIncomingMaterials('SCI-2')">
                        <h2>SCI-2</h2>
                        <br>
                        <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                            <strong>
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('-', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('-', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
                            </strong>
                        </div>
                    </div>
                </div> --}}
                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('HTI')">
                            <h2>HTI</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('HTI', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('HTI', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('SAI')">
                            <h2>SAI</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SAI', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('SAI', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('JSSI')">
                            <h2>JSSI</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('JSSI', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('JSSI', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-ms-3">
                        <div class="metric-card" onclick="showIncomingMaterials('USC')">
                            <h2>USC</h2>
                            <br>
                            <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                <strong>
                                    <p class="status-box-item closeText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('USC', 'Close')">PO CLOSE</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item openText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                        onclick="event.stopPropagation(); fetchSupplierData('USC', 'NULL')">PO OPEN</p>
                                </strong>
                                <strong>
                                    <p class="status-box-item totalText status-text"
                                        style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">
                                        TOTAL</p>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-button right" onclick="slideRight()">›</button>
            </div>


            <div class="carousel-container">
                <div class="carousel-content">
                    <div class="col-md-9">
                        <div class="metric-card2" style="width: 100%;">
                            <strong>
                                <h3 style="color: #ffffff; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                    MONITORING PERFORMANCE DELIVERY SUPPLIER</h3>
                            </strong>
                            <div class="chart" style="width: 100%; height: 550px;">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="metric-card2" style="width: 100%;">
                            <h3 style="color: #ffffff">PO PRESENTATION MONTHLY</h3>
                            <input type="hidden" id="deliveryFilter2" />
                            <div id="totalOrder2" style="color: white; font-size: 16px; margin-bottom: 10px;">Total Order (tons): 0 tons</div>
                            <div id="totalActual2" style="color: white; font-size: 16px; margin-bottom: 20px;">Total Actual (tons): 0 tons</div>
                            <div class="chart-container-row" style="display: flex; align-items: center; justify-content: space-between; min-height: 400px; margin-top: 15px; gap: 15px; width: 100%;">
                                <div style="width: 45%; height: 320px; position: relative;">
                                    <canvas id="orderActualPieChart"></canvas>
                                </div>
                                <div id="supplierPerformanceList" style="width: 53%; height: 380px; color: white; text-align: left; padding: 15px; overflow-y: auto; background: rgba(0,0,0,0.5); border-radius: 15px; border: 1px solid rgba(0, 255, 255, 0.2); box-shadow: 0 0 20px rgba(0,0,0,0.5), inset 0 0 10px rgba(0, 255, 255, 0.05);">
                                    <h4 style="font-size: 16px; border-bottom: 2px solid #00ffff; padding-bottom: 10px; margin-bottom: 20px; font-weight: 800; color: #00ffff; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);">Achievement</h4>
                                    <!-- Supplier percentages will go here -->
                                </div>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <p class="info-title mb-1" style="font-size: 13px; background-color:#00ccff; border-radius: 4px; padding: 2px 5px; color: black; font-weight: bold;">Total PO</p>
                                    <h3 id="totalItems" class="info-value"
                                        style="font-size: 16px; font-weight: bold; color:#ffffff">0 PO</h3>
                                </div>
                                <div class="col-md-4">
                                    <p class="info-title mb-1" style="font-size: 13px; background-color:#40ff62; border-radius: 4px; padding: 2px 5px; color: black; font-weight: bold;">PO CLOSE</p>
                                    <h3 id="poCloseDifference" class="info-value"
                                        style="font-size: 16px; font-weight: bold; color:white">0 PO</h3>
                                </div>
                                <div class="col-md-4">
                                    <p class="info-title mb-1" style="font-size: 13px; background-color:#ff9900; border-radius: 4px; padding: 2px 5px; color: black; font-weight: bold;">PO OPEN</p>
                                    <h3 id="nullStatusCount" class="info-value"
                                        style="font-size: 16px; font-weight: bold; color:white">0 PO</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-button left" onclick="slideLeft()">‹</button>
                <button class="carousel-button right" onclick="slideRight()">›</button>
            </div>

            <div class="carousel-container">
                <div class="carousel-content">
                    <div class="col-md-12">
                        <div class="metric-card3" style="width: 100%;">
                            <strong>
                                <h1 style="color: #ffffff; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                    DAILY INCOMING </h1>
                            </strong>
                            <div class="chart" style="width: 100%; height: 530px; position: relative; margin-top: 10px;">
                                <canvas id="performanceChart2" width="800" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-button right" onclick="slideRight()">›</button>
            </div>
        </div>
    </div>

    <br>


    <div class="form-group row">
        <div class="col-12" id="alert"></div>
        <div class="col-sm-7">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <a href="scaninlabel"><button class="btn btn-info"><i class="ph ph-barcode"></i> Scan IN Label</button></a>
            <a href="rmdnincoming"><button class="btn btn-info"><i class="ph ph-barcode"></i> Import DN</button></a>
        </div>

        <!-- Search Bar & Page Length Selector di tempat yang sama dengan tombol -->
        <div class="col-sm-5 text-right d-flex align-items-center justify-content-end">
            <label class="mr-2">Show
                <select id="dataLength" class="form-control d-inline-block w-auto">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select> entries
            </label>
            <input type="text" id="tableSearch" class="form-control ml-2 w-auto" placeholder="Cari data...">
        </div>
    </div>

    <div class="table-responsive">
        <table id="incomingTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Doc PO</th>
                    <th>Doc DN</th>
                    <th>Part No</th>
                    <th>Model</th>
                    <th>Spec</th>
                    <th>Spec T</th>
                    <th>Spec W</th>
                    <th>Spec L</th>
                    <th>Supplier</th>
                    <th>Order Sheet</th>
                    <th>Order Kg</th>
                    <th>Actual Sheet</th>
                    <th>Balance Sheet</th>
                    <th>Status</th>
                    <th>Delivery</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


    <!-- Export Filter Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff"
                    class="modal-header">
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
                            <select id="filterLine" name="supplierFilter" class="form-control"
                                onchange="toggleFields()">
                                <option value="">-Pilih-</option>
                                <option value="ALL">ALL</option>
                                <option value="POSCO-1">POSCO-1</option>
                                <option value="POSCO-2">POSCO-2</option>
                                <option value="TTMI">TTMI</option>
                                <option value="SSK">SSK</option>
                                <option value="SCI">SCI</option>
                                {{-- <option value="SCI-2">SCI-2</option> --}}
                            </select>
                        </div>

                        <!-- New input for DOC_PO filter -->
                        <div class="form-group">
                            <label for="doc_po">Enter DOC</label>
                            <input type="text" id="docPoFilter" name="docPoFilter" class="form-control"
                                placeholder="Enter DOC_PO" oninput="toggleFields()">
                        </div>

                        <div class="form-group">
                            <label for="periodeFilter">Masukan Periode</label>
                            <input type="text" id="periodeFilter" name="periodeFilter" class="form-control"
                                placeholder="Masukan Periode" oninput="toggleFields()">
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

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-lg border-0">
                <div style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%);"
                    class="modal-header text-white">
                    <h5 class="modal-title d-flex align-items-center" id="detailModalLabel">
                        <i class="bi bi-info-circle-fill me-2"></i> Info Detail PO
                    </h5>
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Close
                </div>
                <div class="modal-body bg-light">
                    <div class="row g-3">
                        <div class="col-md-1">
                            <label for="detailId" class="form-label fw-bold">Id</label>
                            <input type="text" class="form-control border-primary" id="detailId" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="detailDocPo" class="form-label fw-bold">DOC PO</label>
                            <input type="text" class="form-control border-primary" id="detailDocPo" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="detailDocDn" class="form-label fw-bold">DOC DN</label>
                            <input type="text" class="form-control border-primary" id="detailDocDn" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="detailOrderSheet" class="form-label fw-bold">Order Sheet</label>
                            <input type="number" class="form-control border-primary" id="detailOrderSheet" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="detailKg" class="form-label fw-bold">Order KG</label>
                            <input type="number" class="form-control border-primary" id="detailKg" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="kgSheet" class="form-label fw-bold">Sheet / KG</label>
                            <input type="text" class="form-control border-primary" id="kgSheet" readonly>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-2">
                            <label for="detailPartNo" class="form-label fw-bold">Part No</label>
                            <input type="text" class="form-control border-primary" id="detailPartNo" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="detailSpec" class="form-label fw-bold">Spek Material</label>
                            <input type="text" class="form-control border-primary" id="detailSpec" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailModel" class="form-label fw-bold">Model</label>
                            <input type="text" class="form-control border-primary" id="detailModel" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailT" class="form-label fw-bold">T</label>
                            <input type="text" class="form-control border-primary" id="detailT" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailW" class="form-label fw-bold">W</label>
                            <input type="text" class="form-control border-primary" id="detailW" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailL" class="form-label fw-bold">L</label>
                            <input type="text" class="form-control border-primary" id="detailL" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailSupplier" class="form-label fw-bold">Supplier</label>
                            <input type="text" class="form-control border-primary" id="detailSupplier" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="detailDelivery" class="form-label fw-bold">Delivery</label>
                            <input type="text" class="form-control border-primary" id="detailDelivery" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailRak" class="form-label fw-bold">NO Rak</label>
                            <input type="text" class="form-control border-primary" id="detailRak" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="detailStatus" class="form-label fw-bold">Status</label>
                            <input type="text" class="form-control border-primary" id="detailStatus" readonly>
                        </div>

                    </div>

                    <hr class="mt-4">
                    <div class="form-group row">
                        <label for="detailPartNo2" class="col-sm-2 col-form-label">Part No:</label>
                        <div class="col-sm-4">
                            <input type="hidden" id="id" class="form-control">
                            <input type="text" id="part_no" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <form id="insertForm" action="/your-endpoint" method="POST">
                        <div class="row mb-3">
                            <label for="actual" class="col-sm-2 col-form-label">Actual:</label>
                            <div class="col-sm-4">
                                <input type="number" inputmode="numeric" id="actual"
                                    class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kg" class="col-sm-2 col-form-label">KG:</label>
                            <div class="col-sm-4">
                                <input type="text" id="kg" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row mb-3" style="display: none">
                            <label for="sts_scan" class="col-sm-2 col-form-label">sts_scan:</label>
                            <div class="col-sm-4">
                                <input type="text" id="sts_scan" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-end">
                                <button type="submit" class="btn btn-success" id="btnInsert">Insert d</button>
                            </div>
                        </div>
                    </form>
                    <!-- Tabel untuk menampilkan data yang di-insert -->
                    <div class="table-responsive mt-3">
                        <button id="btn_generate_all" class="btn btn-primary">Generate Selected QR Codes</button>

                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="check_all" /> <!-- Checkbox untuk Check All -->
                                    </th>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Doc PO</th>
                                    <th class="text-center">Doc DN</th>
                                    <th class="text-center">Part No</th>
                                    <th class="text-center">Actual</th>
                                    <th class="text-center">Spec</th>
                                    <th class="text-center">KG Sheet</th>
                                    <th class="text-center">Generate</th>
                                    <th class="text-center">Update Time</th>
                                    <th class="text-center" style="width: 120px">Action</th>
                                    <th class="text-center">UniqNo</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="insertedData">
                            </tbody>
                        </table>
                    </div>

                </div>
                <div style="background: linear-gradient(to bottom right, #006699 0%, #003366 100%);"
                    class="modal-footer text-white">
                    <button type="button" class="close; btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Close
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detail Data</h5>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Data dari JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">Close</button>
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
            document.getElementById('insertForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman form secara default

                console.log('Form submitted');

                // Ambil data form menggunakan FormData
                let formData = new FormData(this);

                // Gantilah '/your-endpoint' dengan URL tujuan yang sesuai
                fetch('/your-endpoint', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Lakukan sesuatu dengan responnya
                    })
                    .catch(error => console.error('Error:', error));
            });

            $('#myTable').DataTable({
                "language": {
                    "emptyTable": "" // Mengosongkan pesan "No data available"
                }
            });

            // document.getElementById("searchButton").addEventListener("click", function() {
            //       let searchTerm = document.getElementById("searchInput").value.toLowerCase();
            //     let tableRows = document.querySelectorAll("#incomingTable tbody tr");
            //      tableRows.forEach(row => {
            //         let cells = row.getElementsByTagName("td");
            //         let rowContainsSearchTerm = false;

            //         for (let i = 0; i < cells.length; i++) {
            //             if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
            //                 rowContainsSearchTerm = true;
            //                 break;
            //             }
            //         }

            //         row.style.display = rowContainsSearchTerm ? "" : "none"; // Tampilkan atau sembunyikan baris
            //     });
            // });

            function slideLeft() {
                const carousel = document.querySelector('.carousel-content');
                carousel.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            }

            function slideRight() {
                const carousel = document.querySelector('.carousel-content');
                carousel.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }

            /// grafik q

            document.addEventListener("DOMContentLoaded", function() {
                let chart = null;
                let currentFilterValue = ''; // Simpan filter created_at saat ini

                function fetchAndUpdateChart() {
                    // Fetch data dari server dengan filter created_at jika ada
                    const url = new URL("{{ route('dashboardrm.getSupplierData2') }}");
                    if (currentFilterValue) {
                        url.searchParams.append('created_at', currentFilterValue); // Tambahkan parameter created_at
                    }

                    fetch(url, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Fungsi untuk menghitung total data berdasarkan supplier
                            function sumDataBySupplier(data) {
                                return data.reduce((acc, item) => {
                                    const supplier = item.supplier;
                                    if (!acc[supplier]) {
                                        acc[supplier] = {
                                            total_order_kg: 0,
                                            total_actual_kg: 0
                                        };
                                    }
                                    acc[supplier].total_order_kg += item.total_order_kg;
                                    acc[supplier].total_actual_kg += item.total_actual_kg;
                                    return acc;
                                }, {});
                            }


                            function displayTotals(data) {
                                const totalOrderKg = data.reduce((sum, item) => sum + item.total_order_kg, 0);
                                const totalActualKg = data.reduce((sum, item) => sum + item.total_actual_kg, 0);
                                const totalOutstanding = totalOrderKg - totalActualKg;

                                // document.getElementById('totalOrder').textContent = `Total Order (tons): ${(totalOrderKg / 1000).toFixed(2)} tons`;
                                // document.getElementById('totalActual').textContent = `Total Actual (tons): ${(totalActualKg / 1000).toFixed(2)} tons`;
                                // document.getElementById('totalOutStanding').textContent = `Total Outstanding (tons): ${(totalOutstanding / 1000).toFixed(2)} tons`;
                            }

                            // Fungsi untuk memperbarui grafik berdasarkan data
                            function updateChart(filteredData) {
                                const summedData = sumDataBySupplier(filteredData);

                                const labels = Object.keys(summedData);
                                const orderSheetData = labels.map(supplier => summedData[supplier].total_order_kg /
                                    1000);
                                const actualSheetData = labels.map(supplier => summedData[supplier]
                                    .total_actual_kg / 1000);
                                const outStandingData = labels.map(supplier =>
                                    Math.max((summedData[supplier].total_order_kg - summedData[supplier]
                                        .total_actual_kg) / 1000, 0)
                                );

                                chart.data.labels = labels;
                                chart.data.datasets[0].data = orderSheetData;
                                chart.data.datasets[1].data = actualSheetData;
                                chart.data.datasets[2].data = outStandingData;
                                chart.update();

                                displayTotals(filteredData);
                            }



                            if (!chart) {
                                const ctx = document.getElementById('performanceChart').getContext('2d');

                                chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [],
                                        datasets: [{
                                                label: 'Total Order (tons)',
                                                data: [],
                                                backgroundColor: 'rgba(0, 157, 255, 0.68)',
                                                borderColor: 'rgba(0, 29, 255, 1)',
                                                borderWidth: 2,
                                            },
                                            {
                                                label: 'Total Actual (tons)',
                                                data: [],
                                                backgroundColor: 'rgba(0, 255, 82, 0.35)',
                                                borderColor: 'rgba(0, 255, 141, 1)',
                                                borderWidth: 2,
                                            },
                                            {
                                                label: 'Total OutStanding (tons)',
                                                data: [],
                                                backgroundColor: 'rgba(247, 10, 41, 0.5)',
                                                borderColor: 'rgba(247, 0, 0, 1)',
                                                borderWidth: 2,
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                grid: {
                                                    color: 'rgb(255,255,255)'
                                                },
                                                ticks: {
                                                    color: 'rgb(255,255,255)',
                                                    font: {
                                                        size: 16
                                                    },
                                                    callback: function(value) {
                                                        return value + ' tons';
                                                    }
                                                }
                                            },
                                            x: {
                                                grid: {
                                                    color: 'rgb(255,255,255)'
                                                },
                                                ticks: {
                                                    color: 'rgb(255,255,255)',
                                                    font: {
                                                        size: 17
                                                    }
                                                }
                                            }
                                        },
                                        plugins: {
                                            legend: {
                                                labels: {
                                                    color: 'rgb(255,255,255)',
                                                    font: {
                                                        size: 20,
                                                        weight: 'bold'
                                                    }
                                                }
                                            },
                                            datalabels: {
                                                anchor: 'end',
                                                align: 'top',
                                                color: 'rgba(0, 0, 0, 1)',
                                                backgroundColor: 'rgba(255, 255, 255, 0.63)',
                                                borderRadius: 4,
                                                padding: 6,
                                                font: {
                                                    size: 15,
                                                    weight: 'bold'
                                                },
                                                formatter: function(value) {
                                                    return value.toFixed(2) + ' tons';
                                                }
                                            }
                                        }
                                    },
                                    plugins: [ChartDataLabels]
                                });
                            }

                            updateChart(data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                // Fetch pertama dan update chart
                fetchAndUpdateChart();

                // Tambahkan event listener untuk tombol filter
                document.getElementById('filterButton').addEventListener('click', function() {
                    currentFilterValue = document.getElementById('deliveryFilter').value;
                    fetchAndUpdateChart();
                });

                // Auto-refresh data setiap 30 detik
                setInterval(() => {
                    fetchAndUpdateChart();
                }, 3000); // 30 detik
            });




            document.addEventListener("DOMContentLoaded", function() {
                let chart = null;

                function fetchAndDisplayTotals(createdAt = '') {
                    const filterDate = createdAt || document.getElementById('deliveryFilter2')
                        .value; // Get the filter date

                    fetch("{{ route('dashboardrm.getSupplierData3') }}", {
                            method: 'GET',
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                console.log('No data found for the selected filter.');

                                // Set chart data to 0 if there's no data
                                document.getElementById('totalOrder2').textContent = `Total Order (tons): 0 tons`;
                                document.getElementById('totalActual2').textContent = `Total Actual (tons): 0 tons`;

                                if (chart) {
                                    chart.data.datasets[0].data = [0, 0]; // Set empty data for pie chart
                                    chart.update();
                                }
                                return; // Exit early if no data
                            }

                            function displayTotals(data) {
                                let totalOrderKg = data.reduce((sum, item) => sum + item.total_order_kg, 0);
                                const totalActualKg = data.reduce((sum, item) => sum + item.total_actual_kg, 0);

                                document.getElementById('totalOrder2').textContent =
                                    `Total Order (tons): ${(totalOrderKg / 1000).toFixed(2)} tons`;
                                document.getElementById('totalActual2').textContent =
                                    `Total Actual (tons): ${(totalActualKg / 1000).toFixed(2)} tons`;

                                const total = totalOrderKg + totalActualKg;

                                // Group by supplier and calculate achievement %
                                const supplierStats = data.reduce((acc, item) => {
                                    const s = item.supplier;
                                    if (!acc[s]) acc[s] = { order: 0, actual: 0 };
                                    acc[s].order += item.total_order_kg;
                                    acc[s].actual += item.total_actual_kg;
                                    return acc;
                                }, {});

                                let listHtml = '<h4 style="font-size: 16px; border-bottom: 2px solid #00ffff; padding-bottom: 10px; margin-bottom: 20px; font-weight: 800; color: #00ffff; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);">Achievement</h4>';
                                Object.keys(supplierStats).sort().forEach(s => {
                                    const stats = supplierStats[s];
                                    const percent = stats.order > 0 ? (stats.actual / stats.order * 100).toFixed(1) : 0;
                                    let color = '#ff4d4d'; // Red if low
                                    if (percent >= 90) color = '#00ff88'; // Vibrant Green
                                    else if (percent >= 60) color = '#ffcc00'; // Vibrant Yellow
                                    
                                    listHtml += `
                                        <div style="margin-bottom: 18px;">
                                            <div style="font-weight: 700; font-size: 13px; margin-bottom: 6px; display: flex; justify-content: space-between; align-items: center;">
                                                <span style="color: #ffffff; letter-spacing: 0.5px;">${s}</span>
                                                <span style="font-size: 18px; color: ${color}; font-family: 'Courier New', Courier, monospace; font-weight: 900;">${percent}%</span>
                                            </div>
                                            <div style="background: rgba(255,255,255,0.05); height: 10px; border-radius: 5px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); position: relative;">
                                                <div style="width: ${Math.min(percent, 100)}%; background: ${color}; height: 100%; box-shadow: 0 0 15px ${color}; transition: width 1.5s cubic-bezier(0.17, 0.67, 0.83, 0.67);"></div>
                                            </div>
                                        </div>
                                    `;
                                });
                                document.getElementById('supplierPerformanceList').innerHTML = listHtml;

                                if (chart) {
                                    chart.data.datasets[0].data = [totalOrderKg, totalActualKg];
                                    chart.update();
                                } else {
                                    const ctx = document.getElementById('orderActualPieChart').getContext('2d');
                                    chart = new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: ['Total Order', 'Total Actual'],
                                            datasets: [{
                                                data: [totalOrderKg, totalActualKg],
                                                backgroundColor: [
                                                    'rgba(255, 149, 0, 0.75)', // Orange Transparent
                                                    'rgba(0, 230, 118, 0.75)'  // Green Transparent
                                                ],
                                                borderColor: [
                                                    'rgba(255, 149, 0, 1)',
                                                    'rgba(0, 230, 118, 1)'
                                                ],
                                                borderWidth: 2,
                                                hoverOffset: 15
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            layout: {
                                                padding: 20
                                            },
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                    labels: {
                                                        font: {
                                                            size: 13,
                                                            weight: 'bold'
                                                        },
                                                        color: '#ffffff',
                                                        padding: 15,
                                                        usePointStyle: true,
                                                        pointStyle: 'rectRounded'
                                                    }
                                                },
                                                tooltip: {
                                                    backgroundColor: 'rgba(0, 20, 40, 0.9)',
                                                    borderColor: '#00ffff',
                                                    borderWidth: 1,
                                                    titleFont: { size: 15, weight: 'bold' },
                                                    bodyFont: { size: 14 },
                                                    padding: 12,
                                                    callbacks: {
                                                        label: function(context) {
                                                            const percentage = ((context.raw / total) *
                                                                100).toFixed(2);
                                                            return ` ${context.label}: ${percentage}% (${(context.raw / 1000).toFixed(2)} tons)`;
                                                        }
                                                    }
                                                },
                                                datalabels: {
                                                    color: '#000000',
                                                    backgroundColor: 'rgba(255, 255, 255, 0.85)',
                                                    borderRadius: 6,
                                                    padding: 6,
                                                    formatter: function(value) {
                                                        const percentage = ((value / total) * 100)
                                                            .toFixed(1);
                                                        return `${percentage}%`;
                                                    },
                                                    font: {
                                                        weight: '900',
                                                        size: 15
                                                    },
                                                    offset: 0
                                                }
                                            }
                                        },
                                        plugins: [ChartDataLabels]
                                    });
                                }
                            }
                            displayTotals(data);
                        })

                        .catch(error => console.error('Error fetching data:', error));
                }

                // Initial fetch when the page loads
                fetchAndDisplayTotals();

                // Set up the filter button to trigger data refresh
                document.getElementById('filterButton2').addEventListener('click', function() {
                    const filterDate = document.getElementById('deliveryFilter2')
                        .value; // Get the date from input
                    fetchAndDisplayTotals(filterDate); // Fetch filtered data
                });

                setInterval(() => {
                    const filterDate = document.getElementById('deliveryFilter2')
                        .value; // Refresh with the selected date every 3 seconds
                    fetchAndDisplayTotals(filterDate);
                }, 3000);
            });


            document.addEventListener("DOMContentLoaded", function() {
                // Function to fetch and update dashboard data
                function fetchAndUpdateDashboard() {
                    fetch("{{ route('dashboardrm.getDashboardData') }}")
                        .then(response => response.json())
                        .then(data => {
                            // Update the Total PO
                            document.getElementById('totalItems').textContent = `${data.totalItems} PO`;

                            // Update the PO CLOSE
                            document.getElementById('poCloseDifference').textContent =
                                `${data.poCloseDifference} PO`;

                            // Update the PO OPEN
                            document.getElementById('nullStatusCount').textContent = `${data.nullStatusCount} PO`;
                        })
                        .catch(error => console.error('Error fetching dashboard data:', error));
                }

                // Fetch and update dashboard every 3 seconds
                fetchAndUpdateDashboard();
                setInterval(fetchAndUpdateDashboard, 3000); // Update every 3 seconds
            });

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



            function showIncomingMaterials(supplier) {
                const section = document.getElementById('material-section');
                const offset = 5000;

                window.scrollTo({
                    top: section.offsetTop + offset,
                    behavior: 'smooth'
                });

                $.ajax({
                    url: "{{ route('dashboardrm.detail') }}",
                    method: 'GET',
                    data: {
                        supplier: supplier
                    },
                    success: function(response) {
                        let tableBody = '';
                        let rowNumber = 1;

                        response.forEach(function(item) {
                            const formattedDate = formatDate(item.created_at);
                            const monthLabel = item.month_label || '';

                            tableBody += `
                    <tr>
                        <td>${rowNumber++}</td>
                        <td style="background: linear-gradient(to bottom, #66ccff 17%, #0099cc 99%);">${item.doc_po}</td>
                        <td>${item.doc_dn}</td>
                        <td style="background: #4682B4; color:#ffffff">${item.part_no}</td>
                        <td>${item.model}</td>
                        <td>${item.spec}</td>
                        <td>${item.spec_t}</td>
                        <td>${item.spec_w}</td>
                        <td>${item.spec_l}</td>
                        <td>${item.supplier}</td>
                        <td style="background-color: #90EE90">${item.order_sheet}</td>
                        <td>${item.order_kg}</td>
                        <td style="background-color: #66ccff">${item.actual_sheet}</td>
                        <td style="background: #FFB6C1">${item.balance_sheet}</td>
                        <td style="background-color: ${item.status === 'Close' ? '#90EE90' : '#FFFF99'};">
                            ${item.status ? item.status : 'Open'}
                        </td>

                        <td>${item.delivery}</td>

                        <td>
                            <a id="btn_detail" data-id="${item.id}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>`;
                        });

                        // Isi tabel
                        $('#incomingTable tbody').html(tableBody);

                        // Hancurkan instance DataTable lama jika ada
                        if ($.fn.DataTable.isDataTable('#incomingTable')) {
                            $('#incomingTable').DataTable().clear().destroy();
                        }

                        // Inisialisasi ulang DataTable
                        const table = $('#incomingTable').DataTable({
                            processing: true,
                            serverSide: false,
                            autoWidth: false,
                            responsive: true,
                            searching: true,
                            bLengthChange: false,
                            pageLength: 10,
                            order: [
                                [0, 'asc']
                            ],
                            language: {
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ data",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                paginate: {
                                    first: "Pertama",
                                    last: "Terakhir",
                                    next: "›",
                                    previous: "‹"
                                }
                            }
                        });

                        // Event listener pencarian
                        $('#tableSearch').off('keyup').on('keyup', function() {
                            table.search(this.value).draw();
                        });

                        // Event listener jumlah data per halaman
                        $('#dataLength').off('change').on('change', function() {
                            table.page.len(this.value).draw();
                        });
                    },

                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }


            // <td>${formattedDate}</td>


            $(document).on('click', '#btn_pdf', function(e) {
                e.preventDefault();

                // Ambil data-id dari tombol yang diklik
                var id = $(this).data('id');

                // Bangun URL untuk mencetak PDF
                var printUrl = "{{ route('dashboardrm.cetak', ':id') }}".replace(':id', id);

                // Coba buka di tab baru
                var newWindow = window.open(printUrl, '_blank');

                // Fallback: jika tab baru diblokir oleh browser, buka di jendela saat ini
                if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                    window.location.href = printUrl;
                }
            });

            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('dashboardrm.count') }}", // Adjust route as needed
                    method: 'GET',
                    success: function(data) {
                        // Reset text for each metric card
                        $('.closeText').text('PO CLOSE'); // Reset initial text
                        $('.openText').text('PO OPEN'); // Reset initial text

                        // Update the text for 'PO CLOSE'
                        data.close.forEach(function(count) {
                            if (count.supplier === 'POSCO-1') {
                                $('.metric-card:contains("POSCO-1") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'POSCO-2') {
                                $('.metric-card:contains("POSCO-2") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'TTMI') {
                                $('.metric-card:contains("TTMI") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SSK') {
                                $('.metric-card:contains("SSK") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SCI') {
                                $('.metric-card:contains("SCI") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'HTI') {
                                $('.metric-card:contains("HTI") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SAI') {
                                $('.metric-card:contains("SAI") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'JSSI') {
                                $('.metric-card:contains("JSSI") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            } else if (count.supplier === 'USC') {
                                $('.metric-card:contains("USC") .closeText').text('PO CLOSE (' +
                                    count.total + ')');
                            }
                        });

                        // Update the text for 'PO OPEN'
                        data.open.forEach(function(count) {
                            if (count.supplier === 'POSCO-1') {
                                $('.metric-card:contains("POSCO-1") .openText').text('PO OPEN (' +
                                    count.total + ')');
                            } else if (count.supplier === 'TTMI') {
                                $('.metric-card:contains("TTMI") .openText').text('PO OPEN (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SSK') {
                                $('.metric-card:contains("SSK") .openText').text('PO OPEN (' + count
                                    .total + ')');
                            } else if (count.supplier === 'POSCO-2') {
                                $('.metric-card:contains("POSCO-2") .openText').text('PO OPEN (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SCI') {
                                $('.metric-card:contains("SCI") .openText').text('PO OPEN (' + count
                                    .total + ')');
                            } else if (count.supplier === 'HTI') {
                                $('.metric-card:contains("HTI") .openText').text('PO OPEN (' + count
                                    .total + ')');
                            } else if (count.supplier === 'SAI') {
                                $('.metric-card:contains("SAI") .openText').text('PO OPEN (' + count
                                    .total + ')');
                            } else if (count.supplier === 'JSSI') {
                                $('.metric-card:contains("JSSI") .openText').text('PO OPEN (' +
                                    count.total + ')');
                            } else if (count.supplier === 'USC') {
                                $('.metric-card:contains("USC") .openText').text('PO OPEN (' + count
                                    .total + ')');
                            }
                        });
                        // Update the text for 'TOTAL PO'
                        data.total.forEach(function(count) {
                            if (count.supplier === 'POSCO-1') {
                                $('.metric-card:contains("POSCO-1") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'TTMI') {
                                $('.metric-card:contains("TTMI") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SSK') {
                                $('.metric-card:contains("SSK") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'POSCO-2') {
                                $('.metric-card:contains("POSCO-2") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SCI') {
                                $('.metric-card:contains("SCI") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'HTI') {
                                $('.metric-card:contains("HTI") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'SAI') {
                                $('.metric-card:contains("SAI") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'JSSI') {
                                $('.metric-card:contains("JSSI") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            } else if (count.supplier === 'USC') {
                                $('.metric-card:contains("USC") .totalText').text('PO TOTAL (' +
                                    count.total + ')');
                            }
                        });
                    },
                    error: function() {
                        console.error("Error fetching the count by supplier");
                    }
                });
            });


            function fetchSupplierData(supplier, status) {
                const section = document.getElementById('material-section');
                const offset = 5000; // Ubah ini kalau mau lebih bawah lagi (dalam pixel)

                window.scrollTo({
                    top: section.offsetTop + offset,
                    behavior: 'smooth'
                });

                $.ajax({
                    url: "{{ route('dashboardrm.getSupplierData') }}",
                    method: 'GET',
                    data: {
                        supplier: supplier,
                        status: status
                    },
                    success: function(response) {
                        let table = $('#incomingTable');

                        // Hancurkan DataTable jika sudah ada
                        if ($.fn.DataTable.isDataTable(table)) {
                            table.DataTable().clear().destroy();
                        }

                        let tableBody = table.find('tbody');
                        tableBody.empty(); // Kosongkan tabel sebelum mengisi ulang

                        response.forEach((item, index) => {
                        let statusText = item.status === null ? 'Open' : item.status;
                        let formattedDate = formatDate(item.created_at);
                        let statusColor = statusText === 'Close' ? '#90EE90' : '#eba75f';

                        let row = `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                <td style="background: linear-gradient(to bottom, #66ccff 17%, #0099cc 99%);">${item.doc_po}</td>
                                <td>${item.doc_dn}</td>
                                <td style="background: #4682B4; color:#ffffff">${item.part_no}</td>
                                <td>${item.model}</td>
                                <td>${item.spec}</td>
                                <td>${item.spec_t}</td>
                                <td>${item.spec_w}</td>
                                <td>${item.spec_l}</td>
                                <td>${item.supplier}</td>
                                <td style="background-color: #ffe084">${item.order_sheet}</td>
                                <td>${item.order_kg}</td>
                                <td style="background-color: #66ccff">${item.actual_sheet ?? 0}</td>
                                <td style="background: #FFB6C1">${item.balance_sheet}</td>
                                <td style="background-color: ${statusColor}; font-weight: bold;">${statusText}</td>
                                <td style="background-color: #66ccff">${item.delivery}</td>
                                <td>${formattedDate}</td>
                                <td>
                                    <a href="#" id="btn_detail" data-id="${item.id}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });


                        // Inisialisasi ulang DataTable setelah menambahkan data
                        table.DataTable({
                            processing: true,
                            serverSide: false,
                            autoWidth: false,
                            responsive: true,
                            searching: true,
                            bLengthChange: false,
                            pageLength: 10,
                            order: [
                                [0, 'asc']
                            ],
                            language: {
                                search: "Cari:",
                                lengthMenu: "Tampilkan _MENU_ data",
                                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                paginate: {
                                    first: "Pertama",
                                    last: "Terakhir",
                                    next: "›",
                                    previous: "‹"
                                }
                            }
                        });

                        // Perbarui event listener untuk pencarian
                        $('#tableSearch').off('keyup').on('keyup', function() {
                            table.DataTable().search(this.value).draw();
                        });

                        // Perbarui event listener untuk jumlah data per halaman
                        $('#dataLength').off('change').on('change', function() {
                            table.DataTable().page.len(this.value).draw();
                        });
                    },

                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }


            $('#exportModal').on('show.bs.modal', function(event) {
                // You can add additional logic here if needed when the modal is about to be shown
            });

            $(document).on('click', '#exportBtn', function (e) {
        e.preventDefault();

        let filter = $('#supplierFilter').val(); // Ambil nilai filter jika ada

        // Tampilkan SweetAlert loading
        Swal.fire({
            title: 'Mengekspor Data...',
            html: `<img src="{{ asset('dist/img/Hourglass.gif') }}" width="50"><br>Mohon tunggu, sedang diproses...`,
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Buat form POST dinamis jika tidak ada form sebelumnya
        let form = $('#exportForm');
        form.append($('<input>', {
            type: 'hidden',
            name: 'supplierFilter',
            value: filter
        }));

        // Submit form
        form.submit();

        // Tutup loading setelah beberapa detik (estimasikan waktu untuk export)
        setTimeout(() => {
            Swal.close();
        }, 4000); // bisa sesuaikan waktu sesuai dengan ukuran data
    });


            // Fungsi Hide Pilih Export
            function toggleFields() {
                const supplierField = document.getElementById('filterLine');
                const docPoField = document.getElementById('docPoFilter');
                const periodeField = document.getElementById('periodeFilter');

                if (supplierField.value) {
                    // Jika supplierField diisi, nonaktifkan docPoField dan periodeField
                    docPoField.disabled = true;
                    periodeField.disabled = true;

                    // Kosongkan nilai kolom lain
                    docPoField.value = '';
                    periodeField.value = '';
                } else if (docPoField.value) {
                    // Jika docPoField diisi, nonaktifkan supplierField dan periodeField
                    supplierField.disabled = true;
                    periodeField.disabled = true;

                    // Kosongkan nilai kolom lain
                    supplierField.value = '';
                    periodeField.value = '';
                } else if (periodeField.value) {
                    // Jika periodeField diisi, nonaktifkan supplierField dan docPoField
                    supplierField.disabled = true;
                    docPoField.disabled = true;

                    // Kosongkan nilai kolom lain
                    supplierField.value = '';
                    docPoField.value = '';
                } else {
                    // Jika tidak ada nilai di kolom mana pun, aktifkan semua kolom
                    supplierField.disabled = false;
                    docPoField.disabled = false;
                    periodeField.disabled = false;
                }
            }




            window.onload = toggleFields;

            document.getElementById('exportBtn').addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Check if at least one field is filled out
                const supplierField = document.getElementById('filterLine');
                const docPoField = document.getElementById('docPoFilter');
                const periodeField = document.getElementById('periodeFilter');

                if (!supplierField.value && !docPoField.value && !periodeField.value) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please fill in either the Supplier or DOC_PO field.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                    return;
                }

                // Trigger SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to export the data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Export!',
                    cancelButtonText: 'No, Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if the user confirms
                        document.getElementById('exportForm').submit();
                    }
                });
            });

            // FUNSGI MODAL SHOW DETAIL
            $(document).on('click', '#check_all', function() {
                const isChecked = $(this).prop('checked');

                // Set semua checkbox, kecuali yang memiliki sts_scan = 1
                $('#insertedData input[type="checkbox"]').each(function() {
                    const parentRow = $(this).closest('tr');
                    const scanBadge = parentRow.find('.badge').text().trim(); // Ambil teks dari badge
                    if (scanBadge !== 'SUDAH SCAN') { // Hanya centang jika belum scan
                        $(this).prop('checked', isChecked);
                    }
                });
            });


            $(document).on('click', '#btn_detail', function(e) {
                e.preventDefault();
                const materialId = $(this).data('id'); // Ambil data-id dari tombol
                $.ajax({
                    url: "{{ route('dashboardrm.detail2') }}", // Sesuaikan route
                    method: 'GET',
                    data: {
                        id: materialId
                    },
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                            return;
                        }

                        // Debug: Lihat respons di console
                        console.log(response);

                        // Isi data detail dari material
                        $('#detailDocPo').val(response.material.doc_po);
                        $('#detailId').val(response.material.id);
                        $('#detailDocDn').val(response.material.doc_dn);
                        $('#detailPartNo').val(response.material.part_no);
                        $('#part_no').val(response.material.part_no); // Isi ke input dengan id="part_no"
                        $('#detailSpec').val(response.material.spec);
                        $('#detailKg').val(response.material.order_kg);
                        $('#detailStatus').val(response.material.status);
                        $('#kgSheet').val(response.material.spec_kg);
                        $('#detailT').val(response.material.spec_t);
                        $('#detailW').val(response.material.spec_w);
                        $('#detailL').val(response.material.spec_l);
                        $('#detailSupplier').val(response.material.supplier);
                        $('#detailDelivery').val(response.material.delivery);
                        $('#detailRak').val(response.material.no_rak);
                        $('#detailModel').val(response.material.model);
                        $('#detailOrderSheet').val(response.material.order_sheet);
                        // $('#part_no').val(response.material.part_no);

                        // Tampilkan data dn_inputs di tabel
                        const insertedData = $('#insertedData');
                        insertedData.empty(); // Kosongkan isi tabel sebelumnya

                        // Pastikan data dn_inputs ada
                        if (response.dn_inputs && response.dn_inputs.length > 0) {
                            response.dn_inputs.forEach((item, index) => {
                                const scanBadge = item.sts_scan == 1 ?
                                    '<span class="badge badge-success" style="font-size:15px">SUDAH SCAN</span>' :
                                    '<span class="badge badge-secondary" style="font-size:15px">BELUM SCAN</span>';

                                insertedData.append(`
                <tr>
                    <td><input type="checkbox" class="dataCheckbox" value="${item.id}" /></td>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${item.doc_po}</td>
                    <td class="text-center">${item.doc_dn}</td>
                    <td class="text-center">${item.part_no}</td>
                    <td class="text-center">${item.actual}</td>
                    <td class="text-center">${item.spec}</td>
                    <td class="text-center">${item.kg_sheet}</td>
                    <td class="text-center">
                        <a href="#" id="btn_pdf" title="Generate" data-id="${item.id}" class="btn btn-info btn-sm">
                            <i class="fas fa-qrcode"></i>
                        </a>
                    </td>
                    <td class="text-center">${item.update_time}</td>
                    <td class="text-center" style="width: 120px">
                        <a href="#" id="btn_delete_line" title="Delete" data-id="${item.id}" class="btn btn-danger btn-sm ${item.sts_scan == 1 ? 'disabled' : ''}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                    <td class="text-center">${item.uniq_no}</td>
                    <td class="text-center">
                        ${scanBadge}
                    </td>
                </tr>
            `);

                            });

                        }
                        $('#detailModal').modal('show');
                    },
                    error: function(error) {
                        console.error('AJAX Error:', error);
                        alert('Failed to fetch material data. Please check the console for details.');
                    }
                });
            });

            $(document).on("click", "#btnInsert", function() {
                const partNo = $('#part_no').val();
                const id = $('#id').val();
                const detailId = $('#detailId').val();
                const actual = $('#actual').val();
                const docPo = $('#detailDocPo').val();
                const docDn = $('#detailDocDn').val();
                const spec = $('#detailSpec').val();
                const detailT = $('#detailT').val();
                const detailW = $('#detailW').val();
                const detailL = $('#detailL').val();
                const detailModel = $('#detailModel').val();
                const kgSheet = $('#kgSheet').val();
                const detailSupplier = $('#detailSupplier').val();
                const detailDelivery = $('#detailDelivery').val();
                const detailRak = $('#detailRak').val();
                const sts_scan = $('#sts_scan').val();

                if (!partNo) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Part NO harus diisi!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }

                if (!actual || isNaN(actual)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Actual harus diisi dengan angka!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }

                if (!kgSheet || isNaN(kgSheet)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'KG Sheet harus diisi dengan angka!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }

                // Kalkulasi KG
                const kg = (actual * kgSheet).toFixed(3); // Ambil 2 angka di belakang koma
                $('#kg').val(kg); // Masukkan nilai ke input field

                $.ajax({
                    type: 'POST',
                    url: "{{ route('dashboardrm.insertPartNo') }}",
                    data: {
                        id: id,
                        detail_id: detailId,
                        actual: actual,
                        part_no: partNo,
                        doc_po: docPo,
                        doc_dn: docDn,
                        spec: spec,
                        kg_sheet: kg,
                        spec_t: detailT,
                        spec_w: detailW,
                        spec_l: detailL,
                        supplier: detailSupplier,
                        delivery: detailDelivery,
                        no_rak: detailRak,
                        model: detailModel,
                        sts_scan: sts_scan,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Hapus pesan "No data available" jika ada data dalam tabel
                            const insertedData = $('#insertedData');
                            if (insertedData.find('tr').length === 0) {
                                insertedData
                                    .empty(); // Kosongkan tabel jika sebelumnya ada pesan "No data available"
                            }
                            // Add new row to the table
                            const newRow = `
                        <tr>
                            <td><input type="checkbox" class="dataCheckbox" value="${data.id}" /></td>
                            <td class="text-center">${$('#insertedData tr').length + 1}</td>
                            <td class="text-center">${docPo}</td>
                            <td class="text-center">${docDn}</td>
                            <td class="text-center">${partNo}</td>
                            <td class="text-center">${actual}</td>
                            <td class="text-center">${spec}</td>
                            <td class="text-center">${kg}</td>
                            <td class="text-center">
                                <a href="#" id="btn_pdf" title="Generate" data-id="${data.id}" class="btn btn-info btn-sm">
                                    <i class="fas fa-solid fa-qrcode"></i>
                                </a>
                            </td>
                            <td class="text-center">${data.update_time}</td>
                              <td  class="text-center" style="width: 120px">
                                <a href="#" id="btn_delete_line" title="Delete" data-id="${data.id}" class="btn btn-danger btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                             </td>
                               <td class="text-center">${sts_scan}</td>

                        </tr>
                    `;
                            insertedData.append(newRow);

                            // Reset form - hanya reset #actual dan #kg
                            $('#actual').val('');
                            $('#kg').val('');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal menyimpan data: ' + data.message,
                                showConfirmButton: true
                            });
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            showConfirmButton: true
                        });
                    }
                });
            });

            $(document).on('click', '#btn_generate_all', function(e) {
        e.preventDefault();

        const selectedIds = [];
        $('.dataCheckbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Pilih setidaknya satu data untuk generate QR Code!',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        // ✅ Tampilkan loading saat proses
        Swal.fire({
            title: 'Generating QR Codes...',
            html: `<img src="{{ asset('dist/img/Hourglass.gif') }}" width="50"><br>Silakan tunggu...`,
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('dashboardrm.generateMultipleQrCodes') }}",
            method: 'POST',
            xhrFields: {
                responseType: 'blob' // penting agar file binary (PDF) bisa diproses
            },
            data: {
                ids: selectedIds,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.close(); // ❌ Tutup loading

                const blob = new Blob([response], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'qrcodes_' + new Date().toISOString().slice(0, 10) + '.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr) {
                Swal.close();

                let errorMsg = 'Terjadi kesalahan saat memproses data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    showConfirmButton: true
                });
            }
        });
    });

            $(document).on("click", "#btn_delete_line", function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr'); // Ambil elemen baris tabel
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
                            url: "{{ route('dashboardrm.destroyline') }}",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // Hapus baris tabel
                                    row.fadeOut(300, function() {
                                        $(this).remove();
                                    });
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
                            error: function(error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete the line. Please try again.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                console.error('AJAX Error:', error);
                            }
                        });
                    }
                });
            });

            // Pastikan ChartDataLabels dimuat jika menggunakan Chart.js versi terbaru
            // Pastikan ChartDataLabels dimuat jika menggunakan Chart.js versi terbaru
            Chart.register(ChartDataLabels);

            var ctx = document.getElementById('performanceChart2').getContext('2d');

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Array.from({
                        length: 30
                    }, (_, i) => `${i + 1}`), // Labels untuk 30 hari
                    datasets: [{
                            label: 'Accumulation Actual (Sheet)',
                            type: 'bar',
                            data: [],
                            backgroundColor: 'rgba(0, 157, 255, 0.68)',
                            borderColor: 'rgba(0, 0, 0, 1)',
                            borderWidth: 2,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            borderRadius: 5,
                            order: 1
                        },
                        {
                            label: 'Accumulation Actual (Kilogram)',
                            type: 'bar',
                            data: [],
                            backgroundColor: 'rgba(255, 0, 0, 0.6)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 2,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8,
                            borderRadius: 5,
                            order: 1
                        }
                        // {
                        //     label: ' Line Sheet',
                        //     type: 'line', // Hapus label agar tidak muncul di legenda
                        //     data: [],
                        //     borderColor: '#00FFCC',
                        //     backgroundColor: 'transparent',
                        //     borderWidth: 4,
                        //     pointBackgroundColor: '#FFD700',
                        //     pointBorderColor: '#000000',
                        //     pointRadius: 8,
                        //     pointHoverRadius: 12,
                        //     tension: 0.3,
                        //     order: 2
                        // },
                        // {
                        //     label: 'Line Kg',
                        //     type: 'line',
                        //     data: [],
                        //     borderColor: '#FFFFFF',
                        //     backgroundColor: 'transparent',
                        //     borderWidth: 4,
                        //     pointBackgroundColor: '#FFFFFF',
                        //     pointBorderColor: '#000000',
                        //     pointRadius: 8,
                        //     pointHoverRadius: 12,
                        //     tension: 0.3,
                        //     order: 2
                        // }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgb(255,255,255)'
                            },
                            ticks: {
                                color: 'rgb(255,255,255)',
                                font: {
                                    size: 20
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgb(255,255,255)'
                            },
                            ticks: {
                                color: 'rgb(255,255,255)',
                                font: {
                                    size: 18
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgb(255,255,255)',
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: 'white',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            borderRadius: 4,
                            padding: 6,
                            formatter: function(value, context) {
                                if (context.datasetIndex === 2 || context.datasetIndex === 3) {
                                    return ''; // Jangan tampilkan label untuk grafik garis
                                }
                                if (context.datasetIndex === 0) {
                                    return value > 0 ? value + ' Sheet' : ''; // Tambahkan ' sheet' untuk qty_in
                                }
                                return value > 0 ? value + ' Kg' : '';
                            }
                        }
                    },
                    onClick: function(event, elements) {
                        if (elements.length > 0) {
                            let index = elements[0].index;
                            let selectedDay = chart.data.labels[index];

                            let selectedDate = new Date();
                            selectedDate.setDate(selectedDay);
                            let formattedDate = selectedDate.toISOString().split('T')[0];

                            fetchDataByDate(formattedDate);
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            function updateChart() {
                $.ajax({
                    url: "{{ route('dashboardrm.getChartData') }}",
                    method: "GET",
                    success: function(response) {
                        let labels = Array.from({
                            length: 30
                        }, (_, i) => `${i + 1}`);
                        let accumulationActualData = new Array(30).fill(0);
                        let qtyKgData = new Array(30).fill(0);

                        response.forEach(item => {
                            let dayIndex = item.day - 1;
                            accumulationActualData[dayIndex] = item.total_qty;
                            qtyKgData[dayIndex] = parseFloat(item.total_kg).toFixed(2);
                        });

                        chart.data.labels = labels;
                        chart.data.datasets[0].data = accumulationActualData; // qty_in
                        chart.data.datasets[1].data = qtyKgData; // qty_kg
                        // chart.data.datasets[2].data = accumulationActualData; // Trend line
                        // chart.data.datasets[3].data = qtyKgData; // Peak line untuk qty_kg

                        chart.update();
                    },
                    error: function(error) {
                        console.log("Error fetching data", error);
                    }
                });
            }

            // Jalankan pertama kali dan update otomatis setiap 5 detik
            updateChart();
            setInterval(updateChart, 5000);






            // Fungsi untuk mengambil data berdasarkan tanggal
            function fetchDataByDate(date) {
                $.ajax({
                    url: "{{ route('dashboardrm.getScanData') }}",
                    method: "GET",
                    data: {
                        date: date
                    }, // Kirim tanggal ke server
                    success: function(response) {
                        showModal(response, date);
                    },
                    error: function(error) {
                        console.log("Error fetching scan data", error);
                    }
                });
            }

            // Fungsi untuk menampilkan modal dengan data dari scan_in_labels
            function showModal(data, date) {
                let modal = document.getElementById("chartModal");
                let modalTitle = document.getElementById("modalTitle");
                let modalBody = document.getElementById("modalBody");

                modalTitle.innerHTML = `Detail Data Grafik - ${date}`;

                let tableHTML = `
            <table id="scanDataTable" class="table table-bordered">
                <thead class="text-center" >
                    <tr>
                        <th>No</th>
                        <th>Uniq No</th>
                        <th>Spek</th>
                        <th>Part No</th>
                        <th>Supplier</th>
                        <th>Sheet</th>
                        <th>Kg</th>
                        <th>User</th>
                        <th>Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
        `;

                if (data.length > 0) {
                    data.forEach((item, index) => {
                        tableHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.uniqNo}</td>
                        <td>${item.spec}</td>
                        <td>${item.part_no}</td>
                        <td>${item.supplier}</td>
                        <td>${item.qty_in}</td>
                        <td>${item.qty_kg}</td>
                        <td>${item.createdby}</td>
                        <td>${item.created_at}</td>
                    </tr>
                `;
                    });
                } else {
                    tableHTML += `
                <tr>
                    <td colspan="9" class="text-center">No data available</td>
                </tr>
            `;
                }

                tableHTML += `</tbody></table>`;

                modalBody.innerHTML = tableHTML;

                let myModal = new bootstrap.Modal(modal);
                myModal.show();

                // Inisialisasi DataTables setelah tabel dimasukkan ke dalam modal
                $('#scanDataTable').DataTable({
                    processing: true,
                    serverSide: false, // Set true jika ingin mengambil data dari server secara langsung
                    autoWidth: false,
                    responsive: false,
                    searching: true,
                    bLengthChange: true,
                    destroy: true, // Agar DataTables tidak error saat reload modal
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ] // Urutkan berdasarkan kolom pertama (No)
                });
            }
        </script>
@endpush
