@extends('layouts.app')

<style>
    /* Add a page border */

    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 15px; /* Reduced font size */
    }

    th, td {
        border: 1px solid #ccc;
        padding: 4px; /* Reduced padding */
        text-align: left;
    }

    th {
        background-color: #acacac;
        font-weight: bold;
    }

    .header {
        background-color: #0c0753;
        text-align: center;
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
        text-align: center;
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

    @media (max-width: 768px) {
        th, td {
            font-size: 13px;
            padding: 3px;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
        }

        /* Adjust modal layout for small screens */
        .modal-lg {
            max-width: 90%;
        }
    }

    @media (max-width: 576px) {
        th, td {
            font-size: 12px;
            padding: 2px;
        }

        /* Smaller modal */
        .modal-lg {
            max-width: 100%;
        }
    }
</style>

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Scan QR-Code Kedatangan</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div id="you-qr-result"></div>
                <div id="my-qr-reader" style="width: 100%; max-width: 500px;"></div>
            </div>
        </div>

        <!-- Modal untuk menampilkan detail material -->
        <div class="modal fade" id="materialsModal" tabindex="-1" role="dialog" aria-labelledby="materialsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="materialsModalLabel">Material Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="header">
                                    <tr>
                                        <th>Doc No</th>
                                        <th>Material Name</th>
                                        <th>Quantity Plan</th>
                                        <th>Qty In</th>
                                        <th>Supplier ID</th>
                                        <th>Category ID</th>
                                        <th>Date Plan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="materials-body">
                                    <!-- Data will be dynamically populated -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary" id="save-changes">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load Libraries -->
        <script src="https://unpkg.com/html5-qrcode"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var lastResult, countResults = 0;

                // Function to play sound on successful scan
                function playSuccessSound() {
                    var audio = new Audio('/sound/success_sound.mp3');
                    audio.play();
                }

                // Function called when QR code is scanned successfully
                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        lastResult = decodedText;
                        countResults++;
                        playSuccessSound();

                        // AJAX request to get material data by doc_no
                        $.ajax({
                            url: '{{ route("getMaterialsByDocNodn") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                doc_no: decodedText
                            },
                            success: function(response) {
                                populateMaterialsTable(response);
                                $('#materialsModal').modal('show'); // Show modal
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Failed to retrieve material data.', 'error');
                            }
                        });
                    }
                }

                // Function to populate material table
                function populateMaterialsTable(data) {
                    var materialsBody = $('#materials-body');
                    materialsBody.html(''); // Clear previous table

                    // Populate with new data
                    data.forEach(function(item) {
                        materialsBody.append(`
                            <tr data-id="${item.id}">
                                <td>${item.doc_no ? item.doc_no : ''}</td>
                                <td class="highlight" width="90">${item.material_id ? item.material_id : ''}</td>
                                <td width="100" >${item.qty_plan ? item.qty_plan : ''}</td>
                                <td><input type="text" inputmode="numeric" class="form-control qty-in" value="${item.qty_in ? item.qty_in : ''}"></td>
                                <td>${item.suplai_id ? item.suplai_id : ''}</td>
                                <td>${item.category_id ? item.category_id : ''}</td>
                                <td>${item.date_plan ? item.date_plan : ''}</td>
                                <td>${item.keterangan ? item.keterangan : ''}</td>
                            </tr>
                        `);
                    });
                }

                // Save changes when 'Save Changes' button is clicked
                $(document).on('click', '#save-changes', function() {
                    var updates = [];

                    $('#materials-body tr').each(function() {
                        var id = $(this).data('id');
                        var qtyIn = $(this).find('.qty-in').val();

                        if (id && qtyIn) {
                            updates.push({ id: id, qty_in: qtyIn });
                        }
                    });

                    if (updates.length > 0) {
                        $.ajax({
                            url: '{{ route("updateQtyIndn") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                updates: updates
                            },
                            success: function(response) {
                                Swal.fire('Success', 'Quantity updated successfully.', 'success').then(function() {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error', 'Failed to update quantity.', 'error');
                            }
                        });
                    }
                });

                // Initialize QR code scanner
                var htmlScanner = new Html5QrcodeScanner(
                    "my-qr-reader", { fps: 10, qrbox: 250 }
                );

                // Render QR code scanner
                htmlScanner.render(onScanSuccess);
            });
        </script>
    </div>
</section>
@endsection
