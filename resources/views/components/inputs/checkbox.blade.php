<input type="checkbox"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ old($name) ?? $shell->getAttribute($name) ?? $data->default ?? '' }}"
    style="{{ isset($data->style) ? 'style' : '' }}"
    class="{{ isset($class) ? $class : '' }} {{ isset($data->settings->class) ? $data->settings->class : '' }}"
    {{ $shell->getAttribute($name) || (isset($data->default) && $data->default) ? 'checked' : '' }}
    {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >