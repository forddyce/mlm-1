<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr class="info">
            <td><strong>Username</strong></td>
            <td>:</td>
            <td>{{ $model->username }}</td>
          </tr>

          <tr>
            <td><strong>Active</strong></td>
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
            <td><strong>Join On</strong></td>
            <td>:</td>
            <td>{{ $model->created_at->format('d F Y') }}</td>
          </tr>

          @if ($mUser = $model->user)
          <tr>
            <td><strong>Full Name</strong></td>
            <td>:</td>
            <td>{{ $model->first_name }}</td>
          </tr>
          @endif

          <tr>
            <td><strong>Nationality</strong></td>
            <td>:</td>
            <td>{{ $model->nationality }}</td>
          </tr>

          <tr>
            <td><strong>Gender</strong></td>
            <td>:</td>
            <td>{{ $model->gender }}</td>
          </tr>

          <tr>
            <td><strong>Date of birth</strong></td>
            <td>:</td>
            <td>{{ $model->date_of_birth }}</td>
          </tr>

          <tr>
            <td><strong>Phone</strong></td>
            <td>:</td>
            <td>{{ $model->phone }}</td>
          </tr>

          <tr>
            <td><strong>Email</strong></td>
            <td>:</td>
            <td>{{ $model->email }}</td>
          </tr>

          <tr>
            <td><strong>Bank Info</strong></td>
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
            <td><strong>Package</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->package_amount, 0) }}</td>
          </tr>

          <tr>
            <td><strong>Cash Wallet</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->cash_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>Register Wallet</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->register_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>ROI Wallet</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->roi_wallet, 0) }}</td>
          </tr>

          <tr>
            <td><strong>Accumulated ROI</strong></td>
            <td>:</td>
            <td>USD {{ number_format($model->current_roi, 0) }}</td>
          </tr>

          <tr>
            <td><strong>Next ROI</strong></td>
            <td>:</td>
            <td>{{ $model->next_roi }}</td>
          </tr>

          <?php
            $wd = 0;
            if ($takes = $model->takes()->get()) {
              foreach ($takes as $take) {
                $wd += $take->amount;
              }
            }
          ?>
          <tr>
            <td><strong>Total Withdraw</strong></td>
            <td>:</td>
            <td>{{ number_format($wd, 0) }}</td>
          </tr>
        </tbody>  
      </table>
    </div>
  </div>
</div>
