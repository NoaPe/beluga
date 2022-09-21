@include('beluga::components.inputs.parts.top', ['data' => $data])
        <input type="checkbox"
            name="{{ $name }}"
            id="{{ $name }}"
            value="1" 
            style="{{ isset($data->style) ? 'style' : '' }}"
            class=" {{ isset($data->settings->class) ? $data->settings->class : '' }}"
            {{ isset($data->value) && $data->value ? 'checked' : '' }}
            {{ isset($data->settings->visible) && $data->settings->visible == false ? 'hidden' : '' }} >
@include('beluga::components.inputs.parts.bottom', ['data' => $data])