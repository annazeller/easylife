@extends('layouts.main')

@section('content')
@include('partials.alert')
<ul>
    <li><a href="/calendar/create">Create Calendar</a></li>
    <li><a href="/event/create">Create Event</a></li>
    <li><a href="/calendar/sync">Sync Calendar</a></li>
    <li><a href="/events">Events</a></li>
    <li><a href="/logout">Logout</a></li>
</ul>

@stop