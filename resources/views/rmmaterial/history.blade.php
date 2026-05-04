@extends('layouts.app')

@section('content')

<style>

.swal2-popup {
    font-size: 0.875rem; /* Mengubah ukuran font */
    max-width: 400px; /* Mengurangi lebar maksimum modal */
    padding: 1.25rem; /* Mengurangi padding modal */
}

    .swal2-popup {
        font-size: 0.875rem;
        max-width: 400px;
        padding: 1.25rem;
    }


.modal-header.bg-primary {
  background-color: #007bff !important;
}

.modal-header .modal-title {
  font-weight: bold;
  font-size: 1.25rem;
}

.modal-body p {
  font-size: 1rem;
  margin-bottom: 0.5rem;
}

.modal-body span {
  font-weight: bold;
  color: #555;
}

.modal-footer .btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
}

.modal-footer .btn-secondary:hover {
  background-color: #5a6268;
  border-color: #545b62;
}

.modal-dialog {
  max-width: 600px;
}

.modal-content {
  border-radius: 10px;
}
tr:nth-child(even) {
  background-color: #bbb8b8;
}

.status-not {
  background-color: rgb(255, 238, 0);
  border-radius: 10%;
  padding: 10px;
  display: inline-block;
  width: 150px;
  height: 30px;
  line-height: 10px;
  text-align: center;
}

.status-approved {
  background-color: green;
  border-radius: 10%;
  padding: 10px;
  display: inline-block;
  width: 100px;
  height: 30px;
  line-height: 10px;
  text-align: center;
  color: white;
}
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">History Material OUT TO Line</h1>
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
            <h3 class="card-title">List Data History</h3>
            <div class="card-tools">
              <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="detailModalLabel">Detail Item</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row mb-3">
                        <div class="col-12">
                          <p><strong>Detail Material:</strong> <span id="detailMaterial"></span></p>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-6">
                          <p><strong>Time Scan OUT:</strong> <span id="timeScanOut"></span></p>
                        </div>
                        <div class="col-6">
                          <p><strong>Status:</strong> <span id="status"></span></p>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-6">
                          <p><strong>Material Out:</strong> <span id="materialId"></span></p>
                        </div>
                        <div class="col-6">
                          <p><strong>Qty Out:</strong> <span id="qtyOut"></span></p>
                        </div>
                        <div class="col-6">
                          <p><strong>no:</strong> <span id="no"></span></p>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-6">
                          <p><strong>Scan By:</strong> <span id="scanBy"></span></p>
                        </div>
                        <div class="col-6">
                          <p><strong>Update By:</strong> <span id="updatedby"></span></p>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-12">
                          <p><strong>Time Out:</strong> <span id="timeOut"></span></p>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <!-- Tambahkan atribut data-dismiss="modal" -->
                  </div>
                  </div>
                </div>
              </div>
            
            </div>
          </div>
          <div class="card-body">
            <table id="tableHeader" class="table table-bordered table-striped">
              <thead class="tabel-warning">
                <tr>
                  <th>No</th>
                  <th class="text-center">Detail Material</th>
                  <th class="text-center">Time Scan OUT</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Scan By</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="results-tbody">
                @foreach($scanned_results as $index => $result)
                <tr>
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ $result->result_text }}</td>
                  <td class="text-center">{{ $result->created_at }}</td>
                  <td class="text-center">
                    <span class="{{ $result->status == 'NOT-APPROVED' ? 'status-not' : ($result->status == 'APPROVED' ? 'status-approved' : '') }}">  {{ $result->status }}</span>
                  </td>
                  <td class="text-center">{{ $result->created_by_name }}</td>
                    <td class="text-center">
                      <button class="btn btn-success btn-approve" data-id="{{ $result->id }}" {{ $result->status == 'APPROVED' ? 'disabled' : '' }}>Approve</button>
                      <button class="btn btn-info btn-detail" data-id="{{ $result->id }}" data-toggle="modal" data-target="#detailModal">Detail</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
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
    var table = $('#tableHeader').DataTable({
        columnDefs: [{
            "targets": [0],
            "orderable": false,
        }],
        responsive: true,
        fixedColumns: true,
        oLanguage: {
            sProcessing: '<img src="{{asset('dist/img/Hourglass.gif')}}">Loading . . .'
        },
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });

    $('#tableSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#tableHeader').on('click', '.btn-detail', function() {
        var id = $(this).data('id');

        $.ajax({ 
            url: '/history/detail/' + id,
            method: 'GET',
            success: function(response) {
                var created_at = new Date(response.created_at).toLocaleString();
                var updated_at = new Date(response.updated_at).toLocaleString();

                $('#detailMaterial').text(response.result_text);
                $('#timeScanOut').text(created_at);
                $('#status').text(response.status);
                $('#scanBy').text(response.createdby);
                $('#updatedby').text(response.updated_by);
                $('#timeOut').text(updated_at);
                $('#materialId').text(response.material_id);
                $('#qtyOut').text(response.qty_out);
                $('#no').text(response.no);

                $('#detailModal').modal('show');
            },
            error: function() {
                alert('An error occurred while fetching details.');
            }
        });
    });
$(document).ready(function() {
    $('#tableHeader').on('click', '.btn-approve', function() {
        var id = $(this).data('id');
        var itemText = $(this).closest('tr').find('.text-center:eq(1)').text();
        if (!itemText.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the item detail first!'
            });
            return;
        }

        Swal.fire({
            title: 'Approve Material',
            html: `
                    <select style="width: 100%;" id="materialId" class="form-control select2" required>
                        <option value="" selected>- pilih -</option>
                        @foreach ($rm_materials as $material)
                            <option value="{{ $material->id }}">{{ $material->spek }}</option>
                        @endforeach
                    </select>
                </div>
                <input id="qtyOut" class="swal2-input" placeholder="Quantity Out">
                <input id="no" class="swal2-input" placeholder="no">
            `,
            showCancelButton: true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const materialId = Swal.getPopup().querySelector('#materialId').value;
                const qtyOut = Swal.getPopup().querySelector('#qtyOut').value;
                const no = Swal.getPopup().querySelector('#no').value;
                if (!materialId || !qtyOut || !no) {
                    Swal.showValidationMessage('Column qty request not empty');
                }
                return { materialId: materialId, qtyOut: qtyOut, no: no };
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value.materialId && result.value.qtyOut && result.value.no) {
                $.ajax({
                    url: '{{ route("history.approve") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        material_id: result.value.materialId,
                        qty_out: result.value.qtyOut,
                        no: result.value.no,
                    },
                    success: function(response) {
                        if (response.success) {
                            var row = $('button[data-id="' + id + '"]').closest('tr');
                            var statusCell = row.find('span');
                            statusCell.removeClass('status-not').addClass('status-approved').text('APPROVED');
                            row.find('.btn-approve').prop('disabled', true);
                            row.find('.btn-detail').prop('disabled', true);

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Item has been approved successfully!'
                            });
                        } else {
                            alert('Approval failed!');
                        }
                    },
                });
            }
        });
    });
});
});
</script>

@endpush

@push('stylesheets')
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
