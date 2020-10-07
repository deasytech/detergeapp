@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/buttons.bootstrap4.css') }}">
@endsection
@section('content')
<div class="dashboard-main-wrapper">
    @include('includes.navbar')
    @include('includes.left_sidebar')
    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Invoice Management</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"
                                            class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">All Invoices</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    @include('notifications.alert')
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                {!! $dataTable->table() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="payLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Payment Status</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <form class="form" action="{{ route('account.update.status') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="customer_type_id">Payment Status</label>
                                <hr class="mt-0">
                                <div class="custom-controls-stacked">
                                    @foreach (paymentStatus() as $payment => $value)
                                    <label class="custom-control custom-checkbox">
                                        <input type="radio" name="status" data-check="{{ $value['name'] }}" required value="{{ $value['name'] }}"
                                            id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span
                                            class="custom-control-label">{{ $value['display'] }}</span>
                                    </label>
                                    @endforeach
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
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#pay').on('shown.bs.modal', function (event) {
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
        })
    });
</script>
{!! $dataTable->scripts() !!}
@endsection