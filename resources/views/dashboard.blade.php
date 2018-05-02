@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
@include('partials.alert')
<div class="row">
<!--<a href="/event/create" class="btn btn-default" type="button" data-toggle="" data-target=""> Termin erstellen</a>-->
	<a href="/calendar" class="btn btn-default" type="button" data-toggle="" data-target=""> Kalender</a>
    <a href="/calendar/sync" class="btn btn-default" type="button" data-toggle="" data-target=""> Kalender synchronisieren</a>
</div>
@stop
@push('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.min.js "></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"></script>-->
<script src="{{ asset('assets/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('assets/create_event.js') }}"></script>
@endpush