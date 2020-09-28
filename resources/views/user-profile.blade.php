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
    <div class="dashboard-header">
      @include('includes.navbar')
      @include('includes.left_sidebar')
      <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="page-header">
                <h2 class="pageheader-title">User Profile </h2>
                <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                <div class="page-breadcrumb">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ Auth::user()->hasRole('admin') ? route('app.dashboard') : route('user.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ Auth::user()->name }} Profile</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              @include('notifications.alert')
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="text-center">
                        @php
                        if (presentAvatar(Auth::user()->id)) {
                          $file = presentAvatar(Auth::user()->id);
                          echo '<img src="' . asset("/storage/avatar/$file") . '" class="img-circle img-thumbnail avatar" alt="'.Auth::user()->name.'">';
                        }else {
                          echo '<img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="img-circle img-thumbnail avatar" alt="'.Auth::user()->name.'">';
                        }
                        @endphp
                        <h6>Upload a different photo...</h6>
                        <input type="file" name="avatar" class="text-center center-block file-upload form-control">
                      </div>
                    </div>
                    <div class="col-sm-9">
                      <form id="basicform" data-parsley-validate="" action="{{ route('user.update.profile',Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Names</label>
                              <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                              <label>Email</label>
                              <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Telephone</label>
                              <input type="text" class="form-control" name="telephone" value="{{ Auth::user()->telephone }}">
                            </div>
                            <div class="col-md-6">
                              <label>Location</label>
                              <input type="text" class="form-control" name="location" value="{{ Auth::user()->location }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-3">
                              <label>Birthday</label>
                              <input type="date" class="form-control" name="birthday" value="{{ Auth::user()->birthday }}">
                            </div>
                            <div class="col-md-9">
                              <label>Address</label>
                              <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <small class="text-danger">Leave password field blank if you want to retain current password.</small>
                          <hr>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Current Password</label>
                              <input type="password" class="form-control" name="current_password" id="current_password" autocomplete="false">
                              <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password mr-2"></span>
                            </div>
                            <div class="col-md-6">
                              <label>New Password</label>
                              <input type="password" class="form-control" name="password" id="new_password">
                              <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password mr-2"></span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
                        </div>
                      </form>
                    </div>
                  </div><!--/col-9-->
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
    <script type="text/javascript">
    $(document).ready(function() {
      var readURL = function(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('.avatar').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }
      $(".file-upload").on('change', function(){
        readURL(this);
        var url = "{!! route('user.avatar') !!}";
        var avatar = this.files[0];
        var formData = new FormData();
        formData.append('avatar', this.files[0]);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: url,
          type:"POST",
          data: formData,
          processData: false,
          contentType: false,
          enctype: 'multipart/form-data',
          success:function(res) {
            console.log(res.success);
            // $('#msg').html(res.success);
            // $('#message').slideDown(function() {
            //   setTimeout(function() {
            //     $('#message').slideUp();
            //   }, 3000);
            // });
          }
        });
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
    });
    </script>
  @endsection
