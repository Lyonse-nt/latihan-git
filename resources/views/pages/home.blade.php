@extends('layouts.public')

@section('content')
    @include('components.hero')
    @include('components.about')
    @include('components.statistics')
    @include('components.members')
    @include('components.memories')
    @include('components.hall-of-fame')
    @include('components.quotes')
    @include('components.guestbook')
@endsection
