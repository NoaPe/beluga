@extends(isset($layout) && $layout !== '' ? $layout : 'beluga::layouts.raw')

@section('title', $shell->getName())

@section('content')
<div class="row">
    <div class="beluga-table-group table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach($data_attributes as $data_name => $data)
                        <th>{{ $data->label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($lines as $line)
                <tr>
                    @foreach($data_attributes as $data_name => $data)
                        <td>{{ $line->getAttribute($data_name) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection