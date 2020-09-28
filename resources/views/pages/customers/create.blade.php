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
              <h2 class="pageheader-title">Add New Customer</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}" class="breadcrumb-link">Customers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Customer</li>
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
                <form action="{{ route('customer.store') }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="name">Customer Name</label>
                    <input id="name" type="text" name="name" data-parsley-trigger="change" required="" autofocus autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" data-parsley-type="email" data-parsley-trigger="change" autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input id="telephone" data-parsley-type="number" type="text" name="telephone" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input id="location" name="location" type="text" required="" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required="" rows="4" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="customer_type_id">Customer Type</label>
                    <hr class="mt-0">
                    <div class="custom-controls-stacked">
                      @foreach (presentCustomerTypes() as $type)
                        <label class="custom-control custom-checkbox">
                          <input type="radio" name="customer_type_id" required value="{{ $type->id }}" id="e1" data-parsley-multiple="group1" data-parsley-errors-container="#error-container2" class="custom-control-input"><span class="custom-control-label">{{ $type->name }}</span>
                        </label>
                      @endforeach
                      <div id="error-container2"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="customer_type_id">Availability Status</label>
                    <hr class="mt-0">
                    <div class="custom-controls-stacked">
                      <label class="custom-control custom-checkbox">
                        <input type="radio" name="status" value="1" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">Active</span>
                      </label>
                      <label class="custom-control custom-checkbox">
                        <input type="radio" name="status" value="0" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">In-active</span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3" class="form-control"></textarea>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <button class="btn btn-space btn-secondary" onclick="window.location.href='/customer'">Cancel</button>
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
  <script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>
@endsection
