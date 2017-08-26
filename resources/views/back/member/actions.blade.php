<button class="btn btn-success btn-show btn-raised" title="Show" data-id="{{ $model->id }}" data-toggle="modal" data-target="#showModal" data-url="{{ route('adminMember.show', ['member' => $model->id]) }}">
  <i class="md md-visibility"></i> Show
</button>

<a href="{{ route('admin.member.network', ['id' => $model->id]) }}" class="btn btn-info btn-raised" title="Edit">
  <i class="md md-settings-input-component"></i> Network
</a>

<a href="{{ route('admin.member.edit', ['id' => $model->id]) }}" class="btn btn-warning btn-raised" title="Edit">
  <i class="md md-mode-edit"></i> Edit
</a>
