<!-- Html text for string $data dataType -->
<div class="row">
    <div class="col-6">
        <label>{{ $data->label }}</label>
    </div>
    <div class="col-6">
        <input type="text"
            name="{{ $data->name }}"
            id="{{ $data->name }}"
            style="{{ isset($data->style) ? 'style' : '' }}"
            placeholder="{{ isset($data->placeholder) ? $data->placeholder : '' }}"
            class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
            {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >
    </div>
</div>
