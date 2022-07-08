<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="WolfooGames Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">WolfooGames</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
        @php
        $user = Auth::user();

        $avatar = '/dist/img/user2-160x160.jpg';
        if (!is_null($user->profile_photo_path) && !empty($user->profile_photo_path)) {
            $avatar = $user->profile_photo_path;
        }
        @endphp
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ $avatar }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" style="padding-top: 0!important;">
          <div><a href="/system/user/profile" class="d-block">{{ $user->name }}</a></div>
          <div>
            <!-- Authentication -->
            <form method="POST" id="form_logout" action="{{ route('logout') }}">@csrf
                <a href="{{ route('logout') }}" onclick="$('#form_logout').submit(); return false;"><small>{{ __('Log Out') }}</small></a>
            </form>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/dashboard" class="nav-link @yield('nav-dashboard','')">
              <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">CONTENT</li>
          <li class="nav-item">
            <a href="/content/game" class="nav-link @yield('nav-game','')"><i class="nav-icon fas fa-gamepad"></i>
              <p>Game</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/charactor" class="nav-link @yield('nav-charactor','')"><i class="nav-icon fas fa-portrait"></i>
              <p>Charactor</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/video" class="nav-link @yield('nav-video','')"><i class="nav-icon fas fa-video"></i>
              <p>Video</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/news" class="nav-link @yield('nav-news','')"><i class="nav-icon far fa-newspaper"></i>
              <p>News</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/slider" class="nav-link @yield('nav-slider','')"><i class="nav-icon far fa-images"></i>
              <p>Slider</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/channel" class="nav-link @yield('nav-channel','')"><i class="nav-icon far fa-images"></i>
              <p>Channel</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/message" class="nav-link @yield('nav-message','')"><i class="nav-icon far fa-images"></i>
              <p>Messages</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/content/page" class="nav-link @yield('nav-page','')"><i class="nav-icon far fa-images"></i>
              <p>Pages</p>
            </a>
          </li>
          @if (in_array(Auth::user()->email, config('app.super_emails')))
          <li class="nav-header">SYSTEM</li>
          <li class="nav-item">
            <a href="/system/user/list" class="nav-link @yield('nav-user-list','')"><i class="nav-icon fas fa-users"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
          <a href="/system/config" class="nav-link @yield('nav-config','')"><i class="nav-icon fas fa-cog"></i>
              <p>Config</p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
