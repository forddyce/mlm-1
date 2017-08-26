<header id="header" >
  <div class="headerbar">
    <div class="headerbar-left">
      <ul class="header-nav header-nav-options">
        <li class="header-nav-brand" >
          <div class="brand-holder">
            <a href="{{ route('admin.index') }}">
              <span class="text-primary">{{ strtoupper(config('app.name')) }} DASHBOARD</span>
            </a>
          </div>
        </li>
        <li>
          <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
            <i class="md md-menu"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
