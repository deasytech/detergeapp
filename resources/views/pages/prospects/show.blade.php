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
                            <h2 class="pageheader-title">Prospective Customer Management</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('prospect.index') }}" class="breadcrumb-link">Prospective Customers</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Prospective Customer Detail</li>
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
                                <a href="{{ route('prospect.edit', $prospect->id) }}" class="btn btn-sm btn-warning float-right">Edit</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <th>Organisation</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $prospect->organisation }}</td>
                                                <td>{{ $prospect->customer_phone_number }}</td>
                                                <td>{{ $prospect->contact_email }}</td>
                                                <td>{{ $prospect->physical_address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nature of Business</th>
                                                <th>Date Added</th>
                                                <th colspan="2">Feedback</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $prospect->nature_of_business }}</td>
                                                <td>{{ presentDate($prospect->created_at) }}</td>
                                                <td colspan="2">
                                                    @if ($prospect->notes->count() != 0)
                                                        <ul class="list">
                                                            @foreach ($prospect->notes as $note)
                                                                <li>{{ $note->details }} - {{ presentDate($note->created_at) }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        No notes currently
                                                    @endif
                                                </td>
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
