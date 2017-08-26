@extends('front.app')

@section('title')
Withdraw ROI Wallet - {{ config('app.name') }}
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
            <h2>Your ROI Wallet <br> <span class="text-primary">{{ number_format($member->roi_wallet, 0) }} USD</span></h2>
            <p>Please wait 3-7 working days for your transaction to be processed</p>
          </div>
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">Withdraw ROI Wallet</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" onsubmit="return false;" data-url="{{ route('withdraw.roi') }}" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="amount">Amount</label>
                    <div class="input-group">
                      <input type="number" value="100" step="50" min="100" name="amount" id="amount" required="" class="form-control">
                      <span class="input-group-addon">USD</span>
                    </div>
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
  @include('front.include.sidebar')
</div>
@stop
