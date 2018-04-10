@extends('layouts.main')
 
@section('content')
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      var result = {!! $result !!};
      console.log(result);

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable(result);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
        ['Erledigt', result.anzahlErledigt],
        ['Offen', result.anzahlOffen],
        ['Geplant', result.anzahlGeplant],
        ['Ungeplant', result.anzahlUngeplant],
]);
        var options = {
          title: 'result Line Chart',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="linechart" style="width: 900px; height: 500px"></div>
  </body>
</html>
@endsection