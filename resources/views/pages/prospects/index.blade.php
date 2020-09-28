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
                            <h2 class="pageheader-title">Prospective Customers Management</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">All Prospective Customers</li>
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
                            <div class="card-header">
                                <a href="{{ route('prospect.create') }}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Organisation</th>
                                                <th>Nature of Business</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Organisation</th>
                                                <th>Nature of Business</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Location</th>
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
            <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="feedbackLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Client Feedback</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <form class="form" action="{{ route('prospect.feedback') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="feedback">Feedback</label>
                                    <textarea id="feedback" name="details" rows="5" value="{{ old('feedback') }}" class="form-control"></textarea>
                                </div>
                                <input type="hidden" name="prospect_id">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Post Feedback</button>
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
            ajax: '{!! route('ajax.prospects') !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'organisation', name: 'organisation' },
                { data: 'nature_of_business', name: 'nature_of_business' },
                { data: 'contact_phone_number', name: 'contact_phone_number' },
                { data: 'contact_email', name: 'contact_email' },
                { data: 'physical_address', name: 'physical_address' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#feedback').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            console.log(button.data)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body input[name="prospect_id"]').val(id)
        });
    });
    </script>
@endsection
