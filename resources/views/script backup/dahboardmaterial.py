@extends('layouts.app')

@section('content')
<style>
#incomingTable.table-hover tbody tr:hover {
    background: linear-gradient(to top, #003366 17%, #ffffff 99%);
    color: #000000; /* Warna teks saat hover (opsional) */
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
    margin-left: 10px; /* Adjust as needed */
    display: inline-block; /* Keeps the badge in line with text */
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
    margin-left: 10px; /* Adjust as needed */
    display: inline-block; /* Keeps the badge in line with text */
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
            <div style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                <strong><h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="clock" class="text-right"></h3></strong>
            </div>
        </div>        
    </div>
    
    
    

    <!-- Metrics Row -->
    <div class="row mb-4" id="material-section">
        <div class="carousel-container">
            <button class="carousel-button left" onclick="slideLeft()">‹</button>
            <div class="carousel-content">
                <div class="col-ms-3">
                    <div class="metric-card" onclick="showIncomingMaterials('POSCO')">
                        <h2>POSCO</h2>
                        <br>
                        <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                            <strong>
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('POSCO', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('POSCO', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
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
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('POSCO-2', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('POSCO-2', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
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
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('TTMI', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('TTMI', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
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
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('SSK', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('SSK', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
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
                                <p class="status-box-item closeText status-text" style="font-size: 15px; margin: 0; cursor: pointer;  background: linear-gradient(to bottom left, #00cc99 0%, #99ff99 100%);"
                                   onclick="event.stopPropagation(); fetchSupplierData('SCI', 'Close')">PO CLOSE</p>
                            </strong>
                            <strong>
                                <p class="status-box-item openText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to right, #ffcc66 0%, #ff9933 100%);"
                                onclick="event.stopPropagation(); fetchSupplierData('SCI', 'NULL')">PO OPEN</p>
                            </strong>
                            <strong>
                                <p class="status-box-item totalText status-text" style="font-size: 15px; margin: 0; cursor: pointer; background: linear-gradient(to top right, #00ccff 0%, #ffffff 100%);">TOTAL</p>
                            </strong>
                        </div>
                    </div>
                </div> 
                <div class="col-ms-3">
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
                </div> 
                <div class="col-ms-3">
                    <div class="metric-card" onclick="showIncomingMaterials('HTI')">
                        <h2>HTI</h2>
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
                </div>              
        </div>
            <button class="carousel-button right" onclick="slideRight()">›</button>
        </div>


        <div class="carousel-content">
            {{-- GRAFIK --}}
            <div class="col-ms-12">
                <div class="metric-card2">
                    <strong><h3 style="color: #ffffff; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">MONITORING PERFORMANCE DELIVERY SUPPLIER</h3></strong>
                    <!-- Display Total Order and Actual Values -->
                    <div type="hide" id="totalOrder" style="color: white; font-size: 20px; margin-bottom: 10px;">Total Order (tons): 0 tons</div>
                    <div id="totalActual" style="color: white; font-size: 20px; margin-bottom: 20px; ">Total Actual (tons): 0 tons</div>
                    <!-- Input field to enter delivery filter -->
                    <input type="text" id="deliveryFilter" placeholder="Enter Delivery Date" style="margin-bottom: 10px; width: 300px;" />
            
                    <button id="filterButton" style="margin-left: 10px;">View</button>
            
                    <div class="chart" style="width: 700px; height: 400px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
                <div class="col-ms-12"> <!-- Adjusted to Bootstrap's full-width class -->
                    <div class="metric-card2">
                        <h3 style="color: #ffffff">PO PRESENTATION MONTHLY</h3>
                        <div id="totalOrder2" style="color: white; font-size: 16px; margin-bottom: 10px;">Total Order (tons): 0 tons</div>
                        <div id="totalActual2" style="color: white; font-size: 16px; margin-bottom: 20px;">Total Actual (tons): 0 tons</div>
                        <div class="chart" style="width: 350px; height: 450px;"> <!-- Fixed width and height for the chart -->
                            <canvas id="orderActualPieChart"></canvas>
                            <br>
                
                            <!-- Display Total PO -->
                            @php
                                // Count of total items
                                $totalItems = DB::table('rm_dn_incomings')->count();
                
                                // Count of items where status is NULL or empty
                                $nullStatusCount = DB::table('rm_dn_incomings')
                                    ->whereNull('status')
                                    ->orWhere('status', '')
                                    ->count();
                
                                // Calculate difference
                                $poCloseDifference = $totalItems - $nullStatusCount;
                            @endphp
                
                            <div class="row mb-3">
                                <div class="col-md-4"> <!-- Adjust column width as needed -->
                                    <p class="info-title mb-1" style="font-size: 16px; background-color:#00ccff">Total PO</p>
                                    <h3 class="info-value" style="font-size: 18px; font-weight: bold; color:#ffffff">{{ $totalItems }} PO</h3>
                                </div>
                
                                <div class="col-md-4"> <!-- Adjust column width as needed -->
                                    <p class="info-title mb-1" style="font-size: 16px; background-color:#40ff62; color">PO CLOSE</p>
                                    <h3 class="info-value" style="font-size: 18px; font-weight: bold; color:white">{{ $poCloseDifference }} PO</h3>
                                </div>
                
                                <div class="col-md-4"> <!-- New column for difference -->
                                    <p class="info-title mb-1" style="font-size: 16px; background-color:#ff9900;">PO OPEN</p>
                                    <h3 class="info-value" style="font-size: 18px; font-weight: bold; color:white">{{ $nullStatusCount }} PO</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  {{-- GRAFIK --}}
                  <div class="col-ms-12"> <!-- Adjusted to Bootstrap's full-width class -->
                    <div class="metric-card3">
                        <h3 style="color: #ffffff">MONTHLY</h3>
                        <div class="chart" style="width: 1500px; height: 530px;"> <!-- Fixed width and height for the chart -->
                            <canvas id="performanceChart2"></canvas>
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
                     <button id="saveChanges" class="btn btn-primary">Save Changes</button>
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
                        <th style="width: 150px; text-align:center">Doc PO</th>
                        <th style="width: 150px; text-align:center">Doc Dn</th>
                        <th style=" text-align:center">Part No</th>
                        <th style=" text-align:center">Model</th>
                        <th style=" text-align:center">Spec</th>
                        <th style=" text-align:center">T</th>
                        <th style=" text-align:center">W</th>
                        <th style=" text-align:center">L</th>
                        <th style=" text-align:center">Supplier</th>
                        <th style=" text-align:center">Order Sheet</th>
                        <th style=" text-align:center">Actual Sheet</th>
                        <th style=" text-align:center">Balance Sheet</th>
                        <th style=" text-align:center">Order KG</th>
                        <th style=" text-align:center">Actual KG</th>
                        <th style=" text-align:center">Status</th>
                        <th style=" text-align:center">Tgl Delivery</th>
                        <th style=" text-align:center">Time</th>
                        <th style=" text-align:center">Action</th>
                        <th style=" text-align:center">Action 2</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                <!-- Data tabel akan diisi di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Export Filter Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="background-color: #adadad" class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Data Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportForm" action="{{ route('dnIncoming.export') }}" method="POST">
                    @csrf <!-- CSRF Token -->
                    
                    <div class="form-group">
                        <label for="filterLine">Select Supplier</label>
                        <select id="filterLine" name="supplierFilter" class="form-control" onchange="toggleFields()">
                            <option value="">-Pilih-</option>
                            <option value="POSCO">POSCO</option>
                            <option value="POSCO-2">POSCO-2</option>
                            <option value="TTMI">TTMI</option>
                            <option value="SSK">SSK</option>
                            <option value="SCI">SCI</option>
                            <option value="SCI-2">SCI-2</option>
                        </select>
                    </div>
                    
                    <!-- New input for DOC_PO filter -->
                    <div class="form-group">
                        <label for="doc_po">Enter DOC_PO</label>
                        <input type="text" id="docPoFilter" name="docPoFilter" class="form-control" placeholder="Enter DOC_PO" oninput="toggleFields()">
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
    <div class="modal-dialog modal-xl"> <!-- Modal ukuran besar -->
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="detailModalLabel">
                    <i class="bi bi-info-circle-fill me-2"></i> Info Detail PO
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="detailDocPo" class="form-label fw-bold">DOC PO</label>
                        <input type="text" class="form-control border-primary" id="detailDocPo" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="detailDocDn" class="form-label fw-bold">DOC DN</label>
                        <input type="text" class="form-control border-primary" id="detailDocDn" readonly>
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
                    <div class="col-md-2">
                        <label for="detailOrderSheet" class="form-label fw-bold">Order Sheet</label>
                        <input type="number" class="form-control border-primary" id="detailOrderSheet" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="detailKg" class="form-label fw-bold">Order KG</label>
                        <input type="number" class="form-control border-primary" id="detailKg" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="detailStatus" class="form-label fw-bold">Status</label>
                        <input type="text" class="form-control border-primary" id="detailStatus" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="kgSheet" class="form-label fw-bold">Sheet / KG</label>
                        <input type="text" class="form-control border-primary" id="kgSheet" readonly>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <i class="bi bi-archive-fill text-secondary" style="font-size: 2rem;"></i>
                    <p class="text-muted">Review the details carefully before closing.</p>
                </div>
            </div>
            <div class="modal-footer bg-primary text-white">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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

    document.getElementById("searchButton").addEventListener("click", function() {
        let searchTerm = document.getElementById("searchInput").value.toLowerCase();
        let tableRows = document.querySelectorAll("#incomingTable tbody tr");
         tableRows.forEach(row => {
            let cells = row.getElementsByTagName("td");
            let rowContainsSearchTerm = false;

            for (let i = 0; i < cells.length; i++) {
                if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                    rowContainsSearchTerm = true;
                    break;
                }
            }

            row.style.display = rowContainsSearchTerm ? "" : "none"; // Tampilkan atau sembunyikan baris
        });
    });

    function slideLeft() {
        const carousel = document.querySelector('.carousel-content');
        carousel.scrollBy({ left: -300, behavior: 'smooth' });
    }

    function slideRight() {
        const carousel = document.querySelector('.carousel-content');
        carousel.scrollBy({ left: 300, behavior: 'smooth' });
    }

    // var ctx = document.getElementById('performanceChart').getContext('2d');
    //  var chart = new Chart(ctx, {
    //     type: 'bar', // Line chart
    //     data: {
    //         labels: ['POSCO', 'POSCO-2', 'TTMI', 'SSK', 'SCI', 'SCI-2', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    //         datasets: [
    //             {
    //                 label: 'Monthly Budget',
    //                 data: [20000, 22000, 18000, 25000, 26500, 24000, 27000, 28000, 29000, 30000, 31000, 32000],
    //                 backgroundColor: 'rgba(0, 124, 255, 0.46)',
    //                 borderColor: 'rgba(0, 123, 255, 1)',
    //                 borderWidth: 2,
    //                 tension: 0.4,
    //                 fill: true,
    //                 pointBackgroundColor: 'rgba(0, 123, 255, 1)',
    //                 pointBorderColor: 'rgba(0, 123, 255, 1)',
    //                 pointRadius: 5,
    //             },
    //             {
    //                 label: 'Monthly Expenses',
    //                 data: [12000, 10400, 15000, 20000, 20000, 19000, 21000, 20000, 22000, 20000, 21000, 20000],
    //                 backgroundColor: 'rgba(0, 255, 82, 0.35)',
    //                 borderColor: 'rgba(255, 99, 132, 1)',
    //                 borderWidth: 2,
    //                 tension: 0.4,
    //                 fill: true,
    //                 pointBackgroundColor: 'rgba(255, 54, 97, 1)',
    //                 pointBorderColor: 'rgba(247, 255, 0, 0.02)',
    //                 pointRadius: 5,
    //             }
    //         ]
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         scales: {
    //             y: {
    //                 beginAtZero: true,
    //                 grid: {
    //                     color: 'rgb(255,255,255)',
    //                 },
    //                 ticks: {
    //                     color: 'rgb(255,255,255)',
    //                     font: {
    //                         size: 16 // Increase this value to enlarge the month labels
    //                     }
    //                 }
    //             },
    //             x: {
    //                 grid: {
    //                     color: 'rgb(255,255,255)',
    //                 },
    //                 ticks: {
    //                     color: 'rgb(255,255,255)',
    //                     font: {
    //                         size: 17 // Increase this value to enlarge the month labels
    //                     }
    //                 }
    //             }
    //         },
    //         plugins: {
    //             legend: {
    //                 labels: {
    //                     color: 'rgba(0, 0, 0, 1)'
    //                 }
    //             },
    //             datalabels: {
    //                 anchor: 'end',
    //                 align: 'top',
    //                 color: 'rgba(0, 0, 0, 1)',
    //                 backgroundColor: 'rgba(255, 255, 255, 0.63)', // Transparent background color
    //                 borderRadius: 4, // Rounded corners
    //                 padding: 6, // Padding inside the label box
    //                 font: {
    //                     size: 14, // Increase this number for larger text size
    //                     weight: 'bold'
    //                 },
    //                 formatter: function(value, context) {
    //                     return value; // Display data value inside the label box
    //                 }
    //             }
    //         }
    //     },
    //     plugins: [ChartDataLabels] // Enable ChartDataLabels plugin
    // });
    
    document.addEventListener("DOMContentLoaded", function() {
        let chart = null;  // Declare chart outside the function to avoid reinitialization
        let currentFilterValue = '';  // Variable to store the current filter value

        // Function to fetch and update the chart
        function fetchAndUpdateChart() {
            fetch("{{ route('dashboardrm.getSupplierData2') }}", {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                // Function to sum the data based on supplier
                function sumDataBySupplier(data) {
                    return data.reduce((acc, item) => {
                        const supplier = item.supplier;
                        if (!acc[supplier]) {
                            acc[supplier] = { total_order_kg: 0, total_actual_kg: 0 };
                        }
                        acc[supplier].total_order_kg += item.total_order_kg;
                        acc[supplier].total_actual_kg += item.total_actual_kg;
                        return acc;
                    }, {});
                }

                // Function to calculate and display total order and actual values in tons
                function displayTotals(data) {
                    const totalOrderKg = data.reduce((sum, item) => sum + item.total_order_kg, 0);
                    const totalActualKg = data.reduce((sum, item) => sum + item.total_actual_kg, 0);

                    document.getElementById('totalOrder').textContent = `Total Order (tons): ${(totalOrderKg / 1000).toFixed(2)} tons`;
                    document.getElementById('totalActual').textContent = `Total Actual (tons): ${(totalActualKg / 1000).toFixed(2)} tons`;
                }

                // Function to update the chart based on delivery filter
                function updateChart(deliveryFilterValue) {
                    const filteredData = deliveryFilterValue === ''
                        ? data
                        : data.filter(item => item.delivery.toLowerCase().includes(deliveryFilterValue.toLowerCase()));

                    const summedData = sumDataBySupplier(filteredData);

                    const labels = Object.keys(summedData);
                    const orderSheetData = labels.map(supplier => summedData[supplier].total_order_kg / 1000); // Convert to tons
                    const actualSheetData = labels.map(supplier => summedData[supplier].total_actual_kg / 1000); // Convert to tons

                    // Only update chart data, not the entire chart initialization
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = orderSheetData;
                    chart.data.datasets[1].data = actualSheetData;
                    chart.update();

                    // Display totals based on the filtered data
                    displayTotals(filteredData);
                }

                // Initialize the chart only once (if not already initialized)
                if (!chart) {
                    const ctx = document.getElementById('performanceChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(sumDataBySupplier(data)),
                            datasets: [
                                {
                                    label: 'Total Order (tons)',
                                    data: Object.values(sumDataBySupplier(data)).map(item => item.total_order_kg / 1000),
                                    backgroundColor: 'rgba(0, 157, 255, 0.68)',
                                    borderColor: 'rgba(0, 29, 255, 1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(255, 123, 255, 1)',
                                    pointBorderColor: 'rgba(0, 123, 255, 1)',
                                    pointRadius: 5,
                                },
                                {
                                    label: 'Total Actual (tons)',
                                    data: Object.values(sumDataBySupplier(data)).map(item => item.total_actual_kg / 1000),
                                    backgroundColor: 'rgba(0, 255, 82, 0.35)',
                                    borderColor: 'rgba(0, 255, 141, 1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: 'rgba(255, 54, 97, 1)',
                                    pointBorderColor: 'rgba(247, 255, 0, 0.02)',
                                    pointRadius: 5,
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
                                            color: 'rgb(255,255,255)',
                                        },
                                        ticks: {
                                            color: 'rgb(255,255,255)',
                                            font: {
                                                size: 16
                                            },
                                            callback: function(value) { return value + ' tons'; }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            color: 'rgb(255,255,255)',
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
                                                size: 20 , // Increase the font size here
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
                                        formatter: function(value, context) {
                                            return value.toFixed(2) + ' tons'; // Display data value in tons with 2 decimal places
                                        }
                                    }
                                }
                            },

                        plugins: [ChartDataLabels]
                    });
                }

                // Update chart with the current filter value (maintain filter on each refresh)
                      updateChart(currentFilterValue);
            })
            .catch(error => console.error('Error fetching data:', error));
        }

        // Initial fetch and chart update
        fetchAndUpdateChart();

        // Set interval to update the chart every 3 seconds (3000 milliseconds)
        setInterval(fetchAndUpdateChart, 3000); // Adjust the time as needed (e.g., 3 seconds)

        // Add event listener for the filter button
        document.getElementById('filterButton').addEventListener('click', function() {
            currentFilterValue = document.getElementById('deliveryFilter').value;
                 fetchAndUpdateChart();  // Fetch data with the current filter
             });
        });

    // var ctx = document.getElementById('deliveryChart').getContext('2d');
    //     var chart = new Chart(ctx, {
    //         type: 'pie', // Set the chart type to 'pie'
    //         data: {
    //             labels: ['PO CLOSE', 'PO OPEN'],
    //             datasets: [{
    //                 label: 'Purchase Orders',
    //                 data: [20000, 15000], // Example data for PO CLOSE and PO OPEN
    //                 backgroundColor: [
    //                     'rgba(0, 255, 19, 1)', // Color for PO CLOSE
    //                     'rgba(252, 255, 0, 1)' // Color for PO OPEN
    //                 ],
    //                 borderColor: [
    //                     'rgba(0, 255, 19, 1)', // Border color for PO CLOSE
    //                     'rgba(75, 192, 192, 1)' // Border color for PO OPEN
    //                 ],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             plugins: {
    //                 legend: {
    //                     labels: {
    //                         color: 'rgba(255, 255, 255, 1)' // White legend text color
    //                     }
    //                 },
    //                 datalabels: {
    //                     formatter: (value, ctx) => {
    //                         let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
    //                         let percentage = (value / sum * 100).toFixed(2) + "%";
    //                         return percentage;
    //                     },
    //                     color: 'black', // Text color for the percentage
    //                     font: {
    //                         size: 16, // Increase this number to enlarge the font size
    //                         weight: 'bold'
    //                     }
    //                 }
    //             }
    //         },
    //         plugins: [ChartDataLabels] // Activate the datalabels plugin
    // });

    document.addEventListener("DOMContentLoaded", function() {
        let chart = null;  // Declare chart outside the function to avoid reinitialization

        // Function to fetch and update the totals display and the chart
        function fetchAndDisplayTotals() {
            fetch("{{ route('dashboardrm.getSupplierData3') }}", {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                // Function to calculate and display total order and actual values in tons
                function displayTotals(data) {
                    const totalOrderKg = data.reduce((sum, item) => sum + item.total_order_kg, 0);
                    const totalActualKg = data.reduce((sum, item) => sum + item.total_actual_kg, 0);

                    // Update the totals displayed in the DOM
                    document.getElementById('totalOrder2').textContent = `Total Order (tons): ${(totalOrderKg / 1000).toFixed(2)} tons`;
                    document.getElementById('totalActual2').textContent = `Total Actual (tons): ${(totalActualKg / 1000).toFixed(2)} tons`;

                    // Calculate percentages for the pie chart
                    const total = totalOrderKg + totalActualKg;
                    const orderPercentage = (totalOrderKg / total) * 100;
                    const actualPercentage = (totalActualKg / total) * 100;

                    // Update or create the pie chart
                    if (chart) {
                        // Update chart data if chart already exists
                        chart.data.datasets[0].data = [totalOrderKg, totalActualKg];
                        chart.update();
                    } else {
                        // Create chart if it doesn't exist
                        const ctx = document.getElementById('orderActualPieChart').getContext('2d');
                        chart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Total Order', 'Total Actual'],
                                datasets: [{
                                    data: [totalOrderKg, totalActualKg],
                                    backgroundColor: ['#ff8000', '#2ecc71'],
                                }]
                            }, 
                            options: {
                                responsive: true,
                                color: 'rgb(255,255,255)',
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                size: 18  // Increase font size for labels
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return `${context.label}: ${((context.raw / total) * 100).toFixed(2)}% (${context.raw.toFixed(2)} kg)`;
                                            }
                                        }
                                    },
                                    datalabels: {
                                        color: '#000000',
                                        formatter: function(value, context) {
                                            const percentage = ((value / total) * 100).toFixed(2);
                                            return `${percentage}%`;
                                        },
                                        font: {
                                            weight: 'bold',
                                            size: 18
                                        }
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }
                }

                // Display totals without updating the chart
                displayTotals(data);
            })
            .catch(error => console.error('Error fetching data:', error));
        }

        // Initial fetch and display update
        fetchAndDisplayTotals();

        // Set interval to update the display every 3 seconds (3000 milliseconds)
        setInterval(fetchAndDisplayTotals, 3000); // Adjust the time as needed (e.g., 3 seconds)
    });

    var ctx = document.getElementById('performanceChart2').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar', // Base chart type
        data: {
            labels: [
                '1 Nov', '2 Nov', '3 Nov', '4 Nov', '5 Nov', '6 Nov', '7 Nov', '8 Nov', '9 Nov', '10 Nov', 
                '11 Nov', '12 Nov', '13 Nov', '14 Nov', '15 Nov', '16 Nov', '17 Nov', '18 Nov', '19 Nov', 
                '20 Nov', '21 Nov', '22 Nov', '23 Nov', '24 Nov', '25 Nov', '26 Nov', '27 Nov', '28 Nov', 
                '29 Nov', '30 Nov', '31 Nov'
            ],
            datasets: [
                {
                    label: 'Accumulation Actual',
                    type: 'line', // This makes it a line chart
                    data: [30, 75, 95, 120, 115, 125],
                    backgroundColor: 'rgba(148, 203, 32, 1)',
                    borderColor: 'rgba(148, 203, 32, 1)',
                    borderWidth: 4, // Increased to make the line thicker
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: 'rgba(148, 203, 32, 1)',
                    pointBorderColor: 'rgba(148, 203, 32, 1)',
                    pointRadius: 5,
                    datalabels: {
                        display: false // Menyembunyikan nilai pada garis Cumulative Budget
                    }
                },
                {
                    label: 'Accumulation Plan',
                    type: 'line', // This makes it a line chart
                    data: [0, 10, 30, 50, 70, 75],
                    backgroundColor: 'rgba(255, 255, 255, 1)',
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 4, // Increased to make the line thicker
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                    pointBorderColor: 'rgba(255, 255, 255, 1)',
                    pointRadius: 4,
                    datalabels: {
                        display: false // Menyembunyikan nilai pada garis Cumulative Budget
                    }
                },
                {
                    label: 'Daily Plan',
                    data: [69, 88, 44, 74, 116, 94],
                    backgroundColor: 'rgba(0, 157, 255, 0.68)',
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                    pointBorderColor: 'rgba(0, 123, 255, 1)',
                    pointRadius: 5,
                },
                {
                    label: 'Daily Actual',
                    data: [101, 102, 114, 142, 112, 110],
                    backgroundColor: 'rgba(255, 0, 0, 0.6)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(255, 54, 97, 1)',
                    pointBorderColor: 'rgba(247, 255, 0, 0.02)',
                    pointRadius: 5,
                },
            ]
        },
       options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgb(255,255,255)',
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
                        color: 'rgb(255,255,255)',
                    },
                    ticks: {
                        color: 'rgb(255,255,255)',
                        font: {
                            size: 18
                        }
                    },
                    barThickness: 30, // Menetapkan ketebalan bar, bisa disesuaikan
                    maxBarThickness: 40 // Ketebalan maksimal bar
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgb(255,255,255)',
                        font: {
                            size: 20 , // Increase the font size here
                            weight: 'bold'
                        }
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'rgba(255, 252, 252, 1)',
                    // backgroundColor: 'rgba(255, 255, 255, 0.63)',
                    borderRadius: 4,
                    padding: 6,
                    font: {
                        size: 15,
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                }
            }
        },
      plugins: [ChartDataLabels]
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
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const monthName = months[now.getMonth()];
        const date = now.getDate();
        const year = now.getFullYear();
        
        // Format: Day, Month Date, Year HH:MM:SS
        clockElement.innerText = `${dayName},  ${date} ${monthName} ${year}, ${hours}:${minutes}:${seconds}`;
     }  
     setInterval(updateClock, 1000); // Memperbarui jam setiap detik
    updateClock(); // Menampilkan jam langsung saat halaman dimua

    function showIncomingMaterials(supplier) {
        document.getElementById('material-section').scrollIntoView({ behavior: 'smooth' });
        $.ajax({
            url: "{{ route('dashboardrm.detail') }}", // Route untuk mengambil data
            method: 'GET',
            data: { supplier: supplier }, // Kirim supplier sebagai parameter
            success: function(response) {
                let tableBody = '';
                response.forEach(function(item, index) { // Add index as the second parameter
                    const formattedDate = formatDate(item.created_at);

                    tableBody += `
                        <tr>
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
                            <td>${item.order_sheet}</td>
                            <td>
                                <input type="text" style="width:50px" class="form-control form-control-sm actual-sheet" 
                                data-id="${item.id}" value="${item.actual_sheet ? item.actual_sheet : ''}" 
                                ${item.balance_sheet === 0 ? 'style="display: none;"' : ''} />
                            </td>
                            <td style="background: #F0E68C">${item.balance_sheet}</td>
                            <td>${item.order_kg}</td>
                            <td>${item.actual_kg}</td>
                            <td>${item.status ? item.status : 'OPEN'}</td>
                            <td style="background-color: #66ccff">${item.delivery}</td>
                            <td>${formattedDate}</td>
                            <td>
                                <a href="#" id="btn_pdf" title="Generate" data-id="${item.id}" class="btn btn-info btn-sm">
                                    <i class="fas fa-solid fa-qrcode"></i>
                                </a>
                            </td>
                           <td>
                            <a href="#" id="btn_detail" data-id="${item.id}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                $('#incomingTable tbody').html(tableBody);
                // $('#incomingModal').modal('show'); // Menampilkan modal
            },
            // error: function(error) {
            //     console.error('Error fetching data', error);
            // }
        });
    }

    $('#saveChanges').on('click', function() {
        let dataToSend = [];

        // Ambil nilai dari input 'actual-sheet'
        $('.actual-sheet').each(function() {
            let actualSheet = $(this).val();
            let id = $(this).data('id');

            dataToSend.push({
                id: id,
                actual_sheet: actualSheet
            });
        });

        // Kirim data yang sudah diambil ke server melalui AJAX POST
        $.ajax({
            url: "{{ route('dashboardrm.update') }}", // Route untuk update data
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",  // Sertakan CSRF token
                data: dataToSend
            },
            success: function(response) {
                // Tampilkan pesan sukses dengan SweetAlert
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data berhasil diperbarui.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            },
            error: function(xhr, status, error) {
                // Tampilkan pesan error dengan SweetAlert
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memperbarui data: ' + error,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });

    $(document).on('click', '#btn_pdf', function(e) {
            e.preventDefault();

            var doc_dn = $(this).data('id');
            var printUrl = "{{ route('dashboardrm.cetak', ':doc_dn') }}".replace(':doc_dn', doc_dn);

            // For mobile compatibility, ensure window.open works correctly
            var newWindow = window.open(printUrl, '_blank');

            // If the browser blocks the new tab, this ensures it's opened
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                window.location.href = printUrl; // Fallback to open in the same window
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
                if (count.supplier === 'POSCO') {
                    $('.metric-card:contains("POSCO") .closeText').text('PO CLOSE (' + count.total + ')');
                } else if (count.supplier === 'POSCO-2') {
                    $('.metric-card:contains("POSCO-2") .closeText').text('PO CLOSE (' + count.total + ')');
                } else if (count.supplier === 'TTMI') {
                    $('.metric-card:contains("SSK") .closeText').text('PO CLOSE (' + count.total + ')');
                } else if (count.supplier === 'SSK') {
                    $('.metric-card:contains("SSK") .closeText').text('PO CLOSE (' + count.total + ')');
                } else if (count.supplier === 'SCI') {
                    $('.metric-card:contains("SCI") .closeText').text('PO CLOSE (' + count.total + ')');
                }
            });

            // Update the text for 'PO OPEN'
            data.open.forEach(function(count) {
                if (count.supplier === 'POSCO') {
                    $('.metric-card:contains("POSCO") .openText').text('PO OPEN (' + count.total + ')');
                } else if (count.supplier === 'TTMI') {
                    $('.metric-card:contains("TTMI") .openText').text('PO OPEN (' + count.total + ')');
                }else if (count.supplier === 'SSK') {
                    $('.metric-card:contains("SSK") .openText').text('PO OPEN (' + count.total + ')');
                }else if (count.supplier === 'POSCO-2') {
                    $('.metric-card:contains("POSCO-2") .openText').text('PO OPEN (' + count.total + ')');
                }else if (count.supplier === 'SCI') {
                    $('.metric-card:contains("SCI") .openText').text('PO OPEN (' + count.total + ')');
                }
            });
                  // Update the text for 'TOTAL PO'
                  data.total.forEach(function(count) {
                if (count.supplier === 'POSCO') {
                    $('.metric-card:contains("POSCO") .totalText').text('PO TOTAL (' + count.total + ')');
                } else if (count.supplier === 'TTMI') {
                    $('.metric-card:contains("TTMI") .totalText').text('PO TOTAL (' + count.total + ')');
                } else if (count.supplier === 'SSK') {
                    $('.metric-card:contains("SSK") .totalText').text('PO TOTAL (' + count.total + ')');
                } else if (count.supplier === 'POSCO-2') {
                    $('.metric-card:contains("POSCO-2") .totalText').text('PO TOTAL (' + count.total + ')');
                }else if (count.supplier === 'SCI') {
                    $('.metric-card:contains("SCI") .totalText').text('PO TOTAL (' + count.total + ')');
                }
            });
        },
            error: function() {
                console.error("Error fetching the count by supplier");
            }
        });
    });

    function fetchSupplierData(supplier, status) {
        $.ajax({
            url: "{{ route('dashboardrm.getSupplierData') }}", // Adjust route as needed
            method: 'GET',
            data: {
                supplier: supplier,
                status: status
            },
                success: function(response) {
            let tableBody = $('#incomingTable tbody');
            tableBody.empty(); // Clear previous data

            // Populate the table with the response data
            response.forEach((item, index) => {
                let statusText = item.status === null ? 'Open' : item.status; // Check for null and set to 'Open'
                let statusText2 = item.actual_sheet === null ? '0' : item.actual_sheet; // Check for null and set to 'Open'
                const formattedDate = formatDate(item.created_at);

                
                let row = `
                    <tr>
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
                            <td>${item.order_sheet}</td>
                            <td>
                                <input type="text" style="width:50px" class="form-control form-control-sm actual-sheet" 
                                data-id="${item.id}" value="${item.actual_sheet ? item.actual_sheet : ''}" 
                                ${item.balance_sheet === 0 ? 'style="display: none;"' : ''} />
                            </td>
                            <td style="background: #F0E68C">${item.balance_sheet}</td>
                            <td>${item.order_kg}</td>
                            <td>${item.actual_kg}</td>
                            <td>${item.status ? item.status : 'OPEN'}</td>
                            <td style="background-color: #66ccff">${item.delivery}</td>
                            <td>${formattedDate}</td>
                            <td>
                                <a href="#" id="btn_pdf" title="Generate" data-id="${item.id}" class="btn btn-info btn-sm">
                                    <i class="fas fa-solid fa-qrcode"></i>
                                </a>
                            </td>
                           <td>
                            <a href="#" id="btn_detail" data-id="${item.id}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        },
        error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

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

    $('#exportModal').on('show.bs.modal', function (event) {
        // You can add additional logic here if needed when the modal is about to be shown
    });

    // Function to toggle between the two input fields
    function toggleFields() {
        const supplierField = document.getElementById('filterLine');
        const docPoField = document.getElementById('docPoFilter');
        
        if (supplierField.value) {
            // If supplier is selected, disable the DOC_PO field
            docPoField.disabled = true;
            docPoField.value = ''; // Clear the DOC_PO field
        } else {
            docPoField.disabled = false; // Enable DOC_PO if supplier is not selected
        }

        // If the DOC_PO field has value, disable the supplier selection
        if (docPoField.value) {
            supplierField.disabled = true;
        } else {
            supplierField.disabled = false;
        }
     }
    window.onload = toggleFields;

    // Add SweetAlert confirmation before form submission
    document.getElementById('exportBtn').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Check if at least one field is filled out
        const supplierField = document.getElementById('filterLine');
        const docPoField = document.getElementById('docPoFilter');

        if (!supplierField.value && !docPoField.value) {
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

    $(document).on('click', '#btn_detail', function(e) {
    e.preventDefault();

    const materialId = $(this).data('id'); // Ambil data-id dari tombol

    $.ajax({
        url: "{{ route('dashboardrm.detail2') }}", // Ganti dengan route untuk fetch detail
        method: 'GET',
        data: { id: materialId },
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            // Isi form modal dengan data
            $('#detailDocPo').val(response.doc_po);
            $('#detailDocDn').val(response.doc_dn);
            $('#detailPartNo').val(response.part_no);
            $('#detailSpec').val(response.spec);
            $('#detailKg').val(response.order_kg);
            $('#detailStatus').val(response.status);
            $('#kgSheet').val(response.spec_kg);
            $('#detailOrderSheet').val(response.order_sheet);

            // Tampilkan modal
            $('#detailModal').modal('show');
        },
        error: function(error) {
            console.error('AJAX Error:', error);
            alert('Failed to fetch material data. Please check the console for details.');
        }
    });
});





    

</script>
@endpush

 

