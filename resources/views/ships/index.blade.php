@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <h2>Корабли</h2>
        <div class="list-group">
            @foreach($ships as $ship)
            <a href="/ships/{{ $ship->id }}/edit" class="list-group-item list-group-item-action">{{ $ship->title }}</a>
            @endforeach
        </div>
    </div>
@endsection
