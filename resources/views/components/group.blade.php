{{-- Form for a $group with $prefix --}}
@if (isset($standalone) && $standalone)
<form method="POST" action="">
    @csrf
@endif

    {{-- If $group have label show it --}}
    @if($group->label)
        <div class="form-label">
            {{ $group->label }}
        </div>
    @endif
    {{-- If $group have description show it --}}
    @if($group->description)
        <div class="form-description">
            {{ $group->description }}
        </div>
    @endif

    {{-- Loop for each data in $group->datas --}}
    @foreach($group->datas as $name => $data)
        {{-- include input component --}}
        <x-beluga-input :shell="$shell" :name="$name" :prefix="$prefix" :internal="$internal" />
    @endforeach
    
    {{-- Loop for each group in $group->groups --}}
    @foreach($group->groups as $group)
        {{-- include group component --}}
        <x-beluga-group :shell="$shell" :group="$group" :prefix="$prefix.$group->name" :internal="$internal" />
    @endforeach

@if (isset($standalone) && $standalone)
</form>
@endif
