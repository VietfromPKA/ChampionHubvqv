<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    @php
        $tournaments = \App\Models\Tournament::all();
    @endphp
    
    @include('public.tournaments.index', ['tournaments' => $tournaments])
@endsection