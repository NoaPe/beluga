{{-- Form for a $shell --}}
<form method="POST" action="">
    @csrf

    {{-- If $shell->schema have description show it --}}
    @if(isset($schema->description))
        <div class="form-description">
            {{ $schema->description }}
        </div>
    @endif

    {{-- Loop for each data in $shell->schema->datas --}}
    @if(isset($schema->datas)) 
        @foreach($schema->datas as $name => $data)
            {{-- include input component --}}
            <x-beluga-input :shell="$shell" :name="$name" :internal="$internal" prefix="" />
        @endforeach
    @endif

    {{-- Loop for each group in $shell->schema->groups --}}
    @if(isset($schema->groups)) 
        @foreach($schema->groups as $group)
            {{-- include group component --}}
            <x-beluga-group :group="$group" :internal="$internal" />
        @endforeach
    @endif
</form>