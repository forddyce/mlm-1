@extends('front.app')

@section('title')
@lang('pageTransStatement.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageTransStatement.title')</header>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table id="transactionListTable" class="dt-responsive display nowrap table table-grid table-striped table-bordered table-hover" width="100%" role="grid" data-url="{{ route('take.index') }}">
                    <thead>
                      <tr>
                        <th data-id="created_at">@lang('pageTransStatement.tableCreated')</th>
                        <th data-id="id">#ID</th>
                        <th data-id="amount">@lang('pageTransStatement.tableAmount')</th>
                        <th data-id="type">@lang('pageTransStatement.tableType')</th>
                        <th data-id="status">@lang('pageTransStatement.tableStatus')</th>
                        <th data-id="action" data-orderable="false" data-searchable="false">@lang('pageTransStatement.tableAction')</th>
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
  @include('front.include.sidebar')
</div>
@stop
