<select name="{{ $name }}" {{(isset($data->settings->visible) && $data->settings->visible == false) || 
        isset($data->hidden) && $data->hidden ? 'hidden' : '' }}>
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
