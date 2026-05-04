@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
  </div>
</div>
<section class="content" style="color: #010203">
  <div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">

      <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-warning">
          <div class="inner">
            @php
                  $row = DB::table('str_stok_atks')->select(DB::raw('count(id) as jml'))->first();
             @endphp
          <b><h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Item</h4></b> 
            <b><p>Quantity Item ATK</p></b>
          </div>
          <div class="icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <a href="" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-success">
          <div class="inner">
            @php
                  $row = DB::table('str_stok_rtks')->select(DB::raw('count(id) as jml'))->first();
             @endphp
          <b><h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Item</h4></b> 
            <b><p>Quantity Item RTK</p></b>
          </div>
          <div class="icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <a href="" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-danger">
          <div class="inner">
            @php
                  $row = DB::table('str_stok_consums')->select(DB::raw('count(id) as jml'))->first();
             @endphp
          <b><h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Item</h4></b> 
            <b><p>Quantity Item Consum</p></b>
          </div>
          <div class="icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <a href="" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-purple">
          <div class="inner">
            @php
                  $row = DB::table('str_stok_tis')->select(DB::raw('count(id) as jml'))->first();
             @endphp
          <b><h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Item</h4></b> 
            <b><p>Quantity Item Tool & Insert</p></b>
          </div>
          <div class="icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <a href="" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">TISU GULUNG</span>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_rtks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 140)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Pcs</h4>
            </span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">WPC</span>
            <span class="info-box-number">
              @php
                 $row = DB::table('str_stok_rtks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 142)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml }}-Pcs</h4>
            </span>
          </div>
        </div>
      </div>
      <div class="col-8 col-sm-3 col-md-3">
        <div class="info-box mb-2">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Rinso Bubuk</span>
            <span class="info-box-number">
              @php
                $row = DB::table('str_stok_rtks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 143)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Pcs</h4>
            </span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">HANDSHOP</span>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_rtks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 563)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Item</h4>
            </span>
          </div>
        </div>
      </div> 

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas 	fas fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" style="font-family: 'Times New Roman', Times, serif">BUSSINES FILE A4 (ATK)</span>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_atks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 28)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Item</h4>
            </span>
          </div>
        </div>
      </div> 
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas 	far fa-file"></i></span>
          <div class="info-box-content">
            <b><span class="info-box-text" style="font-family: 'Times New Roman', Times, serif">HVS A4 (ATK)</span></b>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_atks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 53)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Sheet</h4>
            </span>
          </div>
        </div>
      </div> 
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas 	far fa-file-alt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" style="font-family: 'Times New Roman', Times, serif">HVS A3(ATK)</span>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_atks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 52)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Item</h4>
            </span>
          </div>
        </div>
      </div> 
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas far fa-window-restore"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" style="font-family: 'Times New Roman', Times, serif">LAMINATING FILM A4(ATK)</span>
            <span class="info-box-number">
              @php
                  $row = DB::table('str_stok_atks')->select(DB::raw('SUM(actual) as jml'))->where('item_id', 73)->first();
              @endphp
              <h4 style="font-family: 'Times New Roman', Times, serif">{{ $row->jml}}-Pcs</h4>
            </span>
          </div>
        </div>
      </div> 
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!--/. container-fluid -->
</section>



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
          setInterval(() => {
            console.log('hello world')
          }, 3000);

    </script>



@endpush