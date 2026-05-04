<!DOCTYPE html>
<html>
<head>
    <title>Shipping Label List</title>
    <style>
        body {
                 font-family: Arial, sans-serif;
                 height: 1766.93px; /* 150mm in points */
                 width: 285.46px; /* 100mm in points */
                 margin-left: auto;
                 margin-right: auto;
             }
             .container {
                 width: 340px;
                 border: 2px solid black;
                 padding: 8px;
                 margin: 10px auto;
                 /* height: 250px; */
                 margin-left: -30px;
                 margin-top: -20px;
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
    gap: 10px;
}

.details .box {
    flex: 1;
    border: 1px solid #333;
    padding: 5px;
    background-color: #f9f9f9;
    border-radius: 4px;
    font-size: 11px;
    word-wrap: break-word;    /* agar kata panjang terbungkus */
    overflow-wrap: break-word; /* alternatif modern */
    white-space: normal;       /* agar teks boleh turun baris */
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
         /* margin-top: 15px; */
         margin-left: -30px;
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
                 margin-top: -15px;
                 font-size: 10px;
                 margin-top: -20px;

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
                 width: 85px; /* Sesuaikan ukuran lebar QR code */
                 height: 85px; /* Sesuaikan ukuran tinggi QR code */
             }
             .brand-image{
                 width: 120px; /* Sesuaikan ukuran lebar QR code */
                 height: 20px; /* Sesuaikan ukuran tinggi QR code */
             }
       </style>
</head>
<body>
    @foreach($data as $item)
    <div class="container">
        <div class="header">
            <img src="dist/img/adw2.png" class="brand-image">
            <span class="header-title">Label PART NO</span>
        </div>
        
        <div class="order-number">
            Doc DN: {{ $item['no_dn'] }}
        </div>

        <div class="details">
            <div class="box">
                <p><strong>Pengirim:</strong> {{ $item['supplier'] }}</p>
            </div>
            <div class="box">
                <p><strong>Prode Date:</strong> </p>
            </div>
        </div>
        
        
       
   
   <img src="dist/img/inspector2.png"
        class="qrcode"
        style="width: 150px; height: 70px; border: 1px solid black; padding: 5px; box-sizing: border-box;">
        <img src="data:image/png;base64,{{ $item['qrcode'] }}"
        class="qrcode"
        style="width: 70px; height: 70px; border: 1px solid black; padding: 5px; box-sizing: border-box; margin-right: 20px; margin-top: 30px;">
   
        
        
        
        
        
        <table class="product-table">
            <tr>
                <th style="text-align: center;">Part No</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: center;">Pembuat Label</th>
                {{-- <th style="text-align: center;">Costumer</th> --}}
                <th style="text-align: center;">Label Dibuat</th>
            </tr>
            <tr>
                <td style="text-align: center; font-size:12px">{{ $item['part_no'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['qty_act'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['createdby'] }}</td>
                <td style="text-align: center; font-size:12px">{{ $item['created_at'] }}</td>
                {{-- <td style="text-align: center; font-size:12px">-</td> --}}
            </tr>
        </table>
    </div>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
