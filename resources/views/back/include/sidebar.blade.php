<?php $route = \Route::currentRouteName(); ?>
<div id="menubar" class="menubar-inverse ">
  <div class="menubar-fixed-panel">
    <div>
      <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="expanded">
      <a href="{{ route('home') }}">
        <span class="text-lg text-bold text-primary ">{{ strtoupper(config('app.name')) }}&nbsp;DASHBOARD</span>
      </a>
    </div>
  </div>
  <div class="menubar-scroll-panel">
    <ul id="main-menu" class="gui-controls">
      <li @if ($route == 'admin.index') class="active" @endif>
        <a href="{{ route('admin.index') }}">
          <div class="gui-icon"><i class="md md-dashboard"></i></div>
          <span class="title">Home</span>
        </a>
      </li>
      <li class="gui-folder @if (strpos($route, 'settings') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-settings"></i></div>
          <span class="title">Settings</span>
        </a>
        <ul>
          <li><a href="{{ route('admin.settings') }}">Account Settings</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'member') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-accessibility"></i></div>
          <span class="title">Member</span>
        </a>
        <ul>
          <li><a href="{{ route('admin.member.register') }}">Register New Member</a></li>
          <li><a href="{{ route('admin.member.list') }}">All Members</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'package') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-wallet-giftcard"></i></div>
          <span class="title">Package</span>
        </a>
        <ul>
          <li><a href="{{ route('admin.package') }}">Configure</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'transaction') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-swap-vert-circle"></i></div>
          <span class="title">Withdraw</span>
        </a>
        <ul>
          <li><a href="{{ route('admin.withdraw.list') }}">All Withdraws</a></li>
        </ul>
      </li>
      <li>
        <a href="{{ route('admin.logout') }}">
          <div class="gui-icon"><i class="md md-settings-power"></i></div>
          <span class="title">Logout</span>
        </a>
      </li>
    </ul>
    <div class="menubar-foot-panel">
      <small class="no-linebreak hidden-folded">
        <span class="opacity-75">Copyright &copy; 2007-2017</span><br>Chancery Investment Management</strong>
      </small>
    </div>
  </div>
</div>
