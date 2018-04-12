@extends('layouts.main')

@section('content')
@include('partials.alert')
<form method="POST">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <p>
        <label for="calendar_id">Kalender:</label>
        <select name="calendar_id" id="calendar_id">
            @foreach($calendars as $cal)
            <option value="{{ $cal->calendar_id }}">{{ $cal->title }}</option>
            @endforeach
        </select>
    </p>
    <button type="button" class="btn btn-success" data-dismiss=""> Kalender synchronisieren</button>
</form>
@stop