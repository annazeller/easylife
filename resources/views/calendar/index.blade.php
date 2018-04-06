<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie-edge">
	<title>Termine</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	<script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="container">
	<h3>FullCalendar</h3>
	<div id="calendar"></div>
</div>

<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-3.9.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events:'cal'
        });
    });
</script>
</body>
</html>