@extends(isset($layout) && $layout !== '' ? $layout : 'beluga::layouts.raw')

@section('title_beluga', $shell->getName())
@section('content_beluga')
<div class="row">
    <div class="beluga-table-group table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                <tr>
                    @foreach($data_attributes as $data_name => $data)
                        <th>{{ isset($data->label) ? $data->label : '' }}</th>
                    @endforeach

                    @if(isset($custom_columns))
                        @foreach($custom_columns as $name => $custom_column)
                            <th>{{ $name }}</th>
                        @endforeach
                    @endif

                    @if(isset($actions))
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($lines as $line)
                <tr>
                    @foreach($data_attributes as $data_name => $data)
                        <td>{{ $line->getAttribute($data_name) }}</td>
                    @endforeach

                    @if(isset($custom_columns))
                        @foreach($custom_columns as $name => $custom_column)
                            <td>{{ $custom_column($line) }}</td>
                        @endforeach
                    @endif

                    @if(isset($actions))
                        <td>
                            @foreach($actions as $action)
                                {{ $action::render($line) }}
                            @endforeach
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection