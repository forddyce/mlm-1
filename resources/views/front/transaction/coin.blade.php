@extends('front.app')

@section('title')
@lang('pageTransCoin.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-4">
            <h1>@lang('pageTransCoin.registerCoin'): <span class="text-primary">{{ number_format($member->register_wallet, 0) }} USD</span></h1>
          </div>
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">
                @lang('pageTransCoin.title')</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" id="transferCoinForm" onsubmit="return false;" data-url="{{ route('transaction.coin.transfer') }}" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="member">@lang('pageTransCoin.user')</label>
                    <input type="text" name="member_id" class="form-control" required="">
                    <span class="help-block">@lang('pageTransCoin.userHelp')</span>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="amount">@lang('pageTransCoin.amount')</label>
                    <input type="number" value="1" min="1" name="amount" id="amount" required="" class="form-control">
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageTransCoin.submit')</span>
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
