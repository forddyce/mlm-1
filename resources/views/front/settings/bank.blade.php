@extends('front.app')

@section('title')
@lang('pageSettingsBank.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageSettingsBank.title')</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" onsubmit="return false;" data-url="{{ route('account.update') }}" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="identification_number">@lang('pageSettingsBank.id')</label>
                    <input type="text" value="{{ $member->identification_number }}" name="identification_number" id="identification_number" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_name">@lang('pageSettingsBank.name')</label>
                    <input type="text" value="{{ $member->bank_name }}" name="bank_name" id="bank_name" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_account_number">@lang('pageSettingsBank.account')</label>
                    <input type="text" value="{{ $member->bank_account_number }}" name="bank_account_number" id="bank_account_number" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="bank_account_holder">@lang('pageSettingsBank.holder')</label>
                    <input type="text" value="{{ $member->bank_account_holder }}" name="bank_account_holder" id="bank_account_holder" required="" class="form-control">
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageSettingsBank.submit')</span>
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
