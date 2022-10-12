<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    rows="5"
    placeholder="{{ isset($data->placeholder) ? $data->placeholder : '' }}"
    {{  isset($data->settings->required)  &&  ? $data->settings->required : '' }}
>
{{ old($name) ?? $shell->getAttribute($name) ?? $data->default ?? '' }}
</textarea>