@extends('layouts.app')
@section('styles')
  <style media="all">
  .field-icon {
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;
    z-index: 2;
  }
  </style>
@endsection
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
              <h2 class="pageheader-title">Add New Staff</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}" class="breadcrumb-link">Staff</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Staff</li>
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
                <form action="{{ route('staff.store') }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="name">Staff Name</label>
                    <input id="name" type="text" name="name" data-parsley-trigger="change" value="{{ old('name') }}" required="" autofocus autocomplete="off" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" data-parsley-type="email" value="{{ old('email') }}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="password">Password</label>
                      <input id="password" name="password" type="password" required="" class="form-control">
                      <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password mr-2"></span>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="password_confirmation">Retype Password</label>
                      <input id="password_confirmation" name="password_confirmation" data-parsley-equalto="#password" type="password" required="" class="form-control">
                      <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password mr-2"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input id="telephone" data-parsley-type="number" type="text" name="telephone" value="{{ old('telephone') }}" required="" class="form-control">
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="location">Location</label>
                      <input id="location" name="location" type="text" required="" class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="birthday">Birthday</label>
                      <input id="birthday" name="birthday" type="date" class="form-control date-inputmask" value="{{ old('birthday') }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="address">Address</label>
                      <textarea id="address" name="address" required="" rows="4" class="form-control">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="address">Roles</label>
                      @foreach (presentAllRoles() as $role)
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="roles[]" value="{{ $role->id }}">
                          <span class="custom-control-label">{{ $role->name }}</span>
                        </label>
                      @endforeach
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
                        <input type="radio" name="status" value="0" id="stat1" data-parsley-multiple="group2" class="custom-control-input"><span class="custom-control-label">Inactive</span>
                      </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <button class="btn btn-space btn-secondary" onclick="window.location.href='/staff'">Cancel</button>
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
  <script src="{{ asset('vendor/inputmask/js/jquery.inputmask.bundle.js') }}"></script>
  <script>
  $('#form').parsley();
  $(function(e) {
    "use strict";
    $(".date-inputmask").inputmask("dd/mm/yyyy")
  });

  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  </script>
@endsection
