@extends('layouts.main')

	@push('styles')
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	@endpush
	@section('title', 'Kalender')
	@section('content')

	<div class="container">
	    <button id="sync" class="btn btn">Sync</button>
	    <div id="calendar" width="100%"></div>
	</div>

	@include('partials.event_erstellen')

	@endsection

	@push('scripts')
		<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/lib/moment.min.js'></script>
		<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/fullcalendar.min.js'></script>
		<script>
		    $(document).ready(function() {
		        $('#calendar').fullCalendar({
		        	defaultView: 'agendaWeek',
		        	firstDay: 1,
		        	nowIndicator: true,
		        	height: 'auto',
		        	selectable: true,
		        	header: {
				      left: 'prev,next today',
				      center: 'title',
				      right: 'agendaWeek,month,listYear'
				    },
		            events:'events',

		            dayClick: function(date) {

		            	$('#datetime_start').val(date.format("DD.MM.YYYY HH:mm"));
		            	$('#create').modal('show');
		            },
		            select: function(startDate, endDate) {
		            	var beginn = startDate.format("DD.MM.YYYY HH:mm");
		            	var ende = endDate.format("DD.MM.YYYY HH:mm");
		            	$('#datetime_start').val(beginn);
		            	$('#datetime_end').val(ende);
		            	$('#create').modal('show');
		            },
		            views: {
		                week: {
		                    minTime: "00:00:00",
		                    maxTime: "24:00:00"
		                },
		                day: {
		                    minTime: "00:00:00",
		                    maxTime: "24:00:00"
		                }
		            },
		        });
		    });
		</script>
		<script type="text/javascript">
		    $(document).ready(function(){
		        $.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            }
		        });

				$("#sync").click(function () {
					var calendar_id = {!! $calendars !!};

		            $.ajax({
		                type: 'POST',
		                url: "/calendar/sync",
		                dataType: 'text',
		                data: {
		                    'calendar_id': calendar_id
		                },
		                success: function () {
		                	$('#calendar').fullCalendar( 'refetchEvents' );
		            	}
	        		});
				});


		        $(".createsubmit").click(function () {
		            $.ajax({
		                type: 'POST',
		                url: "/event/create",
		                dataType: 'text',
		                data: {
		                    'title': $('#title').val(),
		                    'description': $('#description').val(),
		                    'calendar_id': $('#calendar_id').val(),
		                    'location': $('#location').val(),
		                    'priority': $('#priority').val(),
		                    'datetime_start': $('#datetime_start').val(),
		                    'datetime_end': $('#datetime_end').val(),
		                },

		                success: function () {
		                    $('#calendar').fullCalendar( 'refetchEvents' );

		                }
		            });
		        });

		    });

</script>


	@endpush
