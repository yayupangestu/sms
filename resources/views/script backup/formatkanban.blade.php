<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Layout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px; /* Default font size (lebih kecil) */
        }

        .kanban-table {
            width: 80%; /* Kurangi lebar tabel */
            border-collapse: collapse;
            font-size: 10px; /* Table font size lebih kecil */
        }

        .kanban-table td {
            border: 0.5mm solid black; /* Border lebih tipis */
            padding: 1mm; /* Padding lebih kecil */
            text-align: center;
        }

        .header {
            font-weight: bold;
            background-color: #ffffff;
        }

        .large-text {
            font-size: 12px; /* Ukuran font lebih kecil */
            font-weight: bold;
        }

        .highlight {
            background-color: #00AEEF;
            color: white;
            font-size: 10px; /* Ukuran font lebih kecil */
            font-weight: bold;
        }

        .picture img {
            width: 15mm; /* Ukuran gambar lebih kecil */
            height: auto;
        }

        .qrcode img {
            width: 15mm; /* Ukuran QR code lebih kecil */
            height: auto;
        }

        .double-col {
            colspan: 2;
        }
    </style>
</head>
<body>

<div width="5%" class="kanban">
    <table class="kanban-table">
        @foreach($listdetail as $detail)
        <tr>
            <td rowspan="2" colspan="2">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img src="dist/img/Gambaradw2.png" alt="Logo" style="width: 20mm; height: auto;"> <!-- Ukuran gambar logo lebih kecil -->
                    <b style="margin-left: 3mm; margin-top: -2mm;">KANBAN STAMPING</b> <!-- Kurangi margin kiri -->
                </div>
            </td>
            <td width="5%" class="header">LINE</td>
            <td width="5%" class="large-text">STAMPING </td>
        </tr>
        <tr>
            <td width="5%" style="font-size: 70%" class="header">DESTINATION</td> <!-- Ukuran font lebih kecil -->
            <td width="5%" class="highlight" style="font-size: 70%">PC STORE</td> <!-- Ukuran font lebih kecil -->
        </tr>
        <tr>
            <td width="5%" style="font-size: 70%" class="header">PART NO</td> <!-- Ukuran font lebih kecil -->
            <td width="5%">{{ $detail->part_name }}</td>
            <td width="5%" style="font-size: 70%" class="header">PART TYPE</td> <!-- Ukuran font lebih kecil -->
            <td width="5%" style="font-size: 70%" class="header">DIRECT</td> <!-- Ukuran font lebih kecil -->
        </tr>
        <tr>
           <td width="5%" style="font-size: 70%" class="header">JOB NO / MODEL</td> <!-- Ukuran font lebih kecil -->
            <td width="5%">{{ $detail->job_no }} / {{ $detail->model }}</td>
           <td width="%" style="font-size: 100%" class="header">Date / Shift</td> <!-- Ukuran font lebih kecil -->
            <td width="5%" style="font-size: 90%">{{ date('m-d-Y') }} / {{ $detail->shift }}</td>
        </tr>
        <tr>
           <td style="font-size: 70%" class="header">UNIQ NO</td> <!-- Ukuran font lebih kecil -->
            <td class="highlight">{{ $detail->uniqNo }}</td>
           <td style="font-size: 70%" class="header">QTY / KANBAN</td> <!-- Ukuran font lebih kecil -->
            <td>{{$detail->qty_ok }}</td>
        </tr>
        <tr>
           <td style="font-size: 70%" class="header">Crated</td> <!-- Ukuran font lebih kecil -->
            <td>{{ $detail->createdby}}</td>
           <td style="font-size: 70%" class="header">TIME START/TIME END</td> <!-- Ukuran font lebih kecil -->
            <td>{{ $detail->time_start }} / {{ $detail->time_end }}</td>
        </tr>
        <tr>
            <td class="header" colspan="2">
                <!-- Menampilkan QR code -->
                <div class="qrcode">
                    <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
                </div>
            </td>
            <td style="font-size: 70%; text-align: center;">
                <div style="font-size: 100%; font-weight: bold;">TYPE PALLET</div>
                <div style="font-size: 200%;">NO</div>
            </td>
            
            <!-- Ukuran font lebih kecil -->
           <td style="font-size: 70%" class="header">
                <img src="dist/img/Part1.png" alt="Logo" style="width: 15mm; height: auto;"> <!-- Ukuran gambar lebih kecil -->
            </td>
        </tr>
        @endforeach
    </table>
</div>

</body>
</html>
