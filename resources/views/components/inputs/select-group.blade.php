@if (array_values($group) !== $group)
    @foreach($group as $value => $text)
        @if(is_array($text))
            <optgroup label="{{ $value }}">
                <x-beluga::inputs.select-group :group="$text" />
            </optgroup>
        @else
            <x-beluga::inputs.select-item  :value="$value" :text="$text" />
        @endif
    @endforeach
@else
    @foreach($group as $item)
        <x-beluga::inputs.select-item  :value="$item" :text="$item" />
    @endforeach
@endif