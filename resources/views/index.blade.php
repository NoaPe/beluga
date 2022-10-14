 
@extends('beluga::layouts.default')

@section('title', 'Administration')

@section('content')
    <p>Show Tables</p>

    {{-- <x-beluga-form shell="Place" />

    <script>
    bindClickEvent(map_localisation, (coords) => {
        map_polyline.setView(coords, 13);
        map_surface.setView(coords, 13);
    });
    </script>--}}


    <p>Depollution</p>

    <x-beluga-form shell="Depollution" />
@endsection