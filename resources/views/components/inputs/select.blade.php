

<div class="row">
    <div class="col-6">
        <label>{{ isset($data->label) ? $data->label : '' }}</label>
    </div>
    <div class="col-6">
        <select name="{{ $name }}">
            @foreach($data->settings->options as $value => $text)
                @if(is_array($text))
                    <optgroup label="{{ $value }}">
                        <x-beluga::select-group :group="$text" />
                    </optgroup>
                @else
                    <x-beluga::select-item  :value="$value" :text="$text" />
                @endif
            @endforeach
        </select>
    </div>
</div>
