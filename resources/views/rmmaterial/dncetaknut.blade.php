{{-- <!DOCTYPE html>
<html>
<head>
    <title>Inmaterial PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Document No: {{ $doc_no_formatted }}</h1>



    <table>
        <thead>
            <tr>
                <th>Date Plan</th>
                <th>Suplai</th>
                <th>Material ID</th>
                <th>Planning Qty</th>
                <th>Actual Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->date_plan }}</td>
                    <td>{{ $item->suplai_id }}</td>
                    <td class="highlight">{{ $item->material_id }}</td>
                    <td>{{ $item->qty_plan }}</td>
                    <td>{{ $item->qty_in }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="qr-code">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        <p>Scan untuk melihat detail data</p>
    </div>

</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach($data as $item)
        <title>No: {{ $item->doc_no }}
    </title>
    @endforeach
    <style>
        /* Add a page border */
        body {
            margin: 0;
            padding: 20px; /* Reduced padding */
            border: 2px solid black;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 12px; /* Reduced font size */
        }

        th, td {
            border: 1px solid #ccc;
            padding: 4px; /* Reduced padding */
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .header {
            font-weight: bold;
        }

        .header2 {
            background-color: #6cd2ee;
            text-align: center;
        }

        .total {
            background-color: #0c0753;
            color: #f2f2f2;
        }

        .highlight {
            background-color: #f4e8d3;
        }

        .qr-code {
            margin-top: 20px;
            text-align: center;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
        }

        /* Styles for printing */
        @media print {
            body {
                margin: 0;
                padding: 10px;
                font-size: 12px;
            }

            th, td {
                padding: 4px;
            }

            .company-header img {
                display: none;
            }

            .qr-code {
                display: none;
            }

            table {
                page-break-inside: avoid;
            }
        }

        /* New styles for the header text */
        .company-header {
            text-align: right;
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .company-header img {
            float: left;;
            max-height: 110px;
            margin-top: -100px;
        }
    </style>
</head>
<body>

    <!-- Company Header -->
    <div class="company-header">
        <p>PT. Adyawinsa Stamping Industries<br>
        Jl. Surotokunto Dusun Krajan I, Klari Karawang - Jawa Barat, 41313<br>
        Indonesia</p>
        <img src="dist/img/adw2.png" alt="AdminLTE Logo" class="brand-image">
    </div>

    <table>
        <tr>
            <td colspan="2" class="header">TANGGAL ORDER :</td>
            <td colspan="4">{{ \Carbon\Carbon::parse($data->first()->date_plan)->translatedFormat('d F Y') }}</td>
            <td colspan="3" class="header">CYCLE ISSUE :</td>
        </tr>
        <tr>
            <td colspan="2" class="header">TANGGAL DELIVERY :</td>
            <td colspan="4">{{ \Carbon\Carbon::parse($data->first()->date_delivery)->translatedFormat('d F Y') }}</td>
            <td colspan="3" class="header">JAM DELIVERY :</td>
        </tr>
        <tr>
            <th class="header2" width="20">No</th>
            <th class="header2">Suplai</th>
            <th class="header2">Material ID</th>
            <th class="header2" width="70">Planning Qty</th>
            <th class="header2" width="60">Actual Qty</th>
            <th class="header2" width="60">Balance</th> <!-- New Balance Column -->
            <th class="header2" width="80">No Dn</th>
            <th class="header2" width="150">Remark</th>
            <th class="header2" width="50">Order No</th>
        </tr>
        <tbody>
            @php
                $totalPlanningQty = 0;
                $totalActualQty = 0;
                $totalBalance = 0;
            @endphp
            @foreach($data as $item)
                @php
                    $planningQty = $item->qty_plan;
                    $actualQty = $item->qty_in;
                    $balance = $planningQty - $actualQty; // Calculate balance
                
                    // Format balance with '+' sign for negative values
                    $formattedBalance = $balance < 0 ? '+' . abs($balance) : $balance;
        
                    $totalPlanningQty += $planningQty;
                    $totalActualQty += $actualQty;
                    $totalBalance += $balance; // Add to total balance
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->suplai_id }}</td>
                    <td class="highlight">{{ $item->material_id }}</td>
                    <td>{{ $planningQty }}</td>
                    <td>{{ $actualQty }}</td>
                    <!-- Apply conditional color to Balance -->
                    <td style="background-color: 
                        {{ $balance < 0 ? '#aef8c5' : ($balance != 0 ? '#f8c5c5' : '#ffffff') }};
                        color: black;">
                        {{ $formattedBalance }}
                    </td>
                    <td>SP{{ $item->doc_no }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->no }}</td>
                </tr>
            @endforeach
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3" class="header">Total</td>
                <td class="total">{{ $totalPlanningQty }}</td>
                <td class="total">{{ $totalActualQty }}</td>
                <td class="total">{{ $totalBalance }}</td> <!-- Display total balance -->
                <td colspan="3" class="total"></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <div class="qr-code">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
    </div>

</body>
</html>







