@if ($data->settings->selectable)

@endif

@if ($data->settings->addable)
    <div class="beluga-addable" data-route="{{ route((new $data->settings->class())->getRoute().'.create'); }}">
    </div>
@endif