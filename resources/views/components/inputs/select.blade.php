<select name="{{ $name }}">
    @foreach($options as $value => $text)
        @if(is_array($text))
            <optgroup label="{{ $value }}">
                <x-beluga::select-group :group="$text" />
            </optgroup>
        @else
            <x-beluga::select-item  :value="$value" :text="$text" />
        @endif
    @endforeach
</select>
