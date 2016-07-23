
      google.charts.load('current', {'packages':['corechart']});
     
	  /*$.getJSON('action_page.php', function(json) {
	  alert(JSON.stringify(json));
			//var dataTable = new google.visualization.DataTable(json);
		});*/
	  var dataTable1,dataTable2,dataTable3,dataTable4=null;
	  var chart1,chart2,chart3,chart4=null;
	  var options1,options2,options3,options4;
	  var oldTime1,oldTime2,oldTime3,oldTime4=null;
			//----------------------------------------------------------------F1--------------------------------------------------------	 
	 google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
	  
	  $.getJSON('action_page.php/?q=1&x=1', function(json) {
	  //alert(JSON.stringify(json));
		    dataTable1 = new google.visualization.DataTable();
			dataTable1.addColumn('datetime',   'time');
			 dataTable1.addColumn('number', 'Current1');
			 dataTable1.addColumn('number', 'Current2');
			 dataTable1.addColumn('number', 'Current3');
			 oldTime1=json[0].time;
			 dataTable1.addRow([new Date(json[0].time), parseInt(json[0].value1),parseInt(json[0].value2),parseInt(json[0].value3),]);
			 //dataTable.addRow([new Date(json[0].time), parseInt(json[0].current)]);
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

        chart1.draw(dataTable1, options1);
		});
		var app1=200;
		function updater1(){
			$.getJSON('action_page.php/?q=1&x=1', function(json) {
			if(!(oldTime1===json[0].time))
				dataTable1.addRow([new Date(json[0].time), parseInt(json[0].value1), parseInt(json[0].value2), parseInt(json[0].value3)]);	
			
		if (dataTable1.getNumberOfRows()>100)
				{
					dataTable1.removeRow(0);		
				}
			});
			chart1.draw(dataTable1, options1);
			
			app1=app1+200;
		}
		//-----------------------------------------------------F2--------------------------------------------------------------------
	/*google.charts.setOnLoadCallback(drawChart2);
      function drawChart2() {
	  */
	  $.getJSON('action_page.php/?q=4&x=0', function(json) {
	  //alert(JSON.stringify(json));
		    dataTable2 = new google.visualization.DataTable();
			dataTable2.addColumn('datetime',   'time');
			 dataTable2.addColumn('number', 'Voltage');
			 oldTime2=json[0].time;
			 dataTable2.addRow([new Date(json[0].time), parseInt(json[0].value)]);
			 //dataTable.addRow([new Date(json[0].time), parseInt(json[0].current)]);
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
				dataTable2.addRow([new Date(json[0].time), parseInt(json[0].value)]);	
			
		if (dataTable2.getNumberOfRows()>100)
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
			 dataTable3.addRow([new Date(json[0].time), parseInt(json[0].value)]);
			 //dataTable.addRow([new Date(json[0].time), parseInt(json[0].current)]);
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
				dataTable3.addRow([new Date(json[0].time), parseInt(json[0].value)]);	

		if (dataTable3.getNumberOfRows()>100)
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
			 dataTable4.addColumn('number', 'Phase1');
			 dataTable4.addColumn('number', 'Phase2');
			 dataTable4.addColumn('number', 'Phase3');
			 oldTime4=json[0].time;
			 dataTable4.addRow([new Date(json[0].time), parseInt(json[0].value1),parseInt(json[0].value2),parseInt(json[0].value3),]);
			 //dataTable.addRow([new Date(json[0].time), parseInt(json[0].current)]);
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
				dataTable4.addRow([new Date(json[0].time), parseInt(json[0].value1),parseInt(json[0].value2),parseInt(json[0].value3)]);	
			
		if (dataTable4.getNumberOfRows()>300)
				{
					dataTable4.removeRow(0);		
				}
			});
			chart4.draw(dataTable4, options4);
			
			app4=app4+200;
		}
		setInterval(function(){updater1();updater2();updater3();updater4();},1000);
      }
  