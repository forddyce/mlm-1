@extends('front.app')

@section('title')
Login - {{ config('app.name') }}
@stop

@section('content')

<section class="section-account">
  <div class="img-backdrop" style="background-image: url({{ asset('assets/img/admin/img16.jpg') }});"></div>
  <div class="spacer"></div>
  <div class="card contain-sm style-transparent">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="img-responsive">
            <a href="http://chancery-group.com/hgi/index.html" target="_blank">
              <img src="{{ asset('assets/img/logo.png') }}" width="100%">
            </a>
          </div>
          <br/>
          <div class="text-center">
            <span class="text-lg text-bold text-primary">@lang('pageLogin.title')</span>
          </div>
          <br/><br/>
          <div class="text-center">
            <a href="{{ route('login', ['lang' => 'en']) }}">English Version</a> | <a href="{{ route('login', ['lang' => 'ch']) }}">中文版</a>
          </div>
          <br/><br/>
          <form class="form action-form" data-parsley-validate="" data-url="{{ route('post.login', ['lang' => \App::getLocale()]) }}" http-type="post" accept-charset="utf-8" onsubmit="return false;">
            <div class="form-group label-floating">
              <label for="username" class="control-label">@lang('pageLogin.username')</label>
              <input type="text" class="form-control" id="username" name="username" required="">
            </div>
            <div class="form-group label-floating">
              <label for="password" class="control-label">@lang('pageLogin.password')</label>
              <input type="password" class="form-control" id="password" name="password" required="">
            </div>
            <br/>
            <div class="row">
              <div class="col-xs-6 text-left">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember"> @lang('pageLogin.remember')
                  </label>
                </div>
              </div>
              <div class="col-xs-6 text-right">
                <button class="btn btn-primary btn-raised" type="submit">
                  <span class="btn-preloader">
                    <i class="md md-refresh icon-spin"></i>
                  </span>
                  <span>@lang('pageLogin.submit')</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@stop