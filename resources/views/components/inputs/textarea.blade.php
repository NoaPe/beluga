@include('beluga::components.inputs.parts.top', ['data' => $data])
        <input type="text"
            name="{{ $name }}"
            id="{{ $name }}"
            style="{{ isset($data->style) ? 'style' : '' }}"
            placeholder="{{ $data->placeholder ? 'placeholder' : '' }}"
            class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
            {{ $data->value ? 'checked' : '' }}
            {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >
@include('beluga::components.inputs.parts.bottom', ['data' => $data])