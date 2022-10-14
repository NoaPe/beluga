@extends('beluga::layouts.default')

@section('title', 'Creation')

@section('content')
    <p>Schema creation</p>

    <x-beluga-form shell="Table" :internal="true" />
@endsection