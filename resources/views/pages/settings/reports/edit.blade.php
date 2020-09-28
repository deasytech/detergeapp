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
              <h2 class="pageheader-title">Update Service</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service.index') }}" class="breadcrumb-link">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Service</li>
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
                <form action="{{ route('service.update', $serviceType->id) }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="row">
                    <div class="form-group col-md-8">
                      <label for="name">Service Location</label>
                      <input id="name" type="text" name="name" data-parsley-trigger="change" value="{{ $serviceType->name }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option value="1" {{ ($serviceType->status == 1) ? 'selected' : '' }}>Enable</option>
                        <option value="0" {{ ($serviceType->status == 0) ? 'selected' : '' }}>Disable</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <a class="btn btn-space btn-secondary" href="{{ route('service.index') }}'">Cancel</a>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script src="{{ asset('vendor/parsley/parsley.js') }}"></script>
  <script>
  $('#form').parsley();
  $("[name=customer_id]").select2({
    placeholder: 'Search for customer',
    allowClear: true
  });
  $("[name=vendor_id]").select2({
    placeholder: 'Search for technician',
    allowClear: true
  });
  </script>
@endsection
