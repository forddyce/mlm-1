@extends('front.app')

@section('title')
@lang('pageNetworkTree.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-2">
            <div class="card">
              <div class="card-body">
                <form role="form" id="userSearchForm" onsubmit="return false;">
                  <div class="form-group">
                    <label class="control-label" for="username">@lang('pageNetworkTree.username')</label>
                    <input type="text" name="username" minlength="1" required="" placeholder="Username.." id="username" class="form-control">
                    <span class="help-block">@lang('pageNetworkTree.usernameHelp')</span>
                  </div>

                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-raised">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageNetworkTree.searchSubmit')</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageNetworkTree.title')</header>
              </div>

              <div class="card-body">
                <div id="networkContainer">
                  <div class="loading">
                    <span>
                      <img src="{{ asset('assets/img/loading.gif') }}" alt="Network Loading">
                      <br>
                      <small class="text-primary">@lang('pageNetworkTree.treeLoading')</small>
                    </span>
                  </div>

                  <div class="error">
                    <span>
                      <i class="md md-error"></i>
                      <br>
                      <small class="text-danger">@lang('pageNetworkTree.treeError')</small>
                    </span>
                  </div>

                  <div id="visNetwork">
                  </div>
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

<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="memberModalLabel">@lang('pageNetworkTree.modalTitle')</h4>
      </div>
      <div class="modal-body">
        <div class="loading text-center">
          <img src="{{ asset('assets/img/loading.gif') }}" alt="Network Loading">
          <br>
          <small class="text-primary">@lang('pageNetworkTree.modalLoading')</small>
        </div>

        <div class="error text-center">
          <i class="md md-error"></i>
          <br>
          <small class="text-danger">@lang('pageNetworkTree.modalError')</small>
        </div>

        <div id="modalContent">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-raised" data-dismiss="modal">@lang('pageNetworkTree.modalClose')</button>
      </div>
    </div>
  </div>
</div>
@stop
