@extends('back.app')

@section('title')
Dashboard - {{ config('app.name') }}
@stop

@section('content')
@include('back.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <a class="card-link" href="{{ route('admin.withdraw.list') }}">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-success no-margin">
                    <h1 class="pull-right text-success">
                      <i class="md md-swap-vert-circle"></i>
                    </h1>
                    <strong class="text-xl" id="withdrawCount"></strong>
                    <br>
                    <strong class="opacity-50">Queued Withdraw</strong>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <a class="card-link" href="{{ route('admin.member.list') }}">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-info no-margin">
                    <h1 class="pull-right text-info">
                      <i class="md md-accessibility"></i>
                    </h1>
                    <strong class="text-xl" id="memberCount"></strong>
                    <br>
                    <strong class="opacity-50">Member Count</strong>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th>Country</th>
                        <th>Currency</th>
                        <th>Buy IN</th>
                        <th>Sell OUT</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $currencies = config('misc.currency'); ?>
                      @foreach ($currencies as $index => $currency)
                        <tr>
                          <td><span class="flag-icon flag-icon-{{ $currency['flag']}}" title="{{ $index }}"></span> {{ \Lang::get('currency.' . $index) }}</td>
                          <td>{{ $currency['iso'] }}</td>
                          <td>{{ $currency['buy'] }}</td>
                          <td>{{ $currency['sell'] }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
