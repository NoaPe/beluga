@include('beluga::components.inputs.parts.top', ['data' => $data])

@include('beluga::components.inputs.'.$input_type, [
    'name' => $name,
    'data' => $data
])

@include('beluga::components.inputs.parts.bottom', ['data' => $data])