@extends('layouts.app')

@section('content')

<!-- Add Tailwind and Font Awesome -->
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>

@media (max-width: 780px) {
    .ml-4 {
        margin-left: 0;
    }
}
      .step-box {
        position: relative;
        padding-left: 2.5rem;
        margin-bottom: 2rem;
    }

    /* Create vertical lines between the boxes */
    .step-box::before {
        content: '';
        position: absolute;
        left: 1.25rem; /* Adjust this for correct alignment */
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #9CA3AF; /* Light gray for the line */
        z-index: -1;
    }

    /* Hide the line for the last box */
    .step-box:last-child::before {
        display: none;
    }

    /* Circle for each step */
    .step-icon {
        position: absolute;
        left: 1.25rem; /* Align with the line */
        top: 0;
        transform: translateY(0.25rem); /* Adjust to align with text */
        background-color: #f1f1f1; /* Green color */
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">INFORMATION PROCESS</h1>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #122d3f; color:#ffffff">
                        <h3 class="card-title">Get Information Process</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               <!-- Form Section -->
                            <div class="form-group row">
                                <div class="col-12" id="alert"></div>
                                
                                <!-- Start Date -->
                                <label class="col-sm-1 col-form-label">Start Date :</label>
                                <div class="col-sm-2">
                                    <input type="date" id="start_date" class="form-control form-control-sm" required>
                                </div>

                                <!-- End Date -->
                                <label class="col-sm-1 col-form-label">End Date :</label>
                                <div class="col-sm-2">
                                    <input type="date" id="end_date" class="form-control form-control-sm" required>
                                </div>

                                <!-- Spek Filter -->
                                <label class="col-sm-1 col-form-label">Spek :</label>
                                <div class="col-sm-2">
                                    <select id="spek_id" class="form-control select2" required>
                                        <option value="">-Part No-</option>
                                        <option value="57635/36-BZ150/120">57635/36-BZ150/120</option>
                                        <option value="58315/16-BZ100/030">58315/16-BZ100/030</option>
                                        <option value="57465-BZ070">57465-BZ070</option>
                                        <option value="57634-BZ070">57634-BZ070</option>
                                        <option value="57414-BZ100">57414-BZ100</option>
                                        <option value="57413-BZ100">57413-BZ100</option>
                                        <option value="57633/34-BZ070/60">57633/34-BZ070/60</option>
                                        <option value="57441-BZ090">57441-BZ090</option>
                                        <option value="51969-BZ180">51969-BZ180</option>
                                        <option value="57646-BZ110">57646-BZ110</option>
                                        <option value="58377-BZ040">58377-BZ040</option>
                                        <option value="51969-BZ130">51969-BZ130</option>
                                        <option value="58377-BZ050">58377-BZ050</option>
                                        <option value="58227-BZ040">58227-BZ040</option>
                                        <option value="57634-BZ080">57634-BZ080</option>
                                        <!-- Add other spek options -->
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>

                            </div>

                            <!-- Step Process UI starts here -->
                            <div class="bg-white rounded-lg shadow p-6 w-full">
                                <div class="relative">
                                    <div class="absolute left-0 top-0 h-full w-1 bg-gray-200"></div>
                                    <div class="relative pl-8" id="step-process-content"></div>
                                </div>
                            </div>
                            <!-- Step Process UI ends here -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
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
      $(document).ready(function() {
    $("#example1").hide();

    $(document).ready(function() {
        $('#spek_id').select2();
        });

            $(document).on("click", "#btn_search", function () {
                // Ensure start_date, end_date, and line_id are provided before performing the search
                if ($('#start_date').val() !== '' && $('#end_date').val() !== '' && $('#part_kbn_1').val() !== '') {
                    $("#example1").show();
                    list();
                } else {
                    $("#example1").hide();
                }
            });
        });



function list() {
    let processHTML = '';
    let no = 1;

    $.ajax({
        type: 'GET',
        url: "{{ route('proses1.list') }}",
        data: {
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            // line_id: $('#line_id').val(),
            part_kbn_1: $('#spek_id').val() // Optional filter for 'spek'
        },
        success: function(result) {
            $.each(result.data, function(key, value) {
                const date_id = value.date_id || '';
                const uniqNo = value.uniqNo || '';
                        const name_material = value.name_material || '';
                        const qty_out = value.qty_out || '';
                        const suplier = value.suplier || '';
                        const scanrm_by = value.scanrm_by || '';
                        const name_material_in_stmp = value.name_material_in_stmp || '';
                        const scanstmp_by = value.scanstmp_by || '';
                        const part_kbn_1 = value.part_kbn_1 || '';
                        const job_kbn_1 = value.job_kbn_1 || '';
                        const qty_kbn_1 = value.qty_kbn_1 || '';
                        const waktu_kbn_1 = value.waktu_kbn_1 || '';
                        const part_kbn_2 = value.part_kbn_2 || '';
                        const job_kbn_2 = value.job_kbn_2 || '';
                        const qty_kbn_2 = value.qty_kbn_2 || '';
                        const waktu_kbn_2 = value.waktu_kbn_2 || '';
                        const part_kbn_3 = value.part_kbn_3 || '';
                        const job_kbn_3 = value.job_kbn_3 || '';
                        const qty_kbn_3 = value.qty_kbn_3 || '';
                        const waktu_kbn_3 = value.waktu_kbn_3 || '';
                        const part_pcs1 = value.part_pcs1 || '';
                        const job_pcs1 = value.job_pcs1 || '';
                        const qty_pcs1 = value.qty_pcs1 || '';
                        const waktu_pcs1 = value.waktu_pcs1 || '';
                        const in_pcs1_job = value.in_pcs1_job || '';
                        const in_pcs1_no = value.in_pcs1_no || '';
                        const in_pcs1_qty = value.in_pcs1_qty || '';
                        const in_pcs1_waktu = value.in_pcs1_waktu || '';
                        const job_no_outpcs1 = value.job_no_outpcs1 || '';
                        const part_no_outpcs1 = value.part_no_outpcs1 || '';
                        const qty_outpcs1 = value.qty_outpcs1 || '';
                        const cycle_outpcs1 = value.cycle_outpcs1 || '';
                        const area_outpcs1 = value.area_outpcs1 || '';
                        processHTML += `
    <div class="flex flex-wrap items-center mb-4">
        <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-xs"></i>
        </div>
        
        <!-- RAW MATERIAL -->
        <div class="ml-4 bg-[#cce7ff] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">DATE: ${date_id}</h6>
            <h6 class="text-green-700">RAW MATERIAL:</h6>
            <p class="text-dark-500 text-sm">Uniq No: ${uniqNo}</p>
            <p class="text-dark-500 text-sm">Supplier: ${suplier}</p>
            <p class="text-dark-500 text-sm">Qty Out: ${qty_out}</p>
            <p class="text-dark-500 text-sm">Scanned by: ${scanrm_by}</p>
              <p class="text-dark-500 text-sm">-</p>
              <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- STAMPING IN -->
        <div class="ml-4 bg-[#f5f9ca] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">DATE: ${date_id}</h6>
            <h6 class="text-green-700">STAMPING IN:</h6>
            <p class="text-dark-500 text-sm">Uniq No: ${uniqNo}</p>
            <p class="text-dark-500 text-sm">Supplier: ${suplier}</p>
            <p class="text-dark-500 text-sm">Qty In: ${qty_out}</p>
            <p class="text-dark-500 text-sm">Scanned by: ${scanrm_by}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- KANBAN 1 -->
        <div class="ml-4 bg-[#f5f9ca] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">PROSES: ${date_id}</h6>
            <h6 class="text-green-700">KANBAN 1:</h6>
            <p class="text-dark-500 text-sm">Part No: ${part_kbn_1}</p>
            <p class="text-dark-500 text-sm">Job No: ${job_kbn_1}</p>
            <p class="text-dark-500 text-sm">Qty by: ${qty_kbn_1}</p>
            <p class="text-dark-500 text-sm">Time: ${waktu_kbn_1}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- KANBAN 2 -->
        <div class="ml-4 bg-[#f5f9ca] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">PROSES: ${date_id}</h6>
            <h6 class="text-green-700">KANBAN 2:</h6>
            <p class="text-dark-500 text-sm">Part No: ${part_kbn_2}</p>
            <p class="text-dark-500 text-sm">Job No: ${job_kbn_2}</p>
            <p class="text-dark-500 text-sm">Qty by: ${qty_kbn_2}</p>
            <p class="text-dark-500 text-sm">Time: ${waktu_kbn_2}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- KANBAN 3 -->
        <div class="ml-4 bg-[#f5f9ca] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">PROSES: ${date_id}</h6>
            <h6 class="text-green-700">KANBAN 3:</h6>
            <p class="text-dark-500 text-sm">Part No: ${part_kbn_3}</p>
            <p class="text-dark-500 text-sm">Job No: ${job_kbn_3}</p>
            <p class="text-dark-500 text-sm">Qty by: ${qty_kbn_3}</p>
            <p class="text-dark-500 text-sm">Time: ${waktu_kbn_3}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- LINE STORE -->
         <div class="ml-4 bg-[#c2ffd2] p-2 rounded w-full md:w-auto">
            <h6 class="text-dark-700">PROSES: ${date_id}</h6>
            <h6 class="text-dark-700">LINE STORE:</h6>
            <p class="text-dark-500 text-sm">Part No: ${part_kbn_3}</p>
            <p class="text-dark-500 text-sm">Job No: ${job_kbn_3}</p>
            <p class="text-dark-500 text-sm">Qty by: ${qty_kbn_3}</p>
            <p class="text-dark-500 text-sm">Time: ${waktu_kbn_3}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

              <!-- Welding 3 -->
        <div class="ml-4 bg-[#f5f9ca] p-2 rounded w-full md:w-auto">
            <h6 class="text-green-700">PROSES: ${date_id}</h6>
            <h6 class="text-green-700">Welding:</h6>
            <p class="text-dark-500 text-sm">Part No: ${part_kbn_3}</p>
            <p class="text-dark-500 text-sm">Job No: ${job_kbn_3}</p>
            <p class="text-dark-500 text-sm">Qty by: ${qty_kbn_3}</p>
            <p class="text-dark-500 text-sm">Time: ${waktu_kbn_3}</p>
            <p class="text-dark-500 text-sm">-</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

        <!-- KANBAN 4 DARK MODE -->
        <div class="ml-4 bg-[#76b285] p-2 rounded w-full md:w-auto">
            <h6 class="text-white text-sm">PROSES: ${date_id}</h6>
            <h6 class="text-white text-sm">PC-STORE:</h6>
            <p class="text-white text-sm">Uniq No: ${uniqNo}</p>
            <p class="text-white text-sm">Supplier: ${part_pcs1}</p>
            <p class="text-white text-sm">Qty Out: ${job_pcs1}</p>
            <p class="text-white text-sm">Scanned by:User</p>
            <p class="text-white text-sm">Time: ${waktu_pcs1}</p>
            <p class="text-dark-500 text-sm">-</p>
        </div>

          <!-- Cycle DARK MODE -->
        <div class="ml-4 bg-[#cce7ff] p-2 rounded w-full md:w-auto">
         <h6 class="text-dark text-sm">PROSES: ${date_id}</h6>
         <h6 class="text-dark text-sm">Preparation:</h6>
         <p class="text-dark text-sm">Uniq No: ${job_no_outpcs1}</p>
         <p class="text-dark text-sm">Supplier: ${part_no_outpcs1}</p>
         <p class="text-dark text-sm">Qty Out: ${qty_outpcs1}</p>
          <p class="text-dark text-sm">Cycle: ${cycle_outpcs1}</p>
          <p class="text-dark text-sm">Area: ${area_outpcs1}</p>
            <p class="text-dark text-sm">Scanned by:User</p>
        </div>
    </div>
`;
                no++;
            });

            $("#step-process-content").html(processHTML);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            $("#alert").html('<div class="alert alert-danger">Failed to fetch data. Please try again.');
        }
    });
}


        function clear() {
            $("#id").val('');
            $("#date_id").val('');
            $('#line_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $('#material_id').val('').trigger('change');
            $("#qty_plan").val('');
        }
    </script>
@endpush

@push('stylesheets')
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
