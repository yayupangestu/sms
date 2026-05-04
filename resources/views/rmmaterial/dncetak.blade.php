<!DOCTYPE html>
<html>
<head>
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
            text-align: center;
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

    <div class="company-header">
        <p>PT. Adyawinsa Stamping Industries<br>
        Jl. Surotokunto Dusun Krajan I, Klari Karawang - Jawa Barat, 41313<br>
        Indonesia</p>
        <img src="dist/img/adw2.png" alt="AdminLTE Logo" class="brand-image">
    </div>

<h2 class="title">Delivery Note: {{ $doc_no_formatted }}</h2>

<table class="delivery-details">
    <tr>
        <td colspan="2" class="header">TANGGAL ORDER :</td>
        <td colspan="4">{{ \Carbon\Carbon::parse($data->first()->date_plan)->translatedFormat('d F Y') }}</td>
        <td colspan="3" class="header">CYCLE ISSUE :</td>
    </tr>
    <tr>
        <td colspan="2" class="header">TANGGAL DELIVERY :</td>
        <td colspan="4">{{ \Carbon\Carbon::parse($data->first()->date_plan)->translatedFormat('d F Y') }}</td>
        <td colspan="3" class="header">JAM DELIVERY :</td>
    </tr>
</table>

<table>
    <thead>
        <tr class="spec-section">
            <th class="header2">No</th>
            <th class="header2">Suplier</th>
            <th class="header2">PART NO</th>
            <th class="header2">MODEL</th>
            <th class="header2">CATEGORY</th>
            <th class="header2">SPEC</th>
            <th class="header2">T</th>
            <th class="header2">W</th>
            <th class="header2">L</th>
            <th class="header2">Qty Plan</th>
            <th class="header2">Qty IN</th>
            {{-- <th class="header2">UniqNo</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="highlight">{{ $row->suplai_id}}</td>
            <td class="highlight">{{ $row->spek }}</td> <!-- Part No column -->
            <td>{{ $row->model }}</td> <!-- Kanban column -->
            <td>{{ $row->category_id }}</td> <!-- Model column -->
            <td>{{ $row->material_id }}</td> <!-- Spec column -->
            <td>{{ $row->spek_p}}</td> <!-- Format T to 2 decimal places -->
            <td>{{ $row->spek_t}}</td>
            <td>{{ $row->spek_l}}</td> <!-- Format L with commas -->
            <td>{{ $row->qty_plan}}</td> <!-- Format KG with 2 decimal places and commas -->
            <td>{{ $row->qty_in}}</td> <!-- Format KG with 2 decimal places and commas -->
            {{-- <td>{{ $uniqNo }}</td> <!-- Added UniqNo --> --}}
        </tr>
        @endforeach

        <!-- Add total row if needed -->
        <tr class="total-row">
            <td class="total" colspan="9">Total</td>
            <td class="total">{{ number_format($data->sum('qty_plan')) }}</td> <!-- Total KG -->
            <td class="total">{{ number_format($data->sum('qty_in')) }}</td> <!-- Total KG -->
        </tr>
    </tbody>
</table>

<!-- QR Code section -->
<div class="qr-code">
    <p>Scan for more details:</p>
    <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
</div>

</body>
</html>
