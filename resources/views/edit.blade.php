 
@extends('beluga::layouts.default')

@section('title', 'Edition')

@section('content')
    <x-beluga-form :shell="$shell" method="PUT" />
@endsection