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
                            <h2 class="pageheader-title">Add New Settings</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('setting.index') }}" class="breadcrumb-link">Settings</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">New Order</li>
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
                                <form action="{{ route('setting.store') }}" id="basicform" data-parsley-validate="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="display_name">Display Name</label>
                                            <input id="display_name" type="text" name="display_name" required data-parsley-trigger="change" value="{{ old('display_name') }}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="key">Key</label>
                                            <input id="key" type="text" name="key" required data-parsley-trigger="change" value="{{ old('key') }}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="type">Input Type</label>
                                            <select name="type" class="form-control" id="type" required>
                                                <option value="">Choose Type</option>
                                                <option value="text">Text Box</option>
                                                <option value="textarea">Text Area</option>
                                                <option value="file">File</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="displayValue" style="display:none">
                                        <div class="form-group col-md-12">
                                            <label>Value</label>
                                            <div id="elementType"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="text-right">
                                                <button type="submit" class="btn btn-space btn-primary">Save Setting</button>
                                                <a href="{{ route('setting.index') }}" class="btn btn-space btn-secondary">Cancel</a>
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
    $('#display_name').keyup('on', function() {
        $('#key').val(convertToSlug(this.value));
    });
    function convertToSlug(Text) {
        return Text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
    }
    $('#type').on('change', function() {
        $("#elementType").html("");
        $('#displayValue').show();
        var type = $(this).val();
        if (type == 'textarea') {
            $("#elementType").append('<textarea name="value" required data-parsley-trigger="change" value="{{ old('value') }}" class="form-control"></textarea>');
        } else {
            $("#elementType").append('<input type="'+type+'" name="value" required data-parsley-trigger="change" value="{{ old('value') }}" class="form-control">');
        }
    });
</script>
@endsection
