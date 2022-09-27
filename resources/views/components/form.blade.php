{{-- Form for a $shell --}}
<form method="POST" action="{{ Route::has($shell->getRoute().'.store') ? route($shell->getRoute().'.store') : '' }}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="beluga-form-{{ $shell->getName() }}" class="beluga-form">
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
        <div class="row">
            <div id="beluga-button-{{ $shell->getName() }}" class="beluga-button justify-content-around d-flex py-3"></div>
        </div>
        <div class="row">
            <div class="justify-content-end d-flex">
                <button type="submit" class="btn btn-primary" id="beluga-button-submit-{{ $shell->getName() }}">Envoyer</button>
            </div>
        </div>
    </div>
</form>

@if (isset($schema->render))
    @include('beluga::components.render.'.$schema->render, [
        'name' => $shell->getName(),
        'groups' => $schema->groups
    ])
@endif