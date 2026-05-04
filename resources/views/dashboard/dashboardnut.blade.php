@extends('layouts.app')

@section('content')
    <style>
        .custom-dashboard {
            /* background: linear-gradient(to bottom right, #006699 0%, #003366 100%); */
            background: #081028;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }


        /* Updated dashboard.css */

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .card {
            background: #0b1e54;
            color: white;
            padding: 10px;
            border-radius: 4px;
            width: calc(20% - 10px);
            /* 5 kartu per baris */
            min-width: 150px;
            /* Pastikan tidak terlalu kecil */
            text-align: center;
            font-size: 10px;
        }

        .card-title {
            font-size: 12px;
            margin-bottom: 2px;
            background-color: #1e5fa057;
            /* Warna lebih solid */
            color: white;
            /* Kontras dengan background */
            padding: 6px 12px;
            /* Tambah padding supaya lebih terlihat */
            border-radius: 5px;
            /* Buat sudut membulat */
            font-weight: bold;
            /* Buat teks lebih tegas */
            box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
            /* Tambah efek timbul */
            display: flex;
            /* Mengatur posisi ikon dan teks */
            justify-content: space-between;
            /* Memisahkan teks dan ikon */
            align-items: center;
            /* Posisikan ikon sejajar dengan teks */
            width: 100%;
            /* Agar memenuhi lebar elemen */
        }

        .card-value {
            font-size: 10px;
            font-weight: bold;
            background-color: #2c3e50
        }

        .sub-table {
            width: 100%;
            margin-top: 3px;
            font-size: 10px;
            border-collapse: collapse;
        }
        

        .sub-table td {
            padding: 4px;
            border: 1px solid #fff;
        }

        .sub-table .separator td {
            border: none;
            height: 2px;
            background: rgba(255, 255, 255, 0.2);
        }

        .up {
            color: green;
        }

        .down {
            color: red;
        }

        .chart-wrapper {
            width: 100%;
            overflow-x: auto;
            /* Aktifkan scroll horizontal */
            padding-bottom: 10px;
            /* Ruang ekstra untuk scroll */
        }

        .chart-container {
            min-width: 500px;
            /* Pastikan grafik tidak mengecil terlalu banyak */
            height: 300px;
            /* Perbesar tinggi agar lebih jelas */
            padding: 8px;
            background: #0b1e54;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-header {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }


        @keyframes blinkGreen {
            0% {
                background-color: #28a745;
                color: white;
            }

            /* Hijau */
            50% {
                background-color: transparent;
                color: rgb(255, 255, 255);
            }

            /* Normal */
            100% {
                background-color: #28a745;
                color: white;
            }

            /* Hijau lagi */
        }

        .blink-green {
            animation: blinkGreen 2s infinite;
            /* Animasi berkedip setiap 1 detik */
        }

        @keyframes blinkRed {
            0% {
                background-color: #b235358f;
                color: white;
            }

            /* Merah */
            50% {
                background-color: transparent;
                color: rgb(255, 255, 255);
            }

            /* Hilang */
            100% {
                background-color: #b235358f;
                color: white;
            }

            /* Merah lagi */
        }

        .blink-red {
            animation: blinkRed 3s infinite;
            /* Animasi berkedip */
        }

        .sub-table2 {
            width: 100%;
            margin-top: 3px;
            font-size: 10px;
            border-collapse: collapse;
        }
        

        .sub-table2 td {
            padding: 4px;
            border: 1px solid #fff;
        }

        
        
    </style>

    <div class="container-fluid py-4 custom-dashboard">
        <!-- Top Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div style="background: linear-gradient(to bottom, #4c6783, #444647 78%);" class="row mb-4 align-items-center">
                  <div class="col-md-6" style="position: relative;">
                    <div style="background-color: #ffffff; display: inline-block; padding: 5px; border-radius: 4px;">
                        <img src="dist/img/adw3.png" class="brand-image" style="width: 200px; height: auto;">
                    </div>
                    <strong><h3 style="color: white; display: inline;">Dashboard Monitoring  LINE SSW</h3></strong>
                </div>
                <div class="col-md-6 text-right">
                  <div style="display: inline-block; inline-block; padding: 4px; border-radius: 8px; background: linear-gradient(to bottom, #4c6783, #2c3e50 78%); border-radius: 6px; clip-path: polygon(5% 0, 100% 0, 100% 100%, 0% 100%);">
                      <strong><h3 style="color: #ffffff; margin: 0; padding-left: 10px;" id="dateTime" class="text-right"></h3></strong>
                  </div>
              </div>
                </div>
              </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- Cards Section -->
                <div class="col-md-7">
                    <div class="cards-container d-flex flex-wrap">
                        <!-- Card Elements -->
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <p class="card-title">
                                INFORMASI RAK SSW 01 <i style="color:#22ff00; font-size:16px" class="fa-solid fa-circle"></i>
                            </p>
                            <table class="sub-table">
                                <thead>
                                    <tr style="background-color: black; color: white;">
                                        <th>RAK / PART</th>
                                        <th>Qty</th>
                                        <th>Use</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>RAK 1 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>RAK 2 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-green">
                                        <td>RAK 3 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                    <tr class="separator">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="blink-red">
                                        <td>RAK 4 <br>(7687-9000)</td>
                                        <td>800</td>
                                        <td>200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
        
                <!-- Chart Section -->
                <div class="col-md-5">        
                        <!-- Wrapper untuk dua tabel berdampingan -->
                        <div class="container mt-3">
                            <h4 style="background-color: #fff" class="text-center">INFORMASI SUPPLY</h4>
                            <div class="d-flex flex-wrap justify-content-between" style="gap: 20px;">
                                <!-- Tabel pertama -->
                                
                                <div class="table-responsive" style="width: 100%; max-width: 48%;">
                                   
                                    <table class="table table-bordered sub-table2" style="border-radius: 8px; overflow: hidden;">
                                        <thead>
                                            <tr style="background-color: #086433; color: white; font-size: 10px; text-align: center;">
                                                <th>PART</th>
                                                <th>NUT</th>
                                                <th>Qty</th>
                                                <th>STATUS</th>
                                                <th>PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody style="background-color:#2d3134; color:white; font-size: 13px; text-align: center;">
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>OUT</td>
                                                <td>Fulan</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        
                                <!-- Tabel kedua -->
                                <div class="table-responsive" style="width: 100%; max-width: 48%;">
                                    <table class="table table-bordered sub-table2" style="border-radius: 8px; overflow: hidden;">
                                        <thead>
                                            <tr style="background-color: #082164; color: white; font-size: 10px; text-align: center;">
                                                <th>PART</th>
                                                <th>NUT</th>
                                                <th>Qty</th>
                                                <th>STATUS</th>
                                                <th>SSW</th>
                                                <th>PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody style="background-color:#2d3134; color:white; font-size: 13px; text-align: center;">
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                            <tr>
                                                <td>(7687-9200)</td>
                                                <td>300</td>
                                                <td>80</td>
                                                <td>IN RUK</td>
                                                <td>6</td>
                                                <td>Fulan</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 

                        <div class="chart-wrapper2">
                            <div class="chart-container">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>

                        <br>
                        <div class="chart-wrapper2">
                            <div class="chart-container">
                                <canvas id="Chart" style="width: 10px; height: 100px;"></canvas>
                            </div>
                        </div>
    
    
                    </div>
                    
                </div>
                
            </div>
        </div>
        
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'SSW 1', 'SSW 2', 'SSW 3', 'SSW 4',
                    'SSW 5', 'SSW 6', 'SSW 7', 'SSW 8',
                    'SSW 9', 'SSW 10', 'SSW 11', 'SSW 12',
                    'SSW 13', 'SSW 14', 'SSW 15', 'SSW 16'
                ],
                datasets: [{
                        label: 'Stok A',
                        data: [5200, 4100, 6800, 7500, 500, 8000, 7888, 6200, 4300, 5100, 7200, 8100, 6900,
                            7300, 5400, 7700
                        ],
                        backgroundColor: '#4CAF50', // Hijau Cantik
                        barPercentage: 0.4,
                        categoryPercentage: 0.6
                    },
                    {
                        label: 'Stok B',
                        data: [3200, 2100, 4800, 6500, 300, 6000, 5888, 4200, 2300, 3100, 5200, 6100, 4900,
                            5300, 3400, 5700
                        ],
                        backgroundColor: '#FFC107', // Kuning Cantik
                        barPercentage: 0.4,
                        categoryPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutCubic',
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.8)'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.8)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.8)'
                        }
                    }
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById("Chart").getContext("2d");

    // Warna untuk setiap kategori bar
    var barColors = [
        "rgba(255, 99, 132, 0.8)",
        "rgba(54, 162, 235, 0.8)",
        "rgba(255, 206, 86, 0.8)",
        "rgba(75, 192, 192, 0.8)",
        "rgba(153, 102, 255, 0.8)",
        "rgba(255, 159, 64, 0.8)"
    ];

    // Data untuk 6 kategori
    var datasets = [];
    for (let i = 0; i < 6; i++) {
        datasets.push({
            label: `Bar ${i + 1}`,
            data: Array.from({ length: 10 }, () => Math.floor(Math.random() * 100)), // Data acak
            backgroundColor: barColors[i], // Warna batang
            borderWidth: 1
        });
    }

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true },
            },
            scales: {
                x: { stacked: false, grid: { display: false } },
                y: { beginAtZero: true }
            }
        }
    });
});
    </script>
@endsection
