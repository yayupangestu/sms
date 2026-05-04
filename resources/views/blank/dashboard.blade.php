@extends('layouts.app')

@section('content')
<style>
    .card {
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    background: #f8f9fa;
    padding: 20px;
    text-align: center;
}

.card-body {
    padding: 15px;
}

.card h6 {
    font-size: 14px;
    color: #6c757d;
    font-weight: bold;
}

.card h3 {
    font-size: 24px;
    font-weight: bold;
}

.text-success {
    color: #28a745;
}

</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard Keuangan</h1>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Top Metrics -->
    <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h6 class="text-muted">Cash in Bank (SAR '000')</h6>
            <h3 class="text-success">40,712</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="text-muted">OD Limit Available (SAR '000')</h6>
            <h3>4,126</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="text-muted">Loan Limit Available (SAR '000')</h6>
            <h3>974,169</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="text-muted">Total Available to Use (SAR '000')</h6>
            <h3 class="text-success">1,019,007</h3>
          </div>
        </div>
      </div>
    </div>
</div>

    
</section>
@endsection
