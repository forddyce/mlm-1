@extends('front.app')

@section('title')
@lang('pageTransWithdraw.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-3">
            <h2>@lang('pageTransWithdraw.cashWallet') <br> <span class="text-primary">{{ number_format($member->cash_wallet, 0) }} USD</span></h2>
            <h2>@lang('pageTransWithdraw.roiWallet') <br> <span class="text-primary">{{ number_format($member->roi_wallet, 0) }} USD</span></h2>
            <p>@lang('pageTransWithdraw.help')</p>
          </div>
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageTransWithdraw.title')</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" onsubmit="return false;" data-url="{{ route('withdraw.cash') }}" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="amount">@lang('pageTransWithdraw.amount')</label>
                    <div class="input-group">
                      <input type="number" value="100" step="100" min="100" name="amount" id="amount" required="" class="form-control">
                      <span class="input-group-addon">USD</span>
                    </div>
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageTransWithdraw.submit')</span>
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
