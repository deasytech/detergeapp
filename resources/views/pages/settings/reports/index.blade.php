@extends('layouts.app')
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
                            <h2 class="pageheader-title">Reports Management</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Generate Report</li>
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
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                        @include('notifications.alert')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">Invoices Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                                                <tbody>
                                                    <tr>
                                                        <th>Invoice Date</th>
                                                        <th>Due Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Grand Total</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                        <form class="form" action="#" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label>Report Type</label>
                                                <select class="form-control" name="type">
                                                    <option value="invoices_report">Invoices Report</option>
                                                    <option value="customer_order_report">Customers Order Report</option>
                                                    <option value="vendor_report">Vendors Report</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Date Start</label>
                                                <input type="date" name="date_start" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Date End</label>
                                                <input type="date" name="date_end" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Payment Status</label>
                                                <select class="form-control" name="payment_status">
                                                    <option value="">Please Select</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                            </div>
                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-primary" disabled>Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
                </div>
            </div>
            @include('includes.footer')
        </div>
    </div>
@endsection
