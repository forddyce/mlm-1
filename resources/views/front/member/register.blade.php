<?php

use App\Models\Package;

$packageModel = new Package;
$packages = $packageModel->where('package_amount', '!=', '3000')->where('package_amount', '!=', '5000')->orderBy('id', 'asc')->get();

?>

@extends('front.app')

@section('title')
@lang('pageMemberRegister.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="text-primary">@lang('pageMemberRegister.title')</h1>
            <h3>@lang('pageMemberRegister.registerCoin'): <span class="text-primary">{{ number_format($member->register_wallet, 0) }}</span></h3>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2 col-md-3">
            <article class="margin-bottom-xxl">
              <ul class="list-divided">
                <li>@lang('pageMemberRegister.fieldInfo')</li>
              </ul>
            </article>
          </div>

          <div class="col-lg-offset-1 col-md-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <form class="form action-form" onsubmit="return false;" data-parsley-validate data-url="{{ route('member.store') }}" id="registerForm" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="package">@lang('pageMemberRegister.package')</label>
                    <div class="input-group">
                      <select class="form-control" name="package_id" id="package">
                        @if (count($packages) > 0)
                          @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ number_format($package->package_amount, 0) }}</option>
                          @endforeach
                        @endif
                      </select>
                      <span class="input-group-addon">USD</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="username">@lang('pageMemberRegister.username')</label>
                    <input type="text" name="username" class="form-control" id="username" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="email">@lang('pageMemberRegister.email')</label>
                    <input type="email" name="email" class="form-control" id="email" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="phone">@lang('pageMemberRegister.phone')</label>
                    <input type="text" name="phone" class="form-control" id="phone" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="password">@lang('pageMemberRegister.password')</label>
                    <input type="password" name="password" class="form-control" minlength="5" id="password" required="">
                    <span class="help-block">@lang('pageMemberRegister.passwordHelp')</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="repassword">@lang('pageMemberRegister.repassword')</label>
                    <input type="password" data-parsley-equalto="#password" minlength="5" class="form-control" id="repassword" required="">
                    <span class="help-block">@lang('pageMemberRegister.passwordHelp')</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="parent">@lang('pageMemberRegister.upline')</label>
                    <input type="text" class="form-control" name="upline_id" required="">
                    <span class="help-block">@lang('pageMemberRegister.uplineHelp')</span>
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageMemberRegister.submit')</span>
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
  @include('front.include.sidebar')
</div>
@stop
