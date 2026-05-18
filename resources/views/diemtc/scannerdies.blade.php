@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h4 class="m-0 text-center text-md-left">Scan QR-Code Dies</h4>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <!-- SELECT MODE -->
                            <div class="form-group mb-3">
                                <label><b>Pilih Mode Scan</b></label>
                                <select id="scanMode" class="form-control">
                                    <option value="">-- PILIH MODE --</option>
                                    <option value="SCAN_OUT">SCAN OUT DIES</option>
                                    <option value="SCAN_ACC">SCAN ACC DIES</option>
                                    <option value="SCAN_HISTORY">SCAN HISTORY DIES</option>
                                </select>
                            </div>

                            <!-- INFO -->
                            <div id="infoText" class="alert alert-warning text-center">
                                Silahkan pilih mode scan terlebih dahulu.
                            </div>

                            <!-- CAMERA -->
                            <div id="camera-container" style="display:none;">
                                <div id="my-qr-reader" style="width:100%;"></div>
                            </div>

                            <!-- RESULT -->
                            <div id="you-qr-result" class="alert alert-success mt-3" style="display:none;"></div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- TABLE LIST -->
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-md-10">

                    <div class="card shadow-sm">
                        <div class="card-header">
                            <b>List Scan</b>
                        </div>

                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width:50px;">No</th>
                                            <th>Mode</th>
                                            <th>QR Result</th>
                                            <th>Lokasi Tujuan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scanTableBody" class="text-center">
                                        <tr>
                                            <td colspan="5">Belum ada data scan</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- LIBRARY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- LEAFLET MAP -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let html5QrCode = null;
            let scanMode = "";
            let lastResult = null;
            let scanCount = 0;

            function playSuccessSound() {
                let audio = new Audio("{{ asset('sound/success_sound.mp3') }}");
                audio.play();
            }

            async function stopScanner() {
                if (html5QrCode) {
                    try {
                        await html5QrCode.stop();
                        await html5QrCode.clear();
                    } catch (err) {
                        console.log("Stop error:", err);
                    }
                    html5QrCode = null;
                }
            }

            async function startScanner() {

                document.getElementById("camera-container").style.display = "block";
                document.getElementById("infoText").style.display = "none";

                html5QrCode = new Html5Qrcode("my-qr-reader");

                try {
                    await html5QrCode.start(
                        { facingMode: "environment" },
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        (decodedText) => {

                            if (decodedText === lastResult) return;
                            lastResult = decodedText;

                            playSuccessSound();

                            let resultBox = document.getElementById("you-qr-result");
                            resultBox.style.display = "block";
                            resultBox.innerHTML = `<b>Mode:</b> ${scanMode} <br><b>Hasil:</b> ${decodedText}`;

                            if (scanMode === "SCAN_OUT") {
                                showMapPicker(decodedText);
                            } else {
                                saveTransaction(decodedText, null, null, "-");
                            }
                        },
                        (errorMessage) => {
                            // ignore
                        }
                    );

                } catch (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Camera Error",
                        text: "Kamera tidak bisa dibuka, cek izin kamera / HTTPS."
                    });
                    console.log("Start error:", err);
                }
            }

            // =============================
            // MAP PICKER + HYBRID SEARCH
            // =============================
            function showMapPicker(qrValue) {

                let selectedLat = null;
                let selectedLng = null;
                let selectedAddress = "";

                Swal.fire({
                    title: "Cari Lokasi Tujuan (SCAN OUT)",
                    html: `
                    <div style="width:100%;">

                        <div style="position:relative; width:100%;">
                            <input type="text" id="searchAddress" 
                                class="swal2-input"
                                style="width:100%; margin:0;"
                                placeholder="Ketik lokasi... contoh: Adyawinsa stamping">

                            <div id="suggestionsBox" 
                                style="
                                    position:absolute;
                                    top:55px;
                                    left:0;
                                    right:0;
                                    background:white;
                                    border:1px solid #ddd;
                                    border-radius:10px;
                                    max-height:400px;
                                    overflow-y:auto;
                                    z-index:999999;
                                    display:none;
                                    box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
                                ">
                            </div>
                        </div>

                        <div style="height:300px; width:100%; border-radius:12px; margin-top:20px;" id="mapPick"></div>

                        <div style="margin-top:10px; text-align:left;">
                            <b>Alamat:</b><br>
                            <span id="alamatText" style="font-size:13px; color:gray;">Belum dipilih</span>
                        </div>

                        <small style="color:gray;">Ketik alamat lalu pilih dari list</small>
                    </div>
                `,
                    width: "95%",
                    padding: "10px",
                    showCancelButton: true,
                    confirmButtonText: "SIMPAN",
                    cancelButtonText: "BATAL",
                    didOpen: () => {

                        let map = L.map('mapPick').setView([-6.3227, 107.3376], 13);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19
                        }).addTo(map);

                        let marker;
                        let typingTimer;

                        function setMarker(lat, lng, addressText) {
                            selectedLat = lat;
                            selectedLng = lng;
                            selectedAddress = addressText;

                            if (marker) {
                                marker.setLatLng([lat, lng]);
                            } else {
                                marker = L.marker([lat, lng]).addTo(map);
                            }

                            map.setView([lat, lng], 16);

                            document.getElementById("alamatText").innerHTML =
                                `${addressText}<br><small>Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}</small>`;
                        }

                        // klik map manual
                        map.on('click', function (e) {
                            setMarker(e.latlng.lat, e.latlng.lng, "Lokasi dipilih manual via map");
                        });

                        let input = document.getElementById("searchAddress");
                        let suggestionBox = document.getElementById("suggestionsBox");

                        async function fetchSuggestions(query) {

                            if (!query || query.length < 2) {
                                suggestionBox.style.display = "none";
                                suggestionBox.innerHTML = "";
                                return;
                            }

                            try {

                                suggestionBox.innerHTML = `<div style="padding:10px; color:gray;">Mencari...</div>`;
                                suggestionBox.style.display = "block";

                                // Photon API
                                let photonUrl = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=20`;

                                // Nominatim API
                                let nominatimUrl =
                                    `https://nominatim.openstreetmap.org/search?format=json` +
                                    `&addressdetails=1` +
                                    `&limit=20` +
                                    `&dedupe=0` +
                                    `&countrycodes=id` +
                                    `&q=${encodeURIComponent(query)}`;

                                let [photonRes, nominatimRes] = await Promise.all([
                                    fetch(photonUrl),
                                    fetch(nominatimUrl)
                                ]);

                                let photonData = await photonRes.json();
                                let nominatimData = await nominatimRes.json();

                                let results = [];

                                // Photon results
                                if (photonData.features) {
                                    photonData.features.forEach(item => {
                                        let props = item.properties;

                                        results.push({
                                            title: props.name || "Lokasi",
                                            address: `${props.name || ""}, ${props.city || ""}, ${props.state || ""}, ${props.country || ""}`
                                                .replace(/,\s*,/g, ",")
                                                .replace(/,\s*$/, ""),
                                            lat: item.geometry.coordinates[1],
                                            lng: item.geometry.coordinates[0]
                                        });
                                    });
                                }

                                // Nominatim results
                                if (nominatimData) {
                                    nominatimData.forEach(item => {
                                        results.push({
                                            title: item.display_name.split(",")[0],
                                            address: item.display_name,
                                            lat: parseFloat(item.lat),
                                            lng: parseFloat(item.lon)
                                        });
                                    });
                                }

                                // remove duplicate
                                let uniqueResults = [];
                                let seen = new Set();

                                results.forEach(r => {
                                    let key = r.address.toLowerCase();
                                    if (!seen.has(key)) {
                                        seen.add(key);
                                        uniqueResults.push(r);
                                    }
                                });

                                suggestionBox.innerHTML = "";

                                if (uniqueResults.length === 0) {
                                    suggestionBox.style.display = "none";
                                    return;
                                }

                                uniqueResults.forEach(item => {

                                    let div = document.createElement("div");
                                    div.style.padding = "10px";
                                    div.style.cursor = "pointer";
                                    div.style.borderBottom = "1px solid #f1f1f1";
                                    div.style.fontSize = "13px";
                                    div.style.lineHeight = "1.3";

                                    div.innerHTML = `
                                    <div style="font-weight:bold; color:#333;">
                                        📍 ${item.title}
                                    </div>
                                    <div style="font-size:12px; color:gray;">
                                        ${item.address}
                                    </div>
                                `;

                                    div.addEventListener("mouseover", function () {
                                        div.style.background = "#f5f5f5";
                                    });

                                    div.addEventListener("mouseout", function () {
                                        div.style.background = "white";
                                    });

                                    div.addEventListener("click", function () {

                                        setMarker(item.lat, item.lng, item.address);

                                        suggestionBox.style.display = "none";
                                        suggestionBox.innerHTML = "";
                                        input.value = item.title;
                                    });

                                    suggestionBox.appendChild(div);
                                });

                                suggestionBox.style.display = "block";

                            } catch (error) {
                                console.log(error);
                                suggestionBox.style.display = "none";
                            }
                        }

                        // input keyup delay
                        input.addEventListener("keyup", function () {
                            clearTimeout(typingTimer);

                            typingTimer = setTimeout(() => {
                                fetchSuggestions(input.value.trim());
                            }, 500);
                        });

                        // klik luar
                        document.addEventListener("click", function (e) {
                            if (!suggestionBox.contains(e.target) && e.target !== input) {
                                suggestionBox.style.display = "none";
                            }
                        });

                    }
                }).then((result) => {

                    if (result.isConfirmed) {

                        if (!selectedLat || !selectedLng) {
                            Swal.fire("Error", "Silahkan pilih lokasi terlebih dahulu!", "error");
                            return;
                        }

                        saveTransaction(qrValue, selectedLat, selectedLng, selectedAddress);

                    } else {
                        Swal.fire("Batal", "Scan OUT dibatalkan.", "warning");
                    }

                });
            }

            // =============================
            // SAVE TRANSACTION AJAX
            // =============================
            function saveTransaction(qrValue, destLat, destLng, destAddress) {

                $.ajax({
                    url: "{{ route('dies.scan.save') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        dies_qr: qrValue,
                        transaction_type: scanMode,
                        destination_lat: destLat,
                        destination_lng: destLng,
                        destination_address: destAddress
                    },
                    success: function (res) {

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil Disimpan!",
                            timer: 1200,
                            showConfirmButton: false
                        });

                        scanCount++;

                        let tbody = document.getElementById("scanTableBody");
                        if (scanCount === 1) {
                            tbody.innerHTML = "";
                        }

                        let now = new Date().toLocaleString();

                        tbody.innerHTML += `
                        <tr>
                            <td>${scanCount}</td>
                            <td>${scanMode}</td>
                            <td style="word-break: break-word;">${qrValue}</td>
                            <td style="word-break: break-word;">
                                ${destLat ? destLat.toFixed(5) + ", " + destLng.toFixed(5) : "-"}
                            </td>
                            <td>${now}</td>
                        </tr>
                    `;
                    },
                    error: function (err) {
                        Swal.fire("Gagal", "Data gagal disimpan ke database!", "error");
                        console.log(err);
                    }
                });
            }

            // =============================
            // CHANGE MODE EVENT
            // =============================
            document.getElementById("scanMode").addEventListener("change", async function () {

                scanMode = this.value;

                document.getElementById("you-qr-result").style.display = "none";
                document.getElementById("you-qr-result").innerHTML = "";
                lastResult = null;

                await stopScanner();
                document.getElementById("my-qr-reader").innerHTML = "";

                if (scanMode === "") {
                    document.getElementById("camera-container").style.display = "none";
                    document.getElementById("infoText").style.display = "block";
                    document.getElementById("infoText").innerHTML = "Silahkan pilih mode scan terlebih dahulu.";
                    return;
                }

                startScanner();
            });

        });
    </script>
@endsection