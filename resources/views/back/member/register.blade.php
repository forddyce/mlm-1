<?php

use App\Models\Package;

$packageModel = new Package;
$packages = $packageModel->orderBy('id', 'asc')->get();

?>

@extends('back.app')

@section('title')
Register New Member - {{ config('app.name') }}
@stop

@section('content')
@include('back.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="text-primary">Register New Member</h1>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-2 col-md-3">
            <article class="margin-bottom-xxl">
              <ul class="list-divided">
                <li>All fields are mandatory</li>
              </ul>
            </article>
          </div>

          <div class="col-lg-offset-1 col-md-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <form class="form action-form" onsubmit="return false;" data-parsley-validate data-url="{{ route('adminMember.store') }}" id="registerForm" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="package">Package</label>
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
                    <label class="control-label" for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" required="">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="password">Password</label>
                    <input type="password" name="password" class="form-control" minlength="5" id="password" required="">
                    <span class="help-block">Minimal length: 5 characters</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="repassword">Re-Password</label>
                    <input type="password" data-parsley-equalto="#password" minlength="5" class="form-control" id="repassword" required="">
                    <span class="help-block">Minimal length: 5 characters</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="parent">Upline ID</label>
                    <input type="text" class="form-control" name="upline_id">
                    <span class="help-block">CASE SENSITIVE, empty field to make this user the top most.</span>
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
