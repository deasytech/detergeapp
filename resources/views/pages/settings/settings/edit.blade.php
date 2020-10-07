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
                <form action="{{ route('setting.update', $setting) }}" id="basicform" data-parsley-validate="" method="post" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="display_name">Display Name</label>
                      <input id="display_name" type="text" name="display_name" required data-parsley-trigger="change" value="{{ $setting->display_name }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="key">Key</label>
                      <input id="key" type="text" name="key" required data-parsley-trigger="change" value="{{ $setting->key }}" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="type">Input Type</label>
                      <input type="text" readonly value="{{ ucwords($setting->type) }}" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    @if ($setting->type == 'file')
                      <div class="col-sm-3 form-group mt-3">
                        <img src="{{ asset('storage/settings/'.$setting->value) }}" alt="{{ $setting->display_name }}" class="img-thumbnail">
                      </div>
                    @endif
                    <div class="form-group {{ $setting->type == 'file' ? 'col-sm-9' : 'col-sm-12' }}">
                      <label>Value</label>
                      <div id="elementType"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 pl-0">
                      <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Submit</button>
                        <a class="btn btn-space btn-secondary" href="{{ route('setting.index') }}">Cancel</a>
                        <input type="hidden" id="currentFileType" value="{{ $setting->type }}">
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

  $('#display_name').keyup('on', function() {
    $('#key').val(convertToSlug(this.value));
  });

  function convertToSlug(Text) {
    return Text
    .toLowerCase()
    .replace(/[^\w ]+/g,'')
    .replace(/ +/g,'-');
  }

  if ($('#currentFileType').val() == 'textarea') {
    $("#elementType").html("");
    $("#elementType").append('<textarea name="value" value="{{ $setting->value }}" class="form-control"></textarea>');
  } else {
    $("#elementType").html("");
    $("#elementType").append('<input type="{{ $setting->type }}" name="value" value="{{ $setting->value }}" class="form-control">');
  }
  </script>
@endsection
