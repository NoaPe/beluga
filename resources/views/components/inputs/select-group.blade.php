@if (array_values($group) !== $group)
    @foreach($group as $value => $text)
        @if(is_array($text))
            <optgroup label="{{ $value }}">
                <x-beluga::select-group :group="$text" />
            </optgroup>
        @else
            <x-beluga::select-item  :value="$value" :text="$text" />
        @endif
    @endforeach
@else
    @foreach($group as $item)
        <x-beluga::select-item  :value="$item" :text="$item" />
    @endforeach
@endif