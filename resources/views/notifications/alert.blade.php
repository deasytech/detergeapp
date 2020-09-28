@if (Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success:</strong> {{ Session::get('success') }}
    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
@endif

@if (count($errors) > 0)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Errors:</strong>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
@endif

@if (Session::has('warning'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Warning:</strong> {{ Session::get('warning') }}
    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
@endif

@if (Session::has('info'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Information:</strong> {{ Session::get('info') }}
    <a href="#" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
@endif
