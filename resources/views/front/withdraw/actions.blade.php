@if ($model->status == 'waiting-user')
<button class="btn btn-success btn-raised btn-confirm" title="Confirm" data-url="{{ route('member.withdraw.update', ['id' => $model->id]) }}">
  <i class="md md-done"></i> Confirm
</button>
@endif
