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
                            <h2 class="pageheader-title">Order Management</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('order.index') }}" class="breadcrumb-link">Orders</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
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
                                <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <th>Order Type</th>
                                                <th>Service Location</th>
                                                <th>Quantity</th>
                                                <th>Service Date</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->service->name }}</td>
                                                <td>{{ $order->service_location }}</td>
                                                <td>{{ $order->dispenser_quantity }}</td>
                                                <td>{{ $order->actual_service_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Customer Phone</th>
                                                <th>Payment Status</th>
                                                <th>Order Status</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>{{ $order->customer->telephone }}</td>
                                                <td>{{ $order->payment_status }}</td>
                                                <td>{{ ucwords($order->status) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Technician</th>
                                                <th>Periodic Service Category</th>
                                                <th>Next Service Date</th>
                                                <th>Problem Description</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->vendor->name }}</td>
                                                <td>{{ $order->periodicServiceCategory->description }}</td>
                                                <td>{{ $order->periodic_service_date }}</td>
                                                <td>{{ $order->problem_description }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Service Cost</th>
                                                <th colspan="2">Other Expenses</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ presentPrice($order->cost) }}</td>
                                                <td colspan="2">{{ presentPrice($order->other_cost) }}</td>
                                            </tr>
                                        </tbody>
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
            @include('includes.footer')
        </div>
    </div>
@endsection
