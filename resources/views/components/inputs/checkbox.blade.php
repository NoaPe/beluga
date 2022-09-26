<input type="checkbox"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ $shell->getAttribute($name) ?? $data->default ?? '' }}"
    style="{{ isset($data->style) ? 'style' : '' }}"
    class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
    {{ isset($data->value) && $data->value ? 'checked' : '' }}
    {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >