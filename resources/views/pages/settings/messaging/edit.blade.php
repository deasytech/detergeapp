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
              <h2 class="pageheader-title">Messaging</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Messaging</li>
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
          <!-- basic form -->
          <!-- ============================================================== -->
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('notifications.alert')
            <div class="card">
              <div class="card-body">
                <form action="{{ route('messaging.update', $messaging->id) }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Mail From Address</label>
                      <input type="text" name="from_email" required value="{{ $messaging->from_email }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Mail From Name</label>
                      <input type="text" name="from_name" required value="{{ $messaging->from_name }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Mail Host</label>
                      <input type="text" name="host" data-parsley-trigger="change" value="{{ $messaging->host }}" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Mail Port</label>
                      <input type="text" name="port" data-parsley-trigger="change" value="{{ $messaging->port }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Mail Username</label>
                      <input type="text" name="username" data-parsley-trigger="change" value="{{ $messaging->username }}" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                      <label>Mail Password</label>
                      <input type="text" name="password" data-parsley-trigger="change" value="{{ $messaging->password }}" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="encryption">Mail Encryption</label>
                      <select class="form-control" id="encryption" name="encryption">
                        <option value="">Please Select</option>
                        <option value="ssl" {{ ($messaging->encryption == 1) ? 'ssl' : '' }}>SSL</option>
                        <option value="tls" {{ ($messaging->encryption == 0) ? 'tls' : '' }}>TLS</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Save</button>
                      </p>
                    </div>
                  </div>
                </form>
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
  <script src="{{ asset('vendor/parsley/parsley.js') }}"></script>
  <script>
  $('#form').parsley();
  </script>
@endsection
