@if(isset($group->datas)) 
    @foreach($group->datas as $data_name => $data)
        {{-- include input component --}}
        @include('beluga::components.inputs.parts.label', ['data' => $data])
        <div class="col-{{ \NoaPe\Beluga\Helpers\Render::inputColumn($data) }}">
            {{ $shell->getAttribute($data_name) }}
        </div>
    @endforeach
@endif

@if(isset($group->groups))
    @foreach($group->groups as $group_name => $subgroup)
        {!! $subgroup->show($shell) !!}
    @endforeach
@endif