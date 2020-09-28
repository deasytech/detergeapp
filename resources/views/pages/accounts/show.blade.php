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
                            <h2 class="pageheader-title">Show Invoice</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('account.index') }}" class="breadcrumb-link">Invoices</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Invoice Detail</li>
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
                                <a href="{{route('account.index')}}" class="btn btn-sm btn-dark">Back</a>
                                <a href="{{route('account.edit', $invoice->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                <form style="display: inline-block;" method="post" action="{{route('account.destroy', $invoice->id)}}" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Invoice No.</label>
                                            <p>{{$invoice->invoice_no}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Grand Total</label>
                                            <p>{{ presentPrice($invoice->grand_total) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Client & Technician</label>
                                            <p>{{$invoice->customer->name}} | Technician: {{ $invoice->technician->name }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Client Address</label>
                                            <pre class="pre">{{$invoice->address}}</pre>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <p>{{$invoice->title}}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Invoice Date</label>
                                                <p>{{$invoice->invoice_date}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Due Date</label>
                                                <p>{{$invoice->due_date}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Service Type</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->services as $service)
                                            <tr>
                                                <td class="table-name">{{ $service->serviceType->name }}</td>
                                                <td class="table-price">{{ presentPrice($service->price) }}</td>
                                                <td class="table-qty">{{ $service->quantity }}</td>
                                                <td class="table-total text-right">{{ presentPrice($service->quantity * $service->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="table-empty" colspan="2"></td>
                                            <td class="table-label">Sub Total</td>
                                            <td class="table-amount text-right">{{ presentPrice($invoice->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-empty" colspan="2"></td>
                                            <td class="table-label">Discount</td>
                                            <td class="table-amount text-right">{{ presentPrice($invoice->discount) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-empty" colspan="2"></td>
                                            <td class="table-label">Grand Total</td>
                                            <td class="table-amount text-right">{{ presentPrice($invoice->grand_total) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
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
