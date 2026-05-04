<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Label</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .kanban {
            /* width: 40mm;
            height: 20mm; */
            /* border: 1px solid black; */
            padding: 1mm;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qrcode {
            width: 60%;
            /* Adjust width as needed */
        }
    </style>
</head>
<body>

@foreach ($data as $item)
    <div class="kanban">
        <!-- Displaying the QR Code as an SVG -->
        <img src="data:image/svg+xml;base64,{{ $item['qrcode'] }}" class="qrcode">
        <div class="text-center" style="font-size: 50%" class="highlight">{{ $item['part_nut'] }}</div>
        
    </div>
@endforeach

</body>
</html>
