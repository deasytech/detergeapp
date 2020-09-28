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
              <h2 class="pageheader-title">Update Technician</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('technician.index') }}" class="breadcrumb-link">Technicians</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Technician</li>
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
                <form action="{{ route('technician.update', $technician->id) }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="form-group">
                    <label for="name">Technician Name</label>
                    <input id="name" type="text" name="name" data-parsley-trigger="change" value="{{ $technician->name }}" required="" autofocus autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" data-parsley-type="email" value="{{ $technician->email }}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input id="telephone" data-parsley-type="number" type="text" value="{{ $technician->telephone }}" name="telephone" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" name="location" type="text" required="" class="form-control" value="{{ $technician->location }}">
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required="" rows="4" class="form-control">{{ $technician->address }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="technician_type_id">Availability Status</label>
                    <hr class="mt-0">
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-checkbox">
                        <input type="radio" name="status" {{ $technician->status == 1 ? 'checked' : '' }} value="1" id="stat1" data-parsley-multiple="group1" class="custom-control-input"><span class="custom-control-label">Active</span>
                      </label>
                      <label class="custom-control custom-checkbox">
                        <input type="radio" name="status" {{ $technician->status == 0 ? 'checked' : '' }} value="1" id="stat1" data-parsley-multiple="group1" class="custom-control-input"><span class="custom-control-label">Inactive</span>
                      </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <button class="btn btn-space btn-secondary" onclick="window.location.href='/technician'">Cancel</button>
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
