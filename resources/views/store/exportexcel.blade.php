@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-8">
                    <h1 class="m-0 font-weight-bold text-black tracking-tight">
                        <i class="ph ph-export mr-2 text-cyan"></i>
                        Export Informasi Data Store Room
                    </h1>
                    <p class="text-muted mb-0 mt-1">Unduh laporan data departemen dalam format Excel secara efisien.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Stamping Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card glass-card h-100">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-emerald-soft text-emerald mr-3">
                                    <i class="ph-bold ph-factory text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="card-title font-weight-bold text-black mb-0">Dept Stamping</h3>
                                    <span class="text-xs text-emerald font-weight-bold uppercase tracking-wider"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-xs font-weight-bold text-gray-400 text-uppercase mb-1">Rentang
                                    Tanggal</label>
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="start_date" class="form-control glass-input"
                                        placeholder="Start Date">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar-check text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="end_date" class="form-control glass-input"
                                        placeholder="End Date">
                                </div>
                            </div>
                            <button class="btn btn-emerald w-100 py-2 font-weight-bold shadow-sm btn-hover-grow"
                                id="btn_export">
                                <i class="ph-bold ph-file-xls mr-2"></i> Export to Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Welding Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card glass-card h-100">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-cyan-soft text-cyan mr-3">
                                    <i class="ph-bold ph-lightning text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="card-title font-weight-bold text-black mb-0">Dept Welding</h3>
                                    <span class="text-xs text-cyan font-weight-bold uppercase tracking-wider"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-xs font-weight-bold text-gray-400 text-uppercase mb-1">Rentang
                                    Tanggal</label>
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="start_date2" class="form-control glass-input"
                                        placeholder="Start Date">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar-check text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="end_date2" class="form-control glass-input"
                                        placeholder="End Date">
                                </div>
                            </div>
                            <button class="btn btn-emerald w-100 py-2 font-weight-bold shadow-sm btn-hover-grow"
                                id="btn_export2">
                                <i class="ph-bold ph-file-xls mr-2"></i> Export to Excel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Production 2 Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card glass-card h-100">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-indigo-soft text-indigo mr-3">
                                    <i class="ph-bold ph-gear text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="card-title font-weight-bold text-black mb-0">Dept Production 2</h3>
                                    <span class="text-xs text-indigo font-weight-bold uppercase tracking-wider"> </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="text-xs font-weight-bold text-gray-400 text-uppercase mb-1">Rentang
                                    Tanggal</label>
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="start_date3" class="form-control glass-input"
                                        placeholder="Start Date">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group modern-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i
                                                class="ph ph-calendar-check text-cyan"></i></span>
                                    </div>
                                    <input type="date" id="end_date3" class="form-control glass-input"
                                        placeholder="End Date">
                                </div>
                            </div>
                            <button class="btn btn-emerald w-100 py-2 font-weight-bold shadow-sm btn-hover-grow"
                                id="btn_export3">
                                <i class="ph-bold ph-file-xls mr-2"></i> Export to Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                container: 'swal2-toast-container'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const handleExport = (startId, endId, routeUrl, params) => {
            var startDate = $(`#${startId}`).val();
            var endDate = $(`#${endId}`).val();

            if (startDate && endDate) {
                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Export',
                    text: 'Are you sure you want to export the data?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Export',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-emerald px-4 mr-2',
                        cancelButton: 'btn btn-outline-secondary px-4'
                    },
                    buttonsStyling: false,
                    background: '#1a1a1a',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let query = `?${params[0]}=${startDate}&${params[1]}=${endDate}`;
                        window.location.href = routeUrl + query;
                    }
                });
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Incomplete Date Range',
                    text: 'Please select a date range before exporting.'
                });
            }
        };

        $(document).on("click", "#btn_export", function () {
            handleExport('start_date', 'end_date', "{{ route('exportall.export') }}", ['start_date', 'end_date']);
        });

        $(document).on("click", "#btn_export2", function () {
            handleExport('start_date2', 'end_date2', "{{ route('exportall.export2') }}", ['start_date2', 'end_date2']);
        });

        $(document).on("click", "#btn_export3", function () {
            handleExport('start_date3', 'end_date3', "{{ route('exportall.export3') }}", ['start_date3', 'end_date3']);
        });
    </script>
@endpush

@push('stylesheets')
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --emerald: #10b981;
            --emerald-soft: rgba(16, 185, 129, 0.1);
            --cyan: #06b6d4;
            --cyan-soft: rgba(6, 182, 212, 0.1);
            --indigo: #6366f1;
            --indigo-soft: rgba(99, 102, 241, 0.1);
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid var(--glass-border) !important;
            color: #000 !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            height: auto !important;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--cyan) !important;
            box-shadow: 0 0 0 2px rgba(6, 182, 212, 0.2) !important;
        }

        .modern-input-group .input-group-text {
            border: 1px solid var(--glass-border);
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
            color: #6b7280;
        }

        .modern-input-group .glass-input {
            border-left: none !important;
            border-radius: 0 0.75rem 0.75rem 0 !important;
        }

        .btn-emerald {
            background-color: var(--emerald);
            color: #fff;
            border-radius: 0.75rem;
        }

        .btn-emerald:hover {
            background-color: #059669;
            color: #fff;
        }

        .btn-cyan {
            background-color: var(--cyan);
            color: #fff;
            border-radius: 0.75rem;
        }

        .btn-cyan:hover {
            background-color: #0891b2;
            color: #fff;
        }

        .btn-indigo {
            background-color: var(--indigo);
            color: #fff;
            border-radius: 0.75rem;
        }

        .btn-indigo:hover {
            background-color: #4f46e5;
            color: #fff;
        }

        .btn-hover-grow {
            transition: transform 0.2s;
        }

        .btn-hover-grow:hover {
            transform: scale(1.02);
        }

        .text-emerald {
            color: var(--emerald);
        }

        .text-cyan {
            color: var(--cyan);
        }

        .text-indigo {
            color: var(--indigo);
        }

        .bg-emerald-soft {
            background-color: var(--emerald-soft);
        }

        .bg-cyan-soft {
            background-color: var(--cyan-soft);
        }

        .bg-indigo-soft {
            background-color: var(--indigo-soft);
        }

        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        /* SweetAlert2 Dark Theme Tweak */
        .swal2-popup {
            border-radius: 1.25rem !important;
            border: 1px solid var(--glass-border) !important;
        }
    </style>
@endpush