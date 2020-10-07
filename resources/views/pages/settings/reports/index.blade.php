@extends('layouts.app')
@section('content')
<div class="dashboard-main-wrapper">
    @include('includes.navbar')
    @include('includes.left_sidebar')
    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Reports Management</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"
                                            class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Generate Report</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    @include('notifications.alert')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Generate Reports</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        @if (isset($_POST['type']) && $_POST['type'] == 'invoices_report')
                                            @include('pages.settings.reports.partials.invoices')
                                        @elseif(isset($_POST['type']) && $_POST['type'] == 'customer_order_report')
                                            @include('pages.settings.reports.partials.customers')
                                        @elseif(isset($_POST['type']) && $_POST['type'] == 'vendor_report')
                                            @include('pages.settings.reports.partials.technicians')
                                        @else
                                        <table id="basic-datatable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="text-center font-bold">Filter Report!</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Filter</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form" action="{{ route('report.store') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>Report Type</label>
                                            <select class="form-control" name="type" required>
                                                <option value="">Please Select</option>
                                                <option value="invoices_report"
                                                    {{ (isset($_POST['type']) && $_POST['type'] == 'invoices_report') ? 'selected' : '' }}>
                                                    Invoices Report</option>
                                                <option value="customer_order_report"
                                                    {{ (isset($_POST['type']) && $_POST['type'] == 'customer_order_report') ? 'selected' : '' }}>
                                                    Customers Order Report</option>
                                                <option value="vendor_report"
                                                    {{ (isset($_POST['type']) && $_POST['type'] == 'vendor_report') ? 'selected' : '' }}>
                                                    Technician Order Report</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="technician" style="{{ (isset($_POST['type']) && $_POST['type'] == 'vendor_report') ? 'display: block' : 'display: none' }}">
                                            <label>Technicians</label>
                                            <select name="technician" class="form-control">
                                                <option value="">Please Select</option>
                                                @foreach (presentVendors() as $vendor)
                                                    <option value="{{ $vendor->id }}" {{ (isset($_POST['technician']) && $_POST['technician'] == $vendor->id) ? 'selected' : '' }}>{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Date Start</label>
                                            <input type="date" name="date_start"
                                                value="{{ (isset($_POST['type'])) ? $_POST['date_start'] : '' }}"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Date End</label>
                                            <input type="date" name="date_end"
                                                value="{{ (isset($_POST['type'])) ? $_POST['date_end'] : '' }}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group" id="payment_status" style="{{ (isset($_POST['type']) && $_POST['type'] == 'invoices_report') ? 'display: block' : 'display: none' }}">
                                            <label>Payment Status</label>
                                            <select class="form-control" name="payment_status">
                                                <option value="">Please Select</option>
                                                @foreach (paymentStatus() as $payment => $value)
                                                    <option value="{{ $value['name'] }}" {{ (isset($_POST['payment_status']) && $_POST['payment_status'] == $value['name']) ? 'selected' : '' }}>{{ $value['display'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.footer')
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $("select[name=type]").on('change', function() {
            if(this.value == 'invoices_report') {
                $("#payment_status").show();
                $("[name=payment_status]").attr("required", true);
            } else {
                $("#payment_status").hide();
                $("[name=payment_status]").attr("required", false);
            }
            
            if(this.value == 'vendor_report') {
                $("#technician").show();
                $("[name=technician]").attr("required", true);
            } else {
                $("#technician").hide();
                $("[name=technician]").attr("required", false);
            }
        })
    </script>
@endsection