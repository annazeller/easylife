@extends('layouts.main')
@section('title', 'Termin erstellen')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/jquery-datetimepicker/build/jquery.datetimepicker.min.css') }}">
@endpush

@section('content')
@include('partials.alert')
<!-- <form method="POST">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <p>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}">
    </p>
    <p>
        <label for="calendar_id">Calendar</label>
        <select name="calendar_id" id="calendar_id">
            @foreach($calendars as $cal)
            <option value="{{ $cal->calendar_id }}">{{ $cal->title }}</option>
            @endforeach
        </select>
    </p>
    <p>
        <label for="datetime_start">Datetime Start</label>
        <input type="text" name="datetime_start" id="datetime_start" class="datetimepicker" value="{{ old('datetime_start') }}">
    </p>
    <p>
        <label for="datetime_end">Datetime End</label>
        <input type="text" name="datetime_end" id="datetime_end" class="datetimepicker" value="{{ old('datetime_end') }}">
    </p>
    <div id="attendees">
        Attendees
        <div class="attendee-row">
            <input type="text" name="attendee_name[]" class="half-input name" placeholder="Name" autocomplete="name">
            <input type="email" name="attendee_email[]" class="half-input email" placeholder="E-Mail" autocomplete="email">
        </div>
    </div>
    <button>Create Event</button>
</form> -->
<form class="form-horizontal" role="form" method="POST">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Titel:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" value="{{ old('title') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="calendar_id">Kalender:</label>
                        <div class="col-sm-10">
                            <select name="calendar_id" id="calendar_id">
                                @foreach($calendars as $cal)
                                <option value="{{ $cal->calendar_id }}">{{ $cal->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="start_date">Startdatum:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="datetime_start" id="datetime_start" class="datetimepicker" value="{{ old('datetime_start') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="end_date">Enddatum:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="datetime_end" id="datetime_end" class="datetimepicker" value="{{ old('datetime_end') }}">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success pull-right" data-dismiss="">speichern</button>
                </form>
@endsection


<!-- @section('attendee_template')
<script id="attendee-template" type="text/x-handlebars-template">
    <div class="attendee-row">
        <input type="text" name="attendee_name[]" class="half-input name" placeholder="Name" autocomplete="name">
        <input type="email" name="attendee_email[]" class="half-input email" placeholder="Email" autocomplete="email">
    </div>
</script>
@endsection-->

    @push('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.min.js "></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"></script>-->
<script src="{{ asset('assets/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('assets/create_event.js') }}"></script>
@endpush