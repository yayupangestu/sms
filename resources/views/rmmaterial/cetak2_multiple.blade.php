<!DOCTYPE html>
<html>
<head>
    <title>Shipping Label List</title>
    <style>
        body {
                 font-family: Arial, sans-serif;
                 height: 1766.93px; /* 150mm in points */
                 width: 295.46px; /* 100mm in points */
                 margin-left: auto;
                 margin-right: auto;
             }
             .container {
                 width: 290px;
                 border: 2px solid black;
                 padding: 8px;
                 margin: 10px auto;
                 /* height: 250px; */
             }
             .header {
                 display: flex;
                 justify-content: space-between;
                 align-items: center;
                 border-bottom: 1px solid black;
                 padding-bottom: 5px;
             }
             .header img {
                 height: 25px;
             }
             .order-number {
                 text-align: center;
                 font-weight: bold;
                 margin: 10px 0;
                 font-size: 12px;
             }
             .barcode {
                 text-align: center;
                 margin: 5px 0;
             }
             .barcode img {
                 width: 100%;
                 height: 30px;
             }
             .details {
                 display: flex;
                 justify-content: space-between;
                 border-bottom: 1px solid black;
                 padding-bottom: 5px;
             }
             .details div {
                 width: 48%;
                 font-size: 10px;
             }
             .details div p {
                 margin: 3px 0;
             }
             .location {
         display: flex;
         justify-content: center; /* Center child elements horizontally */
         border-bottom: 1px solid black;
         padding: 10px 0;
     }

             .location div {
                 width: 88%;
                 text-align: center;
                 border: 1px solid black;
                 padding: 3px;
                 font-size: 20px;
             }
             .info {
                 border-bottom: 1px solid black;
                 padding: 5px 0;
             }
             .info p {
                 margin: 3px 0;
                 font-size: 10px;
             }
             .product-table {
                 width: 100%;
                 border-collapse: collapse;
                 margin-top: 5px;
                 font-size: 10px;
             }
             .product-table th, .product-table td {
                 border: 1px solid black;
                 padding: 3px;
                 text-align: left;
             }
             .product-table th {
                 background-color: #f2f2f2;
             }
             .footer {
                 margin-top: 5px;
                 font-size: 10px;
             }
             .qrcode {
                 width: 120px; /* Sesuaikan ukuran lebar QR code */
                 height: 120px; /* Sesuaikan ukuran tinggi QR code */
             }
             .brand-image{
                 width: 80px; /* Sesuaikan ukuran lebar QR code */
                 height: 10px; /* Sesuaikan ukuran tinggi QR code */
             }
       </style>
</head>
<body>
    @foreach($data as $item)
    <div class="container">
        <div class="header">
            <img src="dist/img/adw2.png" class="brand-image"> Label Material
        </div>
        <div class="order-number">
            Doc DN: {{ $item['doc_dn'] }}
        </div>
        <div class="order-number">
            Doc PO: {{ $item['doc_po'] }}
        </div>
        <div class="details">
            <div>
                <p style="font-size: 13px"><strong>Penerima:</strong> {{ $item['createdby'] }} </p>
                <p style="font-size: 13px"><strong>Diterima:</strong> {{ $item['created_at'] }}</p>
            </div>
            <div>
                <p style="font-size: 12px"><strong>Pengirim:</strong> {{ $item['supplier'] }}</p>
                <p></p>
            </div>
        </div>
        <div class="location" style="text-align: center;">
            <img src="data:image/png;base64,{{ $item['qrcode'] }}" class="qrcode">
        </div>
        <div style="size: 100px" class="info">
            <p style="font-size: 13px"><strong>Dimensi :</strong> T={{ $item['spec_t'] }} x P={{ $item['spec_w'] }} x L={{ $item['spec_l'] }}</p>
            <p style="font-size: 13px"><strong>Part No :</strong> {{ $item['part_no'] }} </p>
            <p style="font-size: 13px"><strong>Model :</strong> {{ $item['model'] }}</p>
        </div>
        <table class="product-table">
            <tr>
                <th style="text-align: center;">Spec</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: center;">UniqNO</th>
                <th style="text-align: center;">Berat</th>
                <th style="text-align: center;">No Rak</th>
            </tr>
            <tr>
                <td style="text-align: center; font-size:10px">{{ $item['spec'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['actual'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['uniq_no'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['kg_sheet'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['no_rak'] }}</td>
            </tr>
        </table>
    </div>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
