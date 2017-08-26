<?php $route = \Route::currentRouteName(); ?>
<div id="menubar" class="menubar-inverse ">
  <div class="menubar-fixed-panel">
    <div>
      <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="expanded">
      <a href="{{ route('home', ['lang' => \App::getLocale()]) }}">
        <span class="text-lg text-bold text-primary ">{{ strtoupper(config('app.name')) }}&nbsp;@lang('sidebar.title')</span>
      </a>
    </div>
  </div>
  <div class="menubar-scroll-panel">
    <ul id="main-menu" class="gui-controls">
      <li>
        <a href="http://chancery-group.com/hgi/index.html" target="_blank">
          <div class="gui-icon"><i class="md md-home"></i></div>
          <span class="title">@lang('sidebar.mainLink')</span>
        </a>
      </li>
      <li @if ($route == 'home') class="active" @endif>
        <a href="{{ route('home', ['lang' => \App::getLocale()]) }}">
          <div class="gui-icon"><i class="md md-dashboard"></i></div>
          <span class="title">@lang('sidebar.home')</span>
        </a>
      </li>
      <li class="gui-folder @if (strpos($route, 'settings') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-settings"></i></div>
          <span class="title">@lang('sidebar.settingsTitle')</span>
        </a>
        <ul>
          <li><a href="{{ route('settings.main', ['lang' => \App::getLocale()]) }}">@lang('sidebar.settingsAccount')</a></li>
          <li><a href="{{ route('settings.bank', ['lang' => \App::getLocale()]) }}">@lang('sidebar.settingsBank')</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'network') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-settings-input-component"></i></div>
          <span class="title">@lang('sidebar.networkTitle')</span>
        </a>
        <ul>
          <li><a href="{{ route('network', ['lang' => \App::getLocale()]) }}">@lang('sidebar.networkFamily')</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'member') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-exit-to-app"></i></div>
          <span class="title">@lang('sidebar.memberTitle')</span>
        </a>
        <ul>
          <li><a href="{{ route('member.register', ['lang' => \App::getLocale()]) }}">@lang('sidebar.memberNew')</a></li>
          <li><a href="{{ route('member.upgrade', ['lang' => \App::getLocale()]) }}">@lang('sidebar.memberUpgrade')</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'transaction') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-swap-vert-circle"></i></div>
          <span class="title">@lang('sidebar.transactionTitle')</span>
        </a>
        <ul>
          <li><a href="{{ route('transaction.coin', ['lang' => \App::getLocale()]) }}">@lang('sidebar.transactionCoinTransfer')</a></li>
          <li><a href="{{ route('transaction.withdraw.cash', ['lang' => \App::getLocale()]) }}">@lang('sidebar.transactionWithdraw')</a></li>
          <li><a href="{{ route('transaction.statement', ['lang' => \App::getLocale()]) }}">@lang('sidebar.transactionStatement')</a></li>
        </ul>
      </li>
      <li class="gui-folder @if (strpos($route, 'investment') !== false) {{ 'active' }} @endif">
        <a href="#">
          <div class="gui-icon"><i class="md md-trending-up"></i></div>
          <span class="title">@lang('sidebar.investmentTitle')</span>
        </a>
        <ul>
          <li><a href="{{ route('investment.financial', ['lang' => \App::getLocale()]) }}">@lang('sidebar.investmentFinancial')</a></li>
        </ul>
      </li>
      <li>
        <a href="{{ route('logout', ['lang' => \App::getLocale()]) }}">
          <div class="gui-icon"><i class="md md-settings-power"></i></div>
          <span class="title">@lang('sidebar.logout')</span>
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
