  <!-- User (xs) -->
  <div class="navbar-user d-md-none">
    <!-- Dropdown -->
    <div class="dropdown">
      <!-- Toggle -->
      <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false">
      <div class="avatar avatar-sm avatar-online">
        <img src="{{asset("img/user-default.jpg")}}" class="rounded-circle" alt="..." width="40px">
      </div>
    </a>
    <!-- Menu -->
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
      <a href="/settings/profile" class="dropdown-item">Profile</a>
      <a href="/settings/profile" class="dropdown-item">Settings</a>
      <hr class="dropdown-divider">
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </div>
</div>