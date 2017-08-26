@if ($model->status != 'done')
<button class="btn btn-success btn-raised btn-confirm" title="Confirm" data-url="{{ route('admin.withdraw.update', ['id' => $model->id]) }}">
  <i class="md md-thumb-up"></i> Confirm
</button>
@endif

<button class="btn btn-info btn-raised btn-show" title="Detail" data-url="{{ route('withdraw.show', ['id' => $model->id]) }}" data-toggle="modal" data-target="#showModal">
  <i class="md md-accessibility"></i> Member Detail
</button>

@if ($model->status != 'done')
<button class="btn btn-danger btn-raised btn-reject" title="Remove" data-url="{{ route('admin.withdraw.update', ['id' => $model->id]) }}">
  <i class="md md-thumb-down"></i> Reject
</button>
@endif
