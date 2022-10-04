@if ($layout)
    @extends($layout)

    @section('title', $shell->getName())

    @section('content')
@endif
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach($schema->datas as $data_name => $data)
                    <th>{{ $data->label }}</th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
            <tr>
                @foreach($schema->datas as $data_name => $data)
                    <td>{{ $line->getAttribute($data_name) }}</td>
                @endforeach
                <td>
                    <a href="{{ route($shell->getRoute().'.edit', $line->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route($shell->getRoute().'.destroy', $line->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
    </table>
@if ($layout)
    @endsection
@endif