
    google.charts.load('current', {'packages':['line']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart1);
	 var dataTable1,dataTable2,dataTable3,dataTable4=null;
	 var chart1,chart2,chart3,chart4=null;
	 var options1,options2,options3,options4;
      
   function drawChart1() {
	  
	  $.getJSON('action_graph_week.php/?c=0', function(json) {
	 // alert(JSON.stringify(json));
	  dataTable1 = new google.visualization.DataTable()		
			
			dataTable1.addColumn('datetime',   'Time');
			 dataTable1.addColumn('number', 'Current1');
			 dataTable1.addColumn('number', 'Current2');
			 dataTable1.addColumn('number', 'Current3');
			 for(i=0;i <json.length; i++)
			 { 
			  console.log(json[i].Time);
			  
			  dataTable1.addRow([new Date(json[i].Time),parseInt(json[i].Current),parseInt(json[i].Current2),parseInt(json[i].Current3)]);
			 }
			 
		options1 = {
		chartArea: {width: '70%' , height: '70%'},
          title: 'Current',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: { viewWindow:{min:0}, minValue:0, maxValue:10,gridlines:{count:20}},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart1 = new google.charts.Line(document.getElementById('line_chart1'));
        chart1.draw(dataTable1, google.charts.Line.convertOptions(options1));
		
		//-----------------------------------------------------
		dataTable2 = new google.visualization.DataTable()		
			
			dataTable2.addColumn('datetime',   'Time');
			 dataTable2.addColumn('number', 'Voltage');
			 for(i=0;i <json.length; i++)
			 { 
			  
			  dataTable2.addRow([new Date(json[i].Time), parseInt(json[i].Voltage)]);
			 }
			 
		options2 = {
		chartArea: {width: '85%' , height: '80%'},
          title: 'Voltage',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: {viewWindow:{min:0},minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart2 = new google.charts.Line(document.getElementById('line_chart2'));
        chart2.draw(dataTable2, google.charts.Line.convertOptions(options2));
		//---------------------------------------------------------
		dataTable3 = new google.visualization.DataTable()		
			
			dataTable3.addColumn('datetime',   'Time');
			 dataTable3.addColumn('number', 'Frequency');
			 for(i=0;i <json.length; i++)
			 { 
			  
			  dataTable3.addRow([new Date(json[i].Time), parseInt(json[i].Frequency)]);
			 }
			 
		options3 = {
		chartArea: {width: '85%' , height: '80%'},
          title: 'Frequency',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: {viewWindow:{min:0},minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart3 = new google.charts.Line(document.getElementById('line_chart3'));
        chart3.draw(dataTable3, google.charts.Line.convertOptions(options3));
		//------------------------------------------------------
		dataTable4 = new google.visualization.DataTable()		
			
			dataTable4.addColumn('datetime',   'Time');
			 dataTable4.addColumn('number', 'Phase1');
			 dataTable4.addColumn('number', 'Phase2');
			 dataTable4.addColumn('number', 'Phase3');
			 for(i=0;i <json.length; i++)
			 { 
			 
			  dataTable4.addRow([new Date(json[i].Time), parseInt(json[i].Phase1), parseInt(json[i].Phase2) ,parseInt(json[i].Phase3)]);
			 }
			 
		options4 = {
		chartArea: {width: '85%' , height: '80%'},
          title: 'Phase',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: {viewWindow:{min:0},minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart4 = new google.charts.Line(document.getElementById('line_chart4'));
       chart4.draw(dataTable4, google.charts.Line.convertOptions(options4));
		
		});
		}
