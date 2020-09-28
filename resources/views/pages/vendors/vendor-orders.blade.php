@extends('layouts.app')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/buttons.bootstrap4.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/select.bootstrap4.css') }}">
@endsection
@section('content')
  <div class="dashboard-main-wrapper">
    @include('includes.navbar')
    @include('includes.left_sidebar')
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
      <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
              <h2 class="pageheader-title">Technician Requests</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Requests</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
          <!-- ============================================================== -->
          <!-- data table  -->
          <!-- ============================================================== -->
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('notifications.alert')
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Technician</th>
                        <th>Customer Name</th>
                        <th>Telephone</th>
                        <th>Location</th>
                        <th>Service Type</th>
                        <th>Service Date</th>
                        <th>Service Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Technician</th>
                        <th>Customer Name</th>
                        <th>Telephone</th>
                        <th>Location</th>
                        <th>Service Type</th>
                        <th>Service Date</th>
                        <th>Service Status</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- end data table  -->
          <!-- ============================================================== -->
        </div>
      </div>
      <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Change Request Status</h5>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </a>
            </div>
            <form class="form" action="{{ route('technician.update.status') }}" method="post">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="customer_type_id">Status</label>
                  <hr class="mt-0">
                  <div class="custom-controls-stacked">
                    <label class="custom-control custom-checkbox">
                      <input type="radio" name="status" required value="pending" data-check="pending" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">Pending</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="radio" name="status" required value="on-going" data-check="on-going" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">On-going</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input type="radio" name="status" required value="completed" data-check="completed" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">Completed</span>
                    </label>
                  </div>
                </div>
                <input type="hidden" name="id">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @include('includes.footer')
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/jszip.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/pdfmake.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/js/dataTables.select.min.js') }}"></script>
  <script>
  $(document).ready(function() {
    $('#basic-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('technician.ajax.orders') !!}',
      columns: [
        { data: 'id', name: 'id' },
        { data: 'vendor_id', name: 'vendor_id' },
        { data: 'customer_id', name: 'customer_id' },
        { data: 'telephone', name: 'telephone', searchable: false },
        { data: 'service_location', name: 'service_location' },
        { data: 'service_type_id', name: 'service_type_id' },
        { data: 'actual_service_date', name: 'actual_service_date' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
      ]
    });

    $('#changeStatus').on('shown.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id')
      var status = button.data('status')
      var modal = $(this)
      modal.find('.modal-body input[name="id"]').val(id)
      $(':radio').each(function(i,val) {
        if(val.value == status) {
          $('input[data-check='+status+']').prop("checked", true);
        }
      });
    });
  });
  </script>
@endsection
