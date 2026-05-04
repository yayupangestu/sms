<!DOCTYPE html>
<html>
<head>
    <title>Shipping Label List Stamping</title>
    <style>
        @page {
            margin: 0 !important;
            padding: 0 !important;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: 67.5mm; /* sesuai permintaan */
            border: 2px solid #000;
            margin: auto;
            padding: 0;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        .box {
            border: 1px solid #000;
            text-align: center;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header {
            font-size: 12pt;
            padding: 2mm;
        }

        .company {
            font-size: 10pt;
            padding: 2mm;
        }

        .tasi {
            font-size: 18pt;
            font-weight: 900;
            padding: 3mm;
        }

        .times {
            display: flex;
            border: 1px solid #000;
        }

        .time-box {
            flex: 1;
            border-right: 1px solid #000;
        }
        .time-box:last-child {
            border-right: none;
        }

        .time-head {
            border-bottom: 1px solid #000;
            padding: 1mm;
            font-size: 8pt;
        }

        .time-value {
            padding: 2mm;
            font-size: 9pt;
        }

        .rc {
            display: grid;
            grid-template-columns: 1fr 1fr; /* dua kolom seimbang */
        }

        .rc-cell {
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2mm;
        }
        .rc-big {
            font-size: 14pt;
            font-weight: 900;
        }
        .rc-num {
            font-size: 14pt;
            font-weight: 900;
        }

        .data-bar {
            border: 1px solid #000;
            font-size: 10pt;
            padding: 1.5mm;
            text-align: center;
        }

        .barcode {
            border: 1px solid #000;
            padding: 2mm;
            text-align: center;
        }

        .barcode img {
            width: 50%;
            height: auto;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            font-weight: 1200;
        }

        .product-table th,
        .product-table td {
            border: 0.3mm solid black;
            padding: 1mm;
            text-align: center;
        }

        .footer {
            font-size: 7pt;
            text-align: center;
            margin-top: 2mm;
        }

        .page-break {
            page-break-after: always;
        }
        .footer {
    font-size: 8pt;
    text-align: center;
    margin-top: 1mm;
}

    </style>
</head>
<body>
    @foreach($listdetail as $item)
        <div class="container">
            <div class="box header">TAG LABEL STAMPING B1</div>
            <div class="box company">ADYAWINSA STAMPING INDUSTRIES</div>

            <!-- Product Info -->
            <table class="product-table">
                <tr>
                    <th>Part No</th>
                    <th>JobNo</th>
                    <th>UniqueNo</th>
                </tr>
                <tr>
                    <td>{{ $item->part_no ?? '' }}</td>
                    <td>{{ $item->job_no ?? '' }}</td>
                    <td>{{ $item->uniqNo ?? '' }}</td>
                </tr>
            </table>

            <div style="font-weight: 900" class="box data-bar">{{ $item->part_name ?? '' }}</div>

            <table class="product-table">
                <tr>
                    <th>Model</th>
                    <th>Qty</th>
                    <th>Line</th>
                </tr>
                <tr>
                    <td>{{ $item->model ?? '' }}</td>
                    <td>{{ $item->qty_ok ?? '' }}</td>
                    <td>{{ $item->tujuan ?? '' }}</td>
                </tr>
            </table>

            <table style="width:100%; border:0; margin-top:5px;">
                <tr>
                    <!-- Kolom kiri: QR Code -->
                    <td style="width:50%; text-align:center; vertical-align:top;">
                        <img src="data:image/svg+xml;base64,{{ $qrcode }}"
                             style="width:120px; height:auto; margin-top:5px;">
                    </td>

                    <!-- Kolom kanan: Gambar -->
                    <td style="width:50%; text-align:center; vertical-align:top;">
                        <div style="border:1px solid black; padding:5px; display:inline-block; margin-top:10px;">
                            <img src="{{ $okImage }}"
                                 style="width:70px; height:auto; display:block; margin:0 auto;">
                        </div>
                        <hr>
                        <div style="margin-bottom:5px;">
                            <img src="{{ $extraImage }}"
                                 style="width:120px; height:auto; display:block; margin:0 auto;">
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Printed info -->
            <div class="footer">
                Waktu Proses Item <strong>{{ $item->time_start ?? $item->created_at ?? '' }} - {{ $item->createdby ?? ''}}</strong>
            </div>
        </div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
    </body>

</html>
