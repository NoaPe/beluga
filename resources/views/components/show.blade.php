@extends(isset($layout) && $layout !== '' ? $layout : 'beluga::layouts.raw')

@section('title_beluga', $shell->getName())
@section('content_beluga')
    <div id="beluga-show-{{ $shell->getName() }}" class="beluga-show">

        @if(isset($schema->description))
            <div class="show-description">
                {{ $schema->description }}
            </div>
        @endif

        {!! $schema->show($shell) !!}
    </div>
@endsection