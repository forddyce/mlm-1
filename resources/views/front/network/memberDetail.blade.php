<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr class="info">
            <td><strong>@lang('memberDetail.username')</strong></td>
            <td>:</td>
            <td>{{ $model->username }}</td>
          </tr>

          @if ($mUser = $model->user)
          <tr>
            <td><strong>@lang('memberDetail.fullName')</strong></td>
            <td>:</td>
            <td>{{ $model->first_name }}</td>
          </tr>
          @endif

          <tr>
            <td><strong>@lang('memberDetail.nationality')</strong></td>
            <td>:</td>
            <td>{{ $model->nationality }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.gender')</strong></td>
            <td>:</td>
            <td>{{ $model->gender }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.dob')</strong></td>
            <td>:</td>
            <td>{{ $model->date_of_birth }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.active')</strong></td>
            <td>:</td>
            <td>
              @if ($model->is_active)
                <label class="label label-success">YES</label>
              @else
                <label class="label label-danger">NO</label>
              @endif
            </td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.created')</strong></td>
            <td>:</td>
            <td>{{ $model->created_at->format('d F Y') }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.phone')</strong></td>
            <td>:</td>
            <td>{{ $model->phone }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.email')</strong></td>
            <td>:</td>
            <td>{{ $model->email }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.idCard')</strong></td>
            <td>:</td>
            <td>{{ $model->identification_number }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.bankInfo')</strong></td>
            <td>:</td>
            <td>{{ $model->bank_name . ' / ' . $model->bank_account_number . ' / ' . $model->bank_account_name }}</td>
          </tr>
        </tbody>  
      </table>
    </div>
  </div>

  <div class="col-md-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr class="info">
            <td><strong>@lang('memberDetail.package')</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->package_amount, 0) }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.cashWallet')</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->cash_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.registerWallet')</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->register_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.roiWallet')</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->roi_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>@lang('memberDetail.roiTotal')</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->current_roi, 0) }}</td>
          </tr>
        </tbody>  
      </table>
    </div>
  </div>
</div>
