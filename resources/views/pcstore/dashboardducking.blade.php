@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">DASHBOARD DELIVERY</h1>
      </div>
      <div class="col-sm-6 d-flex justify-content-end">
        <!-- Breadcrumb for Rekap Survey -->
      </div>
    </div>
  </div>
</div>

<!-- Kanban Board starts here -->
<section class="content">
  <div class="container-fluid h-50">
    <div class="row"> 
      <!-- Row to arrange cards horizontally -->

      @php
        // Group the scan_out_pcs data by area
        $groupedByArea = $scan_out_pcs->groupBy('area');
      @endphp

      <!-- Area Ducking 1 -->
      <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">AREA DUCKING 1</h3>
          </div>
          <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
            <h3 style="color: rgb(0, 0, 0)" class="card-title">TMMIN</h3>
          </div>
          <div class="card-body">
            @php
              // Check if scans exist for Ducking 1
              $scans = $groupedByArea->get('Ducking 1', collect());
              // Group scans by cycle within Ducking 1
              $groupedByCycle = $scans->groupBy('cycle');
            @endphp

            <!-- Loop through each cycle group -->
            @foreach($groupedByCycle as $cycle => $cycleScans)
              <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
              <!-- Items for the current cycle -->
              @foreach($cycleScans as $scan)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                  <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                  <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                </div>
              @endforeach
              <hr /> <!-- Horizontal line to separate cycles -->
            @endforeach

            <!-- If no scans, display a message -->
            @if($groupedByCycle->isEmpty())
              <p>No scans available for this area.</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Area Ducking 2 -->
      <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">AREA DUCKING 2</h3>
          </div>
          <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
            <h3 style="color: rgb(0, 0, 0)" class="card-title">ADM PLANT 1</h3>
          </div>
          <div class="card-body">
            @php
              // Check if scans exist for Ducking 2
              $scans = $groupedByArea->get('Ducking 2', collect());
              // Group scans by cycle within Ducking 2
              $groupedByCycle = $scans->groupBy('cycle');
            @endphp

            <!-- Loop through each cycle group -->
            @foreach($groupedByCycle as $cycle => $cycleScans)
              <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
              <!-- Items for the current cycle -->
              @foreach($cycleScans as $scan)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                  <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                  <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                </div>
              @endforeach
              <hr /> <!-- Horizontal line to separate cycles -->
            @endforeach

            <!-- If no scans, display a message -->
            @if($groupedByCycle->isEmpty())
              <p>No Preparation</p>
            @endif
          </div>
        </div>
      </div>

        <!-- Area Ducking 3 -->
        <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
          <div class="card card-row card-secondary">
            <div class="card-header">
              <h3 class="card-title">AREA DUCKING 3</h3>
            </div>
            <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
              <h3 style="color: rgb(0, 0, 0)" class="card-title">ADM PLANT 2</h3>
            </div>
            <div class="card-body">
              @php
                // Check if scans exist for Ducking 2
                $scans = $groupedByArea->get('Ducking 2', collect());
                // Group scans by cycle within Ducking 2
                $groupedByCycle = $scans->groupBy('cycle');
              @endphp
  
              <!-- Loop through each cycle group -->
              @foreach($groupedByCycle as $cycle => $cycleScans)
                <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
                <!-- Items for the current cycle -->
                @foreach($cycleScans as $scan)
                  <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                    <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                    <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                    <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                  </div>
                @endforeach
                <hr /> <!-- Horizontal line to separate cycles -->
              @endforeach
  
              <!-- If no scans, display a message -->
              @if($groupedByCycle->isEmpty())
                <p>No Preparation</p>
              @endif
            </div>
          </div>
        </div>

          <!-- Area Ducking 2 -->
      <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">AREA DUCKING 4</h3>
          </div>
          <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
            <h3 style="color: rgb(0, 0, 0)" class="card-title">TOYOTA</h3>
          </div>
          <div class="card-body">
            @php
              // Check if scans exist for Ducking 2
              $scans = $groupedByArea->get('Ducking 2', collect());
              // Group scans by cycle within Ducking 2
              $groupedByCycle = $scans->groupBy('cycle');
            @endphp

            <!-- Loop through each cycle group -->
            @foreach($groupedByCycle as $cycle => $cycleScans)
              <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
              <!-- Items for the current cycle -->
              @foreach($cycleScans as $scan)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                  <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                  <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                </div>
              @endforeach
              <hr /> <!-- Horizontal line to separate cycles -->
            @endforeach

            <!-- If no scans, display a message -->
            @if($groupedByCycle->isEmpty())
              <p>No Preparation</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">AREA DUCKING 5</h3>
          </div>
          <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
            <h3 style="color: rgb(0, 0, 0)" class="card-title">KAP</h3>
          </div>
          <div class="card-body">
            @php
              // Check if scans exist for Ducking 2
              $scans = $groupedByArea->get('Ducking 2', collect());
              // Group scans by cycle within Ducking 2
              $groupedByCycle = $scans->groupBy('cycle');
            @endphp

            <!-- Loop through each cycle group -->
            @foreach($groupedByCycle as $cycle => $cycleScans)
              <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
              <!-- Items for the current cycle -->
              @foreach($cycleScans as $scan)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                  <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                  <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                </div>
              @endforeach
              <hr /> <!-- Horizontal line to separate cycles -->
            @endforeach

            <!-- If no scans, display a message -->
            @if($groupedByCycle->isEmpty())
              <p>No Preparation</p>
            @endif
          </div>
        </div>
      </div>
      <div class="col-md-2"> <!-- Using col-md-12 for full width card -->
        <div class="card card-row card-secondary">
          <div class="card-header">
            <h3 class="card-title">AREA DUCKING 4</h3>
          </div>
          <div style="background-color: rgba(154, 189, 255, 0.2)" class="card-header">
            <h3 style="color: rgb(0, 0, 0)" class="card-title">ADM PLANT 5</h3>
          </div>
          <div class="card-body">
            @php
              // Check if scans exist for Ducking 2
              $scans = $groupedByArea->get('Ducking 2', collect());
              // Group scans by cycle within Ducking 2
              $groupedByCycle = $scans->groupBy('cycle');
            @endphp

            <!-- Loop through each cycle group -->
            @foreach($groupedByCycle as $cycle => $cycleScans)
              <h5 style="background-color: greenyellow">{{ $cycle }}</h5> <!-- Cycle header -->
              <!-- Items for the current cycle -->
              @foreach($cycleScans as $scan)
                <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox{{ $scan->id }}" disabled>
                  <label class="custom-control-label mr-2" for="customCheckbox{{ $scan->id }}">{{ $scan->job_no }}</label>
                  <strong><span class="ml-5">{{ $scan->qty }} PCS</span></strong> <!-- Display quantity -->
                </div>
              @endforeach
              <hr /> <!-- Horizontal line to separate cycles -->
            @endforeach

            <!-- If no scans, display a message -->
            @if($groupedByCycle->isEmpty())
              <p>No Preparation</p>
            @endif
          </div>
        </div>
      </div>

    </div> <!-- End Row -->
  </div>
</section>
@endsection
