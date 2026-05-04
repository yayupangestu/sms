@extends('layouts.app')

@section('content')

<style>
  .small-box {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .small-box:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  .container {
  display: flex;
  flex-wrap: wrap; /* Membuat elemen pindah ke bawah jika ruang habis */
  justify-content: center; /* Memposisikan elemen agar tetap di tengah */
  gap: 10px; /* Jarak antar elemen */
  padding: 10px;
}

.small-box {
  background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%);
  width: 300px;
  height: 150px;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s;
}

.small-box:hover {
  transform: scale(1.05); /* Animasi saat hover */
}

@media (max-width: 768px) {
  .small-box {
    width: 100%; /* Membuat elemen memenuhi lebar layar pada layar kecil */
    height: auto;
  }
}

@media (max-width: 480px) {
  .container {
    flex-direction: column; /* Jika layar sangat kecil, buat semua elemen berbaris vertikal */
    align-items: center;
  }
}


</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Stok Material</h1>
      </div>
      <div class="col-md-6 text-right">
        <h3 id="clock" class="text-right"></h3> <!-- Menambahkan elemen jam di sini -->
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Metric Cards -->
    <div class="row">
      <div style="background: linear-gradient(to top, #33ccff 30%, #3333ff 100%);" class="col-lg-3 col-6">
        <div style="  background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%);" class="small-box bg-white card-shadow p-3">
          <div class="inner" onclick="showIncomingMaterials('1,2,3,4,5,6,7,8,9')">
            @php
            $row = DB::table('rm_materials')->select(DB::raw('count(name_material) as jml'))->first();
            @endphp
            <h3>{{ $row->jml }}-Item</h3>
           <strong><i><p style="font-size: 20px">TOTAL MATERIAL</p></i></strong> 
            <span class="text-warning">More Info</span> 
          </div>
          <div style="color: white" class="icon">
            <i class="fas fa-box"></i>
          </div>
        </div>
      </div>
      <div style="background: linear-gradient(to top, #33ccff 30%, #3333ff 100%);" class="col-lg-3 col-6">
    <div style="background: linear-gradient(to bottom, #00cc99 38%, #66ffff 100%);" class="small-box bg-white card-shadow p-3">
      <div class="inner" onclick="showIncomingMaterials2('safe_data')">
        @php
        // Menghitung jumlah item di mana actual lebih besar dari minimal + 300
        $row = DB::table('rm_stoks')->whereColumn('actual', '>', DB::raw('minimal + 500'))->count();
        @endphp
        <h3>{{ $row }}-Item</h3>
        <strong><i><p style="font-size: 20px">SAFE</p></i></strong> 
        <span class="text-warning">More Info</span> 
    </div>
    <div style="color: white" class="icon">
        <i class="fas fa-box"></i>
    </div>
</div>

      </div>
      <div style="background: linear-gradient(to top, #33ccff 30%, #3333ff 100%);" class="col-lg-3 col-6">
        <div style=" background: linear-gradient(to bottom right, #ffffcc 45%, #ccff33 100%);" class="small-box bg-white card-shadow p-3">
          <div class="inner" onclick="showIncomingMaterials4('order_data')">
            @php
            // Menghitung jumlah item di mana actual berada dalam rentang (minimal, minimal + 200) dan minimal > 0
            $row = DB::table('rm_stoks as a')
                ->leftJoin('rm_materials as b', 'b.id', '=', 'a.material_id') // Join untuk mengakses informasi dari rm_materials
                ->whereColumn('a.actual', '>=', 'a.minimal') // actual lebih besar atau sama dengan minimal
                ->whereColumn('a.actual', '<=', DB::raw('a.minimal + 500')) // actual tidak lebih dari minimal + 200
                ->where('a.minimal', '>', 0) // Tambahkan kondisi untuk hanya menghitung di mana minimal > 0
                ->count();
            @endphp
            <h3>{{ $row }} - Item</h3>
            <strong><i><p style="font-size: 20px">ORDERING</p></i></strong> 
            <span class="text-warning">More Info</span> 
        </div>
          <div style="color: rgb(0, 0, 0)" class="icon">
            <i class="fas fa-box"></i>
          </div>
        </div>
      </div>
      <div style="background: linear-gradient(to top, #33ccff 30%, #3333ff 100%);" class="col-lg-3 col-6">
        <div style="background: linear-gradient(to bottom left, #ff9999 57%, #ff3300 100%);" class="small-box bg-white card-shadow p-3">
          <div class="inner" onclick="showIncomingMaterials3('critical_data')">
            @php
            $row = DB::table('rm_stoks')
                    ->whereColumn('actual', '<', 'minimal') // Menyaring hanya yang nilai actual di bawah minimal
                    ->select(DB::raw('count(*) as jml')) // Menghitung jumlah baris
                    ->first();
            @endphp
            <h3>{{ $row->jml }} - Item</h3>
            <strong><i><p style="font-size: 20px">CRITICAL</p></i></strong> 
            <span class="text-warning">More Info</span> 
        </div>        
          <div style="color: white" class="icon">
            <i class="fas fa-battery-half"></i>
          </div>
        </div>
      </div>
    </div>
    <br>

    
    <div class="container">
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('D03')">
          <h3 style="font-size: 23px;">Model D03</h3>
          @php
            $modelName = 'D03'; // Ganti dengan nama model yang ingin dihitung
            $row = DB::table('rm_stoks')->where('model_id', $modelName)->count();
          @endphp
          <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
    
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('2')">
          <h3 style="font-size: 23px;">Model D14</h3>
          @php
          $modelName = '2'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('3')">
          <h3 style="font-size: 23px;">Model D26</h3>
          @php
          $modelName = '3'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('5')">
          <h3 style="font-size: 23px;">Model D30</h3>
          @php
          $modelName = '5'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('6')">
          <h3 style="font-size: 23px;">Model D40</h3>
          @php
          $modelName = '5'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('7')">
          <h3 style="font-size: 23px;">Model D40L</h3>
          @php
          $modelName = '7'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('8')">
          <h3 style="font-size: 23px;">Model D55</h3>
          @php
          $modelName = '8'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('9')">
          <h3 style="font-size: 23px;">Model D55L</h3>
          @php
          $modelName = '9'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('10')">
          <h3 style="font-size: 23px;">Model D74</h3>
          @php
          $modelName = '10'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
      <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-3">
        <div class="inner"  onclick="showIncomingMaterials('11')">
          <h3 style="font-size: 23px;">Model D88</h3>
          @php
          $modelName = '11'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
         <div style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%); width: 150px; height: 150px; padding: 10px;" class="small-box bg-white card-shadow p-4">
        <div class="inner"  onclick="showIncomingMaterials('12')">
          <h3 style="font-size: 23px;">SU2id</h3>
          @php
          $modelName = '12'; // Ganti dengan nama model yang ingin dihitung
          $row = DB::table('rm_materials')->where('model', $modelName)->count();
        @endphp
        <strong><i><p style="font-size: 20px;"> {{ $row }} Items</p></i></strong>
          <span class="text-warning">More Info</span>
        </div>
      </div>
    </div>
  
    <div class="modal-body">
      <div class="form-group row">
          <div class="col-12" id="alert"></div>              
          <div class="col-sm-7">

          </div>
          <div class="col-sm-5 text-right">
              <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="display: inline-block; width: auto;">
              <button id="searchButton" class="btn btn-secondary" style="display: inline-block;">Search</button>
          </div>
      </div>
      <div class="table-responsive">
          <table id="incomingTable" class="table table-hover table-bordered" style="table-layout: fixed;">
              <thead style="background: linear-gradient(to bottom left, #99ccff 44%, #6699ff 100%);" >
                  <tr>
                      <th style="width: 10px; text-align:center">N0</th>
                      <th style="width: 60px; text-align:center">Part No</th>
                      <th style="width: 60px; text-align:center">Model</th>
                      <th style="width: 70px; text-align:center">Spec</th>
                      <th style="width: 70px; text-align:center">T</th>
                      <th style="width: 10px; text-align:center">W</th>
                      <th style="width: 10px; text-align:center">L</th>
                      <th style="width: 10px; text-align:center">Home Line</th>
                      <th style="width: 50px; text-align:center">Supplier</th>
                      <th style="width: 50px; text-align:center">Minimal</th>
                      <th style="width: 50px; text-align:center">Actual</th>
                  </tr>
              </thead>
              <tbody style="text-align: center">
                  <!-- Data tabel akan diisi di sini -->
              </tbody>
          </table>
      </div>
  </div>

  </div>
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

function updateClock() {
    const now = new Date();
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    const dayName = days[now.getDay()]; // Mendapatkan hari dalam seminggu
    const day = now.getDate().toString().padStart(2, '0');
    const monthName = months[now.getMonth()]; // Mendapatkan nama bulan
    const year = now.getFullYear();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    // Format: Day, DD Month YYYY HH:mm:ss
    const formattedTime = `${dayName}, ${day} ${monthName} ${year} ${hours}:${minutes}:${seconds}`;

    document.getElementById('clock').innerHTML = formattedTime;
  }

  setInterval(updateClock, 1000); // Perbarui setiap detik
  updateClock(); // Panggil fungsi pertama kali

  function showIncomingMaterials(values) {
    // Pecah string berdasarkan koma menjadi array
    const models = values.split(',');

    // Kosongkan isi tabel sebelum menambahkan data baru untuk menghindari duplikasi
    $('#incomingTable tbody').empty();

    // Variabel untuk menghitung urutan
    let counter = 1;

    // Iterasi setiap model
    models.forEach(function(model) {
        console.log("Processing model: " + model);

        // AJAX untuk setiap model
        $.ajax({
            url: "{{ route('dashboardrmstok.detail') }}", // Route untuk mengambil data
            method: 'GET',
            data: { model: model }, // Kirim model sebagai parameter
            success: function(response) {
                let tableBody = '';

                // Iterasi setiap item dari response
                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                          <td style="background-color:#eaeaea">${counter}</td> <!-- Kolom urutan -->
                          <td style="background-color:#eaeaea">${item.spek}</td>
                          <td style="background-color:#eaeaea">${item.model}</td>
                          <td style="background-color:#eaeaea">${item.name_material}</td>
                          <td style="background-color:#eaeaea">${item.spek_t}</td>
                          <td style="background-color:#eaeaea">${item.spek_p}</td>
                          <td style="background-color:#eaeaea">${item.spek_l}</td>
                          <td style="background-color:#eaeaea">${item.line_id}</td>
                          <td style="background-color:#eaeaea">${item.supplier}</td>
                          <td style="background-color:#eaeaea">
                              ${item.minimal !== null ? item.minimal : 'Not Ready'}
                          </td>
                          <td style="background-color:${item.actual === 0 || item.actual === null ? '#ea9999' : '#eaeaea'}">
                              ${item.actual !== null ? item.actual : 'Not Ready'}
                          </td>
                        </tr>`;
                    counter++; // Increment urutan setiap kali item ditambahkan
                });

                // Tambahkan data ke dalam tabel
                $('#incomingTable tbody').append(tableBody);
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    });

    // Setelah semua request selesai, tampilkan modal
    $('#incomingModal').modal('show');
}

function showIncomingMaterials2(condition) {
    // Clear the table to avoid duplication
    $('#incomingTable tbody').empty();

    if (condition === 'safe_data') {
        // Make an AJAX request to get data where `actual` > `minimal + 300`
        $.ajax({
            url: "{{ route('dashboardrmstok.getSafeData') }}", // Adjust route to fetch 'safe' data
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                // Iterate over the response data
                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                          <td style="background-color:#eaeaea">${counter}</td> <!-- Kolom urutan -->
                          <td style="background-color:#eaeaea">${item.part_name}</td>
                          <td style="background-color:#eaeaea">${item.model_id}</td>
                          <td style="background-color:#eaeaea">${item.material_id}</td>
                          <td style="background-color:#eaeaea">${item.spek_t}</td>
                          <td style="background-color:#eaeaea">${item.spek_p}</td>
                          <td style="background-color:#eaeaea">${item.spek_l}</td>
                          <td style="background-color:#eaeaea">${item.line_id}</td>
                          <td style="background-color:#eaeaea">${item.supplier}</td>
                          <td style="background-color:#eaeaea">${item.minimal}</td>
                          <td style="background-color:#9cf6b8">${item.actual}</td>
                        </tr>`;
                    counter++;
                });

                // Add the data to the table body
                $('#incomingTable tbody').append(tableBody);
                $('#incomingModal').modal('show'); // Show modal with data
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}

function showIncomingMaterials3(condition) {
    // Clear the table to avoid duplication
    $('#incomingTable tbody').empty();

    if (condition === 'critical_data') {
        // Make an AJAX request to get data where `actual` > `minimal + 300`
        $.ajax({
            url: "{{ route('dashboardrmstok.getCritcalData') }}", // Adjust route to fetch 'safe' data
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                // Iterate over the response data
                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                          <td style="background-color:#eaeaea">${counter}</td> <!-- Kolom urutan -->
                          <td style="background-color:#eaeaea">${item.part_name}</td>
                          <td style="background-color:#eaeaea">${item.model_id}</td>
                          <td style="background-color:#eaeaea">${item.material_id}</td>
                          <td style="background-color:#eaeaea">${item.spek_t}</td>
                          <td style="background-color:#eaeaea">${item.spek_p}</td>
                          <td style="background-color:#eaeaea">${item.spek_l}</td>
                          <td style="background-color:#eaeaea">${item.line_id}</td>
                          <td style="background-color:#eaeaea">${item.supplier}</td>
                          <td style="background-color:#eaeaea">${item.minimal}</td>
                          <td style="background-color:#fba2a2">${item.actual}</td>
                        </tr>`;
                    counter++;
                });

                // Add the data to the table body
                $('#incomingTable tbody').append(tableBody);
                $('#incomingModal').modal('show'); // Show modal with data
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}


function showIncomingMaterials4(condition) {
    // Clear the table to avoid duplication
    $('#incomingTable tbody').empty();

    if (condition === 'order_data') {
        // Make an AJAX request to get data where `actual` > `minimal + 300`
        $.ajax({
            url: "{{ route('dashboardrmstok.getOrderData') }}", // Adjust route to fetch 'safe' data
            method: 'GET',
            success: function(response) {
                let tableBody = '';
                let counter = 1;

                // Iterate over the response data
                response.forEach(function(item) {
                    tableBody += `
                        <tr>
                          <td style="background-color:#eaeaea">${counter}</td> <!-- Kolom urutan -->
                          <td style="background-color:#eaeaea">${item.part_name}</td>
                          <td style="background-color:#eaeaea">${item.model_id}</td>
                          <td style="background-color:#eaeaea">${item.material_id}</td>
                          <td style="background-color:#eaeaea">${item.spek_t}</td>
                          <td style="background-color:#eaeaea">${item.spek_p}</td>
                          <td style="background-color:#eaeaea">${item.spek_l}</td>
                          <td style="background-color:#eaeaea">${item.line_id}</td>
                          <td style="background-color:#eaeaea">${item.supplier}</td>
                          <td style="background-color:#eaeaea">${item.minimal}</td>
                          <td style="background-color:#fcffb2">${item.actual}</td>
                        </tr>`;
                    counter++;
                });

                // Add the data to the table body
                $('#incomingTable tbody').append(tableBody);
                $('#incomingModal').modal('show'); // Show modal with data
            },
            error: function(error) {
                console.error('Error fetching data', error);
            }
        });
    } else {
        console.log("Unknown condition: " + condition);
    }
}



   





</script>
@endpush

