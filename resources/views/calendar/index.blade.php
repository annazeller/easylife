@extends('layouts.app')

	@push('styles')
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	@endpush

	@section('content')
	@csrf
		<div class="container">
			<h3>FullCalendar</h3>
			<div id="calendar"></div>
		</div>
	@endsection

	@push('scripts')
		<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/lib/moment.min.js'></script>
		<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/fullcalendar.min.js'></script>
		<script>
		    $(document).ready(function() {
		        $('#calendar').fullCalendar({
		        	defaultView: 'listWeek',
		        	header: {
				      left: 'prev,next today',
				      center: 'title',
				      right: 'month,listYear'
				    },
		            events:'cal'
		        });
		    });
		</script>
	@endpush
