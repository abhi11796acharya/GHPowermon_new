    google.charts.load('current', {'packages':['line']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart1);
	 var dataTable1,dataTable2,dataTable3,dataTable4=null;  //Declare global variables
	 
	 var chart1,chart2,chart3,chart4=null;
	 var options1,options2,options3,options4;
      
   function drawChart1() {
	  
	  $.getJSON('action_graph_week.php/?c=0', function(json) {  			//acquires echoed JSON from 'action_graph_week.php', c=0 notifies the page that graph is  
	 // alert(JSON.stringify(json));										  accessing the page and hence not allowed to change the chosen period in log by the user.
	  dataTable1 = new google.visualization.DataTable()		
			
			dataTable1.addColumn('datetime',   'Time');  					//Create columns
			 dataTable1.addColumn('number', 'Device1');
			 dataTable1.addColumn('number', 'Device2');
			 dataTable1.addColumn('number', 'Device3');
			 for(i=0;i <json.length; i++)									//Feed data using loop
			 { 
			  console.log(json[i].Time);
			  
			  dataTable1.addRow([new Date(json[i].Time),parseFloat(json[i].Current),parseFloat(json[i].Current2),parseFloat(json[i].Current3)]);
			 }
			 
		options1 = {														//options for the graph
		chartArea: {width: '70%' , height: '70%'},
          title: 'Current',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: { viewWindow:{min:0}, minValue:0, maxValue:10,gridlines:{count:20}},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart1 = new google.charts.Line(document.getElementById('line_chart1'));	
        chart1.draw(dataTable1, google.charts.Line.convertOptions(options1));  		//draws the graph
		
		//-----------------------------------------------------
		dataTable2 = new google.visualization.DataTable()							//similar process for the rest.
			
			dataTable2.addColumn('datetime',   'Time');
			 dataTable2.addColumn('number', 'Voltage');
			 for(i=0;i <json.length; i++)
			 { 
			  
			  dataTable2.addRow([new Date(json[i].Time), parseFloat(json[i].Voltage)]);
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
			  
			  dataTable3.addRow([new Date(json[i].Time), parseFloat(json[i].Frequency)]);
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
			 dataTable4.addColumn('number', 'Device1');
			 dataTable4.addColumn('number', 'Device2');
			 dataTable4.addColumn('number', 'Device3');
			 for(i=0;i <json.length; i++)
			 { 
			 
			  dataTable4.addRow([new Date(json[i].Time), parseFloat(json[i].Phase1), parseFloat(json[i].Phase2) ,parseFloat(json[i].Phase3)]);
			 }
			 
		options4 = {
		chartArea: {width: '85%' , height: '80%'},
          title: 'Phase',
          curveType: 'function',
		  pointSize: 1,
		   vAxis: {viewWindow:{min:-90},minValue:-90, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };
        chart4 = new google.charts.Line(document.getElementById('line_chart4'));
       chart4.draw(dataTable4, google.charts.Line.convertOptions(options4));
		
		});
		}
