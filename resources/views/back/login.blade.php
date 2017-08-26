@extends('back.app')

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
          <br/>
          <span class="text-lg text-bold text-primary">{{ strtoupper(config('app.name')) }} - ADMIN</span>
          <br/><br/>
          <form class="form action-form" data-parsley-validate="" data-url="{{ route('admin.postLogin') }}" http-type="post" accept-charset="utf-8" onsubmit="return false;">
            <div class="form-group label-floating">
              <label for="username" class="control-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required="">
            </div>
            <div class="form-group label-floating">
              <label for="password" class="control-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required="">
            </div>
            <br/>
            <div class="row">
              <div class="col-xs-6 text-left">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember"> Remember me
                  </label>
                </div>
              </div>
              <div class="col-xs-6 text-right">
                <button class="btn btn-primary btn-raised" type="submit">
                  <span class="btn-preloader">
                    <i class="md md-refresh icon-spin"></i>
                  </span>
                  <span>Login</span>
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