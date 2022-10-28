<div class="form-group">
@include('beluga::components.inputs.parts.top', ['data' => $data])

@include('beluga::components.inputs.'.$input_type, [
    'name' => $name,
    'data' => $data,
    'class' => 'form-control'
])

@include('beluga::components.inputs.parts.bottom', ['data' => $data])
</div>