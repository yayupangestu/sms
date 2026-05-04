




@extends('layouts.app')

@section('content')

{{-- DATATABLES CDN --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 4px 10px;
        border-radius: 6px !important;
        border: 1px solid #ddd !important;
        margin: 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #007bff !important;
        color: white !important;
        border: 1px solid #007bff !important;
    }
</style>



<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Log Activity</h1>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- FILTER BOX -->
    <div class="card shadow-sm">
      <div class="card-body">
        <form method="GET" action="{{ route('logactivity.index') }}">
          <div class="row">

            <div class="col-md-3">
              <label>User</label>
              <select name="user_id" class="form-control">
                <option value="">-- All User --</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->username }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3">
              <label>Date From</label>
              <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
            </div>

            <div class="col-md-3">
              <label>Date To</label>
              <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>

          </div>
        </form>
      </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm mt-3">
      <div class="card-body table-responsive">

        <table id="logTable" class="table table-striped table-bordered nowrap" style="width: 100%;">
          <thead class="bg-dark text-white">
            <tr>
              <th>No</th>
              <th>User</th>
              <th>Activity</th>
              <th>Date</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($logs as $index => $log)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $log->user->username ?? '-' }}</td>
              <td>{{ $log->activity }}</td>
              <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>

  </div>
</section>


@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#logTable').DataTable({
        responsive: true,
        pageLength: 30,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [[3, "desc"]],
        autoWidth: false,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching data found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
});
</script>
@endpush
@endsection

