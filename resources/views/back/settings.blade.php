@extends('back.app')

@section('title')
Account Settings - {{ config('app.name') }}
@stop

@section('content')
@include('back.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">Account Settings</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" onsubmit="return false;" data-url="{{ route('admin.updateAccount') }}" http-type="post">
                  <div class="form-group">
                    <div class="alert alert-info">Empty password fields if do not want to change password.</div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="password">New Password</label>
                    <input type="password" minlength="5" name="password" id="password" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="repassword">Retype New Password</label>
                    <input type="password" id="repassword" data-parsley-equalto="#password" class="form-control">
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>Submit</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('back.include.sidebar')
</div>
@stop
