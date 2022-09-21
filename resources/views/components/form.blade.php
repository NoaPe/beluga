{{-- Form for a $shell --}}
<form method="POST" action="">
    @csrf

    {{-- If $shell->schema have description show it --}}
    @if(isset($schema->description))
        <div class="form-description">
            {{ $schema->description }}
        </div>
    @endif


    {{-- Loop for each data in $schema->datas --}}
    @if(isset($schema->datas)) 
        @foreach($schema->datas as $name => $data)
            {{-- include input component --}}
            <x-beluga-input :shell="$shell" :name="$name" :internal="$internal" />
        @endforeach
    @endif

    {{-- Loop for each group in $schema->groups --}}
    @if(isset($schema->groups)) 
        @foreach($schema->groups as $name => $group)
            {{-- include group component --}}
            <x-beluga-group :shell="$shell" :name="$name" :internal="$internal" />
        @endforeach
    @endif
</form>