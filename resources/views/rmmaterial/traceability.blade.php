@extends('layouts.app')

<style>
    .timeline {
        position: relative;
        padding: 1rem 0;
        list-style: none;
        margin: 0;
    }
    .timeline-item {
        position: relative;
        padding: 1rem 0;
        margin-left: 2rem;
        margin-bottom: 1rem;
        opacity: 0;
        transform: translateX(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .timeline-item.show {
        opacity: 1;
        transform: translateX(0);
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -1rem;
        top: 0;
        width: 0.25rem;
        height: 100%;
        background: #000000;
    }
    .timeline-icon {
        position: absolute;
        left: -2.25rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: #1d2e5e;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        box-shadow: 0 0 0.5rem rgba(0,0,0,0.2);
    }
    .timeline-icon:hover {
        background: #0056b3;
    }
    .timeline-content {
        padding-left: 2.5rem;
        background: #f8f9fa;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        transition: background 0.3s ease;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .timeline-content .col {
        flex: 1;
        padding: 0.5rem;
        box-sizing: border-box;
    }
    .timeline-content:hover {
        background: #e9ecef;
    }
</style>

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0" style="font-family: 'Times New Roman', Times, serif">Trace Proses SSW</h1>
        </div>
        <div class="col-sm-6">
          <!-- Add additional content here if needed -->
        </div>
      </div>
    </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('reportb3.update') }}" method="POST">
                    @csrf
                    <div class="card-header" style="background-color: rgb(162, 162, 162)">
                    <h3 class="card-title" style="font-family: 'Times New Roman', Times, serif">Trace Proses SSW</h3>
                    <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="form-group row">
                                    <div class="col-12" id="alert"></div>
                                    <label class="col-sm-1 col-form-label">Uniq NO:</label>
                                    <div class="col-sm-2">
                                        <input type="text" id="uniqno" name="uniq_no" class="form-control form-control-sm" placeholder="Enter Uniq NO">
                                    </div>
                                    <label class="col-sm-1 col-form-label">Part Nut:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="partnut" name="part_nut" class="form-control form-control-sm" placeholder="Enter Part Nut">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="timeline" id="timeline">
                                <!-- Timeline items will be inserted here -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</section>

@endsection