<?php

use App\Models\Package;

$packageModel = new Package;
$packages = $packageModel->where('package_amount', '!=', '3000')->where('package_amount', '!=', '5000')->orderBy('id', 'asc')->get();

?>

@extends('front.app')

@section('title')
@lang('pageMemberUpgrade.title') - {{ config('app.name') }}
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
            <h1 class="text-primary">
              @lang('pageMemberUpgrade.package'): USD {{ number_format($member->package_amount, 0) }}
            </h1>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-4">
            <article class="margin-bottom-xxl">
              <p>@lang('pageMemberUpgrade.help1')</p>
              <hr>
              <p>@lang('pageMemberUpgrade.help2')&nbsp;<span id="amountCount" class="text-primary text-xl text-bold" data-original="{{ (float) $member->package_amount }}">0</span> USD</p>
            </article>
            <h3>@lang('pageMemberUpgrade.registerWallet'): <span class="text-danger">{{ number_format($member->register_wallet, 0) }} USD</span></h3>
          </div>

          <div class="col-md-4 col-sm-6">
            <div class="card">
              <div class="card-body">
                <form class="form action-form" onsubmit="return false;" data-parsley-validate data-url="{{ route('member.post.upgrade') }}" id="upgradeForm" http-type="post">
                  <div class="form-group">
                    <div class="togglebutton">
                      <label>
                        <input type="checkbox" name="is_renew">
                        &nbsp;@lang('pageMemberUpgrade.renew')
                      </label>
                    </div>
                  </div>

                  <div class="form-group" id="togglePackage">
                    <label class="control-label" for="package">@lang('pageMemberUpgrade.upgradeTitle')</label>
                    <div class="input-group">
                      <select class="form-control" name="package_id" id="package">
                        <option value="0" selected="">@lang('pageMemberUpgrade.selectNewPackage')</option>
                        @if (count($packages) > 0)
                          @foreach ($packages as $package)
                            @if ($package->package_amount > $member->package_amount)
                            <option value="{{ $package->id }}" data-amount="{{ (float) $package->package_amount }}">{{ number_format($package->package_amount, 0) }}</option>
                            @endif
                          @endforeach
                        @endif
                      </select>
                      <span class="input-group-addon">USD</span>
                    </div>
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageMemberUpgrade.submit')
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
