<?php
  $route = \Route::currentRouteName();
  if (is_null($route)) $route = 'home';
?>

<header id="header" >
  <div class="headerbar">
    <div class="headerbar-left">
      <ul class="header-nav header-nav-options">
        <li class="header-nav-brand" >
          <div class="brand-holder">
            <a href="{{ route('home', ['lang' => \App::getLocale()]) }}">
              <span class="text-primary">{{ strtoupper(config('app.name')) }} @lang('header.title')</span>
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

    <div class="headerbar-right">
      <ul class="header-nav header-nav-profile">
        <li class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-icon-toggle" data-toggle="dropdown">
            <i class="md md-account-balance-wallet"></i>
          </a>
          <ul class="dropdown-menu animation-dock">
            <li class="dropdown-header">@lang('header.wallet')</li>
            <li><a href="#">@lang('header.roi'): USD {{ number_format($member->roi_wallet, 0) }}</a></li>
            <li><a href="#">@lang('header.cash'): USD {{ number_format($member->cash_wallet, 0) }}</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('logout', ['lang' => \App::getLocale()]) }}"><i class="md md-settings-power text-danger"></i> @lang('header.logout')</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-icon-toggle" data-toggle="dropdown">
            <i class="md md-language"></i>
          </a>
          <ul class="dropdown-menu animation-dock">
            <li>
              <a href="{{ route($route, ['lang' => 'en']) }}">English Version</a>
            </li>
            <li>
              <a href="{{ route($route, ['lang' => 'ch']) }}">中文版</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>
