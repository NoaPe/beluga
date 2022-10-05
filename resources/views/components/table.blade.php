@extends(isset($layout) && $layout !== '' ? $layout : 'beluga::layouts.raw')

@section('title', $shell->getName())

@section('content')
    <x-beluga::table.group :shell="$shell" :group="$schema" :lines="$lines" />
@endsection