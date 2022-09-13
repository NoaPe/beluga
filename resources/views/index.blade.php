 
@extends('beluga::layouts.default')

@section('title', 'Administration')

@section('content')
    <p>Show Tables</p>

    <x-beluga-form shell="Data" internal=true />
@endsection