{{-- Form for a $shell --}}
<form method="POST" action="">
    @csrf

    <div id="beluga-form-{{ $shell->getName() }}">
        {{-- If $shell->schema have description show it --}}
        @if(isset($schema->description))
            <div class="form-description">
                {{ $schema->description }}
            </div>
        @endif


        {{-- Loop for each data in $schema->datas --}}
        @if(isset($schema->datas)) 
            @foreach($schema->datas as $data_name => $data)
                {{-- include input component --}}
                <x-beluga-input :shell="$shell" :name="$data_name" :internal="$internal" />
            @endforeach
        @endif

        {{-- Loop for each group in $schema->groups --}}
        @if(isset($schema->groups))
            @foreach($schema->groups as $group_name => $group)
                <div class="container-fluid beluga-form-group" id="beluga-form-group-{{ $group_name }}">
                    {{-- include group component --}}
                    <x-beluga-group :shell="$shell" :name="$group_name" :internal="$internal" />
                </div>
            @endforeach
        @endif

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </div>
</form>

@if (isset($schema->render))
    @include('beluga::components.render.'.$schema->render, [
        'name' => $shell->getName(),
        'groups' => $schema->groups
    ])
@endif