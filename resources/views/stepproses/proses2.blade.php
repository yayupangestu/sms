@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }
    .container {
        width: 100%;
        max-width: 2000px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
    }
    .tabs {
    display: flex;
    justify-content: space-between;
    padding: 0;
    margin: 0;
}

.tab {
    flex: 1;
    position: relative;
    text-align: center;
    padding: 10px 20px;
    font-weight: bold;
    color: white;
    background-color: #a8c4bb; /* Warna hijau pucat */
    border-right: 1px solid white; /* Garis pemisah antar tab */
    transition: background-color 0.3s;
}

.tab.active {
    background-color: #007c3c; /* Warna hijau gelap untuk tab aktif */
    color: white;
}

.tab::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 0; /* Tempatkan di sisi kanan */
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 20px 20px 20px 0; /* Bentuk panah */
    border-color: transparent #a8c4bb transparent transparent; /* Warna panah mengikuti tab */
}

.tab.active::after {
    border-color: transparent #ffffff transparent transparent; /* Panah untuk tab aktif */
}

.tab:last-child {
    border-right: none; /* Menghilangkan garis pada tab terakhir */
}

.tab:last-child::after {
    display: none; /* Menghilangkan panah pada tab terakhir */
}


    .order-info {
        margin-top: 20px;
        display: flex;
    }
    .order-list {
        flex: 1;
        padding: 10px;
        border-right: 1px solid #00a651;
    }
    .order-list p {
        margin: 0;
        font-weight: bold;
    }
    .order-list button {
        width: 100%;
        padding: 10px;
        border: 1px solid #00a651;
        background-color: #fff;
        color: #00a651;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
    }
    .order-details {
        flex: 3;
        padding: 10px;
    }
    .order-details h4 {
        margin: 0;
        color: #000000;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
    }
    .order-details h5 {
        margin: 0;
        color: #010101;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
    }
    .order-details table {
        width: 100%;
        margin-top: 10px;
    }
    .order-details table td {
        padding: 5px;
    }
    .order-details table td:first-child {
        font-weight: bold;
    }
    .order-details table td:nth-child(2) {
        color: #00a651;
        font-weight: bold;
    }
    .search-container {
    background-color: #f9f9f9;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    max-width: 800px;
    margin: 20px auto;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.search-header h4 {
    margin: 0 0 10px 0;
    font-size: 18px;
    color: #333;
    text-align: center;
    font-weight: bold;
}

.search-box {
    margin-top: 15px;
}

.search-box label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 8px;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
}

#searchInput {
    flex: 1;
    border: none;
    padding: 10px;
    font-size: 14px;
    color: #333;
}

#searchInput:focus {
    outline: none;
}

.btn-search {
    background-color: #00a651;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-search:hover {
    background-color: #007c3c;
}

.icon-search {
    font-size: 16px;
}

.order-btn.selected {
    background-color: #007bff !important; /* Warna biru */
    color: white !important;
    border: 1px solid #0056b3;
    font-weight: bold;
}


</style>

<div class="container-fluid">
    <div style="background: linear-gradient(to bottom, #007c3c 25%, #000000 78%);" class="row mb-4 align-items-center">
      <div class="col-md-6" style="position: relative;">
        <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
            <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
        </div>
        <strong><h3 style="color: white; display: inline;">Lacak informasi proses Produksi</h3></strong>
    </div>
    <div class="col-md-6 text-right">
      <div style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
          <strong><h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="dateTime" class="text-right"></h3></strong>
      </div>
  </div>
    </div>
  </div> 

<div class="container">
    <div class="search-container">
        <div class="search-header">
            <h4>Lacak Informasi Produksi</h4>
        </div>
        <label for="searchInput">Lacak Proses Produksi dengan memasukan Tanggal dan Part No yang berada di Label:</label>
        <div class="search-container">
            <input type="radio" id="waybill" name="searchType" checked>
            <label for="waybill" class="active">Direct</label>
            <input type="radio" id="order" name="searchType">
            <label for="order">Sub-Assy</label>
        </div>
        <div class="search-box">
            <div class="col-12 mb-3">
                <label for="date_plan">Date Plan:</label>
                <input type="date" id="date_plan" class="form-control">
            </div>
            <div class="search-input-wrapper">
                <input type="text" id="part_no2" placeholder="Masukkan Part No..">
                <button id="btn_search" class="btn-search">
                    <span class="icon-search">&#128269;</span>
                </button>
            </div>
        </div>
    </div>
    
    


    {{-- <div class="row">
        <div class="col-12 mb-3">
            <label for="date_plan">Date Plan:</label>
            <input type="date" id="date_plan" class="form-control">
        </div>
        <div class="col-12 mb-3">
            <label for="part_no2">Unique No:</label>
            <input type="text" id="part_no2" class="form-control">
        </div>
        <div class="col-12 mb-3 text-end">
            <button id="btn_search" class="btn btn-success">Search</button>
        </div>
    </div> --}}

    <div id="example1" style="display: none;">
        <div class="tabs">
            <div class="tab active" data-tab="PPIC">PPIC</div>
            <div class="tab" data-tab="RAW MATERIAL">RAW MATERIAL</div>
            <div class="tab" data-tab="BLANKOUT">BLANK</div>
            <div class="tab" data-tab="STAMPINGIN">STAMPING IN</div>
            <div class="tab" data-tab="STAMPINGOUT">STAMPING OUT</div>
            <div class="tab" data-tab="LINE STORE">LINE STORE</div>
            <div class="tab" data-tab="BUTTON PUSH">BUTTON PUSH</div>
            {{-- <div class="tab" data-tab="WELDING">WELDING</div>
            <div class="tab" data-tab="BUTTON PUSH">PC-STORE</div>
            <div class="tab" data-tab="WELDING">DELIVERY</div> --}}
        </div>     
        

        <div class="order-info">
            <div class="order-list">
                <p>Part No(Kode yang digunkan saat produksi):</p>
                {{-- <button id="order-id"></button> --}}
            </div>
            <div class="order-details">
                <h4>Informasi Planning<i class="fas fa-cubes" style="margin-left: 20px; color: #9A9A9A;"></i></h4>
                <table>
                </table>
            </div>
        </div>
        
    </div>
</div>
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
 $(document).ready(function () {
    // Hide the data container initially
    $("#example1").hide();

    // Click event on the tabs
    $(document).on("click", ".tab", function () {
        // Remove the 'active' class from all tabs
        $(".tab").removeClass("active");

        // Add the 'active' class to the clicked tab
        $(this).addClass("active");

        // Get the selected tab
        const selectedTab = $(this).data("tab");

        // Call the list function to update the data for the selected tab
        list(selectedTab);
    });

    // Search button click event
    $(document).on("click", "#btn_search", function () {
        if ($("#date_plan").val() !== '' && $("#part_no2").val() !== '') {
            $("#example1").show();
            $("#part_no2").text($("#part_no2").val());
            $("#order-id").text($("#part_no2").val());
            list();  // Default call to list without specific tab
        } else {
            $("#example1").hide();
        }
    });

  

    let allData = []; // Variabel global untuk menyimpan semua data

 function list(selectedTab = '') {
    $.ajax({
        type: 'GET',
        url: "{{ route('proses2.list') }}",
        data: {
            date_plan: $("#date_plan").val(),
            part_no2: $("#part_no2").val()
        },
        success: function (result) {
            allData = result.data || []; // Simpan semua data ke variabel global
            $(".order-list").html('<p>Part No (Kode yang digunakan saat produksi):</p>'); // Reset list
            let orderButtons = '';

            if (allData.length > 0) {
                allData.forEach(item => {
                    // Gabungkan uniqNo yang tersedia
                    const combinedUniqNo = [
                        item.stmp_out_uniqNo,
                        item.stmp_out_uniqNo2,
                        item.stmp_out_uniqNo3,
                        item.stmp_out_uniqNo4
                    ].filter(Boolean).join(' | '); // Hanya nilai yang tidak null

                    orderButtons += `
                        <button class="order-btn" data-id="${item.id}" data-tab="${selectedTab}" style="margin-bottom: 8px; padding: 10px; width: 100%; text-align: left;">
                            <div><strong>ID:</strong> ${item.id} | <strong>Part:</strong> ${item.part_no2}</div>
                            <div style="font-size: 13px; color: #555;">
                                ${combinedUniqNo}
                            </div>
                        </button>
                    `;
                });
            } else {
                orderButtons = '<p class="text-danger">Tidak ada data ditemukan.</p>';
            }

            $(".order-list").append(orderButtons);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
            $(".order-list").html(` 
                <h5 class="text-danger font-weight-bold">Error loading data</h5> 
                <p>Unable to load the requested information. Please try again later.</p> 
            `);
        }
    });
}



// Event listener untuk menangani klik tombol order
// Event listener untuk menangani klik tombol order
$(document).on("click", ".order-btn", function () {
    const id = $(this).data("id");
    const selectedTab = $(this).data("tab");
    const selectedData = allData.find(item => item.id == id) || {};

    // Hilangkan efek warna dari tombol lain
    $(".order-btn").removeClass("selected");

    // Tambahkan efek warna ke tombol yang diklik
    $(this).addClass("selected");

    if (!selectedData.id) {
        $(".order-details").html('<p class="text-danger">Data tidak ditemukan.</p>').hide().slideDown(500);
        return;
    }

    const generateTable = (rows) => `
        <table class="table table-bordered table-striped">
            ${rows.map(row => `
                <tr>
                    <td class="font-weight-bold">${row.label1}</td>
                    <td>${row.value1 || '-'}</td>
                    <td class="font-weight-bold">${row.label2}</td>
                    <td>${row.value2 || '-'}</td>
                </tr>`).join('')}
        </table>`;

    let detailsHtml = `
        <h4>Detail Data ID: ${selectedData.id}</h4>
        <h4>Planning Line Proses<i class="fas fa-cubes" style="margin-left: 20px; color: #9A9A9A;"></i></h4>
        ${generateTable([
            { label1: 'Id Proses', value1: selectedData.uniqNo, label2: 'Job No', value2: selectedData.job_no },
            { label1: 'Mesin Proses', value1: selectedData.mesin, label2: 'Part No', value2: selectedData.part_no2 },
            { label1: 'Tanggal Planning', value1: selectedData.date_plan, label2: 'Model', value2: selectedData.model_id },
            { label1: 'Pembuat', value1: selectedData.createdby, label2: 'Spesifikasi', value2: selectedData.spek },
            { label1: 'Waktu Dibuat', value1: selectedData.created_at, label2: 'Quantity Planning', value2: selectedData.qty_plan },
            { label1: 'Diedit', value1: selectedData.updatedby, label2: 'SHIFT', value2: selectedData.shift },
            { label1: 'Waktu Diedit', value1: selectedData.updated_at, label2: '-', value2: '-' }
        ])}`;

        if (selectedTab === 'RAW MATERIAL') {
        detailsHtml += `
            <h4>Material Out 1<i class="fas fa-cubes" style="margin-left: 20px; color: #9A9A9A;"></i></h4>
            ${generateTable([
                { label1: 'Uniqe No', value1: selectedData.rm_uniqNo, label2: 'Part No', value2: selectedData.part_no2 },
                { label1: 'Scan Out', value1: selectedData.rm_user, label2: 'Spesifikasi', value2: selectedData.rm_spek },
                { label1: 'Waktu Keluar', value1: selectedData.rm_time, label2: 'Quantity', value2: selectedData.rm_qty },
                { label1: 'RM/G5', value1: selectedData.part_no2, label2: 'Supplier', value2: selectedData.rm_supplier }
            ])}
            <h4>Material Out 2<i class="fas fa-cubes" style="margin-left: 20px; color: #9A9A9A;"></i></h4>
            ${generateTable([
                { label1: 'Uniqe No', value1: selectedData.rm_uniqNo2, label2: 'Part No', value2: selectedData.rm_partNo2 },
                { label1: 'Scan Out', value1: selectedData.rm_user2, label2: 'Spesifikasi', value2: selectedData.rm_spek2 },
                { label1: 'Waktu Keluar', value1: selectedData.rm_time2, label2: 'Quantity', value2: selectedData.rm_qty2 },
                { label1: '-', value1: '-', label2: 'Supplier', value2: selectedData.rm_supplier2 }
            ])}`;
    }


    if (selectedTab === 'BLANKOUT') {
    detailsHtml += `
        <h5 class="font-weight-bold mb-4">Informasi Blank Proses</h5>
         ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.blank_uniqNo, label2: 'Part No', value2: selectedData.blank_partNo },
            { label1: 'PIC', value1: selectedData.blank_user, label2: 'Spesifikasi', value2: selectedData.blank_spek },
            { label1: 'Waktu Keluar', value1: selectedData.blank_time, label2: 'Quantity', value2: selectedData.blank_qty },
            { label1: '-',  label2: 'Mesin Proses', value2: selectedData.blank_supplier }
        ])}
          <h5 class="font-weight-bold mb-4">Informasi Blank Proses</h5>
         ${generateTable([
            { label1: 'Kode Material', value1: selectedData.blank_uniqNo2, label2: 'Part No', value2: selectedData.blank_partNo2 },
            { label1: 'Scan IN', value1: selectedData.blank_user2, label2: 'Spesifikasi', value2: selectedData.blank_spek2 },
            { label1: 'Waktu Masuk', value1: selectedData.blank_time2, label2: 'Quantity', value2: selectedData.blank_qty2 },
            { label1: 'Leader Line', value1: selectedData.blank_user2, label2: 'Supplier', value2: selectedData.blank_supplier2 }
        ])}`;
    }

    if (selectedTab === 'STAMPINGIN') {
    detailsHtml += `
        <h5 class="font-weight-bold mb-4">Informasi Stamping In</h5>
         ${generateTable([
            { label1: 'Kode Material', value1: selectedData.stmp_in_uniqNo, label2: 'Part No', value2: selectedData.stmp_in_partNo },
            { label1: 'Scan IN', value1: selectedData.stmp_in_user, label2: 'Spesifikasi', value2: selectedData.stmp_in_spek },
            { label1: 'Waktu Masuk', value1: selectedData.stmp_in_time, label2: 'Quantity', value2: selectedData.stmp_in_qty },
            { label1: 'Leader Line', value1: selectedData.stmp_in_leader_line, label2: 'Supplier', value2: selectedData.stmp_in_supplier }
        ])}
         <h5 class="font-weight-bold mb-4">Informasi Stamping In</h5>
         ${generateTable([
            { label1: 'Kode Material', value1: selectedData.stmp_in_uniqNo2, label2: 'Part No', value2: selectedData.stmp_in_partNo2 },
            { label1: 'Scan IN', value1: selectedData.stmp_in_user2, label2: 'Spesifikasi', value2: selectedData.stmp_in_spek2 },
            { label1: 'Waktu Masuk', value1: selectedData.stmp_in_time2, label2: 'Quantity', value2: selectedData.stmp_in_qty2 },
            { label1: 'Leader Line', value1: selectedData.stmp_in_leader_line2, label2: 'Supplier', value2: selectedData.stmp_in_supplier2 }
        ])}
          <h5 class="font-weight-bold mb-4">Informasi Stamping In</h5>
         ${generateTable([
            { label1: 'Kode Material', value1: selectedData.stmp_in_uniqNo3, label2: 'Part No', value2: selectedData.stmp_in_partNo3 },
            { label1: 'Scan IN', value1: selectedData.stmp_in_user3, label2: 'Spesifikasi', value2: selectedData.stmp_in_spek3 },
            { label1: 'Waktu Masuk', value1: selectedData.stmp_in_time3, label2: 'Quantity', value2: selectedData.stmp_in_qty3 },
            { label1: 'Leader Line', value1: selectedData.stmp_in_leader_line3, label2: 'Supplier', value2: selectedData.stmp_in_supplier3 }
        ])}
          <h5 class="font-weight-bold mb-4">Informasi Stamping In</h5>
         ${generateTable([
            { label1: 'Kode Material', value1: selectedData.stmp_in_uniqNo4, label2: 'Part No', value2: selectedData.stmp_in_partNo4 },
            { label1: 'Scan IN', value1: selectedData.stmp_in_user4, label2: 'Spesifikasi', value2: selectedData.stmp_in_spek4 },
            { label1: 'Waktu Masuk', value1: selectedData.stmp_in_time4, label2: 'Quantity', value2: selectedData.stmp_in_qty4 },
            { label1: 'Leader Line', value1: selectedData.stmp_in_leader_line4, label2: 'Supplier', value2: selectedData.stmp_in_supplier4 }
        ])}`;
    }

    if (selectedTab === 'STAMPINGOUT') {
    detailsHtml += `
        <h5 class="font-weight-bold mb-4">Informasi Stamping Out Kanban 1</h5>
         ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.stmp_out_uniqNo, label2: 'Part No', value2: selectedData.stmp_out_jobNo },
            { label1: 'Scan Out', value1: selectedData.stmp_out_user, label2: 'Spesifikasi', value2: selectedData.stmp_out_partNo },
            { label1: 'Waktu Keluar', value1: selectedData.stmp_out_time, label2: 'Model', value2: selectedData.stmp_out_model },
            { label1: 'Tanggal Planning', value1: selectedData.stmp_out_date, label2: 'Quantity', value2: selectedData.stmp_out_qty },
            { label1: 'LINE', value1: '-', label2: 'Start Proses', value2: selectedData.stmp_out_start },
            { label1: 'Leader Line', value1: selectedData.stmp_out_leader_line, label2: 'End Proses', value2: selectedData.stmp_out_end },
            { label1: '-', value1: '-', label2: 'Kode Material', value2: selectedData.stmp_out_kodematerial }
        ])}
        <h5 class="font-weight-bold mb-4">Informasi Stamping Out Kanban 2</h5>
         ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.stmp_out_uniqNo2, label2: 'Part No', value2: selectedData.stmp_out_jobNo2 },
            { label1: 'Scan Out', value1: selectedData.stmp_out_user2, label2: 'Spesifikasi', value2: selectedData.stmp_out_partNo2 },
            { label1: 'Waktu Keluar', value1: selectedData.stmp_out_time2, label2: 'Model', value2: selectedData.stmp_out_model2 },
            { label1: 'Tanggal Planning', value1: selectedData.stmp_out_date2, label2: 'Quantity', value2: selectedData.stmp_out_qty2 },
            { label1: 'LINE', value1: '-', label2: 'Start Proses', value2: selectedData.stmp_out_start2 },
            { label1: 'Leader Line', value1: selectedData.stmp_out_leader_line2, label2: 'End Proses', value2: selectedData.stmp_out_end2 },
            { label1: '-', value1: '-', label2: 'Kode Material', value2: selectedData.stmp_out_kodematerial2 }
        ])}
         <h5 class="font-weight-bold mb-4">Informasi Stamping Out Kanban 3</h5>
          ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.stmp_out_uniqNo3, label2: 'Part No', value2: selectedData.stmp_out_jobNo3 },
            { label1: 'Scan Out', value1: selectedData.stmp_out_user3, label2: 'Spesifikasi', value2: selectedData.stmp_out_partNo3 },
            { label1: 'Waktu Keluar', value1: selectedData.stmp_out_time3, label2: 'Model', value2: selectedData.stmp_out_model3 },
            { label1: 'Tanggal Planning', value1: selectedData.stmp_out_date3, label2: 'Quantity', value2: selectedData.stmp_out_qty3 },
            { label1: 'LINE', value1: '-', label2: 'Start Proses', value2: selectedData.stmp_out_start3 },
            { label1: 'Leader Line', value1: selectedData.stmp_out_leader_line3, label2: 'End Proses', value2: selectedData.stmp_out_end3 },
            { label1: '-', value1: '-', label2: 'Kode Material', value2: selectedData.stmp_out_kodematerial3 }
        ])}
          <h5 class="font-weight-bold mb-4">Informasi Stamping Out Kanban 4</h5>
          ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.stmp_out_uniqNo4, label2: 'Part No', value2: selectedData.stmp_out_jobNo4 },
            { label1: 'Scan Out', value1: selectedData.stmp_out_user4, label2: 'Spesifikasi', value2: selectedData.stmp_out_partNo4 },
            { label1: 'Waktu Keluar', value1: selectedData.stmp_out_time4, label2: 'Model', value2: selectedData.stmp_out_model4 },
            { label1: 'Tanggal Planning', value1: selectedData.stmp_out_date4, label2: 'Quantity', value2: selectedData.stmp_out_qty4 },
            { label1: 'LINE', value1: '-', label2: 'Start Proses', value2: selectedData.stmp_out_start4 },
            { label1: 'Leader Line', value1: selectedData.stmp_out_leader_line4, label2: 'End Proses', value2: selectedData.stmp_out_end4 },
            { label1: '-', value1: '-', label2: 'Kode Material', value2: selectedData.stmp_out_kodematerial4 }
        ])}
         <h5 class="font-weight-bold mb-4">Informasi Stamping Out Kanban 5</h5>
          ${generateTable([
            { label1: 'Uniqe No', value1: selectedData.stmp_out_uniqNo5, label2: 'Part No', value2: selectedData.stmp_out_jobNo5 },
            { label1: 'Scan Out', value1: selectedData.stmp_out_user5, label2: 'Spesifikasi', value2: selectedData.stmp_out_partNo5 },
            { label1: 'Waktu Keluar', value1: selectedData.stmp_out_time5, label2: 'Model', value2: selectedData.stmp_out_model5 },
            { label1: 'Tanggal Planning', value1: selectedData.stmp_out_date5, label2: 'Quantity', value2: selectedData.stmp_out_qty5 },
            { label1: 'LINE', value1: '-', label2: 'Start Proses', value2: selectedData.stmp_out_start5 },
            { label1: 'Leader Line', value1: selectedData.stmp_out_leader_line5, label2: 'End Proses', value2: selectedData.stmp_out_end5 },
            { label1: '-', value1: '-', label2: 'Kode Material', value2: selectedData.stmp_out_kodematerial5 }
        ])}`;
}

    // Gunakan animasi slide
    $(".order-details").slideUp(1000, function () {
        $(this).html(detailsHtml).slideDown(800);
    });
});






});


</script>
@endpush
