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
              <h2 class="pageheader-title">Add New Prospect</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('prospect.index') }}" class="breadcrumb-link">Prospects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Prospect</li>
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
                <form action="{{ route('prospect.store') }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="name">Organisation</label>
                      <input id="name" type="text" name="organisation" data-parsley-trigger="change" value="{{ old('organisation') }}" required="" autofocus autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email">Email</label>
                      <input id="email" type="email" name="contact_email" data-parsley-type="contact_email" value="{{ old('contact_email') }}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="contact_phone_number">Telephone</label>
                      <input id="contact_phone_number" data-parsley-type="number" type="text" value="{{ old('contact_phone_number') }}" name="contact_phone_number" required="" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="nature_of_business">Nature of Business</label>
                      <input id="nature_of_business" name="nature_of_business" type="text" required="" class="form-control" value="{{ old('nature_of_business') }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="physical_address">Address</label>
                    <textarea id="physical_address" name="physical_address" required="" rows="2" class="form-control">{{ old('physical_address') }}</textarea>
                  </div>
                  <div class="form-group">
                    <label for="feedback">Notes</label>
                    <textarea id="feedback" name="feedback" rows="3" class="form-control">{{ old('feedback') }}</textarea>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <a class="btn btn-space btn-secondary" href="{{ route('prospect.index') }}">Cancel</a>
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
