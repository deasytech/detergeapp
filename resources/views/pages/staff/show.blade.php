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
                            <h2 class="pageheader-title">Staff Management</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('staff.index') }}" class="breadcrumb-link">Staff</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Staff Detail</li>
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
                                <a href="{{ route('staff.create') }}" class="btn btn-sm btn-primary">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Location</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $staff->name }}</td>
                                                <td>{{ $staff->telephone }}</td>
                                                <td>{{ $staff->email }}</td>
                                                <td>{{ $staff->location }}</td>
                                            </tr>
                                            <tr>
                                                <th>Birthday</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Date Added</th>
                                            </tr>
                                            <tr>
                                                <td>{{ presentDate($staff->birthday) }}</td>
                                                <td>{{ $staff->address }}</td>
                                                <td>{{ $staff->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                <td>{{ presentDate($staff->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="4">Roles</th>
                                            </tr>
                                            <tr>
                                                <td colspan="4">{{ ucwords(implode(' | ', $staff->roles->pluck('name')->toArray())) }}</td>
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
