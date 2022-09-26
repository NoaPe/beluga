<input type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ $shell->getAttribute($name) ?? $data->default ?? '' }}"
    style="{{ isset($data->style) ? 'style' : '' }}"
    placeholder="{{ $data->placeholder ? 'placeholder' : '' }}"
    class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
    {{ $data->value ? 'checked' : '' }}
    {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >