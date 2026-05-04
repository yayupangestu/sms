<html>
 <head>
  <title>
   Shipping Label
  </title>
  <style>
   body {
            font-family: Arial, sans-serif;
            height: 1066.93px; /* 150mm in points */
            width: 295.46px; /* 100mm in points */
            margin-left: auto;
            margin-right: auto;
        }
        .container {
            width: 270px;
            border: 1px solid black;
            padding: 5px;
            margin: 10px auto;
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
            margin: 5px 0;
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
    padding: 5px 0;
}

        .location div {
            width: 48%;
            text-align: center;
            border: 1px solid black;
            padding: 3px;
            font-size: 10px;
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
            width: 80px; /* Sesuaikan ukuran lebar QR code */
            height: 80px; /* Sesuaikan ukuran tinggi QR code */
        }
        .brand-image{
            width: 80px; /* Sesuaikan ukuran lebar QR code */
            height: 10px; /* Sesuaikan ukuran tinggi QR code */
        }
  </style>
 </head>
 <body>
  <div class="container">
   <div class="header">
    <img src="dist/img/adw2.png" class="brand-image">
   </div>
   <div class="order-number">
    Doc NO: {{ $doc_no}}
   </div>
   <div class="details">
    <div>
     <p><strong>Penerima:</strong>{{ $updateby}}</p>
     <p><strong>Diterima:</strong> {{ $in_time}}</p>
    </div>
    <div>
     <p><strong>Pengirim:</strong> {{ $name_suplai}}</p>
     <p>{{ $alamat }}</p>
    </div>
   </div>
   <div class="location" style="text-align: center;">
    <img src="data:image/png;base64,{{ $qrcode }}" class="qrcode">
   </div>
   <div class="info">
    <p><strong>Dimensi:</strong>T={{ $spek_t}} x P={{ $spek_p}} x L={{$spek_l}}</p>
    <p><strong>Part No: {{ $spek }} / {{ $model }}</strong></p>
    <p><strong>Prepared:</strong>{{ $createdby}}</p>
   </div>
   <table class="product-table">
    <tr>
     {{-- <th style="text-align: center;">No</th> --}}
     <th style="text-align: center;">Spec</th>
     <th style="text-align: center;">Category</th>
     <th style="text-align: center;">Qty</th>
     <th style="text-align: center;">Pallet</th>
     <th style="text-align: center;">UniqNO</th>
     <th style="text-align: center;">No Rak</th>
    </tr>
    <tr>
     {{-- <td>1</td> --}}
     <td style="text-align: center;">{{ $material_name }}</td>
     <td style="text-align: center;">{{ $category_id }}</td>
     <td style="text-align: center;">{{ $qty_in}}</td>
     <td style="text-align: center;">{{ $no }}</td>
     <td style="text-align: center;">{{ $uniq_no }}</td>
     <td style="text-align: center;">{{ $no_rak}}</td>
    </tr>
   </table>
  </div>
  <p style="font-size: 78px; text-align: center; margin-top: 8px;">
    *Tolong label jangan rusak sebelum proses scan sudah semua
</p>
 </body>
</html>
