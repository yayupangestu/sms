@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Harian Kerja LINE B3</h1>
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
                <form action="{{ route('lkhb3.update') }}" method="POST">
                    @csrf
                    <div class="card-header" style="background-color: rgb(245, 241, 168)">
                    <h3 class="card-title">Laporan Harian Kerja B3</h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" name="button" value="update" type="submit"><i class="fa fa-plus"></i> Update</button>
                        {{-- <button class="btn btn-danger btn-sm" name="button" value="print" type="submit"><i class="fa fa-file-pdf"></i> Export PDF</button> --}}
                        {{-- <button class="btn btn-success btn-sm" name="button" value="#" type="submit"><i class="fa fa-file-excel"></i> Export XCEL</button> --}}
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-12" id="alert"></div>
                                    <label class="col-sm-1 col-form-label">Date :</label>
                                    <div class="col-sm-2">
                                        <input type="hidden" id="id" class="form-control" required>
                                        <input type="date" id="date_plan" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-sm-1"></div>
                    
                                    <label class="col-sm-1 col-form-label">Line :</label>
                                    <div class="col-sm-2 mb-1">
                                        <select style="width: 100%;" id="line_id" class="form-control select2" required>
                                            <option value="" selected>- pilih -</option>
                                            @foreach ($line_stmps as $line)
                                                <option value="{{ $line->id }}">{{ $line->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    <div class="col-sm-5">
                                        <button type="button" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="example1" class="table  table-bordered table-striped">
                                        <thead class="table" style="background-color:rgb(255, 249, 134)">
                                            <tr class="text-center">
                                                <th width="100">No</th>
                                                <th width="80">Job No</th>
                                                <th>Part No</th>
                                                <th>Material</th>
                                                <th>Planning</th>
                                                <th>QTY Actual</th>
                                                <th>QTY NG</th>
                                                <th>GSPH</th>
                                                <th>DT Mesin</th>
                                                <th>DT Dies</th>
                                                <th>Dandori</th>
                                                <th>Remark</th>
                                                {{-- <th>Planer</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tb_detail">
                                        </tbody>
                                    </table>
                                </div>
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
            $("#example1").hide();
        });

        $(document).on("click", "#btn_search", function () {
            if(date_plan.value != '' && line_id.value != ''){
                $("#example1").show();
                list();
            }else{
                $("#example1").hide();
            }
        });

        function list(){
            var html = '';
            let no = 1;
            let idline = 1;
            let idng = 1;
            let idgsph = 1;
            let idmesin =1;
            let iddies =1;
            let iddandori =1;
            let idremark = 1;
            let spek =1;
            let qty_act = 1;
            let qty_ng = 1;
            let qty_gsph = 1;
            let qty_mesin = 1;
            let qty_dies =1;
            let qty_dandori =1;
            let ket_remark = 1;
           
            // let rm = 1;
            $.ajax({
                type: 'GET',
                url: "{{route('lkhb3.list')}}",
                data: {
                        date_plan: date_plan.value,
                        line_id: line_id.value
                    },
                success: function(result) {
                    $.each(result.data, function(key, value) {
                        var qty = value.qty_act;
                        if(qty == null){
                            qty= ''
                        }else{
                            qty = value.qty_act;
                          
                        }

                         var ng= value.qty_ng;
                         if(ng == null){
                            ng = ''
                         }else{
                            ng = value.qty_ng;
                         }

                         var gsph = value.qty_gsph;
                         if (gsph == null){
                            gsph = ''
                         }else{
                            gsph = value.qty_gsph;
                         }

                         var mesin = value.qty_mesin
                         if (mesin == null){
                            mesin = ''
                         }else{
                            mesin = value.qty_mesin;
                         }


                         var dies = value.qty_dies
                         if (dies == null){
                            dies = ''
                         }else{
                            dies = value.qty_dies;
                         }

                         var dandori = value.qty_dandori
                         if (dandori == null){
                            dandori = ''
                         }else{
                            dandori =value.qty_dandori
                         }

                         var remark = value.ket_remark
                         if (remark == null){
                            remark = ''
                         }else{
                            remark = value.ket_remark;
                         }

                        html += '<tr class="text-center">'+
                                '<td>'+ no++ +'</td>'+
                                '<td width="80">'+value.job_no+'</td>'+
                                '<td>'+value.part_name+'</td>'+
                                '<td>'+value.spek+'</td>'+
                                '<td>'+value.qty_plan+'</td>'+
                                '<td><input type="hidden" name="idline['+ idline++ +']" value="'+value.id+'"><input type="number" name="qty['+ qty_act++ +']" value="'+qty+'"></td>'+
                                '<td><input type="hidden" name="idng['+ idng++ +']" value="'+value.id+'"><input type="number" name="ng['+ qty_ng++ +']" value="'+ng+'"></td>'+
                                '<td><input type="hidden" name="idgsph['+ idgsph++ +']" value="'+value.id+'"><input type="number" name="gsph['+ qty_gsph++ +']" value="'+gsph+'"></td>'+
                                '<td><input type="hidden" name="idmesin['+ idmesin++ +']" value="'+value.id+'"><input type="text" name="mesin['+ qty_mesin++ +']" value="'+mesin+'"></td>'+
                                '<td><input type="hidden" name="iddies['+ iddies++ +']" value="'+value.id+'"><input type="text" name="dies['+ qty_dies++ +']" value="'+dies+'"></td>'+
                                '<td><input type="hidden" name="iddandori['+ iddandori++ +']" value="'+value.id+'"><input type="text" name="dandori['+ qty_dandori++ +']" value="'+dandori+'"></td>'+
                                '<td><input type="hidden" name="idremark['+ idremark++ +']" value="'+value.id+'"><input type="varchar" name="remark['+ket_remark ++ +']" value="'+remark+'"></td>'+
                               
                            '</tr>';
                    })
                    document.getElementById("tb_detail").innerHTML = html;
                }
            });
        }

    

        function clear(){
            $("#id").val('');
            $("#date_plan").val('');
            $('#line_id').val('').trigger('change');
            $('#product_id').val('').trigger('change');
            $('#material_id').val('').trigger('change');
            $("#qty_plan").val('');
        }
    </script>
@endpush

@push('stylesheets')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
