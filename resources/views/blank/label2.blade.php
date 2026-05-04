<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Material Sharing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 1766.93px; /* 150mm */
            width: 295.46px; /* 100mm */
            margin: auto;
            background-color: #f9f9f9;
        }

        .container {
            width: 290px;
            border: 2px solid black;
            padding: 10px;
            margin: 10px auto;
            border-radius: 8px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            background: white;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }

        .header img {
            height: 30px;
        }

        .order-number {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .details {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid black;
            padding-bottom: 5px;
            font-size: 12px;
        }

        .details div {
            width: 48%;
        }

        .details div p {
            margin: 3px 0;
        }

        .location {
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .location img {
            width: 80px;
            height: 80px;
            border: 2px solid black;
            padding: 5px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .info {
            border-bottom: 2px solid black;
            padding: 8px 0;
            font-size: 11px;
        }

        .info p {
            margin: 5px 0;
            font-weight: bold;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 5px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .product-table th {
            background-color: #efefef;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
        }
        

    </style>
</head>
<body>
    @foreach($data as $row)
    <div class="container">
        <div class="header">
            <img src="dist/img/adw2.png" alt="Logo">
            <strong>Label Sharing Opsional</strong>
        </div>

        <div class="order-number">
            {{ $row['part_no'] }} / {{ $row['uniqNo'] }}
        </div>

        <div class="details">
            <div>
                <p><strong>Pembuat:</strong> {{ $row['createdby'] }}</p>
                <p><strong>Dibuat:</strong> {{ $row['created_at'] }}</p>
            </div>
            <div>
                <p><strong>Mesin Proses:</strong> {{ $row['supplier'] }}</p>
            </div>
        </div>

        <div class="location" style="text-align: center;">
            <img src="data:image/png;base64,{{ $row['qrcode'] }}" alt="QR Code">
        </div>

        <div class="info">
            <p>NAME: {{ $row['part_name'] }}</p>
            <p>Unique No: ( {{ $row['uniqNo'] }} )</p>
        </div>

        <table class="product-table">
            <tr>
                <th>Job No</th>
                <th>Part No</th>
                <th>Model</th>
                <th>Spec</th>
                <th>Qty</th>
            </tr>
            <tr>
                <td>{{ $row['job_no'] }}</td>
                <td>{{ $row['part_no2'] }}</td>
                <td>{{ $row['model_id'] }}</td>
                <td>{{ $row['spek'] }}</td>
                <td>{{ $row['actual_sheet'] }}</td>
            </tr>
        </table>
    </div>
    @endforeach
</body>

</html>
