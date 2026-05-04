@extends('layouts.app')

@section('content')
    <style>
        #incomingTable.table-hover tbody tr:hover {
            background: linear-gradient(to top, #818181a8 17%, #ffffff 99%);
            color: #000000;
            /* Warna teks saat hover (opsional) */
        }

        #insertedData:empty::before {
            content: none;
        }

        /* style="background: linear-gradient(to bottom, #EDEDED, #DADADA);  */
.custom-dashboard {
    /* background: linear-gradient(to bottom right, #006699 0%, #003366 100%); */
    background-color: rgba(238, 238, 238, 0.185);
    font-family: 'Poppins', sans-serif;
    padding: 20px;
}

.dashboard-title {
    font-size: 26px;
    font-weight: bold;
    color: #000000;
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

.btn.disabled {
    pointer-events: none; /* Nonaktifkan klik */
    opacity: 0.6; /* Ubah transparansi tombol untuk menunjukkan bahwa itu dinonaktifkan */
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




.dataTables_filter {
    float: right !important; /* Pindahkan search ke kanan */
}
.dataTables_length {
    float: left !important; /* Pindahkan dropdown panjang tabel ke kiri */
}

.info-box {
  background: #eeecec;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgb(0, 0, 0);
  padding: 15px; /* sebelumnya 25px */
  position: relative;
  color: #000000;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  margin-bottom: 15px; /* sebelumnya 20px */
}

.info-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.info-box .inner p {
  font-size: 16px !important; /* sebelumnya 25px */
  margin-bottom: 5px;
}

.info-box .inner h3 {
  font-size: 20px !important; /* sebelumnya besar */
  margin: 0;
}


/* Content Styling */
.info-content {
  display: flex;
  flex-direction: column;
  align-items: start;
}

.info-title {
  font-size: 30px;
  font-weight: 500;
  margin: 0;
  color: #000000;
  opacity: 0.9;
}

/* Icon Styling */
.info-icon {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 80px;
  color: rgba(0, 0, 0, 0.584);
}

/* Change Text Styling */
.info-change {
  font-size: 14px;
  margin-top: 10px;
  display: flex;
  align-items: center;
}

.info-change i {
  margin-right: 5px;
}

/* Color for positive and negative changes */
.text-success {
  color: #4caf50;
}

.text-danger {
  color: #f44336;
}
.btn-success:hover {
    background-color: #28a745;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.2s ease-in-out;
}

</style>

<div class="container-fluid py-4 custom-dashboard">
            <!-- Top Header -->
            <div style= "background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff " class="row mb-4 align-items-center">
                <div class="col-md-6" style="position: relative;">
                    <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                        <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                    </div>
                    <h3 style="color: rgb(255, 255, 255); display: inline;">Dashboard Incoming Part INHOUSE</h3>
                </div>
                <div class="col-md-6 text-right">
                    <div style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: color:#ffffff; border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                        <strong><h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="clock" class="text-right"></h3></strong>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                  <!-- Card 1 -->
                  <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="total_part" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-in-alt fa-2x" style="color: #2878a7;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                          @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'INHOUSE')
                                ->select(DB::raw('count(id) as jml'))
                                ->first();
                          @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART INHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row->jml }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>


                   {{-- <!-- Card 2 -->
                   <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="total_part2" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-out-alt fa-2x" style="color: #2878a7;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                          @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'OUTHOUSE')
                                ->select(DB::raw('count(id) as jml'))
                                ->first();
                          @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART OUTHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row->jml }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div> --}}

                   <!-- Card 3 -->
                   <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="safe_data" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-in-alt fa-2x" style="color: #28a745;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'INHOUSE')
                                ->where(function ($query) {
                                    $query->whereColumn('qty_actual', '>', 'qty_min') // qty_act > qty_min
                                          ->orWhereColumn('qty_actual', '=', 'qty_min'); // qty_actual = qty_min
                                })
                                ->count();
                            @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART SAFE INHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>

                   {{-- <!-- Card 4 -->
                   <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="safe_data2" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-out-alt fa-2x" style="color: #28a745;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'OUTHOUSE')
                                ->where(function ($query) {
                                    $query->whereColumn('qty_actual', '>', 'qty_min') // qty_act > qty_min
                                          ->orWhereColumn('qty_actual', '=', 'qty_min'); // qty_actual = qty_min
                                })
                                ->count();
                            @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART SAFE OUTHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div> --}}

                   <!-- Card 5 -->
                   <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="critical_data" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-in-alt fa-2x" style="color: #ff0d00;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'INHOUSE')
                                ->whereColumn('qty_actual', '<=', 'qty_min')
                                ->where('qty_actual', '!=', 0)
                                ->count();
                          @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART CRITICAL INHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>

                   <!-- Card 6 -->
                   {{-- <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="critical_data2" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-out-alt fa-2x" style="color: #ff0d00;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            $row = DB::table('line_store_stoks')
                                ->where('home_line', 'OUTHOUSE')
                                ->whereColumn('qty_actual', '<=', 'qty_min')
                                ->where('qty_actual', '!=', 0)
                                ->count();
                          @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART CRITICAL OUTHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div> --}}

                   <!-- Card 7 -->
                   <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="data_ta" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-in-alt fa-2x" style="color: #ff0d00;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            // Menghitung jumlah item di mana actual_sheet bernilai NULL atau 0
                            $row = DB::table('line_store_stoks')
                            ->where('home_line', 'INHOUSE')
                                ->where(function ($query) {
                                    $query->whereNull('qty_actual')
                                            ->orWhere('qty_actual', '=', 0);
                                })
                                ->count();
                            @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART TA INHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>

                   <!-- Card 7 -->
                   {{-- <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="data_ta2" class="info-box position-relative" style="cursor: zoom-in;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-sign-out-alt fa-2x" style="color: #ff0d00;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            // Menghitung jumlah item di mana actual_sheet bernilai NULL atau 0
                            $row = DB::table('line_store_stoks')
                            ->where('home_line', 'OUTHOUSE')
                                ->where(function ($query) {
                                    $query->whereNull('qty_actual')
                                            ->orWhere('qty_actual', '=', 0);
                                })
                                ->count();
                            @endphp
                          <p style="font-size: 16px; color: #000000; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART TA OUTHOUSE
                          </p>
                          <h3 style="font-size: 20px; color: #000000; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div> --}}

                  <div class="col-lg-2 col-md-3 col-sm-6">
                    <div id="data_repair" class="info-box text-center p-3" style="cursor: zoom-in; background-color: #343a40; border-radius: 10px;">
                      <!-- Ikon di sudut kanan atas -->
                      <div class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-tools fa-2x" style="color: #00e1ff;"></i>
                      </div>
                      <div class="info-content">
                        <div class="inner">
                            @php
                            $status = DB::table('scan_out_stmps')->value('status');
                            $row = 0;
                            if ($status == 1) {
                                $row = DB::table('scan_out_stmps')
                                    ->where('status', '!=',1 )
                                    ->where('status_2', 2)
                                    ->count();
                            }
                            @endphp
                          <p style="font-size: 16px; color: #ffffff; font-weight: bold; margin-bottom: 5px;">
                            TOTAL PART REPAIR
                          </p>
                          <h3 style="font-size: 20px; color: #ffffff; font-weight: bold;">
                            ( {{ $row }} ) Item Part
                          </h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <!-- Metrics Row -->
            <div class="row mb-4" id="material-section">
                <div class="carousel-container">
                    <button class="carousel-button left" onclick="slideLeft()">‹</button>
                    <div class="carousel-content">
                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model D12 & D14</h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalD12">
                                            <strong>
                                                <p id="totalD12" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                    $modelNames = ['D14N', 'D14N/D12L']; // Daftar nama model
                                                    $row = DB::table('line_store_stoks')
                                                        ->whereIn('home_line', ['INHOUSE', 'OUTHOUSE']) // Perbaikan di sini
                                                        ->whereIn('model', $modelNames)
                                                        ->count();
                                                @endphp

                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>

                                        <strong>
                                            <p id="safeD12" class="status-box-item openText status-text"
                                                style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                                TOTAL SAFE<br>
                                                @php
                                                    $modelNames = ['D14N', 'D14N/D12L']; // Daftar nama model
                                                    $row2 = DB::table('line_store_stoks')
                                                        ->where('home_line', 'INHOUSE')
                                                        ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                        ->whereColumn('qty_actual', '>=', 'qty_min')
                                                        ->count();
                                                @endphp
                                                <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                                </p>
                                        </strong>

                                        <strong>
                                            <p id="criticalD12" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRITICAL<br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                                $modelNames = ['D14N', 'D14N/D12L']; // Daftar nama model
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                         </p>

                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model D26A//D55L/D03B/D74A </h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalD26">
                                            <strong>
                                                <p id="totalD26" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                        $modelNames = ['D26A', 'D26A/D55L/D03B','D55L/D26A/D74A']; // Daftar nama model
                                                        $row = DB::table('line_store_stoks')
                                                            ->where('home_line', 'INHOUSE')
                                                            ->whereIn('model', $modelNames)
                                                            ->count();
                                                    @endphp
                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>

                                        <strong>
                                            <p id="safeD26" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL SAFE <br>
                                            @php
                                           $modelNames = ['D26A', 'D26A/D55L/D03B','D55L/D26A/D74A']; // Daftar nama model
                                            $row2 = DB::table('line_store_stoks')
                                                ->where('home_line', 'INHOUSE')
                                                ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                ->whereColumn('qty_actual', '>=', 'qty_min')
                                                ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                            </p>
                                        </strong>

                                        <strong>
                                            <p id="criticalD26" class="status-box-item openText status-text"
                                           style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRTICAL <br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                                $modelNames = ['D26A', 'D26A/D55L/D03B','D55L/D26A/D74A']; // Daftar nama model
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model D40/D40L/D40G/D72</h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalD40">
                                            <strong>
                                                <p id="totalD40" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                    $modelNames = ['D40G','D40L' ,'D40G/DCWA','D40G/D40L/D72A','D40G/D40L']; // Daftar nama model
                                                    $row = DB::table('line_store_stoks')
                                                        ->where('home_line', 'INHOUSE')
                                                        ->whereIn('model', $modelNames)
                                                        ->count();
                                                @endphp
                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>
                                        <strong>
                                            <p id="safeD40" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL SAFE <br>
                                            @php
                                             $modelNames = ['D40G','D40L' ,'D40G/DCWA','D40G/D40L/D72A','D40G/D40L'];// Daftar nama model
                                             $row2 = DB::table('line_store_stoks')
                                                 ->where('home_line', 'INHOUSE')
                                                 ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                 ->whereColumn('qty_actual', '>=', 'qty_min')
                                                 ->count();
                                             @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                            </p>
                                        </strong>
                                        <strong>
                                            <p id="criticalD40" class="status-box-item openText status-text"
                                           style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRTICAL <br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                                $modelNames = ['D40G','D40L' ,'D40G/DCWA','D40G/D40L/D72A','D40G/D40L']; // Daftar nama model
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model D30</h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalD30">
                                            <strong>
                                                <p id="totalD30" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                    $modelNames = ['D30D','D30']; // Daftar nama model
                                                    $row = DB::table('line_store_stoks')
                                                        ->where('home_line', 'INHOUSE')
                                                        ->whereIn('model', $modelNames)
                                                        ->count();
                                                @endphp
                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>
                                        <strong>
                                            <p id="safeD30" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL SAFE <br>
                                            @php
                                             $modelNames = ['D30D','D30']; // Daftar nama model
                                             $row2 = DB::table('line_store_stoks')
                                                 ->where('home_line', 'INHOUSE')
                                                 ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                 ->whereColumn('qty_actual', '>=', 'qty_min')
                                                 ->count();
                                             @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                            </p>
                                        </strong>
                                        <strong>
                                            <p id="criticalD30" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRTICAL <br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                                $modelNames = ['D30D','D30']; // Daftar nama model
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model D03</h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalD03">
                                            <strong>
                                                <p id="totalD03" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                    $modelNames = ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B']; // Daftar nama model
                                                    $row = DB::table('line_store_stoks')
                                                        ->where('home_line', 'INHOUSE')
                                                        ->whereIn('model', $modelNames)
                                                        ->count();
                                                @endphp
                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>
                                        <strong>
                                            <p id="safeD03" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL SAFE <br>
                                            @php
                                            $modelNames = ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B'];
                                             $row2 = DB::table('line_store_stoks')
                                                 ->where('home_line', 'INHOUSE')
                                                 ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                 ->whereColumn('qty_actual', '>=', 'qty_min')
                                                 ->count();
                                             @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                            </p>
                                        </strong>
                                        <strong>
                                            <p id="criticalD03" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRTICAL <br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                               $modelNames = ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B'];
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-ms-3">
                            <div class="summary-item">
                                <h3>Model KS</h3>
                                <div class="change">
                                    <div class="status-box" style="display: flex; gap: 10px; padding: 5px;">
                                        <div id="totalKS">
                                            <strong>
                                                <p id="totalKS" class="status-box-item openText status-text"
                                                   style="font-size: 13px; margin: 0; cursor: pointer; background:rgba(93, 189, 255, 0.74); padding: 10px; color: black; text-align: center;">
                                                    TOTAL PART <br>
                                                    @php
                                                    $modelNames = ['KS']; // Daftar nama model
                                                    $row = DB::table('line_store_stoks')
                                                        ->where('home_line', 'INHOUSE')
                                                        ->whereIn('model', $modelNames)
                                                        ->count();
                                                @endphp
                                                    <span style="font-size: 16px; font-weight: bold;">{{ $row }}</span>
                                                </p>
                                            </strong>
                                        </div>
                                        <strong>
                                            <p id="safeKS" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer;  background:rgba(0, 255, 82, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL SAFE <br>
                                            @php
                                            $modelNames = ['KS'];
                                             $row2 = DB::table('line_store_stoks')
                                                 ->where('home_line', 'INHOUSE')
                                                 ->whereIn('model', $modelNames) // Gunakan whereIn untuk beberapa model
                                                 ->whereColumn('qty_actual', '>=', 'qty_min')
                                                 ->count();
                                             @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row2 }}</span>
                                            </p>
                                        </strong>
                                        <strong>
                                            <p id="criticalKS" class="status-box-item openText status-text"
                                            style="font-size: 13px; margin: 0; cursor: pointer; background: rgba(255, 0, 0, 0.35); padding: 10px; color: black; text-align: center;">
                                            TOTAL CRTICAL <br>
                                            @php
                                                // Tambahkan model 'D12L' jika ingin mencakup semua varian
                                               $modelNames = ['KS'];
                                                $row3 = DB::table('line_store_stoks')
                                                    ->where('home_line', 'INHOUSE')
                                                    ->whereIn('model', $modelNames) // Gunakan whereIn untuk banyak model
                                                    ->whereColumn('qty_actual', '<', 'qty_min') // qty_actual lebih kecil dari qty_min
                                                    ->count();
                                            @endphp
                                            <span style="font-size: 16px; font-weight: bold;">{{ $row3 }}</span>
                                            </p>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button class="carousel-button right" onclick="slideRight()">›</button>
                </div>
                <button type="button" class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 shadow-sm"
                style="border-radius: 8px; font-weight: 600; font-size: 16px;"
                data-toggle="modal" data-target="#exportModal">
            <i class="fas fa-file-excel"></i> Export ke Excel
        </button>

            </div>

            <div class="table-container table-striped">
                <div style="background-color: #f2f3f5d7; color:black" class="table-responsive">
                    <table id="incomingTable" class="table table-hover table-bordered" style="table-layout: fixed;">
                        <thead style= "background: linear-gradient(to top right, #1a2640 0%, #006699 44%); color: #ffffff">
                           <tr>
                                 <th style="width: 10px; text-align:center">NO</th>
                                 <th style="width: 50px; text-align:center">Supplier</th>
                                 <th style="width: 50px; text-align:center">Job No</th>
                                 {{-- <th style="width: 50px; text-align:center">Part No(G5)</th> --}}
                                 <th style="width: 50px; text-align:center">Part No</th>
                                 <th style="width: 100px; text-align:center">Part Name</th>
                                 <th style="width: 100px; text-align:center">Model</th>
                                 <th style="width: 50px; text-align:center">Category</th>
                                 <th style="width: 50px; text-align:center">Qty Minimal</th>
                                 <th style="width: 50px; text-align:center">Qty Actual</th>
                                 <th style="width: 50px; text-align:center">Detail</th>
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
                    <div style="  background: linear-gradient(to bottom right, #003366 0%, #006699 100%); color:#ffffff" class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export Data Stok Part INHOUSE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="exportForm" action="{{ route('exportLineStore.export') }}" method="POST">
                          @csrf <!-- CSRF Token -->
                          <div class="form-group">
                            <label for="filterLine">Select Filter</label>
                            <select id="filterLine" name="filter" class="form-control">
                                <option value="">-Pilih-</option>
                                <option value="ALL">ALL</option>
                                <option value="critical">CRITICAL</option>
                                <option value="safe">SAFE</option>
                                <option value="ta">TA</option>
                            </select>
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


        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header" style="background: linear-gradient(to bottom right, #003366, #006699); color: #ffffff;">
                        <h5 class="modal-title" id="detailModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle mb-0">
                                <thead class="table-gray text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Uniq No</th>
                                        <th scope="col">Job No</th>
                                        <th scope="col">Part No</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Ng Stamping</th>
                                        <th scope="col">Ng Repair</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Kode Material</th>
                                        <th scope="col">Scan By</th>
                                        <th scope="col">Date Scan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">IN LS</th>
                                        <th scope="col">Status Proses</th>
                                        <th scope="col">Detail Out</th>
                                        <th scope="col">Detail Track</th>
                                    </tr>
                                </thead>
                                <tbody id="detailModalBody" class="text-center">
                                    <!-- Detail content will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom">
                        <button type="button" class="close; btn btn-secondary " data-dismiss="modal"aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
<!-- Detail Out Modal -->
<div class="modal fade" id="detailOutModal" tabindex="-1" aria-labelledby="detailOutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailOutModalLabel">Detail Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Uniq No</th>
                                <th>Job No</th>
                                <th>Part No</th>
                                <th>Model</th>
                                <th>Qty</th>
                                <th>Additional Qty</th>
                                <th>Time Out</th>
                            </tr>
                        </thead>
                        <tbody id="detailOutModalBody">
                            <tr>
                                <td colspan="9" class="text-center">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



  <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to bottom, #006600 0%, #00cc99 100%); color:#ffffff;">
                <h5 class="modal-title" id="trackModalLabel">Tracking Planner</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="bg-light text-center">
                            <tr class="table-bordered">
                                <th class="border">No</th>
                                <th class="border">Tanggal</th>
                                <th class="border">Part No</th>
                                <th class="border">Model</th>
                                <th class="border">Mesin</th>
                                <th class="border">Qty Plan</th>
                                <th class="border">Spek</th>
                                <th class="border">Dibuat</th>
                                <th class="border">Jam</th>
                            </tr>
                        </thead>
                        <tbody id="trackModalBody">
                            <tr>
                                <td colspan="9" class="text-center">No tracking data available.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom">
                <button type="button" class="close; btn btn-secondary " data-dismiss="modal"aria-label="Close">Close</button>
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

            $(document).on('click', '.detail-btn', function() {
                const partNo2 = $(this).data('part');
                const customer = $(this).data('customer');
                const jobNo = $(this).data('job');

                $('#detailModalLabel').text(`Detail for ${partNo2} - ${jobNo}`);
                $('#detailModalBody').html('<tr><td colspan="6">Loading data...</td></tr>');

                $.ajax({
                    url: '{{ route('getScanOutStmps') }}',
                    method: 'GET',
                    data: {
                        part_no2: partNo2
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            let detailHtml = '';
                            response.data.forEach((item, index) => {
                                detailHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.uniqNo}</td>
                                    <td>${item.job_no}</td>
                                    <td>${item.part_no2}</td>
                                    <td>${item.model}</td>
                                    <td>
                                        <span class="badge bg-success" style="font-size: 1.0rem;">${item.qty_act}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger" style="font-size: 1.0rem;">${item.qty_ng}</span>
                                    </td>
                                     <td>
                                        <span class="badge bg-danger" style="font-size: 1.0rem;">${item.ng_repair || '0'}</span>
                                    </td>
                                    <td>${item.date_plan}</td>
                                    <td>${item.kode_material}</td>
                                    <td>${item.createdby || '-'}</td>
                                    <td>${item.date_scan || '-'}</td>
                                    <td>
                                        ${
                                            item.status === 3
                                            ? '<span style="color: green; font-weight:bold;">Received</span>'
                                            : item.status === 2
                                            ? '<span style="color: red; font-weight: bold;">Repair</span>'
                                            : item.status === 1
                                            ? '<span style="color: blue; font-weight: bold;">Transit</span>'
                                            : '<span>-</span>'
                                        }
                                    </td>
                                    <td>${item.scan_in_ls || '-'}</td>
                                     <td>
                                        ${
                                            item.status_2 === 2
                                            ? '<span style="color: red; font-weight: bold;">Repair</span>'
                                            : item.status_2 === 1
                                            ? '<span style="color: green; font-weight: bold;">Stamping</span>'
                                            : (item.status_2 || '-')
                                        }
                                    </td>

                                        <td>
                                            <button class="btn btn-sm btn-info detail-row-btn"
                                                    data-part="${item.part_no2}"
                                                    data-uniq="${item.uniqNo}">
                                                Detail Out
                                            </button>
                                        </td>


                                    <td>
                                        <button class="btn btn-sm btn-success detail-row-btn2"
                                                data-part="${item.part_no2}"
                                                data-dateplan="${item.date_plan}">
                                            Track
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#detailModalBody').html(detailHtml);
                        } else {
                            $('#detailModalBody').html(
                                '<tr><td colspan="13">No data found for this Part No.</td></tr>');
                        }
                    },
                    error: function() {
                        $('#detailModalBody').html(
                            '<tr><td colspan="13">Error loading data. Please try again later.</td></tr>');
                    }
                });

                $('#detailModal').modal('show');
            });


            // Ini modal untuk out detail line Store
            $(document).on('click', '.detail-row-btn', function() {
    const partNo2 = $(this).data('part');
    const uniqNo = $(this).data('uniq'); // <-- pindahkan ke sini

    $('#detailOutModalLabel').text(`Detail Out for ${partNo2}`);
    $('#detailOutModalBody').html('<tr><td colspan="6">Loading data...</td></tr>');

    $.ajax({
        url: '{{ route('getScanPartBps') }}',
        method: 'GET',
        data: {
            part_no2: partNo2,
            uniqNo: uniqNo // <-- tambahkan uniqNo ke parameter
        },
        success: function(response) {
            if (response.data.length > 0) {
                let detailHtml = '';
                response.data.forEach((item, index) => {
                    detailHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.uniqNo}</td>
                            <td>${item.job_no}</td>
                            <td>${item.part_no2}</td>
                            <td>${item.model}</td>
                            <td>${item.qty}</td>
                            <td><span class="badge bg-danger" style="font-size: 1.0rem">${item.additional_qty}</span></td>
                            <td>${item.date_scan}</td>
                        </tr>
                    `;
                });
                $('#detailOutModalBody').html(detailHtml);
            } else {
                $('#detailOutModalBody').html(
                    '<tr><td colspan="9">No data found for this Part No and Uniq No.</td></tr>'
                );
            }
        },
        error: function() {
            $('#detailOutModalBody').html(
                '<tr><td colspan="9">Error loading data. Please try again later.</td></tr>'
            );
        }
    });

    $('#detailOutModal').modal('show');
});

            $(document).on('click', '.detail-row-btn2', function() {
                const partNo2 = $(this).data('part');
                const datePlan = $(this).data('dateplan');

                $('#trackModalLabel').text(`Tracking Planner ${partNo2} - ${datePlan}`);
                $('#trackModalBody').html('<tr><td colspan="6">Loading tracking data...</td></tr>');

                $.ajax({
                    url: '{{ route('getPlanningLineB3') }}',
                    method: 'GET',
                    data: {
                        part_no2: partNo2,
                        date_plan: datePlan
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            let trackHtml = '';
                            response.data.forEach((item, index) => {
                                trackHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.date_plan || '-'}</td>
                            <td>${item.part_no2 || '-'}</td>
                            <td>${item.model_id || '-'}</td>
                            <td>${item.mesin || '-'}</td>
                            <td>${item.qty_plan || '-'}</td>
                            <td>${item.rm_spek || '-'}</td>
                            <td>${item.createdby || '-'}</td>
                            <td>${item.created_at || '-'}</td>

                        </tr>
                    `;
                            });
                            $('#trackModalBody').html(trackHtml);
                        } else {
                            $('#trackModalBody').html(
                                '<tr><td colspan="7">No tracking data found for this Part No.</td></tr>'
                            );
                        }
                    },
                    error: function() {
                        $('#trackModalBody').html(
                            '<tr><td colspan="7">Error loading tracking data. Please try again later.</td></tr>'
                        );
                    }
                });

                $('#trackModal').modal('show');
            });

            //  BARIS UNTUK CARD ATAS

            // INHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let total_part = document.getElementById("total_part");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (total_part) {
                    total_part.addEventListener("click", function() {
                        fetchTotalPart();
                    });
                } else {
                    console.error("Error: Element with ID 'total_part' not found!");
                }
            });
            function fetchTotalPart() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,

                        ajax: "{{ route('getTotalPartInhouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 191, 245, 0.43)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // OUTHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let total_part2 = document.getElementById("total_part2");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (total_part2) {
                    total_part2.addEventListener("click", function() {
                        fetchTotalPart2();
                    });
                } else {
                    console.error("Error: Element with ID 'total_part2' not found!");
                }
            });

            function fetchTotalPart2() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getTotalPartOuthouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 191, 245, 0.43)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // INHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let safe_data = document.getElementById("safe_data");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (safe_data) {
                    safe_data.addEventListener("click", function() {
                        fetchSafePart();
                    });
                } else {
                    console.error("Error: Element with ID 'safe_data' not found!");
                }
            });

            function fetchSafePart() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getSafePartInhouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(0, 255, 0, 0.3)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // OUTHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let safe_data2 = document.getElementById("safe_data2");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (safe_data2) {
                    safe_data2.addEventListener("click", function() {
                        fetchSafePart2();
                    });
                } else {
                    console.error("Error: Element with ID 'safe_data2' not found!");
                }
            });

            function fetchSafePart2() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getSafePartOuthouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(0, 255, 0, 0.3)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // INHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let critical_data = document.getElementById("critical_data");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (critical_data) {
                    critical_data.addEventListener("click", function() {
                        fetchCriticalPart();
                    });
                } else {
                    console.error("Error: Element with ID 'critical_data' not found!");
                }
            });

            function fetchCriticalPart() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getCrticalPartInhouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
    return `
        <div class="d-flex" style="gap: 5px;">
            <button class="btn btn-primary btn-sm detail-btn"
                data-part="${row.part_no2}"
                data-job="${row.job_no}">
                Detail
            </button>
            <button class="btn btn-success btn-sm action-btn"
                data-id="${row.id}">
                Export
            </button>
        </div>
    `;
}

                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // OUTHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let critical_data2 = document.getElementById("critical_data2");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (critical_data2) {
                    critical_data2.addEventListener("click", function() {
                        fetchCriticalPart2();
                    });
                } else {
                    console.error("Error: Element with ID 'critical_data' not found!");
                }
            });

            function fetchCriticalPart2() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getCrticalOuthouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-"
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // INHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let data_ta = document.getElementById("data_ta");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (data_ta) {
                    data_ta.addEventListener("click", function() {
                        fetchTaPart();
                    });
                } else {
                    console.error("Error: Element with ID 'data_ta' not found!");
                }
            });

            function fetchTaPart() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 25,
                        ajax: "{{ route('getTaPartInhouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            // OUTHOUSE
            document.addEventListener("DOMContentLoaded", function() {
                let data_ta2 = document.getElementById("data_ta2");
                let tableContainer = $(".table-container"); // Gunakan jQuery untuk kontrol animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                if (data_ta2) {
                    data_ta2.addEventListener("click", function() {
                        fetchTaPart2();
                    });
                } else {
                    console.error("Error: Element with ID 'data_ta' not found!");
                }
            });

            function fetchTaPart2() {
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk animasi

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Sembunyikan tabel sebelum di-refresh
                tableContainer.fadeOut(200, function() {
                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 25,
                        ajax: "{{ route('getTaPartOuthouse') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Setelah tabel selesai dimuat, munculkan dengan efek fade-in
                            tableContainer.fadeIn(400);
                        }
                    });
                });
            }

            $(document).on("click", ".qty-clickable", function() {
                $("#qtyModal").modal("show");
            });



            // Model D12 & D14
            document.addEventListener("DOMContentLoaded", function() {
                let totalD12 = document.getElementById("totalD12"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalD12) {
                    totalD12.addEventListener("click", function() {
                        fetchMd12Data();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD12Container' not found!");
                }
             });

             function fetchMd12Data() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelD12') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeD12 = document.getElementById("safeD12"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeD12) {
                    safeD12.addEventListener("click", function() {
                        fetchMd12Data2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeD12Container' not found!");
                }
             });

             function fetchMd12Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD12') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             function fetchMd12Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD12') }}", // hanya berfungsi dalam blade
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalD12 = document.getElementById("criticalD12");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalD12) {
                    criticalD12.addEventListener("click", function() {
                        fetchMd12Data3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD12' not found!");
                }
             });

             function fetchMd12Data3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelD12') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }
             // Model D26
            document.addEventListener("DOMContentLoaded", function() {
                let totalD26 = document.getElementById("totalD26"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalD26) {
                    totalD26.addEventListener("click", function() {
                        fetchMd26Data();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD26Container' not found!");
                }
             });

             function fetchMd26Data() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelD26') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeD26 = document.getElementById("safeD26"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeD26) {
                    safeD26.addEventListener("click", function() {
                        fetchMd26Data2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeD26Container' not found!");
                }
             });

             function fetchMd26Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD26') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                    "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalD26 = document.getElementById("criticalD26");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalD26) {
                    criticalD26.addEventListener("click", function() {
                        fetchMd26Data3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD26' not found!");
                }
             });

             function fetchMd26Data3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelD26') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }
            // Model D40
            document.addEventListener("DOMContentLoaded", function() {
                let totalD40 = document.getElementById("totalD40"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalD40) {
                    totalD40.addEventListener("click", function() {
                        fetchMd40Data();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD40Container' not found!");
                }
             });

             function fetchMd40Data() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelD40') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeD40 = document.getElementById("safeD40"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeD40) {
                    safeD40.addEventListener("click", function() {
                        fetchMd40Data2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeD40Container' not found!");
                }
             });

             function fetchMd40Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD40') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                    "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalD40 = document.getElementById("criticalD40");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalD40) {
                    criticalD40.addEventListener("click", function() {
                        fetchMd40Data3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD40' not found!");
                }
             });

             function fetchMd40Data3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelD40') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }
            // Model D30
            document.addEventListener("DOMContentLoaded", function() {
                let totalD30 = document.getElementById("totalD30"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalD30) {
                    totalD30.addEventListener("click", function() {
                        fetchMd30Data();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD30Container' not found!");
                }
             });

             function fetchMd30Data() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelD30') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeD30 = document.getElementById("safeD30"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeD30) {
                    safeD30.addEventListener("click", function() {
                        fetchMd30Data2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeD40Container' not found!");
                }
             });

             function fetchMd30Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD30') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                    "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalD30 = document.getElementById("criticalD30");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalD30) {
                    criticalD30.addEventListener("click", function() {
                        fetchMd40Data3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD40' not found!");
                }
             });

             function fetchMd30Data3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelD30') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }

               // Model D30
               document.addEventListener("DOMContentLoaded", function() {
                let totalD03 = document.getElementById("totalD03"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalD03) {
                    totalD03.addEventListener("click", function() {
                        fetchMd03Data();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD30Container' not found!");
                }
             });

             function fetchMd03Data() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelD03') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeD03 = document.getElementById("safeD03"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeD03) {
                    safeD03.addEventListener("click", function() {
                        fetchMd03Data2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeD03Container' not found!");
                }
             });

             function fetchMd03Data2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelD03') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                    "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalD03 = document.getElementById("criticalD03");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalD03) {
                    criticalD03.addEventListener("click", function() {
                        fetchMd03Data3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD40' not found!");
                }
             });

             function fetchMd03Data3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelD03') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }

               // Model KS
               document.addEventListener("DOMContentLoaded", function() {
                let totalKS = document.getElementById("totalKS"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (totalKS) {
                    totalKS.addEventListener("click", function() {
                        fetchMkSData();
                    });
                } else {
                    console.error("Error: Element with ID 'totalD30Container' not found!");
                }
             });

             function fetchMkSData() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Show loading spinner
                    $('#loadingSpinner')
                        .show(); // Make sure to have a div or element with ID 'loadingSpinner' in your HTML

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('getModelKS') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                        "rgba(39, 191, 245, 0.43)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-sm detail-btn"
                    data-part="${row.part_no2}"
                    data-job="${row.job_no}">Detail</button>`;
                                }
                            }


                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Hide loading spinner and show the table
                            $('#loadingSpinner').hide(); // Hide loading spinner
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });

             }

             document.addEventListener("DOMContentLoaded", function() {
                let safeKS = document.getElementById("safeKS"); // Perbaiki ID
                let tableContainer = $(".table-container");

                // Sembunyikan tabel awalnya
                tableContainer.hide();

                if (safeKS) {
                    safeKS.addEventListener("click", function() {
                        fetchMkSData2();
                    });
                } else {
                    console.error("Error: Element with ID 'safeKSContainer' not found!");
                }
             });

             function fetchMkSData2() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                // Efek slow fade-out sebelum memuat data baru
                tableContainer.fadeOut(500, function() { // 500ms untuk efek lambat

                    // Inisialisasi ulang DataTable
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get2ModelKS') }}", // Ambil data dari controller
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            }, // Auto Numbering
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)")
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color",
                                    "rgba(0, 255, 0, 0.3)"); // Hijau transparan
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                                }
                            }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Memindahkan kolom search ke kanan
                        initComplete: function() {
                            // Efek slow fade-in setelah data selesai dimuat
                            tableContainer.fadeIn(800); // 800ms untuk efek fade-in lebih lambat
                        }
                    });
                });
             }

             document.addEventListener("DOMContentLoaded", function() {
                let criticalKS = document.getElementById("criticalKS");
                let tableContainer = $(".table-container"); // Ambil elemen tabel untuk efek animasi

                // Sembunyikan tabel saat pertama kali dimuat
                tableContainer.hide();

                // Pastikan elemen ditemukan sebelum menambahkan event listener
                if (criticalKS) {
                    criticalKS.addEventListener("click", function() {
                        fetchMkSData3();
                    });
                } else {
                    console.error("Error: Element with ID 'criticalD40' not found!");
                }
             });

             function fetchMkSData3() {
                let tableContainer = $(".table-container");

                // Hapus DataTable lama jika sudah ada
                if ($.fn.DataTable.isDataTable("#incomingTable")) {
                    $("#incomingTable").DataTable().destroy();
                }

                tableContainer.fadeOut(500, function() {
                    // Periksa lagi tabel sebelum destroy
                    if ($("#incomingTable").length > 0 && $.fn.DataTable.isDataTable("#incomingTable")) {
                        $("#incomingTable").DataTable().destroy();
                    }

                    // Load data baru
                    $("#incomingTable").DataTable({
                        processing: true,
                        serverSide: true,
                        autoWidth: false,
                        responsive: false,
                        searching: true,
                        bLengthChange: true,
                        destroy: true,
                        pageLength: 10,
                        ajax: "{{ route('get3ModelKS') }}",
                        columns: [{
                                data: "DT_RowIndex",
                                name: "DT_RowIndex"
                            },
                            {
                                data: "customer",
                                name: "customer",
                                defaultContent: "-"
                            },
                            {
                                data: "job_no",
                                name: "job_no",
                                defaultContent: "-"
                            },
                            // {
                            //     data: "part_no",
                            //     name: "part_no",
                            //     defaultContent: "-"
                            // },
                            {
                                data: "part_no2",
                                name: "part_no2",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(39, 208, 245, 0.17)");
                                }
                            },
                            {
                                data: "part_name",
                                name: "part_name",
                                defaultContent: "-"
                            },
                            {
                                data: "model",
                                name: "model",
                                defaultContent: "-"
                            },
                            {
                                data: "home_line",
                                name: "home_line",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_min",
                                name: "qty_min",
                                defaultContent: "-"
                            },
                            {
                                data: "qty_actual",
                                name: "qty_actual",
                                defaultContent: "-",
                                createdCell: function(td, cellData) {
                                    $(td).css("background-color", "rgba(255, 0, 0, 0.3)");
                                }
                            },
                            {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<button class="btn btn-primary btn-sm detail-btn"
                                data-part="${row.part_no2}"
                                data-job="${row.job_no}">Detail</button>`;
                            }
                        }
                        ],
                        dom: '<"top"lf>rt<"bottom"ip><"clear">',
                        initComplete: function() {
                            // Tampilkan tabel setelah selesai memuat data
                            tableContainer.fadeIn(800);
                        }
                    });
                });

            }
        </script>
@endpush
