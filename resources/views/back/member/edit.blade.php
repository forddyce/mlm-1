<?php

use App\Models\Package;

$packageModel = new Package;
$packages = $packageModel->orderBy('id', 'asc')->get();

?>

@extends('back.app')

@section('title')
Member #{{ $model->id }} - {{ config('app.name') }}
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
            <ul class="breadcrumb">
              <li><a href="{{ route('admin.index') }}">Home</a></li>
              <li><a href="{{ route('admin.member.list') }}">Member List</a></li>
              <li class="active">Edit Member #{{ $model->id }}</li>
            </ul>
          </div>
        </div>

        <div class="row">
          <form class="form action-form" onsubmit="return false;" data-parsley-validate data-url="{{ route('admin.member.update', ['id' => $model->id]) }}" id="memberEditForm" http-type="post">
            <div class="col-md-4 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label class="control-label" for="username">Username</label>
                    <input type="text" class="form-control" id="username" readonly="" disabled="" value="{{ $model->username }}">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $model->phone }}">
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label" for="fullname">Nationality</label>
                    <select class="form-control" name="nationality">
                      <?php $countries = config('misc.countries'); ?>
                      @foreach ($countries as $country)
                        <option value="{{ $country }}" @if ($model->nationality == $country) selected="" @endif>{{ $country }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="dob">Date of Birth</label>
                    <input type="text" value="{{ $model->date_of_birth }}" name="date_of_birth" id="dob" class="form-control input-date">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="gender">Gender</label>
                    <select class="form-control" name="gender" id="gender">
                      <option value="male" @if ($model->gender == 'male') selected="" @endif>Male</option>
                      <option value="female" @if ($model->gender == 'female') selected="" @endif>Female</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="identification_number">Identification Card Number</label>
                    <input type="text" name="identification_number" class="form-control" value="{{ $model->identification_number }}" id="identification_number">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_name">Bank Name</label>
                    <input type="text" name="bank_name" value="{{ $model->bank_name }}" class="form-control" id="bank_name">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_account_number">Bank Account Number</label>
                    <input type="text" name="bank_account_number" class="form-control" id="bank_account_number" value="{{ $model->bank_account_number }}">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_account_holder">Bank Account Holder</label>
                    <input type="text" name="bank_account_holder" class="form-control" id="bank_account_holder" value="{{ $model->bank_account_holder }}">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="cash_wallet">Cash Wallet</label>
                    <input type="number" min="0" name="cash_wallet" class="form-control" id="cash_wallet" required="" value="{{ (float) $model->cash_wallet }}">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="roi_wallet">ROI Wallet</label>
                    <input type="number" min="0" name="roi_wallet" class="form-control" id="roi_wallet" required="" value="{{ (float) $model->roi_wallet }}">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="register_wallet">Register Wallet</label>
                    <input type="number" min="0" name="register_wallet" class="form-control" id="register_wallet" required="" value="{{ (float) $model->register_wallet }}">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <div class="alert alert-info">
                      Empty password fields if do not want to change.
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" minlength="5">
                    <span class="help-block">Minimal length: 5 characters</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="repassword">Retype New Password</label>
                    <input type="password" id="repassword" data-parsley-equalto="#password" class="form-control" minlength="5">
                    <span class="help-block">Minimal length: 5 characters</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="togglebutton">
                    <label>
                      <input type="checkbox" name="is_active" @if ($model->is_active) checked="" @endif> Active (can get roi bonus?)
                    </label>
                  </div>

                  <div class="togglebutton">
                    <label>
                      <input type="checkbox" name="is_ban" @if ($model->is_ban) checked="" @endif> Ban
                    </label>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="package_amount">Package</label>
                    <div class="input-group">
                      <input type="number" class="form-control" value="{{ (float) $model->package_amount }}" id="package_amount" disabled="" readonly="">
                      <span class="input-group-addon">USD</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="direct">Direct Bonus</label>
                    <div class="input-group">
                      <input type="number" name="direct" class="form-control" value="{{ (float) $model->direct }}" id="direct" min="0" required="">
                      <span class="input-group-addon">%</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="roi">ROI Bonus</label>
                    <div class="input-group">
                      <input type="number" name="roi" class="form-control" value="{{ (float) $model->roi }}" id="roi" min="0" required="">
                      <span class="input-group-addon">%</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="max_profit">Maximum Profit</label>
                    <div class="input-group">
                      <input type="number" name="max_profit" class="form-control" value="{{ (float) $model->max_profit }}" id="max_profit" min="0" required="">
                      <span class="input-group-addon">USD</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>Submit</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
  @include('back.include.sidebar')
</div>
@stop
