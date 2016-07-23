
      google.charts.load('current', {'packages':['corechart']});
     
	  /*$.getJSON('action_page.php', function(json) {
	  alert(JSON.stringify(json));
			//var dataTable = new google.visualization.DataTable(json);
		});*/
	  var dataTable1,dataTable2,dataTable3,dataTable4=null;  //declare global variables 
	  var chart1,chart2,chart3,chart4=null;
	  var options1,options2,options3,options4;
	  var oldTime1,oldTime2,oldTime3,oldTime4=null;			 
			//----------------------------------------------------------------F1--------------------------------------------------------	 
	 google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
	  
	  $.getJSON('action_page.php/?q=1&x=1', function(json) { 	//acquire JSON from action_page.php, q=1 indicates it is requesting 'current', x=1
	  //alert(JSON.stringify(json));							  indicates there are 3 different values available for current.
		    dataTable1 = new google.visualization.DataTable();
			dataTable1.addColumn('datetime',   'time');
			 dataTable1.addColumn('number', 'Device1');
			 dataTable1.addColumn('number', 'Device2');
			 dataTable1.addColumn('number', 'Device3');
			 oldTime1=json[0].time;
			 dataTable1.addRow([new Date(json[0].time), parseFloat(json[0].value1),parseFloat(json[0].value2),parseFloat(json[0].value3),]);
			 //dataTable.addRow([new Date(json[0].time), parseFloat(json[0].current)]);
		options1 = {
		chartArea: {width: '80%', height: '80%'},
          title: 'Current',
          curveType: 'function',
		  pointSize: 5,
		   vAxis: {minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' },
		  
        };

        chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));

        chart1.draw(dataTable1, options1);				//Draw the graph with the data provided, THERE IS ONLY ONE VALUE AVAILABLE PER PARAMETER, i.e. JSON
														//generated only had the latest data.
		});
		var app1=200;
		function updater1(){											//updaters() function are responsible for adding new row by frequently requesting (AJAX)
			$.getJSON('action_page.php/?q=1&x=1', function(json) {		//new data from the page, and parsing the provided data in JSON format containing the latest data.
			if(!(oldTime1===json[0].time))								//and hence dynamically adding values as soon as they are updated in table "para" in database.
				dataTable1.addRow([new Date(json[0].time), parseFloat(json[0].value1), parseFloat(json[0].value2), parseFloat(json[0].value3)]);	
																		
		if (dataTable1.getNumberOfRows()>70)							//removerow() constantly removes rows containing old data, when total no. of rows exceed 100. 
				{														//and hence the graph appear to be moving.
					dataTable1.removeRow(0);		
				}
			});
			chart1.draw(dataTable1, options1);
			
			app1=app1+200;			//for console.log, debugging purposes
		}
		//-----------------------------------------------------F2--------------------------------------------------------------------
	/*google.charts.setOnLoadCallback(drawChart2);
      function drawChart2() {			
	  */
	  $.getJSON('action_page.php/?q=4&x=0', function(json) {				// Same process is followed by rest of the parameters.
	  //alert(JSON.stringify(json));
		    dataTable2 = new google.visualization.DataTable();
			dataTable2.addColumn('datetime',   'time');
			 dataTable2.addColumn('number', 'Voltage');
			 oldTime2=json[0].time;
			 dataTable2.addRow([new Date(json[0].time), parseFloat(json[0].value)]);
			 //dataTable.addRow([new Date(json[0].time), parseFloat(json[0].current)]);
		options2 = {
			chartArea: {width: '80%', height: '80%'},
          title: 'Voltage',
          curveType: 'function',
		  pointSize: 5,
		   vAxis: {minValue:200, maxValue:260},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };

        chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart2.draw(dataTable2, options2);
		});
		var app2=200;
		
		function updater2(){
			$.getJSON('action_page.php/?q=4&x=0', function(json) {
			if(!(oldTime2===json[0].time))
				dataTable2.addRow([new Date(json[0].time), parseFloat(json[0].value)]);	
			
		if (dataTable2.getNumberOfRows()>70)
				{
					dataTable2.removeRow(0);		
				}
			});
			chart2.draw(dataTable2, options2);
			
			app2=app2+200;
		}
		//-----------------------------------------------------F3-----------------------------------------------------------------------
	/*	google.charts.setOnLoadCallback(drawChart3);
      function drawChart3() {
	  */
	  $.getJSON('action_page.php/?q=5&x=0', function(json) {
	  //alert(JSON.stringify(json));
		    dataTable3 = new google.visualization.DataTable();
			dataTable3.addColumn('datetime',   'time');
			 dataTable3.addColumn('number', 'Frequency');
			 oldTime3=json[0].time;
			 dataTable3.addRow([new Date(json[0].time), parseFloat(json[0].value)]);
			 //dataTable.addRow([new Date(json[0].time), parseFloat(json[0].current)]);
		options3 = {
			chartArea: {width: '80%', height: '80%'},
          title: 'Frequency',
          curveType: 'function',
		  pointSize: 5,
		   vAxis: {minValue:45, maxValue:55},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };

        chart3= new google.visualization.LineChart(document.getElementById('curve_chart3'));

        chart3.draw(dataTable3, options3);
		});
		var app3=200;		
		
		function updater3(){
			$.getJSON('action_page.php/?q=5&x=0', function(json) {
			if(!(oldTime3===json[0].time))
				dataTable3.addRow([new Date(json[0].time), parseFloat(json[0].value)]);	

		if (dataTable3.getNumberOfRows()>70)
				{
					dataTable3.removeRow(0);		
				}
			});
			chart3.draw(dataTable3, options3);
		 
			app3=app3+200;
		} 
		//----------------------------------------------------------------------------F4-----------------------------------------------------------------
		/*
			google.charts.setOnLoadCallback(drawChart4);
      function drawChart4() {
	  */
	  $.getJSON('action_page.php/?q=6&x=1', function(json) {
	  //alert(JSON.stringify(json));
		    dataTable4 = new google.visualization.DataTable();
			dataTable4.addColumn('datetime',   'time');
			 dataTable4.addColumn('number', 'Device1');
			 dataTable4.addColumn('number', 'Device2');
			 dataTable4.addColumn('number', 'Device3');
			 oldTime4=json[0].time;
			 dataTable4.addRow([new Date(json[0].time), parseFloat(json[0].value1),parseFloat(json[0].value2),parseFloat(json[0].value3),]);
			 //dataTable.addRow([new Date(json[0].time), parseFloat(json[0].current)]);
		options4 = {
			chartArea: {width: '80%', height: '80%'},
          title: 'Phase',
          curveType: 'function',
		  pointSize: 5,
		   vAxis: {minValue:0, maxValue:10},
		  pointShape: 'circle',	
          legend: { position: 'top' }
        };

        chart4= new google.visualization.LineChart(document.getElementById('curve_chart4'));

        chart4.draw(dataTable4, options4);
		});
		var app4=200;		
		
		function updater4(){
			$.getJSON('action_page.php/?q=6&x=1', function(json)
			{
			if(!(oldTime4===json[0].time))
				dataTable4.addRow([new Date(json[0].time), parseFloat(json[0].value1),parseFloat(json[0].value2),parseFloat(json[0].value3)]);	
			
		if (dataTable4.getNumberOfRows()>70)
				{
					dataTable4.removeRow(0);		
				}
			});
			chart4.draw(dataTable4, options4);
			
			app4=app4+200;
		}
		setInterval(function(){updater1();updater2();updater3();updater4();},1000);
      }
  