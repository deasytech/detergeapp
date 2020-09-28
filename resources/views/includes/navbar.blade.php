<div class="dashboard-header">
  <nav class="navbar navbar-expand-lg bg-white fixed-top">
    <a class="navbar-brand" href="{{ route('app.dashboard') }}"><img class="logo-img" src="{{ asset('images/logo.png') }}" alt="{{ __('Login') }}"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto navbar-right-top">
        <li class="nav-item dropdown notification">
          <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
          <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
            <li>
              <div class="notification-title"> Notification</div>
              <div class="notification-list">
                <div class="list-group">

                  {{-- <a href="#" class="list-group-item list-group-item-action active">
                  <div class="notification-info">
                  <div class="notification-list-user-img"><img src="{{ asset('images/avatar-2.jpg') }}" alt="" class="user-avatar-md rounded-circle"></div>
                  <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                  <div class="notification-date">2 min ago</div>
                </div>
              </div>
            </a> --}}
            <div class="notification-info">
              <div class="notification-list-user-block">
                No notification at the moment!
              </div>
            </div>
          </div>
        </div>
      </li>
      {{-- <li>
      <div class="list-footer"> <a href="#">View all notifications</a></div>
    </li> --}}
  </ul>
</li>
<li class="nav-item dropdown nav-user">
  @php
  if (presentAvatar(Auth::user()->id)) {
    $file = presentAvatar(Auth::user()->id);
    echo '<a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="' . asset("/storage/avatar/$file") . '" class="user-avatar-md rounded-circle" alt="'.Auth::user()->name.'"></a>';
  }else {
    echo '<a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="user-avatar-md rounded-circle" alt="'.Auth::user()->name.'"></a>';
  }
  @endphp
  <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
    <div class="nav-user-info">
      <h5 class="mb-0 text-white nav-user-name">{{ auth()->user()->name }}</h5>
      <span class="status"></span><span class="ml-2">Available</span>
    </div>
    <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user mr-2"></i>Account</a>
    @can('manage.settings')
      <a class="dropdown-item" href="{{ route('setting.index') }}"><i class="fas fa-cog mr-2"></i>Setting</a>
    @endcan
    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>{{ __('Logout') }}</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
  </li>
</ul>
</div>
</nav>
</div>
