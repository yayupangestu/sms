@extends('layouts.app')

@section('content')
<style>
  .info-box-icon {
    position: relative;
    display: inline-block;
  }

  .notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    padding: 10px 15px;
    border-radius: 20%;
    color: rgb(0, 0, 0);
    font-size: 14px;
  }

  .info-box-doc {
    /* background: rgb(17, 87, 88); */
    position: center;
    background: linear-gradient(to bottom left, #0099ff 41%, #ccffff 100%);
  }

  .custom-box {
    background-color: rgba(146, 206, 239, 0.288);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px; /* Adjust as needed */
    border-radius: 60px; /* Rounded corners for a modern look */
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
  }

  .box-text {
    font-size: 25px;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    color: rgb(0, 0, 0);
    text-align: center;
    
  }

  .info-box {
    margin: 5px; /* Add some margin around the info box */
    
  }

  .bg-proses-spb-order {
    background: linear-gradient(to bottom left, #ffffcc 5%, #ffff00 100%);
  } 

  .bg-proses-spb-send {
    background: linear-gradient(to top right, #00cc99 53%, #ccffff 100%);
  }

  .bg-proses-spb-order-welding {
    background: linear-gradient(to bottom right, #0099cc 43%, #33cccc 73%);
    color: rgb(255, 255, 255);
  } 

  .bg-proses-spb-order-produksi2 {
    background: linear-gradient(to bottom right, #fff956 43%, #cfd600 73%);
    color: rgb(0, 0, 0);
  } 

   .bg-proses-spb-order-produksi2 {
    background: linear-gradient(to bottom right, #ff8356 43%, #e5987c 73%);
    color: rgb(0, 0, 0);
  } 

   .bg-proses-spb-order-support {
    background: linear-gradient(to bottom right, #ff8356 43%, #e5987c 73%);
    color: rgb(0, 0, 0);
  } 

  .bg-proses-spb-send-welding {
    background: linear-gradient(to top right, #00cc99 53%, #ccffff 100%);
  }
  
      /* MODAL STYE */
    .modal-header {
      background-color: #9bef9b; /* Light gray background */
        border-bottom: none; /* Remove border */
    }

    .modal-title {
        font-size: 1.25rem; /* Adjust font size */
        font-weight: bold; /* Make title bold */
    }

    .modal-body {
        padding: 1.5rem; /* Add padding */
        background-color: 
        #e8fbe8; /* Light gray background */
        color: #495057; /* Darker text color for better readability */
    }

    .modal-footer {
        background-color: #ffffffa9; /* Light gray background */
        border-top: none; /* Remove border */
    }

    .modal-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px; /* Increased space between items */
        padding: 10px; /* Add padding around items */
        border-radius: 5px; /* Rounded corners */
        background-color: #ffffff; /* Light gray background */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .item-label {
        flex: 1; /* Take up remaining space */
        margin-right: 10px; /* Space between label and checkbox */
        font-size: 1rem; /* Font size for label */
        color: #333; /* Darker text color */
    }

    .item-checkbox {
        cursor: pointer; /* Pointer cursor on hover */
    }
    
    .modal-footer button {
        border-radius: 5px; /* Rounded corners for buttons */
    }

    .modal-header .close {
        color: white; /* White close button */
        opacity: 1; /* Full opacity */
    }
    .item-quantity {
margin-right: 20px; /* Adjust the margin as needed */
}


    
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard Kanban </h1>
      </div>
      <div class="col-md-6 text-right">
        <h3 id="clock" class="text-right"></h3> <!-- Menambahkan elemen jam di sini -->
    </div>
    </div>
  </div>
</div>

<section class="content" style="color: #010203">
  <div class="info-box">
    <div style="  background: linear-gradient(to bottom left, #66ccff 47%, #ccffff 100%);" class="info-box-content custom-box">
      <span class="box-text">ANTRIAN SPB</span>
    </div>
  </div>
  <div class="row">
    <!-- Info Box for status 1 -->
    <div id="info-box-status1" class="col-md-11">
      <div class="row" id="info-box-content">
        @foreach ($str_out2s['status1'] as $data)
          <div class="col-md-3 col-sm-5 col-6 mb-2"> <!-- Ubah col-9 menjadi col-6 -->
            <div class="info-box bg-proses-spb-order">
              <a href="strout2" class="info-box-icon" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <strong>
                  <span class="notification-badge bg-success">ORDER</span>
                </strong>
              </a>
              <div class="info-box-content">
                <strong><span class="info-box-text">STAMPING LINE C1 & C2</span></strong>
                <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <strong><span class="progress-description">
                  {{ $data->w_diberi }} / {{ $data->createdby}}</span>
                </span></strong>
                <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                  More Info
                </button>
              </div>
            </div>
          </div>
        @endforeach
    
        @foreach ($str_out3s['status3'] as $data)
          <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
            <div class="info-box bg-proses-spb-order">
              <a href="strout3" class="info-box-icon" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <strong>
                  <span class="notification-badge bg-success">ORDER</span>
                </strong>
              </a>
              <div class="info-box-content">
                <strong><span class="info-box-text">STAMPING LINE B3</span></strong>
                <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <strong><span class="progress-description">
                  {{ $data->w_diberi }} / {{ $data->createdby}}</span>
                </span></strong>
                <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                  More Info
                </button>
              </div>
            </div>
          </div>
        @endforeach
    
        @foreach ($str_out4s['status5'] as $data)
          <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
            <div class="info-box bg-proses-spb-order">
              <a href="strout4" class="info-box-icon" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <strong>
                  <span class="notification-badge bg-success">ORDER</span>
                </strong>
              </a>
              <div class="info-box-content">
                <strong><span class="info-box-text">STAMPING LINE B1 & B2</span></strong>
                <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <strong><span class="progress-description">
                  {{ $data->w_diberi }} / {{ $data->createdby}}</span>
                </span></strong>
                <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                  More Info
                </button>
              </div>
            </div>
          </div>
        @endforeach
    
        @foreach ($str_out5s['status7'] as $data)
          <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
            <div class="info-box bg-proses-spb-order">
              <a href="strout5" class="info-box-icon" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <strong>
                  <span class="notification-badge bg-success">ORDER</span>
                </strong>
              </a>
              <div class="info-box-content">
                <strong><span class="info-box-text">STAMPING LINE A1 & A2</span></strong>
                <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <strong><span class="progress-description">
                  {{ $data->w_diberi }} / {{ $data->createdby}}</span>
                </span></strong>
                <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                  More Info
                </button>
              </div>
            </div>
          </div>
        @endforeach

        @foreach ($str_out6s['status9'] as $data)
        <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
          <div class="info-box bg-proses-spb-order">
            <a href="strout6" class="info-box-icon" target="_blank">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-success">ORDER</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">STAMPING LINE TRANSFERS</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </span></strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach

      @foreach ($str_out7s['status11'] as $data)
        <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
          <div class="info-box bg-proses-spb-order">
            <a href="strout7" class="info-box-icon" target="_blank">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-success">ORDER</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">STAMPING LINE BLANK</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </span></strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach


      @foreach ($str_out8s['status13'] as $data)
        <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
          <div class="info-box bg-proses-spb-order-welding">
            <a href="strout8" class="info-box-icon" target="_blank">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-success">ORDER</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">WELDING ROBOT PSW ROBOT</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </span></strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach

      @foreach ($str_out9s['status15'] as $data)
        <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
          <div class="info-box bg-proses-spb-order-welding">
            <a href="strout9" class="info-box-icon" target="_blank">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-success">ORDER</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">WELDING ROBOT PSW MANUAL</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </span></strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach

  

    @foreach ($str_out11s['status17'] as $data)
    <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
      <div class="info-box bg-proses-spb-order-welding">
        <a href="strout11" class="info-box-icon" target="_blank">
          <i class="fas fa-shopping-cart"></i>
          <strong>
            <span class="notification-badge bg-success">ORDER</span>
          </strong>
        </a>
        <div class="info-box-content">
          <strong><span class="info-box-text">WELDING SSW</span></strong>
          <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <strong><span class="progress-description">
            {{ $data->w_diberi }} / {{ $data->createdby}}</span>
          </span></strong>
          <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
            More Info
          </button>
        </div>
      </div>
    </div>
  @endforeach


  @foreach ($str_out10s['status19'] as $data)
  <div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
    <div class="info-box bg-proses-spb-order-welding">
      <a href="strout10" class="info-box-icon" target="_blank">
        <i class="fas fa-shopping-cart"></i>
        <strong>
          <span class="notification-badge bg-success">ORDER</span>
        </strong>
      </a>
      <div class="info-box-content">
        <strong><span class="info-box-text">WELDING TAIL GATE</span></strong>
        <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
        <strong><span class="progress-description">
          {{ $data->w_diberi }} / {{ $data->createdby}}</span>
        </span></strong>
        <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
          More Info
        </button>
      </div>
    </div>
  </div>
@endforeach

@foreach ($str_out12s['status21'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-welding">
    <a href="strout12" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING D60</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out13s['status23'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-welding">
    <a href="strout10" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING C02</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out14s['status25'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-welding">
    <a href="strout14" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING DCWA</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out15s['status27'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-produksi2">
    <a href="strout15" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING FUELTANK</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out16s['status29'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-produksi2">
    <a href="strout16" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">SERVICE PART</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach


@foreach ($str_out17s['status31'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-produksi2">
    <a href="strout17" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">PAINTING</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out18s['status33'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-produksi2">
    <a href="strout17" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">TM MACHINING</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out19s['status35'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-support">
    <a href="strout17" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">MIP</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach


@foreach ($str_out20s['status37'] as $data)
<div class="col-md-3 col-sm-5 col-6 mb-4"> <!-- Ubah col-9 menjadi col-6 -->
  <div class="info-box bg-proses-spb-order-support">
    <a href="strout17" class="info-box-icon" target="_blank">
      <i class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-success">ORDER</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">TM ASSYY</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </span></strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

  </div>
</div>
  
    
    


    
    <!-- Info Box header -->
    <div class="info-box">
      <div style="  background: linear-gradient(to bottom left, #66ccff 47%, #ccffff 100%);" class="info-box-content custom-box">
        <span class="box-text">SPB SELESAI DI PROSES</span>
      </div>
    </div>
  </div>
  <!-- Info Box for status 2 -->
  <div id="info-box-status2" class="col-md-11">
    <div class="row">
      @foreach ($str_out2s['status2'] as $data)
        <div class="col-md-3 col-sm-6 col-12 mb-4">
          <div class="info-box bg-proses-spb-send">
            <a href="strout2" class="info-box-icon">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-info">PROSES</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">STAMPING LINE C1 & C2</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach

      @foreach ($str_out3s['status4'] as $data)
        <div class="col-md-3 col-sm-6 col-12 mb-4">
          <div class="info-box bg-proses-spb-send">
            <a href="strout3" class="info-box-icon">
              <i class="fas fa-shopping-cart"></i>
              <strong>
                <span class="notification-badge bg-info">PROSES</span>
              </strong>
            </a>
            <div class="info-box-content">
              <strong><span class="info-box-text">STAMPING LINE B3</span></strong>
              <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <strong><span class="progress-description">
                {{ $data->w_diberi }} / {{ $data->createdby}}</span>
              </strong>
              <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
                More Info
              </button>
            </div>
          </div>
        </div>
      @endforeach

      @foreach ($str_out4s['status6'] as $data)
      <div class="col-md-3 col-sm-6 col-12 mb-4">
        <div class="info-box bg-proses-spb-send">
          <a href="strout4" class="info-box-icon">
            <i class="fas fa-shopping-cart"></i>
            <strong>
              <span class="notification-badge bg-info">PROSES</span>
            </strong>
          </a>
          <div class="info-box-content">
            <strong><span class="info-box-text">STAMPING LINE B1 & B2</span></strong>
            <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
            <div class="progress">
              <div class="progress-bar" style="width: 100%"></div>
            </div>
            <strong><span class="progress-description">
              {{ $data->w_diberi }} / {{ $data->createdby}}</span>
            </strong>
            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
              More Info
            </button>
          </div>
        </div>
      </div>
    @endforeach

    @foreach ($str_out5s['status8'] as $data)
    <div class="col-md-3 col-sm-6 col-12 mb-4">
      <div class="info-box bg-proses-spb-send">
        <a href="strout5" class="info-box-icon">
          <i class="fas fa-shopping-cart"></i>
          <strong>
            <span class="notification-badge bg-info">PROSES</span>
          </strong>
        </a>
        <div class="info-box-content">
          <strong><span class="info-box-text">STAMPING LINE A1 & A2</span></strong>
          <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <strong><span class="progress-description">
            {{ $data->w_diberi }} / {{ $data->createdby}}</span>
          </strong>
          <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
            More Info
          </button>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($str_out6s['status10'] as $data)
  <div class="col-md-3 col-sm-6 col-12 mb-4">
    <div class="info-box bg-proses-spb-send">
      <a href="strout6" class="info-box-icon">
        <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
        <strong>
          <span class="notification-badge bg-info">PROSES</span>
        </strong>
      </a>
      <div class="info-box-content">
        <strong><span class="info-box-text">STAMPING LINE TRANSFERS</span></strong>
        <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
        <strong><span class="progress-description">
          {{ $data->w_diberi }} / {{ $data->createdby}}</span>
        </strong>
        <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
          More Info
        </button>
      </div>
    </div>
  </div>
@endforeach

@foreach ($str_out7s['status12'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout7" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">STAMPING LINE BLANK</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out8s['status14'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout8" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING ROBOT PSW</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out9s['status16'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout9" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING PSW MANUAL</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out11s['status18'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout11" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING SSW</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out10s['status20'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout10" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING TAIL GATE</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out12s['status22'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout12" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING D60</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out13s['status24'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout13" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING CO2</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out14s['status26'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout14" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING DCWA</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out15s['status28'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout15" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">WELDING FUEL TANK</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out16s['status30'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout15" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">SERVICE PART</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out17s['status32'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout17" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">PAINTING</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out18s['status34'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout17" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">TM MACHINING</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out19s['status36'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout17" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">MIP</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

@foreach ($str_out20s['status38'] as $data)
<div class="col-md-3 col-sm-6 col-12 mb-4">
  <div class="info-box bg-proses-spb-send">
    <a href="strout17" class="info-box-icon">
      <i style="background: linear-gradient(to bottom left, #00ff99 5%, #ccffff 100%);" class="fas fa-shopping-cart"></i>
      <strong>
        <span class="notification-badge bg-info">PROSES</span>
      </strong>
    </a>
    <div class="info-box-content">
      <strong><span class="info-box-text">TM ASSY</span></strong>
      <span class="info-box-number" style="font-size: 16px;">{{ $data->doc_no }}</span>
      <div class="progress">
        <div class="progress-bar" style="width: 100%"></div>
      </div>
      <strong><span class="progress-description">
        {{ $data->w_diberi }} / {{ $data->createdby}}</span>
      </strong>
      <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="{{ $data->doc_no }}">
        More Info
      </button>
    </div>
  </div>
</div>
@endforeach

    </div>
  </div>
</section>

<!-- Modal Structure -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="infoModalLabel">More Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-detail-content">
            <!-- Content will be inserted here -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>




<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function updateClock() {
        const clockElement = document.getElementById("clock");
        const now = new Date();
        
        // Get time
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // Get day of the week, month, and date
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const monthName = months[now.getMonth()];
        const date = now.getDate();
        const year = now.getFullYear();
        
        // Format: Day, Month Date, Year HH:MM:SS
        clockElement.innerText = `${dayName} / ${monthName} ${date} / ${year} ${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000); // Memperbarui jam setiap detik
    updateClock(); // Menampilkan jam langsung saat halaman dimuat


    $(document).ready(function() {
      $(document).on('click', '.btn-more-info', function() {
        var docNo = $(this).data('doc_no');
        $.ajax({
            url: '{{ route("kanban.getDetails") }}',
            type: 'GET',
            data: { doc_no: docNo },
        success: function(response) {
          var modalContent = `
            <h5>Document Number: ${docNo}</h5>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Select</th>
                  </tr>
                </thead>
            <tbody>`;
          response.forEach(function(item) {
            modalContent += `
              <tr>
                <td>${item.item_id}</td>
                <td>${item.qty_request} ${item.satuan}</td>
                <td>
                <input style="size: 90px" type="checkbox" id="item-${item.item_id}" name="items[]" value="${item.item_id}" class="item-checkbox">
                </td>
              </tr>
            `;
          });
          modalContent += `
            </tbody>
          </table>`;
          $('#modal-detail-content').html(modalContent);
          $('#infoModal').modal('show');
        },
          error: function() {
          alert('Failed to fetch details. Please try again.');
        }
      });
    });

    $(document).ready(function() {
      function fetchDataAndUpdate() {
      $.ajax({
        url: 'http://asi.adyawinsa.com:814/kanban/get-new-data',
        method: 'GET',
        success: function(response) {
          console.log('Data received:', response);

          // Parse the response if it is a string
          let data = (typeof response === 'string') ? JSON.parse(response) : response;

          // Convert status1 to an array if it's not already an array
          let status1 = Array.isArray(data.str_out2s.status1) ? data.str_out2s.status1 : Object.values(data.str_out2s.status1);
          let status2 = Array.isArray(data.str_out2s.status2) ? data.str_out2s.status2 : Object.values(data.str_out2s.status2);
          let status3 = Array.isArray(data.str_out3s.status3) ? data.str_out3s.status3 : Object.values(data.str_out3s.status3);
          let status4 = Array.isArray(data.str_out3s.status4) ? data.str_out3s.status4 : Object.values(data.str_out3s.status4);
          let status5 = Array.isArray(data.str_out4s.status5) ? data.str_out4s.status5 : Object.values(data.str_out4s.status5);
          let status6 = Array.isArray(data.str_out4s.status6) ? data.str_out4s.status6 : Object.values(data.str_out4s.status6);
          let status7 = Array.isArray(data.str_out5s.status7) ? data.str_out5s.status7 : Object.values(data.str_out5s.status7);
          let status8 = Array.isArray(data.str_out5s.status8) ? data.str_out5s.status8 : Object.values(data.str_out5s.status8);
          let status9 = Array.isArray(data.str_out6s.status9) ? data.str_out6s.status9 : Object.values(data.str_out6s.status9);
          let status10 = Array.isArray(data.str_out6s.status10) ? data.str_out6s.status10 : Object.values(data.str_out6s.status10);
          let status11 = Array.isArray(data.str_out7s.status11) ? data.str_out7s.status11 : Object.values(data.str_out7s.status11);
          let status12 = Array.isArray(data.str_out7s.status12) ? data.str_out7s.status12 : Object.values(data.str_out7s.status12);
          let status13 = Array.isArray(data.str_out8s.status13) ? data.str_out8s.status13 : Object.values(data.str_out8s.status13);
          let status14 = Array.isArray(data.str_out8s.status14) ? data.str_out8s.status14 : Object.values(data.str_out8s.status14);
          let status15 = Array.isArray(data.str_out9s.status15) ? data.str_out9s.status15 : Object.values(data.str_out9s.status15);
          let status16 = Array.isArray(data.str_out9s.status16) ? data.str_out9s.status16 : Object.values(data.str_out9s.status16);
          let status17 = Array.isArray(data.str_out11s.status17) ? data.str_out11s.status17 : Object.values(data.str_out11s.status17);
          let status18 = Array.isArray(data.str_out11s.status18) ? data.str_out11s.status18 : Object.values(data.str_out11s.status18);
          let status19 = Array.isArray(data.str_out10s.status19) ? data.str_out10s.status19 : Object.values(data.str_out10s.status19);
          let status20 = Array.isArray(data.str_out10s.status20) ? data.str_out10s.status20 : Object.values(data.str_out10s.status20);
          let status21 = Array.isArray(data.str_out12s.status21) ? data.str_out12s.status21 : Object.values(data.str_out12s.status21);
          let status22 = Array.isArray(data.str_out12s.status22) ? data.str_out12s.status22 : Object.values(data.str_out12s.status22);
          let status23 = Array.isArray(data.str_out13s.status23) ? data.str_out13s.status23 : Object.values(data.str_out13s.status23);
          let status24 = Array.isArray(data.str_out13s.status24) ? data.str_out13s.status24 : Object.values(data.str_out13s.status24);
          let status25 = Array.isArray(data.str_out14s.status25) ? data.str_out14s.status25 : Object.values(data.str_out14s.status25);
          let status26 = Array.isArray(data.str_out14s.status26) ? data.str_out14s.status26 : Object.values(data.str_out14s.status26);
          let status27 = Array.isArray(data.str_out15s.status27) ? data.str_out15s.status27 : Object.values(data.str_out15s.status27);
          let status28 = Array.isArray(data.str_out15s.status28) ? data.str_out15s.status28 : Object.values(data.str_out15s.status28);
          let status29 = Array.isArray(data.str_out16s.status29) ? data.str_out16s.status29 : Object.values(data.str_out16s.status29);
          let status30 = Array.isArray(data.str_out16s.status30) ? data.str_out16s.status30 : Object.values(data.str_out16s.status30);
          let status31 = Array.isArray(data.str_out17s.status31) ? data.str_out17s.status31 : Object.values(data.str_out17s.status31);
          let status32 = Array.isArray(data.str_out17s.status32) ? data.str_out17s.status32 : Object.values(data.str_out17s.status32);
          let status33 = Array.isArray(data.str_out18s.status33) ? data.str_out18s.status33 : Object.values(data.str_out18s.status33);
          let status34 = Array.isArray(data.str_out18s.status34) ? data.str_out18s.status34 : Object.values(data.str_out18s.status34);
          let status35 = Array.isArray(data.str_out19s.status35) ? data.str_out19s.status35 : Object.values(data.str_out19s.status35);
          let status36 = Array.isArray(data.str_out19s.status36) ? data.str_out19s.status36 : Object.values(data.str_out19s.status36);
          let status37 = Array.isArray(data.str_out20s.status37) ? data.str_out20s.status37 : Object.values(data.str_out20s.status37);
          let status38 = Array.isArray(data.str_out20s.status38) ? data.str_out20s.status38 : Object.values(data.str_out20s.status38);
          
          // Check if status1 and status2 are arrays
          if (Array.isArray(status1) && Array.isArray(status2)) {
            updateInfoBox('#info-box-status1  .row', status1, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox('#info-box-status2  .row', status2, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox2('#info-box-status1 .row', status3, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox2('#info-box-status2 .row', status4, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox3('#info-box-status1 .row', status5, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox3('#info-box-status2 .row', status6, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox4('#info-box-status1 .row', status7, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox4('#info-box-status2 .row', status8, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox5('#info-box-status1 .row', status9, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox5('#info-box-status2 .row', status10, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox6('#info-box-status1 .row', status11, 'ORDER', 'bg-proses-spb-order');
            updateInfoBox6('#info-box-status2 .row', status12, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox7('#info-box-status1 .row', status13, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox7('#info-box-status2 .row', status14, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox8('#info-box-status1 .row', status15, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox8('#info-box-status2 .row', status16, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox9('#info-box-status1 .row', status17, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox9('#info-box-status2 .row', status18, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox10('#info-box-status1 .row', status19, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox10('#info-box-status2 .row', status20, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox11('#info-box-status1 .row', status21, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox11('#info-box-status2 .row', status22, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox12('#info-box-status1 .row', status23, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox12('#info-box-status2 .row', status24, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox13('#info-box-status1 .row', status25, 'ORDER', 'bg-proses-spb-order-welding');
            updateInfoBox13('#info-box-status2 .row', status26, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox14('#info-box-status1 .row', status27, 'ORDER', 'bg-proses-spb-order-prduksi2');
            updateInfoBox14('#info-box-status2 .row', status28, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox15('#info-box-status1 .row', status29, 'ORDER', 'bg-proses-spb-order-prduksi2');
            updateInfoBox15('#info-box-status2 .row', status30, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox16('#info-box-status1 .row', status31, 'ORDER', 'bg-proses-spb-order-prduksi2');
            updateInfoBox16('#info-box-status2 .row', status32, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox17('#info-box-status1 .row', status33, 'ORDER', 'bg-proses-spb-order-support');
            updateInfoBox17('#info-box-status2 .row', status34, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox18('#info-box-status1 .row', status35, 'ORDER', 'bg-proses-spb-order-support');
            updateInfoBox18('#info-box-status2 .row', status36, 'SEND', 'bg-proses-spb-send', true);
            updateInfoBox19('#info-box-status1 .row', status37, 'ORDER', 'bg-proses-spb-order-support');
            updateInfoBox19('#info-box-status2 .row', status38, 'SEND', 'bg-proses-spb-send', true);


          } else {
            console.error('status1 or status2 is not an array', data);
          }
        },
        error: function(xhr) {
          console.log('Error fetching data:', xhr.responseText);
        }
      });
    }

    function updateInfoBox(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
      const container = $(containerSelector);
      container.empty();

      // Track doc_no already displayed
      const displayedDocNos = new Set();

      items.forEach(function(item) {
        if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
          return; // Skip duplicates for status 2
        }

        const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
        const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
        const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

        container.append(`
          <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box ${boxClass}">
              <a class="info-box-icon">
                <i class="fas fa-shopping-cart"></i>
                <strong>
                  <span class="notification-badge ${badgeClass}">${badgeText}</span>
                </strong>
              </a>
              <div class="info-box-content">
                <strong><span class="info-box-text">STAMPING LINE C1 & C2</span></strong>
                <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <strong><span class="progress-description">
                  ${item.w_diberi} / ${item.createdby}
                </span></strong>
                <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                  More Info
                </button>
              </div>
            </div>
          </div>
        `);

        // Add doc_no to the set of displayed doc_nos
        if (item.status === 2) {
          displayedDocNos.add(item.doc_no);
        }
      });
    }

    function updateInfoBox2(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">STAMPING LINE B3</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox3(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">STAMPING LINE B1 & B2</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }
    
    function updateInfoBox4(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">STAMPING LINE A1 & A2</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox5(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">STAMPING LINE TRANSFERS</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.created_at} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox6(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">STAMPING LINE BLANK</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox7(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send-welding') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING PSW ROBOT</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox8(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send-welding') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING ROBOT-2</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox9(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING SSW</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox10(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING TAIL GATE</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox11(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING TAIL GATE</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox12(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING CO2</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox13(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING DCWA</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox14(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">WELDING FUEL TANK</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox15(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">SERVICE PART</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    function updateInfoBox16(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">PAINTING</span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

     function updateInfoBox17(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">TM MACHINING</span></span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

       function updateInfoBox18(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">MIP</span></span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

       function updateInfoBox19(containerSelector, items, defaultBadge, defaultBgClass, checkStatus = false) {
        const container = $(containerSelector);

        // Clear container only on the first call
        if (container.is(':empty')) {
            container.empty();
        }

        // Track doc_no already displayed
        const displayedDocNos = new Set();

        items.forEach(function(item) {
            if (item.status === 2 && displayedDocNos.has(item.doc_no)) {
                return; // Skip duplicates for status 2
            }

            const badgeText = checkStatus ? (item.status == 1 ? 'ORDER' : 'SEND') : defaultBadge;
            const badgeClass = checkStatus ? (item.status == 1 ? 'bg-success' : 'bg-success') : 'bg-success';
            const boxClass = checkStatus ? (item.status == 1 ? 'bg-warning' : 'bg-proses-spb-send') : defaultBgClass;

            container.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    <div class="info-box ${boxClass}">
                        <a  class="info-box-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>
                                <span class="notification-badge ${badgeClass}">${badgeText}</span>
                            </strong>
                        </a>
                        <div class="info-box-content">
                            <strong><span class="info-box-text">TM ASSY</span></span></strong>
                            <span class="info-box-number" style="font-size: 16px;">${item.doc_no}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <strong><span class="progress-description">
                                ${item.w_diberi} / ${item.createdby}
                            </span></strong>
                            <button type="button" class="btn btn-light btn-sm mt-1 btn-more-info" data-doc_no="${item.doc_no}">
                                More Info
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add doc_no to the set of displayed doc_nos
            if (item.status === 2) {
                displayedDocNos.add(item.doc_no);
            }
        });
    }

    setInterval(fetchDataAndUpdate, 3000);
    });

});

  </script>
  
@endsection
