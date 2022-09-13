<!-- Html text for boolean $data dataType -->
<div class="row">
    <div class="col-6">
        <label>{{ $data->label }}</label>
    </div>
    <div class="col-6">
        <input type="text"
            name="{{ $data->name }}"
            id="{{ $data->name }}"
            style="{{ isset($data->style) ? 'style' : '' }}"
            placeholder="{{ $data->placeholder ? 'placeholder' : '' }}"
            class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
            {{ $data->value ? 'checked' : '' }}
            {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >
    </div>
</div>
