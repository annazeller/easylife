@extends('layouts.main')
@section('title', 'Statistik')
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

      // Create the data table.
      var data = new google.visualization.DataTable();
      var aE = parseInt(result.Erledigt);
      var aO = parseInt(result.Offen);
      data.addColumn('string', 'Aufgaben');
      data.addColumn('number', 'Anzahl der Aufgaben');
      data.addRows([
        ['Erledigt', aE],
        ['Offen', aO]
      ]);

        // Set chart options
      var options = {'title':'Meine Aufgaben',
                     'width':600,
                     'height':500,
                      pieHole: 0.4,
                      colors: ['#FE8F3E','#293541']
                   };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
@endsection