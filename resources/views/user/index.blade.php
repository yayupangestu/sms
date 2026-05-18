@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen User</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Data User</h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btn_add"><i class="fa fa-plus"></i>
                                    Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Name</th>
                                        <th>username</th>
                                        <th>Level</th>
                                        <th>Line ID</th>
                                        <th width="80">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title1">Tambah User</h4>
                    <h4 class="modal-title" id="title2">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12" id="alert"></div>
                        <label class="col-sm-3 col-form-label">Nama :</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="id" class="form-control" required>
                            <input type="text" id="nama" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Username :</label>
                        <div class="col-sm-9">
                            <input type="text" id="username" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Password :</label>
                        <div class="col-sm-9">
                            <input type="password" id="password" class="form-control form-control-sm" required>
                        </div>

                        <label class="col-sm-3 col-form-label">Level :</label>
                        <div class="col-sm-9">
                            <select style="width: 100%;" id="level" class="form-control select2" required>
                                <option value="" selected>- pilih -</option>
                                <option value="UserB3">User B3</option>
                                <option value="UserB12">User B12</option>
                                <option value="UserA12">User A12</option>
                                <option value="User3000">User 3000</option>
                                <option value="PlanerPPIC">Planer PPIC</option>
                                <option value="AdminSROOM">Admin StoreRoom</option>
                                <option value="userBlank">userBlank</option>
                                <option value="AdminLS">AdminLs</option>
                                <option value="AdminRM">AdminRM</option>
                                <option value="userRak">userRak</option>
                                <option value="PrepareAdm4">PrepareAdm4</option>
                                <option value="PrepareTmminAdm">PrepareTmminAdm</option>
                                <option value="userWelding">userWelding</option>
                                <option value="PlanerPPIC2">PlanerPPIC2</option>
                                <option value="PlanerPPIC3">PlanerPPIC3</option>
                                <option value="userPcStore">userPcStore</option>
                                <option value="userPcStore2">userPcStore2</option>
                                <option value="StokOpname">StokOpname</option>
                                <option value="lineStoreIn">lineStoreIn</option>
                                <option value="adminDm">adminDm</option>
                                <option value="userDm">userDm</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <label class="col-sm-3 col-form-label">LINE :</label>
                        <div class="col-sm-9">
                            <input type="text" id="line_id" class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary Update">Update</button>
                    <button type="button" class="btn btn-primary Save">Save</button>
                </div>
            </div>
        </div>
    </div>
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
        $(document).ready(function() {
            list();
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
                pageLength: 10,
                ajax: {
                    url: "{{ route('user.list') }}"
                },
                columns: [{
                        data: null,
                        sortable: false,
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'line_id',
                        name: 'line_id'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return '<a href="#" id="btn_edit" title="Edit" data-id="' + data +
                                '" class="btn btn-warning btn-sm">' +
                                '<i class="fas fa-pencil-alt"></i>' +
                                '</a>' +
                                '<a href="#" id="btn_delete" title="Delete" data-id="' + data +
                                '" class="btn btn-danger btn-sm ml-1">' +
                                '<i class="far fa-trash-alt"></i>' +
                                '</a>';
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

        $(document).on("click", "#btn_add", function() {
            $('#myModal2').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $(".Update").hide();
            $("#title2").hide();
            $(".Save").show();
            $("#title1").show();
        });

        $(document).on("click", "#btn_edit", function() {
            $(".Save").hide();
            $("#title1").hide();
            $(".Update").show();
            $("#title2").show();
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "{{ route('user.edit') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        $('#myModal2').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                        $('#id').val(result.id);
                        $('#nama').val(result.name);
                        $('#username').val(result.username);
                        $('#level').val(result.level).trigger('change');
                        $('#line_id').val(result.line_id).trigger('change');
                    } else {
                        SweetAlert.fire({
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

        $(document).on("click", ".close", function() {
            clear();
            $("#alert").html('');
        });

        function clear() {
            $("#id").val('');
            $("#nama").val('');
            $("#username").val('');
            $("#password").val('');
            $('#level').val('').trigger('change');
            $('#line_id').val('').trigger('change');
        }

        $(document).on("click", ".Save", function() {
            $("#alert").html('');
            $("#alert").show();
            var lowerCaseLetters = /[a-z]/g;
            var upperCaseLetters = /[A-Z]/g;
            var numbers = /[0-9]/g;
            if (nama.value != '' && username.value != '' && password.value != '' && line_id.value != '') {
                if (password.value.match(lowerCaseLetters) && password.value.match(upperCaseLetters) && password
                    .value.match(numbers) && password.value.length >= 8) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.store') }}",
                        data: {
                            nama: nama.value,
                            username: username.value,
                            password: password.value,
                            level: level.value,
                            line_id: line_id.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success) {
                                $("#alert").html(
                                    '<div class="alert alert-success"><i class="fa fa-check"></i> ' +
                                    result.msg + '</div>');
                                list();
                                clear();
                                setTimeout(() => {
                                    $("#alert").hide();
                                }, 1500);
                            } else {
                                $("#alert").html(
                                    '<div class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                                    result.msg + '</div>');
                                setTimeout(() => {
                                    $("#alert").hide();
                                }, 1500);
                            }
                        }
                    });
                } else {
                    $("#alert").html(
                        '<div class="alert alert-danger"><i class="fa fa-warning"></i>password harus memiliki, huruf kecil, besar, angka dan 8 karakter</div>'
                        );
                    setTimeout(() => {
                        $("#alert").hide();
                    }, 1500);
                }
            } else {
                $("#alert").html(
                    '<div class="alert alert-danger"><i class="fa fa-warning"></i>column cannot be empty.</div>'
                    );
                setTimeout(() => {
                    $("#alert").hide();
                }, 1500);
            }
        });

        $(document).on("click", ".Update", function() {
            if (password.value.length == 0) {
                $("#alert").html('');
                $("#alert").show();
                if (nama.value != '' && username.value != '' && level.value != '' && line_id.value != '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.update') }}",
                        data: {
                            id: id.value,
                            nama: nama.value,
                            username: username.value,
                            password: password.value,
                            level: level.value,
                            line_id: line_id.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success) {
                                $('#myModal2').modal('hide');
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                list();
                                clear();
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                } else {
                    $("#alert").html(
                        '<div class="alert alert-danger"><i class="fa fa-warning"></i>column cannot be empty.</div>'
                        );
                    setTimeout(() => {
                        $("#alert").hide();
                    }, 1500);
                }
            } else {
                $("#alert").html('');
                $("#alert").show();
                var lowerCaseLetters = /[a-z]/g;
                var upperCaseLetters = /[A-Z]/g;
                var numbers = /[0-9]/g;
                if (nama.value != '' && username.value != '' && password.value != '' && level.value != '' && line_id
                    .value) {
                    if (password.value.match(lowerCaseLetters) && password.value.match(upperCaseLetters) && password
                        .value.match(numbers) && password.value.length >= 8) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('user.update') }}",
                            data: {
                                id: id.value,
                                nama: nama.value,
                                username: username.value,
                                password: password.value,
                                level: level.value,
                                line_id: line_id.value,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(result) {
                                if (result.success) {
                                    $('#myModal2').modal('hide');
                                    SweetAlert.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    list();
                                    clear();
                                } else {
                                    SweetAlert.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: result.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    } else {
                        $("#alert").html(
                            '<div class="alert alert-danger"><i class="fa fa-warning"></i>password harus memiliki, huruf kecil, besar, angka dan 8 karakter</div>'
                            );
                        setTimeout(() => {
                            $("#alert").hide();
                        }, 1500);
                    }
                } else {
                    $("#alert").html(
                        '<div class="alert alert-danger"><i class="fa fa-warning"></i>column cannot be empty.</div>'
                        );
                    setTimeout(() => {
                        $("#alert").hide();
                    }, 1500);
                }
            }
        });

        // function validasi(){
        //     $("#alert").show();
        //     var lowerCaseLetters = /[a-z]/g;
        //     var upperCaseLetters = /[A-Z]/g;
        //     var numbers = /[0-9]/g;
        //     if(nama.value != '' && username.value != '' && password.value != '' && level.value != ''){
        //         if(password.value.match(lowerCaseLetters) && password.value.match(upperCaseLetters) && password.value.match(numbers) && password.value.length >= 8){
        //             return true;
        //         }else{
        //             $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>password harus memiliki, huruf kecil, besar, angka dan 8 karakter</div>');
        //             setTimeout(() => { $("#alert").hide(); }, 1500);
        //         }
        //         // if(username.value.indexOf("@")!=-1 && username.value.indexOf(".")!=-1){
        //         // }else{
        //         //     $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>masukan alamat username dengan benar!</div>');
        //         //     setTimeout(() => { $("#alert").hide(); }, 1500);
        //         // }
        //     }else{
        //         $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>column cannot be empty.</div>');
        //         setTimeout(() => { $("#alert").hide(); }, 1500);
        //     }
        // }

        // function validasi2(){
        //     $("#alert").show();
        //     if(nama.value != '' && username.value != '' && level.value != ''){
        //         return true;
        //         // if(username.value.indexOf("@")!=-1 && username.value.indexOf(".")!=-1){
        //         // }else{
        //         //     $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>masukan alamat username dengan benar!</div>');
        //         //     setTimeout(() => { $("#alert").hide(); }, 1500);
        //         // }
        //     }else{
        //         $("#alert").html('<div class="alert alert-danger"><i class="fa fa-warning"></i>column cannot be empty.</div>');
        //         setTimeout(() => { $("#alert").hide(); }, 1500);
        //     }
        // }

        $(document).on("click", "#btn_delete", function() {
            var id = $(this).data('id');
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
                        url: "{{ route('user.destroy') }}",
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                SweetAlert.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                SweetAlert.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: result.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            list();
                        }
                    });
                }
            })
        });
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
