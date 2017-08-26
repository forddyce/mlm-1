<?php $member = $model->member; ?>

@if ($member)
<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr class="info">
            <td>Withdraw #ID</td>
            <td>:</td>
            <td>{{ $model->id }}</td>
          </tr>
          <tr class="primary">
            <td>Username</td>
            <td>:</td>
            <td>{{ $member->id }}</td>
          </tr>
          <tr>
            <td>Amount</td>
            <td>:</td>
            <td>{{ number_format($model->amount) }} USD</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-md-6 col-xs-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <td>Identification Card No</td>
            <td>:</td>
            <td>{{ $member->identification_number }}</td>
          </tr>
          <tr>
            <td>Bank Name</td>
            <td>:</td>
            <td>{{ $member->bank_name }}</td>
          </tr>
          <tr>
            <td>Bank Account Number</td>
            <td>:</td>
            <td>{{ $member->bank_account_number }}</td>
          </tr>
          <tr>
            <td>Bank Account Holder</td>
            <td>:</td>
            <td>{{ $member->bank_account_holder }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@else
<div class="alert alert-danger">
  Member not found.
</div>
@endif
