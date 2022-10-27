 
@extends('beluga::layouts.default')

@section('title', 'Table')

@section('content')
    <x-beluga-table :shell="$shell"
                :display-columns="isset($display_columns) ? $display_columns : null"" 
                :lines="isset($lines) ? $lines : null"
                :actions="isset($actions) ? $actions : null" />
@endsection