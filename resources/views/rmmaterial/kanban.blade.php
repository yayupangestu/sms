<!-- resources/views/formatkanban/kanbanstmp.blade.php -->
<html>
<head>
    <title>Kanban PDF</title>
</head>
<body>
    <h1>PDF Preview s</h1>
    <p>UniqNo: {{ $UniqNo }}</p>
    <p>Qty OK: {{ $qty_ok }}</p>
    
    <!-- Gunakan tag <img> untuk menampilkan QR code -->
    <p>QR Code:</p>
    <img src="data:image/svg+xml;base64,{{ $qrcode }}" alt="QR Code">
</body>
</html>
