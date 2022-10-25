@if ($data->settings->selectable)

@endif

@if (isset($shell->id) && isset($data->settings->addable) && $data->settings->addable)
    <div class="beluga-addable"
        data-route="{{ route((new $data->settings->class())->getRoute().'.create'); }}"
        data-table-route="{{ route($shell->getRoute().'.'.$name, $shell->getAttribute('id')); }}"
        data-parent="{{ $shell->getName(); }}"
        data-settings="{{ json_encode($data->settings); }}"
    >
        <div id="beluga-addable-list-{{ $name }}" class="beluga-addable-list">
        </div>
    </div>
@endif