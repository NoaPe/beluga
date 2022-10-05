
@if (isset($group->datas))
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach($group->datas as $data_name => $data)
                    <th>{{ $data->label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
            <tr>
                @foreach($group->datas as $data_name => $data)
                    <td>{{ $line->getAttribute($data_name) }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

@if (isset($group->groups))
    @foreach ($group->groups as $group2)
        <x-beluga::table.group :shell="$shell" :group="$group2" :lines="$lines" />
    @endforeach
@endif