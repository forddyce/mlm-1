@extends('front.app')

@section('title')
@lang('pageInvestmentFinancial.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-3 col-md-4">
            <h1 class="text-primary">
              @lang('pageInvestmentFinancial.package'): USD {{ number_format($member->package_amount, 0) }}
            </h1>
          </div>
          
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageInvestmentFinancial.title')</header>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table id="bonusListTable" class="dt-responsive display nowrap table table-grid table-striped table-bordered table-hover" width="100%" data-url="{{ route('bonus.index') }}">
                    <thead>
                      <tr>
                        <th data-id="created_at">@lang('pageInvestmentFinancial.tableCreated')</th>
                        <th data-id="amount">@lang('pageInvestmentFinancial.tableAmount')</th>
                        <th data-id="type">@lang('pageInvestmentFinancial.tableType')</th>
                        <th data-id="action" data-orderable="false" data-searchable="false">@lang('pageInvestmentFinancial.tableAction')</th>
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
