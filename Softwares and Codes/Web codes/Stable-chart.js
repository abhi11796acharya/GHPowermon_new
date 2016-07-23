 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="chart.js"></script>
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart1);
      
   function drawChart1() {
	  
	  $.getJSON('action_graph_week.php/?c=0', function(json) {
	  //alert(JSON.stringify(json));
		    dataTable1 = new google.visualization.DataTable();
			dataTable1.addColumn('datetime',   'time');
			 dataTable1.addColumn('number', 'Current');
			 dataTable1.addRow([new Date(json.time), parseInt(json.value)]);
		options1 = {
		chartArea: {width: '80%', height: '80%'},
          title: 'Sensor',
          curveType: 'function',
		  pointSize: 5,
		   vAxis: {minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };

        chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));

        chart1.draw(dataTable1, options1);
		});
