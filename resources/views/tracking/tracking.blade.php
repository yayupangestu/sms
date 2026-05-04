@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="dist/css/tracking.css">

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tracking List</h1>
      </div>
      <div class="col-sm-6">
      
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Left Side: Tracking List -->
      <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <!-- Search Input and Button -->
                <div class="d-flex justify-content-end mb-3">
                    <input type="text" class="form-control w-50 mr-2" placeholder="Search ID">
                    <button class="btn btn-primary">Track your shipment</button>
                </div>
                <!-- Tracking List -->
             <!-- Left Side: Tracking List -->
             <ul class="list-group">
              @foreach($abilities as $ability)
              <li class="list-group-item d-flex justify-content-between align-items-center clickable" data-id="{{ $ability->uniqNo }}">
                  <div>
                      <span class="tracking-id">ID #{{ $ability->uniqNo }}</span>
                      <small class="text-muted">{{ $ability->created_at->format('d/m/Y') }}</small>
                  </div>
                  @if($ability->sts_proses4 == 4)
                      <a href="#" class="badge badge-success badge-pill">Completed</a>
                  @elseif($ability->sts_proses1 == 1)
                      <a href="#" class="badge badge-warning badge-pill">On Delivery</a>
                  @else
                      <a href="#" class="badge badge-secondary badge-pill">{{ $ability->status }}</a>
                  @endif
              </li>
              @endforeach
          </ul>
          
            </div>
        </div>
    </div>
    

      <!-- Right Side: Order Details -->
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
          </div>
          <div class="row">
            <!-- Order Status Progress -->
            <div class="col-md-12">
              <div class="step-tracker">
                <!-- Step 1: RAW MATERIAL -->


                <div class="step {{ $ability->sts_proses1 === null ? 'text-muted' : ($ability->sts_proses1 == 1 ? 'completed text-success' : '') }}">
                  <div class="step-icon {{ $ability->sts_proses1 === null ? 'text-muted' : ($ability->sts_proses1 == 1 ? 'text-success' : '') }}">
                      <span class="checkmark">{{ $ability->sts_proses1 === null ? '1' : '✓' }}</span>
                      @if ($ability->sts_proses1 == 1)
                          <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift" style="display: inline;">
                      @else
                          <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift" style="display: none;">
                      @endif
                  </div>
                  <div class="step-label">
                      <p>RAW MATERIAL</p>
                      <span>-</span>
                  </div>
              </div>

                  <!-- Step 2: SECOND STEP -->
                  <div class="step {{ $ability->sts_proses2 === null ? 'text-muted' : ($ability->sts_proses2 == 2 ? 'completed text-success' : '') }}">
                    <div class="step-icon {{ $ability->sts_proses2 === null ? 'text-muted' : ($ability->sts_proses2 == 2 ? 'text-success' : '') }}">
                        <span class="checkmark">{{ $ability->sts_proses2 === null ? '2' : '✓' }}</span>
                        @if ($ability->sts_proses2 == 2)
                            <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift2" style="display: inline;">
                        @else
                            <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift2" style="display: none;">
                        @endif
                    </div>
                    <div class="step-label">
                        <p>STAMPING</p>
                      <span>-</span>
                    </div>
                  </div>

                    <!-- Step 3: THIRD STEP -->
                    <div class="step {{ $ability->sts_proses3 === null ? 'text-muted' : ($ability->sts_proses3 == 3 ? 'completed text-success' : '') }}">
                      <div class="step-icon {{ $ability->sts_proses3 === null ? 'text-muted' : ($ability->sts_proses3 == 3 ? 'text-success' : '') }}">
                          <span class="checkmark">{{ $ability->sts_proses3 === null ? '3' : '✓' }}</span>
                          @if ($ability->sts_proses3 == 3)
                              <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift3" style="display: inline;">
                          @else
                              <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift3" style="display: none;">
                          @endif
                      </div>
                      <div class="step-label">
                          <p>TRANSIT</p>
                          <span>-</span>
                      </div>
                    </div>
                             <!-- Step 4: THIRD STEP -->
                 <div class="step">
                  <div class="step-icon">
                    <span>4</span>
                  </div>
                  <div class="step-label">
                    <p>LINE STORE</p>
                    <span>---</span>
                  </div>
                </div>
                <div class="step">
                  <div class="step-icon">
                    <span>5</span>
                  </div>
                  <div class="step-label">
                    <p>BUTTON PAS</p>
                    <span>---</span>
                  </div>
                </div>
                <div class="step">
                  <div class="step-icon">
                    <span>6</span>
                  </div>
                  <div class="step-label">
                    <p>WELDING SSW</p>
                    <span>---</span>
                  </div>
                </div>
                <div class="step">
                  <div class="step-icon">
                    <span>7</span>
                  </div>
                  <div class="step-label">
                    <p>WELDING PSW</p>
                    <span>---</span>
                  </div>
                </div>
                <div class="step">
                  <div class="step-icon">
                    <span>8</span>
                  </div>
                  <div class="step-label">
                    <p>TRANSIT</p>
                    <span>---</span>
                  </div>
                </div>
                       <!-- Step 3: THIRD STEP -->
                       <div class="step {{ $ability->sts_proses4 === null ? 'text-muted' : ($ability->sts_proses4 == 4 ? 'completed text-success' : '') }}">
                        <div class="step-icon {{ $ability->sts_proses4 === null ? 'text-muted' : ($ability->sts_proses4 == 4 ? 'text-success' : '') }}">
                            <span class="checkmark">{{ $ability->sts_proses4 === null ? '3' : '✓' }}</span>
                            @if ($ability->sts_proses4 == 4)
                                <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift4" style="display: inline;">
                            @else
                                <img src="dist/img/forklift2.png" alt="forklift" class="animated-truck" id="forklift4" style="display: none;">
                            @endif
                        </div>
                        <div class="step-label">
                            <p>PPIC</p>
                            <span>1 day estimate</span>
                        </div>
                      </div>
              </div>
            </div>

            <!-- Order Information -->
            <div class="col-md-3 order-info">
             <b><p style="font-size:90%; margin-left:10px">INFORMATION</p></b> 
              <p style="font-size:90%; margin-left:10px"><strong>Prepared By:</strong></p>
              <p style="font-size:90%; margin-left:10px">{{ $ability->scanrm_by }}</p>
              <p style="font-size:90%; margin-left:10px"><strong>Time</strong></p>
              <p style="font-size:90%; margin-left:10px">{{ $ability->created_at }}</p>
            </div>

            <!-- Location Information -->
            <div class="col-md-1 location-info">
              <b><p style="font-size:90%; margin-left:-170px;">INFORMATION</p></b> 
              <p style="font-size:90%; margin-left: -170px;"><strong>Pick UP:</strong></p>
              <p style="font-size:90%; margin-left: -170px;">{{ $ability->scanstmp_by }}</p>
              <p style="font-size:90%; margin-left: -170px;"><strong>Pick Up Time:</strong></p>
              <p style="font-size:90%; margin-left:-170px;">{{ $ability->created_at }}</p>
            </div>

            
            <!-- TRANSIT   Information -->
            <div class="col-md-1 location-info">
              <b><p style="font-size:90%; margin-left: -120px;">INFORMATION</p></b> 
              <p style="font-size:90%; margin-left: -120px"><strong>Prepared By:</strong></p>
              <p style="font-size:90%; margin-left:-120px;">{{ $ability->scanstmp_by }}</p>
              <p style="font-size:90%; margin-left: -120px;"><strong>Time:</strong></p>
              <p style="font-size:90%; margin-left:-120px;">{{ $ability->created_at }}</p>
              <p style="font-size:90%; margin-left: -120px;"><strong>LOCATION:</strong></p>
              <p style="font-size:90%; margin-left:-120px;">B3</p>
            </div>

                 <!-- LINE STORE  Information -->
                 <div class="col-md-1 location-info">
                  <b><p style="font-size:90%; margin-left: -80px;">INFORMATION</p></b> 
                  <p style="font-size:90%; margin-left: -80px"><strong>Prepared By:</strong></p>
                  <p style="font-size:90%; margin-left:-80px;">{{ $ability->scanstmp_by }}</p>
                  <p style="font-size:90%; margin-left: -80px;"><strong>Time:</strong></p>
                  <p style="font-size:90%; margin-left:-80px;">{{ $ability->created_at }}</p>
                </div> 
            

            <!-- Item List -->
            <div class="col-md-12 mt-3">
              <p style="font-size:200%; margin-left: 20px">Detail Tracking</p>
              <table class="table table-bordered" >
                <thead style="background-color: rgb(225, 225, 225); color:rgb(0, 0, 0)">
                  <tr>
                    <th>No</th>
                    <th>PART NO</th>
                    <th>JOB NO</th>
                    <th>QUANTITY OK</th>
                    <th>QUANTITY NG</th>
                    <th>TIME KANBAN</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>{{ $ability->part_kbn_1 }}</td>
                    <td>{{ $ability->job_kbn_1 }}</td>
                    <td>{{ $ability->qty_kbn_1 }}</td>
                    <td>{{ $ability->pallet_kbn_1 }}</td>
                    <td>{{ $ability->waktu_kbn_1 }}</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>{{ $ability->part_kbn_2 }}</td>
                    <td>{{ $ability->job_kbn_2 }}</td>
                    <td>{{ $ability->qty_kbn_2 }}</td>
                    <td>{{ $ability->pallet_kbn_2 }}</td>
                    <td>{{ $ability->waktu_kbn_2 }}</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>{{ $ability->part_kbn_3 }}</td>
                    <td>{{ $ability->job_kbn_3 }}</td>
                    <td>{{ $ability->qty_kbn_3 }}</td>
                    <td>{{ $ability->pallet_kbn_3 }}</td>
                    <td>{{ $ability->waktu_kbn_3 }}</td>
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


</body>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>


document.addEventListener("DOMContentLoaded", function() {
    // Function to perform AJAX request and update only the step-tracker
    function fetchStepTrackerUpdate() {
        $.ajax({
            url: "{{ route('abilities.update') }}", // Route to get updated abilities data
            method: 'GET',
            success: function(response) {
                response.forEach(function(ability) {
                    var stepClass1 = ability.sts_proses1 === null ? 'text-muted' : (ability.sts_proses1 == 1 ? 'completed text-success' : '');
                    var stepClass2 = ability.sts_proses2 === null ? 'text-muted' : (ability.sts_proses2 == 2 ? 'completed text-success' : '');
                    var stepClass3 = ability.sts_proses3 === null ? 'text-muted' : (ability.sts_proses3 == 3 ? 'completed text-success' : '');
                    var stepClass8 = ability.sts_proses4 === null ? 'text-muted' : (ability.sts_proses4 == 4 ? 'completed text-success' : '');

                    // Update the step tracker for the first step
                    var $step1 = $('.step-tracker').find('.step').eq(0); // Get first step
                    $step1.removeClass().addClass('step ' + stepClass1);
                    $step1.find('.checkmark').text(ability.sts_proses1 === null ? '1' : '✓');
                    $step1.find('#forklift').css('display', ability.sts_proses1 == 1 ? 'inline' : 'none');

                    // Update the step tracker for the second step
                    var $step2 = $('.step-tracker').find('.step').eq(1); // Get second step
                    $step2.removeClass().addClass('step ' + stepClass2);
                    $step2.find('.checkmark').text(ability.sts_proses2 === null ? '2' : '✓');
                    $step2.find('#forklift2').css('display', ability.sts_proses2 == 2 ? 'inline' : 'none');

                    // Update the step tracker for the third step
                    var $step3 = $('.step-tracker').find('.step').eq(2); // Get third step
                    $step3.removeClass().addClass('step ' + stepClass3);
                    $step3.find('.checkmark').text(ability.sts_proses3 === null ? '3' : '✓');
                    $step3.find('#forklift3').css('display', ability.sts_proses3 == 3 ? 'inline' : 'none');

                    // Update the step tracker for the fourth step
                    var $step8 = $('.step-tracker').find('.step').eq(3); // Get fourth step
                    $step8.removeClass().addClass('step ' + stepClass8);
                    $step8.find('.checkmark').text(ability.sts_proses4 === null ? '4' : '✓');
                    $step8.find('#forklift4').css('display', ability.sts_proses4 == 4 ? 'inline' : 'none');
                });
            },
            error: function() {
                console.error('Failed to fetch updates.');
            }
        });
    }

    // Call the fetchStepTrackerUpdate function every 5 seconds
    setInterval(fetchStepTrackerUpdate, 5000); // Polling every 5000ms (5 seconds)
});


</script>


@endsection
