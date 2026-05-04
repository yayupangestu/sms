@extends('layouts.app')

@section('content')

    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f1f5f9;
            --glass: rgba(255, 255, 255, 0.8);
            --card-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: var(--bg-main);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.03) 0, transparent 50%),
                radial-gradient(at 50% 0%, rgba(59, 130, 246, 0.03) 0, transparent 50%);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        /* Content Header */
        .content-header {
            padding: 2rem 0 1.5rem;
        }

        .content-header h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 12px;
            color: var(--accent);
            box-shadow: var(--shadow-sm);
        }

        /* Premium Stat Cards */
        .stat-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--card-radius);
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle at top right, var(--accent-glow), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        /* Enhanced Table Container */
        .card-glass {
            background: var(--glass);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .table-header-custom {
            background: var(--primary);
            color: white;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Table Grid Styling */
        .table {
            border-collapse: collapse !important;
            width: 100% !important;
            background: white !important;
            border: 1px solid #cbd5e1 !important;
        }

        .table thead th {
            background: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 1rem !important;
            text-align: center;
        }

        .table tbody td {
            border: 1px solid #e2e8f0 !important;
            padding: 1rem !important;
            font-size: 0.875rem;
            color: #1e293b;
            font-weight: 500;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc !important;
            transition: var(--transition);
        }

        .td-part-no {
            font-weight: 700;
            color: var(--primary);
        }

        /* Badge Customization */
        .mrp-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-active {
            background: #ecfdf5;
            color: #059669;
        }

        .badge-rundout {
            background: #fff1f2;
            color: #e11d48;
        }

        /* Fancy Buttons */
        .btn-premium {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.39);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.23);
            color: white;
        }

        .btn-icon-only {
            width: 38px;
            height: 38px;
            padding: 0;
            justify-content: center;
        }

        /* Clock Tooltip */
        .clock-container {
            background: white;
            padding: 8px 16px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            font-weight: 700;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Modal Overrides */
        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .modal-header-glass {
            background: var(--primary);
            color: white;
            padding: 1.5rem 2.5rem;
            border: none;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h1>
                        <div class="header-icon"><i class="fas fa-layer-group"></i></div>
                        LIST MATERIAL MPC
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="clock-container">
                        <i class="far fa-clock text-accent"></i>
                        <span id="current-time">00:00:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Stats Row -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #e0f2fe; color: #0369a1;">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div>
                            <div class="stat-label">Total Materials</div>
                            <div class="stat-value" id="stat-total-part">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #dcfce7; color: #15803d;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Active Status</div>
                            <div class="stat-value text-success" id="stat-active">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #fee2e2; color: #991b1b;">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Rundout Alert</div>
                            <div class="stat-value text-danger" id="stat-rundout">0</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div>
                            <div class="stat-label">Queue Total</div>
                            <div class="stat-value text-accent" id="stat-labels">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-glass">
                        <div class="table-header-custom">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list-ul mr-2"></i> Material Master List
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-light px-3 py-2">LIVE DATA FEED</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive p-4">
                                <table id="example1" class="table align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th width="40">#</th>
                                            <th>Part Name</th>
                                            <th>Part No</th>
                                            <th>Job No</th>
                                            <th>Model</th>
                                            <th>Specification</th>
                                            <th class="text-center">T</th>
                                            <th class="text-center">W</th>
                                            <th class="text-center">L</th>
                                            <th class="text-center">KG</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Qty Label</th>
                                            <th width="100" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center modal-header-glass">
                    <div class="flex-grow-1">
                        <h4 class="modal-title font-weight-bold" id="title1"
                            style="display: flex; align-items: center; gap: 10px;">
                            <div class="badge bg-success-light text-success p-2 rounded-lg"
                                style="background: rgba(16, 185, 129, 0.1);"><i class="fas fa-plus-circle"></i></div>
                            Create Kanban Label
                        </h4>
                        <h4 class="modal-title font-weight-bold" id="title2"
                            style="display:none; align-items: center; gap: 10px;">
                            <div class="badge bg-warning-light text-warning p-2 rounded-lg"
                                style="background: rgba(245, 158, 11, 0.1);"><i class="fas fa-edit"></i></div>
                            Material Detail & History
                        </h4>
                    </div>
                    <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div id="alert"></div>

                    <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted font-weight-bold mb-3 small">Part Information</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="small font-weight-bold text-muted">Part Name</label>
                                            <input type="text" class="form-control" id="part_name" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small font-weight-bold text-muted">Part No</label>
                                            <input type="text" class="form-control font-weight-bold" id="part_no" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small font-weight-bold text-muted">Job No</label>
                                            <input type="text" class="form-control" id="job_no" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small font-weight-bold text-muted">Model</label>
                                            <input type="text" class="form-control" id="model_id" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small font-weight-bold text-muted">Spec</label>
                                            <input type="text" class="form-control" id="spek" readonly>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold text-muted">T (Thick)</label>
                                            <input type="text" class="form-control" id="spek_t" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold text-muted">W (Width)</label>
                                            <input type="text" class="form-control" id="spek_w" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold text-muted">L (Length)</label>
                                            <input type="text" class="form-control" id="spek_l" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small font-weight-bold text-muted">KG</label>
                                            <input type="text" class="form-control" id="spek_kg" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card border-0 shadow-sm h-100"
                                style="border-top: 4px solid var(--accent-indigo) !important;">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted font-weight-bold mb-3 small">Label Configuration
                                    </h6>
                                    <form id="insertForm">
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold">Supplier</label>
                                            <select id="supplier" class="form-control border-indigo" required>
                                                <option value="" selected disabled>- select supplier -</option>
                                                <option value="POSCO-1">POSCO-1</option>
                                                <option value="POSCO-2">POSCO-2</option>
                                                <option value="TTMI">TTMI</option>
                                                <option value="SSK">SSK</option>
                                                <option value="SCI">SCI</option>
                                                <option value="HTI">HTI</option>
                                                <option value="SAI">SAI</option>
                                                <option value="JSSI">JSSI</option>
                                                <option value="USC">USC</option>
                                                <option value="ASI-2">ASI-2</option>
                                                <option value="TCF">TCF</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="small font-weight-bold">Category</label>
                                                <select id="category" class="form-control" required>
                                                    <option value="1">RM (Raw Material)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label class="small font-weight-bold text-primary">Quantity to Print</label>
                                                <input type="number" class="form-control border-primary" id="actual_sheet"
                                                    placeholder="0" required>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="btn-premium btn-block Save mt-2 justify-content-center">
                                            <i class="fas fa-plus"></i> GENERATE NEW TAGS
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white py-3 d-flex align-items-center"
                            style="background: white !important; color: #475569 !important;">
                            <h6 class="mb-0 font-weight-bold flex-grow-1"><i class="fas fa-history mr-2 text-indigo"></i>
                                Label History & Printing</h6>
                            <button id="btn_generate_all" class="btn-premium btn-sm"
                                style="background: var(--accent); color: white;">
                                <i class="fas fa-qrcode"></i> Print Selected (PDF)
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive p-3">
                                <table id="example2" class="table table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" id="selectAll"></th>
                                            <th>No</th>
                                            <th>Doc PO</th>
                                            <th>Part No</th>
                                            <th>Actual</th>
                                            <th>Spec</th>
                                            <th>KG</th>
                                            <th>Update Time</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" id="uniqNo" name="uniqNo">
    <input type="hidden" id="actual_kg" name="actual_kg">
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function () {
            list();
            startClock();
            updateStats();
        });

        function startClock() {
            setInterval(() => {
                const now = new Date();
                $('#current-time').text(now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' }));
            }, 1000);
        }

        function updateStats() {
            $('#example1').on('draw.dt', function () {
                const table = $('#example1').DataTable();
                const info = table.page.info();
                const json = table.ajax.json();

                $('#stat-total-part').text(info.recordsTotal);

                // Use the total rundout count provided by the server
                const totalRundouts = json.rundoutTotal || 0;

                // Update the UI
                $('#stat-rundout').text(totalRundouts);
                $('#stat-active').text(info.recordsTotal - totalRundouts);
            });

            $(document).on('change', '.dataCheckbox', function () {
                $('#stat-labels').text($('.dataCheckbox:checked').length);
            });
        }

        document.getElementById('insertForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            console.log('Form submitted');

            // Ambil data form menggunakan FormData
            let formData = new FormData(this);

            // Gantilah '/your-endpoint' dengan URL tujuan yang sesuai
            fetch('/your-endpoint', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Lakukan sesuatu dengan responnya
                })
                .catch(error => console.error('Error:', error));
        });


        $(document).on('click', '#selectAll', function () {
            const isChecked = this.checked;

            $('.dataCheckbox').each(function () {
                const sts = $(this).data('sts');
                if (sts != 1) {
                    $(this).prop('checked', isChecked);
                } else {
                    $(this).prop('checked', false); // jangan check jika sudah scan
                }
            });
        });




        $(document).on('click', '#btn_generate_all', function (e) {
            e.preventDefault();

            const selectedIds = [];
            $('.dataCheckbox:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Pilih setidaknya satu data untuk generate QR Code!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            // ✅ Tampilkan loading saat proses
            Swal.fire({
                title: 'Generating QR Codes...',
                html: `<img src="{{ asset('dist/img/Hourglass.gif') }}" width="50"><br>Silakan tunggu...`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('taglabel2.generateMultipleQrCodes') }}",
                method: 'POST',
                xhrFields: {
                    responseType: 'blob' // penting agar file binary (PDF) bisa diproses
                },
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.close(); // ❌ Tutup loading

                    const blob = new Blob([response], { type: 'application/pdf' });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'labelOpsional_' + new Date().toISOString().slice(0, 10) + '.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function (xhr) {
                    Swal.close();

                    let errorMsg = 'Terjadi kesalahan saat memproses data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        showConfirmButton: true
                    });
                }
            });
        });



        function list() {
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: false,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 15,
                ajax: {
                    url: "{{ route('taglabel2.list') }}"
                },
                columns: [{
                    data: null,
                    sortable: false,
                    searchable: false,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'part_name',
                    name: 'part_name'
                },
                {
                    data: 'part_no',
                    name: 'part_no',
                    render: function (data) {
                        return `<span class="td-part-no">${data}</span>`;
                    }
                },
                // {
                //     data: 'part_no2',
                //     name: 'part_no2'
                // },
                {
                    data: 'job_no',
                    name: 'job_no'
                },
                {
                    data: 'model_id',
                    name: 'model_id'
                },
                // {
                //     data: 'category_id',
                //     name: 'category_id'
                // },
                {
                    data: 'spek',
                    name: 'spek'
                },
                {
                    data: 'spek_t',
                    name: 'spek_t'
                },
                {
                    data: 'spek_w',
                    name: 'spek_w'
                },
                {
                    data: 'spek_l',
                    name: 'spek_l'
                },
                {
                    data: 'spek_kg',
                    name: 'spek_kg'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    className: 'text-center',
                    render: function (data) {
                        if (data == 2) {
                            return '<span class="mrp-badge badge-rundout"><i class="fas fa-exclamation-triangle"></i> Rundout</span>';
                        } else {
                            return '<span class="mrp-badge badge-active"><i class="fas fa-check-circle"></i> Active</span>';
                        }
                    }
                },
                {
                    data: 'part_count',
                    name: 'part_count',
                    className: 'text-center',
                    render: function (data) {
                        return `
                                        <div style="display: inline-flex; gap: 6px;">
                                            <span class="mrp-badge" style="background: rgba(3, 105, 161, 0.1); color: #0369a1;">${data.count1}</span>
                                            <span class="mrp-badge" style="background: rgba(67, 56, 202, 0.1); color: #4338ca;">${data.count2}</span>
                                        </div>
                                    `;
                    }
                },

                {
                    data: 'id',
                    name: 'id',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return `
                                                        <button id="btn_edit" title="Manage Labels"
                                                        data-id="${data}"
                                                        data-partno="${row.part_no}"
                                                        class="btn btn-premium btn-sm btn-icon-only">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </button>
                                                    `;
                    }
                }
                ],
                columnDefs: [{
                    "targets": [0],
                    "orderable": false,
                }],
                responsive: true,
                fixedColumns: true,
                oLanguage: {
                    sProcessing: '<img src="{{ asset('dist/img/Hourglass.gif') }}">Loading . . .'
                }
            });
        }

        $(document).on("click", "#btn_edit", function () {
            $(".Save").show();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();

            var id = $(this).data('id');
            var partNo = $(this).data('partno');

            $.ajax({
                type: 'GET',
                url: "{{ route('taglabel2.getdatabypart') }}",
                data: {
                    part_no: partNo
                },
                success: function (result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });

                        $('#id').val(result.id);
                        // $('#material_id').val(result.material_id).trigger('change');
                        $('#part_name').val(result.part_name).trigger('change');
                        $('#part_no').val(result.part_no).trigger('change');
                        $('#job_no').val(result.job_no).trigger('change');
                        $('#model_id').val(result.model_id).trigger('change');
                        $('#spek').val(result.spek).trigger('change');
                        $('#spek_t').val(result.spek_t).trigger('change');
                        $('#spek_w').val(result.spek_w).trigger('change');
                        $('#spek_l').val(result.spek_l).trigger('change');
                        $('#spek_kg').val(result.spek_kg).trigger('change');
                        $('#uniqNo').val(result.uniqNo).trigger('change');
                        $('#keterangan').val(result.keterangan).trigger('change');

                        listdetail(result.part_no);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: result.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });





        function listdetail(part_no) {
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                searching: true,
                bLengthChange: true,
                destroy: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('taglabel2.listdetail') }}",
                    type: "GET",
                    data: {
                        part_no: part_no
                    }
                },
                order: [[9, 'desc']], // Sort by ID for latest entry
                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="dataCheckbox" value="${data}" data-sts="${row.sts}">`;
                        }
                    },

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'doc_po', name: 'doc_po' },
                    {
                        data: 'part_no',
                        name: 'part_no',
                        render: function (data) {
                            return `<span class="td-part-no">${data}</span>`;
                        }
                    },
                    {
                        data: 'actual_sheet',
                        name: 'actual_sheet',
                        render: function (data) {
                            return `<span class="badge" style="background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; min-width: 45px;">${data}</span>`;
                        }
                    },
                    { data: 'spek', name: 'spek', className: 'text-center' },
                    { data: 'actual_kg', name: 'actual_kg', className: 'text-center' },
                    { data: 'tanggal', name: 'tanggal', className: 'text-center' },
                    {
                        data: 'sts',
                        name: 'sts',
                        render: function (data) {
                            if (data == 1) {
                                return `<span class="mrp-badge badge-active"><i class="fas fa-barcode"></i> SCANNED</span>`;
                            } else if (data == 2) {
                                return `<span class="mrp-badge badge-rundout"><i class="fas fa-exclamation-triangle"></i> RUNDOUT</span>`;
                            } else {
                                return `<span class="mrp-badge" style="background: #fef3c7; color: #b45309;"><i class="fas fa-clock"></i> PENDING</span>`;
                            }
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function (data, type, row) {
                            const disabled = row.sts == 1 ? 'disabled' : '';
                            return `
                                                    <a href="#" id="btn_delete_line" title="Delete" data-id="${data}" class="btn btn-danger btn-sm ${disabled}">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>`;
                        }
                    }
                ],
                columnDefs: [
                    { targets: [0], orderable: false }
                ],
                drawCallback: function (settings) {
                    // Update main Rundout counter based on this specific part's rundout count if needed
                    // Or just let the user know how many rundout in this list
                    let rundouts = 0;
                    this.api().rows().every(function () {
                        if (this.data().sts == 2) rundouts++;
                    });
                    $('#stat-rundout').text(rundouts); // Updating the dashboard card with this context
                },
                oLanguage: {
                    sProcessing: '<img src="/dist/img/Hourglass.gif"> Loading . . .'
                }
            });
        }




        $(document).on("click", ".Save", function () {
            $("#alert").html('');
            $("#alert").show();

            if (validasi()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('taglabel2.store') }}",
                    data: {
                        part_name: part_name.value,
                        part_no: part_no.value,
                        job_no: job_no.value,
                        model_id: model_id.value,
                        spek: spek.value,
                        spek_t: spek_t.value,
                        spek_w: spek_w.value,
                        spek_l: spek_l.value,
                        spek_kg: spek_kg.value,
                        actual_sheet: actual_sheet.value,
                        uniqNo: uniqNo.value,
                        supplier: supplier.value,
                        actual_kg: actual_kg.value,
                        category: category.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        if (result.success) {
                            // Tambahkan SweetAlert success
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: result.msg,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Refresh listdetail dengan part_no yang baru saja diinput
                            listdetail(part_no.value);

                            // Bersihkan form dan alert
                            list();
                            clear();
                            $("#alert").hide();
                        } else {
                            // SweetAlert untuk error
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: result.msg,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $("#alert").html(
                                '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                                result.msg + '</div>'
                            );
                            setTimeout(() => {
                                $("#alert").hide();
                            }, 1500);
                        }
                    }
                });
            }
        });

        function clear() {
            $("#id").val('');

            $("#actual_sheet").val('');
            // $("#qty_ng").val('');
            // $('#material_id').val('').trigger('change');
        }

        // // Select all buttons with the 'line-filter-btn' class
        // const buttons = document.querySelectorAll('.line-filter-btn');

        // buttons.forEach(button => {
        //     // Add click event listener to each button
        //     button.addEventListener('click', function() {
        //         // Remove the 'active' class from all buttons
        //         buttons.forEach(btn => btn.classList.remove('active'));

        //         // Add 'active' class to the clicked button
        //         this.classList.add('active');
        //     });
        // });

        // // Menyimpan referensi ke elemen
        // const fileInput = document.getElementById('fileInput');
        // const importButton = document.getElementById('importButton');
        // // Menonaktifkan tombol jika tidak ada file yang dipilih
        // fileInput.addEventListener('change', function() {
        //     if (fileInput.files.length > 0) {
        //         importButton.disabled = false; // Aktifkan tombol jika ada file yang dipilih
        //     } else {
        //         importButton.disabled = true; // Nonaktifkan tombol jika tidak ada file
        //     }
        // });

        // document.getElementById('importForm').addEventListener('submit', function(event) {
        //     event.preventDefault(); // Mencegah pengiriman formulir default

        //     // Tampilkan SweetAlert konfirmasi
        //     Swal.fire({
        //         title: 'Konfirmasi',
        //         text: 'Apakah Anda yakin ingin mengimpor Data?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya, impor!',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             this.submit(); // Kirim formulir jika pengguna mengonfirmasi
        //         }
        //     });
        // });


        // function importData() {
        //     let formData = new FormData();
        //     formData.append('file', document.getElementById('fileInput').files[0]);

        //     $.ajax({
        //         url: "{{ route('partname.importDp') }}", // Replace with your route name
        //         type: 'POST',
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: function(response) {
        //             console.log(response); // Add this line
        //             if (response.success) {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Berhasil!',
        //                     text: response.message,
        //                     timer: 2000,
        //                     showConfirmButton: false
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Gagal',
        //                     text: response.message
        //                 });
        //             }
        //         },

        //         error: function(error) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Error',
        //                 text: 'Terjadi kesalahan saat mengimpor data.'
        //             });
        //         }
        //     });
        // }



        function validasi() {
            if (actual_sheet.value !== '' && category.value !== '' && supplier.value !== '') {
                return true;
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Tolong isi Kolomnya',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                return false;
            }
        }


        $(document).on("click", "#btn_delete_line", function () {
            var id = $(this).data('id');
            var part_no = $('#part_no').val(); // Ambil nilai part_no yang sedang aktif

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('taglabel2.destroyline') }}",
                        data: { id: id, _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }

                            // ✅ Pastikan part_no dikirim ke fungsi listdetail
                            listdetail(part_no);
                        }
                    });
                }
            });
        });


    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush


