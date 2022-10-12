<input type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ old($name) ?? $shell->getAttribute($name) ?? $data->default ?? '' }}"
    style="{{ isset($data->style) ? 'style' : '' }}"
    placeholder="{{ isset($data->placeholder) ? $data->placeholder : '' }}"
    class="col-12 {{ isset($data->settings->class) ? $data->settings->class : '' }}"
    {{ (isset($data->settings->visible) && $data->settings->visible == false) || 
        isset($data->hidden) && $data->hidden ? 'hidden' : '' }} >