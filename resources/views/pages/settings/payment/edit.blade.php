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
              <h2 class="pageheader-title">Payment Method</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Payment Method</li>
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
                <form action="{{ route('payment-gateway.update', $paymentMethod->id) }}" id="basicform" data-parsley-validate="" method="post">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Label</label>
                      <input type="text" name="label" data-parsley-trigger="change" value="{{ $paymentMethod->label }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Description</label>
                      <input type="text" name="description" value="{{ $paymentMethod->description }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Payment URL</label>
                      <input type="text" name="payment_url" data-parsley-trigger="change" value="{{ $paymentMethod->payment_url }}" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Public Key</label>
                      <input type="text" name="public_key" data-parsley-trigger="change" value="{{ $paymentMethod->public_key }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label>Secret Key</label>
                      <input type="text" name="secret_key" data-parsley-trigger="change" value="{{ $paymentMethod->secret_key }}" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                      <label>Merchant Email</label>
                      <input type="text" name="merchant_email" data-parsley-trigger="change" value="{{ $paymentMethod->merchant_email }}" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option value="1" {{ ($paymentMethod->status == 1) ? 'selected' : '' }}>Enable</option>
                        <option value="0" {{ ($paymentMethod->status == 0) ? 'selected' : '' }}>Disable</option>
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
