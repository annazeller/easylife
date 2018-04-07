@extends('layouts.main')

	@push('styles')
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	@endpush

	@section('content')

		<div class="container">
			<h3>Kalender</h3>
			<button id="sync" class="btn btn">Sync</button>
			<div id="calendar"></div>
		</div>
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
		        	allDayDefault: true,
		        	header: {
				      left: 'prev,next today',
				      center: 'title',
				      right: 'week,month,listYear'
				    },
		            events:'events'
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
					var calendar_id = "ejh7k3d3e26i2j7h268h2bsfh0@group.calendar.google.com";
		            $.ajax({
		                type: 'POST',
		                url: "/calendar/sync",
		                dataType: 'text',
		                data: {
		                    'calendar_id': calendar_id
		                },
		                success: function (data) {
                      var json = JSON.parse(data);
		                	console.log(json);
		                	$('#calendar').fullCalendar( 'refetchEvents' );
		            	}
	        		});
				});
			});
			
		</script>


	@endpush
