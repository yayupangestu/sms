<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIAP | {{ $title }}</title>
        <link rel="icon" href="{{ asset('dist/img/bar-chart.png') }}" type="image/x-icon">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        {{-- sweetalert2 --}}
        <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
        @stack('stylesheets')
    </head>
</head>
<style>
  .stamping-card {
      background: #cccccd47;
      border-radius: 14px;
      border: 2px solid #000000;
      padding: 10px 10px;
      margin-bottom: 12px;
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
  }

  .stamping-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 18px;
  }

  .stamping-title {
      font-size: 18px;
      font-weight: 700;
      color: #ffffff;
  }

  .stamping-alert {
      font-size: 13px;
      font-weight: 600;
      color: #4de73c;
      display: flex;
      align-items: center;
      gap: 6px;
  }

  .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px 10px;
  }

  .info-item {
      display: flex;
      align-items: center;
      gap: 10px;
  }

  .info-icon {
      font-size: 24px;
      color: #777;
  }

  .info-data {
      display: flex;
      flex-direction: column;
      line-height: 1.1;
  }

  .info-value {
      font-size: 16px;
      font-weight: 700;
      color: #ffffff;
  }

  .info-label {
      font-size: 13px;
      color: #ffffff;
  }

  /* ANDON BULAT */
  .andon {
      margin-top: 16px;
      display: flex;
      justify-content: center;
  }

  .andon-circle {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      border: 3px solid #ccc;
  }

  @keyframes blink {
      0% {
          opacity: 1;
      }

      50% {
          opacity: 0.2;
      }

      100% {
          opacity: 1;
      }
  }

  .dies-box {
  width: 100%;
  /* background: #19ef39;
  border: 1px solid #74e467; */
  padding: 10px 15px;
  margin-top: 12px;
  text-align: center;
  color: #ffffff;
  font-weight: 700;
  border-radius: 8px;
  font-size: 16px;
}

.box-run {
    background: #28a745;
    color: white;
}

.box-standby {
    background: #6c757d;
    color: white;
}


.modern-card {
    border-radius: 14px;
    background: #cccccd72;
    padding: 12px;
    min-height: 95px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: 0.2s;
    border: 1px solid #000000;
}

.modern-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.info-box-icon {
    border-radius: 12px !important;
    width: 55px !important;
    height: 55px !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.info-box-text.title {
    font-size: 13px;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #ffffff;
}

.info-box-number.value {
    font-size: 22px;
    font-weight: 700;
    color: #ffffff;
    margin-top: 2px;
}


</style>
<body style="background: linear-gradient(to bottom right, #003366 72%, #006699 100%);">
  <div class="container-fluid">
    <div style="background: linear-gradient(to bottom, #003366 25%, #000000 78%);"
        class="row mb-4 align-items-center">
        <div class="col-md-6" style="position: relative;">
            <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 8px;">
                <img src="dist/img/adw3.png" class="brand-image2" style="width: 200px; height: auto;">
            </div>
            <strong>
                <h3 style="color: white; display: inline;">Dashboard Informasi Stamping</h3>
            </strong>
        </div>
        <div class="col-md-6 text-right">
            <div
                style="display: inline-block; inline-block; padding: 5px; border-radius: 8px; background: linear-gradient(to bottom, #003366 25%, #006699 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                <strong>
                    <h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="dateTime" class="text-right">
                    </h3>
                </strong>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-3">
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box modern-card">
                <span class="info-box-icon bg-primary shadow-sm"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text title">TOTAL DIES WITH ISSUES</span>
                    <span class="info-box-number value">123</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box modern-card">
                <span class="info-box-icon bg-danger shadow-sm"><i class="fas fa-bolt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text title">TOTAL STROKE</span>
                    <span class="info-box-number value">41,410</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box modern-card">
                <span class="info-box-icon bg-success shadow-sm"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text title">TOTAL PROBLEM TIME</span>
                    <span class="info-box-number value">760</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box modern-card">
                <span class="info-box-icon bg-warning shadow-sm"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text title">MEMBERS</span>
                    <span class="info-box-number value">2,000</span>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container-fluid">
    <div class="row g-2">
  
        <!-- CARD 1 - B1 -->
        <div class="col-lg-3 col-md-5">
            <div class="stamping-card">
                <div class="stamping-header">
                    <div class="stamping-title">Stamping Machine B1</div>
                    <div class="stamping-alert alert-blink">
                        <i class="fas fa-exclamation-triangle" style="font-size:26px;"></i>
                        <span style="font-size:18px;">Alert</span>
                    </div>
                </div>
  
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $lineB1->part_no ?? '-' }}</span>
                            <span class="info-label">PART NUMBER</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $totalProdB1 ?? 0 }}</span>
                            <span class="info-label">JUMLAH STROKE</span>
                        </div>
                    </div>
                </div>
  
                <div class="dies-box {{ ($lineB1 && $lineB1->status_proses == 2) ? 'box-run' : 'box-standby' }}">
                    {{ ($lineB1 && $lineB1->status_proses == 2) ? 'RUNNING' : 'STANDBY' }}
                </div>           
                
            </div>
        </div>
        <!-- CARD 2 - B2 -->
        <div class="col-lg-3 col-md-5">
            <div class="stamping-card">
                <div class="stamping-header">
                    <div class="stamping-title">Stamping Machine B2</div>
                    <div class="stamping-alert alert-blink">
                        <i class="fas fa-exclamation-triangle" style="font-size:26px;"></i>
                        <span style="font-size:18px;">Alert</span>
                    </div>
                </div>
  
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $lineB2->part_no ?? '-' }}</span>
                            <span class="info-label">PART NUMBER</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $totalProdB2 ?? 0 }}</span>
                            <span class="info-label">JUMLAH STROKE</span>
                        </div>
                    </div>
                </div>
  
                <div class="dies-box {{ ($lineB2 && $lineB2->status_proses == 2) ? 'box-run' : 'box-standby' }}">
                    {{ ($lineB2 && $lineB2->status_proses == 2) ? 'RUNNING' : 'STANDBY' }}
                </div> 
            </div>
        </div>
        <!-- CARD 3 - B3 -->
        <div class="col-lg-3 col-md-5">
            <div class="stamping-card">
                <div class="stamping-header">
                    <div class="stamping-title">Stamping Machine B3</div>
                    <div class="stamping-alert alert-blink">
                        <i class="fas fa-exclamation-triangle" style="font-size:26px;"></i>
                        <span style="font-size:18px;">Alert</span>
                    </div>
                </div>
  
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $lineB3->part_no ?? '-' }}</span>
                            <span class="info-label">PART NUMBER</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $totalProdB3 ?? 0 }}</span>
                            <span class="info-label">JUMLAH STROKE</span>
                        </div>
                    </div>
                </div>
  
                <div class="dies-box {{ ($lineB3 && $lineB3->status_proses == 2) ? 'box-run' : 'box-standby' }}">
                    {{ ($lineB3 && $lineB3->status_proses == 2) ? 'RUNNING' : 'STANDBY' }}
                </div>
                
                
            </div>
        </div>
        <!-- CARD 4 - C1 -->
        <div class="col-lg-3 col-md-5">
            <div class="stamping-card">
                <div class="stamping-header">
                    <div class="stamping-title">Stamping Machine C1</div>
                    <div class="stamping-alert alert-blink">
                        <i class="fas fa-exclamation-triangle" style="font-size:26px;"></i>
                        <span style="font-size:18px;">Alert</span>
                    </div>
                </div>
  
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $lineC1->part_no ?? '-' }}</span>
                            <span class="info-label">PART NUMBER</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $totalProdC1 ?? 0 }}</span>
                            <span class="info-label">JUMLAH STROKE</span>
                        </div>
                    </div>
                </div>
  
                <div class="dies-box {{ ($lineC1 && $lineC1->status_proses == 2) ? 'box-run' : 'box-standby' }}">
                    {{ ($lineC1 && $lineC1->status_proses == 2) ? 'RUNNING' : 'STANDBY' }}
                </div> 
            </div>
        </div>
        <div class="w-100"></div>

        <!-- CARD 5 - C2 -->
        <div class="col-lg-3 col-md-5">
            <div class="stamping-card">
                <div class="stamping-header">
                    <div class="stamping-title">Stamping Machine C2</div>
                    <div class="stamping-alert alert-blink">
                        <i class="fas fa-exclamation-triangle" style="font-size:26px;"></i>
                        <span style="font-size:18px;">Alert</span>
                    </div>
                </div>
  
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $lineC2->part_no ?? '-' }}</span>
                            <span class="info-label">PART NUMBER</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-data">
                            <span class="info-value">{{ $totalProdC2 ?? 0 }}</span>
                            <span class="info-label">JUMLAH STROKE</span>
                        </div>
                    </div>
                </div>
  
                <div class="dies-box {{ ($lineC2 && $lineC2->status_proses == 2) ? 'box-run' : 'box-standby' }}">
                    {{ ($lineC2 && $lineC2->status_proses == 2) ? 'RUNNING' : 'STANDBY' }}
                </div> 
            </div>
        </div>
  
    </div>
  </div>
  
    </body>

    <script>
         function updateDateTime() {
            const now = new Date();

            // Hari dalam bahasa Indonesia
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const dayName = days[now.getDay()];

            // Format jam, menit, dan detik
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const time = `${hours}:${minutes}:${seconds}`;

            // Format tanggal
            const day = now.getDate().toString().padStart(2, '0');
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const year = now.getFullYear();
            const date = `${day}-${month}-${year}`;

            // Gabungkan hari, tanggal, dan waktu
            const dateTimeString = `${dayName}, ${date} ${time}`;

            document.getElementById("dateTime").textContent = dateTimeString;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</html>
