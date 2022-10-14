@if (!isset($data->hidden) || !$data->hidden)
    <div class="col-{{ \NoaPe\Beluga\Helpers\Render::labelColumn($data) }}">
        <label>
            {{ isset($data->label) ? $data->label : '' }}
            @if ($data->getType($shell)->is('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    </div>
@endif