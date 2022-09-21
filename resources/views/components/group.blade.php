{{-- Form for a $group with $prefix --}}
@if (isset($standalone) && $standalone)
<form method="POST" action="">
    @csrf
@endif
    <div class="row">
        {{-- If $group have label show it --}}
        @if(isset($group->label))
            <div class="form-label">
                {{ $group->label }}
            </div>
        @endif

        {{-- If $group have description show it --}}
        @if(isset($group->description))
            <div class="form-description">
                {{ $group->description }}
            </div>
        @endif

        {{-- Loop for each data in $group->datas --}}
        @if (isset($group->datas))
            @if (isset($group->render) && $group->render == 'one-line')
                <div class="row">
                @foreach($group->datas as $dataName => $data)
                    {{-- include input component --}}
                    <x-beluga-input :shell="$shell" :name="$dataName" :prefix="$name.'-'.$prefix" :internal="$internal" />
                @endforeach
                </div>
            @else
                @foreach($group->datas as $dataName => $data)
                <div class="beluga-data-{{ $dataName }}">
                    <div class="row">
                        {{-- include input component --}}
                        <x-beluga-input :shell="$shell" :name="$dataName" :prefix="$name.'-'.$prefix" :internal="$internal" />
                    </div>
                </div>
                @endforeach
            @endif
        @endif

        
        {{-- Loop for each group in $group->groups --}}
        @if(isset($group->groups))
            @foreach($group->groups as $name => $group)
                {{-- include group component --}}
                <x-beluga-group :shell="$shell" :name="$name" :prefix="$prefix.$group->name" :internal="$internal" />
            @endforeach
        @endif
    </div>
@if (isset($standalone) && $standalone)
</form>
@endif
