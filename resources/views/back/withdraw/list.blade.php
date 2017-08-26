@extends('back.app')

@section('title')
All Withdraw - {{ config('app.name') }}
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
                <header class="text-primary">All Withdraws</header>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table id="withdrawListTable" class="dt-responsive display nowrap table table-grid table-striped table-bordered table-hover" width="100%" data-url="{{ route('take.index') }}">
                    <thead>
                      <tr>
                        <th data-id="created_at">Created</th>
                        <th data-id="id">#ID</th>
                        <th data-id="amount">Amount</th>
                        <th data-id="status">Status</th>
                        <th data-id="type">Type</th>
                        <th data-id="member.username" data-name="member.username">Member</th>
                        <th data-id="action" data-orderable="false" data-searchable="false">Action</th>
                      </tr>
                    </thead>
                    <tbody>
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

<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showModalLabel">Withdraw Detail</h4>
      </div>
      <div class="modal-body">
        <div class="loading text-center">
          <img src="{{ asset('assets/img/loading.gif') }}" alt="Network Loading">
          <br>
          <small class="text-primary">loading..</small>
        </div>

        <div class="error text-center">
          <i class="md md-error"></i>
          <br>
          <small class="text-danger">Something went wrong</small>
        </div>

        <div id="modalContent">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-raised" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@stop
