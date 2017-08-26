@extends('front.app')

@section('title')
@lang('pageHome.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        @if ($member->bank_name == '' || 
            $member->bank_account_number == '' || 
            $member->bank_account_holder == '' || 
            $member->identification_number == ''
        )
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <a href="{{ route('settings.bank', ['lang' => \App::getLocale()]) }}" class="card-link">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-danger no-margin">
                    <h1 class="pull-right text-danger">
                      <i class="md md-new-releases"></i>
                    </h1>
                    <strong class="text-xl">@lang('pageHome.bankInfoError')</strong>
                    <br>
                    <strong class="opacity-50">
                      <small>@lang('pageHome.bankInfoClick')</small>
                    </strong>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
        @endif

        <div class="row">
          <div class="col-md-3 col-sm-6">
            <div class="card">
              <div class="card-body no-padding">
                <div class="alert alert-callout alert-success no-margin">
                  <h1 class="pull-right text-success">
                    <i class="md md-account-balance-wallet"></i>
                  </h1>
                  <strong class="text-xl">USD {{ number_format($member->roi_wallet, 0) }}</strong>
                  <br>
                  <strong class="opacity-50">@lang('pageHome.roiWallet')</strong>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6">
            <div class="card">
              <div class="card-body no-padding">
                <div class="alert alert-callout alert-info no-margin">
                  <h1 class="pull-right text-info">
                    <i class="md md-account-balance-wallet"></i>
                  </h1>
                  <strong class="text-xl">USD {{ number_format($member->cash_wallet, 0) }}</strong>
                  <br>
                  <strong class="opacity-50">@lang('pageHome.cashWallet')</strong>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6">
            <a href="{{ route('network', ['lang' => \App::getLocale()]) }}" class="card-link">
              <div class="card">
                <div class="card-body no-padding">
                  <div class="alert alert-callout alert-warning no-margin">
                    <h1 class="pull-right text-warning">
                      <i class="md md-settings-input-component"></i>
                    </h1>
                    <strong class="text-xl" id="directSponsorCount">
                      <i class="md md-refresh icon-spin"></i>
                    </strong>
                    <br>
                    <strong class="opacity-50">@lang('pageHome.directSponsor')</strong>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3 col-sm-6">
            <div class="card">
              <div class="card-body no-padding">
                <div class="alert alert-callout alert-danger no-margin">
                  <h1 class="pull-right text-danger">
                    <i class="md md-trending-up"></i>
                  </h1>
                  <strong class="text-xl">USD {{ number_format($member->package_amount) }}</strong>
                  <br>
                  <strong class="opacity-50">@lang('pageHome.package')</strong>
                </div>
              </div>
            </div>
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
                        <th>@lang('pageHome.tableCountry')</th>
                        <th>@lang('pageHome.tableCurrency')</th>
                        <th>@lang('pageHome.tableBuy')</th>
                        <th>@lang('pageHome.tableSell')</th>
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

          <div class="col-md-3">
            <div class="card">
              <div class="card-body no-padding">
                <div class="alert alert-callout alert-info no-margin">
                  <h1 class="pull-right text-info">
                    <i class="md md-lens"></i>
                  </h1>
                  <strong class="text-xl">USD {{ number_format($member->register_wallet, 0) }}</strong>
                  <br>
                  <strong class="opacity-50">@lang('pageHome.registerCoin')</strong>
                  <br>
                  <a href="{{ route('member.register', ['lang' => \App::getLocale()]) }}" class="btn btn-info btn-raised btn-xs text-bold">@lang('pageHome.registerNew')</a>
                </div>
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
