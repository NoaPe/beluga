{{-- Json textarea --}}
@include('beluga::components.inputs.parts.top', ['data' => $data])
<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    rows="5"
    placeholder="{{ isset($data->placeholder) ? $data->placeholder : '' }}"
    {{  isset($data->settings->required)  &&  ? $data->settings->required : '' }}
>
</textarea>
@include('beluga::components.inputs.parts.bottom', ['data' => $data])