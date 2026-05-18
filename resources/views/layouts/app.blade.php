<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmS | {{ $title }}</title>
  <link rel="icon" href="{{asset('dist/img/pie.png')}}" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  {{-- sweetalert2 --}}
  <link rel="stylesheet" href="{{asset('sweetalert2/sweetalert2.min.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <script src="https://cdn.jsdelivr.net/npm/@phosphor-icons/web"></script>


  @stack('stylesheets')

</head>
<body style="background-color: #151414" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
@include('sweetalert::alert')
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center bg-white">
    <img  src="dist/img/loading.gif" alt="loading" height="200" width="200">
  </div>

  <!-- Navbar -->
  @include('layouts.nav')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; Sopfloor 2023.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>




{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

<!-- PAGE PLUGINS -->

{{-- sweetalert2 --}}
<script src="{{asset('sweetalert2/sweetalert2.all.min.js')}}"></script>
@stack('scripts')
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });

  function Logout(){
      SweetAlert.fire({
          title: 'Are you sure?',
          text: "want to exit the application!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, out it!'
          }).then((result) => {
          if (result.isConfirmed) {
              window.location.assign("{{ route('logout') }}");
          }
      })
  }
</script>
</body>
</html>
