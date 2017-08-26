<?php

use App\Models\Package;

$packageModel = new Package;
$packages = $packageModel->orderBy('id', 'asc')->get();

?>

@extends('back.app')

@section('title')
All Package - {{ config('app.name') }}
@stop

@section('content')
@include('back.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-9">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">All Package</header>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table id="packageListTable" class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                      <tr>
                        <th>Amount</th>
                        <th>Direct Sponsor</th>
                        <th>ROI Bonus</th>
                        <th>Max Profit</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($packages as $package)
                        <tr>
                          <td><div class="input-group"><input type="number" name="package_amount" class="form-control" value="{{ (float) $package->package_amount }}"> <span class="input-group-addon">USD</span></div></td>
                          <td><div class="input-group"><input type="number" name="direct" class="form-control" value="{{ (float) $package->direct }}"> <span class="input-group-addon">%</span></div></td>
                          <td><div class="input-group"><input type="number" name="roi" class="form-control" value="{{ (float) $package->roi }}"> <span class="input-group-addon">%</span></div></td>
                          <td><div class="input-group"><input type="number" name="max_profit" class="form-control" value="{{ (float) $package->max_profit }}"> <span class="input-group-addon">USD</span></div></td>
                          <td>
                            <button class="btn btn-warning btn-xs btn-raised btn-update" data-url="{{ route('package.update', ['package' => $package->id]) }}" type="submit">
                              <i class="md md-mode-edit"></i> Update
                            </button>
                          </td>
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
