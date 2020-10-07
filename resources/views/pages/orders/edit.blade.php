@extends('layouts.app')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
            <h2 class="pageheader-title">Update Order</h2>
            <div class="page-breadcrumb">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}"
                      class="breadcrumb-link">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('order.index') }}" class="breadcrumb-link">Orders</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Update Order</li>
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
              <form action="{{ route('order.update', $order->id) }}" id="basicform" data-parsley-validate=""
                method="post">
                @csrf
                {{ method_field('PUT') }}
                <div class="row">
                  <div class="form-group col-md-4">
                    <label for="customer_id">Customer Name</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                      <option></option>
                      @foreach(presentCustomers() as $customer)
                      <option value="{{ $customer->id }}" {{ $customer->id == $order->customer_id ? 'selected' : '' }}>
                        {{ $customer->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="vendor_id">Technician to assign</label>
                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                      <option></option>
                      @foreach(presentVendors() as $technician)
                      <option value="{{ $technician->id }}"
                        {{ $technician->id == $order->vendor_id ? 'selected' : '' }}>{{ $technician->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="vendor_id">Service Type</label>
                    <select class="form-control" id="service_type_id" name="service_type_id" required>
                      <option>Choose Service Type</option>
                      @foreach(presentServiceTypes() as $service)
                      <option value="{{ $service->id }}"
                        {{ $service->id == $order->service_type_id ? 'selected' : '' }}>{{ $service->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="service_location">Service Location</label>
                    <select class="form-control" name="service_location" required>
                      <option>Choose Option</option>
                      @foreach(state() as $state)
                      <option value="{{ $state->name }}" @if ($order->service_location == $state->name)
                        selected
                        @endif>{{ $state->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="service_day">Actual Service Date</label>
                    <input type="date" name="actual_service_date" class="form-control" required
                      value="{{ $order->actual_service_date }}">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="cost">Service Cost</label>
                    <input id="cost" name="cost" type="text" required="" class="form-control"
                      value="{{ $order->cost }}">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="other_cost">Other Expenses</label>
                    <input id="other_cost" name="other_cost" type="text" class="form-control"
                      value="{{ $order->other_cost }}">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="dispenser_brand">Dispenser Brand</label>
                    <input id="dispenser_brand" type="text" name="dispenser_brand" required="" class="form-control"
                      value="{{ $order->dispenser_brand }}">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="dispenser_quantity">Dispenser Quantity</label>
                    <input id="dispenser_quantity" name="dispenser_quantity" type="text" required=""
                      class="form-control" value="{{ $order->dispenser_quantity }}">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="disinfect">Disinfect</label>
                    <hr class="mt-0 mb-1">
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="disinfect" {{ $order->disinfect == 1 ? 'checked' : '' }} value="1"
                        class="custom-control-input">
                      <span class="custom-control-label">Yes</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" name="disinfect" {{ $order->disinfect == 0 ? 'checked' : '' }} value="0"
                        class="custom-control-input">
                      <span class="custom-control-label">No</span>
                    </label>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="disinfect">Periodic Service Category</label>
                    <select class="form-control" name="periodic_service_category_id" required>
                      <option>Select Option</option>
                      @foreach(periodicServices() as $periodic)
                      <option value="{{ $periodic->id }}" @if ($order->periodic_service_category_id == $periodic->id)
                        selected
                        @endif>{{ $periodic->description }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="problem_description">Problem Description</label>
                  <textarea id="problem_description" name="problem_description" required="" rows="4"
                    class="form-control">{{ $order->problem_description }}</textarea>
                </div>
                <div class="row">
                  <div class="col-sm-12 pl-0">
                    <p class="text-right">
                      <button type="submit" class="btn btn-space btn-primary">Submit</button>
                      <button class="btn btn-space btn-secondary"
                        onclick="window.location.href='/order'">Cancel</button>
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