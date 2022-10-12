@extends(isset($layout) && $layout !== '' ? $layout : 'beluga::layouts.raw')

@section('title', $shell->getName())
@section('content')
    <div id="beluga-show-{{ $shell->getName() }}" class="beluga-show">

        @if(isset($schema->description))
            <div class="show-description">
                {{ $schema->description }}
            </div>
        @endif

        {!! $schema->show($shell) !!}
    </div>
@endsection