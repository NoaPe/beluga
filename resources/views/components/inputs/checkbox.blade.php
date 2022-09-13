<!-- Html checkbox for boolean $data dataType -->
<div class="row">
    <div class="col-6">
        <label>{{ $data->label }}</label>
    </div>
    <div class="col-6">
        <input type="checkbox"
            name="{{ $data->name }}"
            id="{{ $data->name }}"
            value="1" 
            style="{{ isset($data->style) ? 'style' : '' }}"
            class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
            {{ isset($data->value) && $data->value ? 'checked' : '' }}
            {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >
    </div>
</div>
