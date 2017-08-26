@extends('back.app')

@section('title')
Family Hierarchy - {{ config('app.name') }}
@stop

@section('content')
@include('back.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <p class="opacity-50">Each node information: username / package / total withdraw</p>
                <h3>Collected Fund: <span class="text-info" id="collectedFund">0</span></h3>
                <h3>Total Withdraw: <span class="text-warning" id="totalWithdraw">0</span></h3>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">Family Hierarchy of {{ $model->username }}</header>
              </div>

              <div class="card-body">
                <div id="networkContainer" data-id="{{ $model->id }}" data-url="{{ route('admin.member.getNetwork', ['id' => $model->id]) }}">
                  <div class="loading">
                    <span>
                      <img src="{{ asset('assets/img/loading.gif') }}" alt="Network Loading">
                      <br>
                      <small class="text-primary">loading..</small>
                    </span>
                  </div>

                  <div class="error">
                    <span>
                      <i class="md md-error"></i>
                      <br>
                      <small class="text-danger">Something went wrong</small>
                    </span>
                  </div>

                  <div id="visNetwork"></div>
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
