<!DOCTYPE HTML>
<html>
  <head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <script type="text/javascript" src="JS/jquery.js"></script>
  <script type="text/javascript" src="jquery.min.js"></script>
  <script type="text/javascript" src="JS/jquery.ui.js"></script>
  <script type="text/javascript" src="JS/jquery.editinplace.js"></script>
  <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">     
  <script type="text/javascript" src="JS/demo.js"></script>
<style>	 
h1
{ 
  border: 100%;
  background-color : #50ff50;
  text-align: center;
  color: white;
  font-size: 30px;
  font-family: corbel;
  margin: 2px 0px 10px 0px;
 
  
}
input[type="radio"]
 {
  margin-top: -1px;
  vertical-align: middle;
}

#choice_buttons{
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
	font-family: impact;
	font-size: 16px;
	 
}

li a:hover {
    background-color: #50ff50;
	color: black;
	text-decoration: none;
}
li a:active
{ 
 background-color: #50ff50;
 color: black;
}


.button1 {
 
  border-radius: 4px;
  background-color: #404090;
  border: none;
  color: #FFFFFF;
  
  text-align: center;
  font-size: 16px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button1:hover
{
 background-color:white;
 color:black;
}
.button1 {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}


#d_status1 {
	 display:inline-block;  
	 border-radius:100%;
	 height:60px;width:60px;
     box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);

	 
}
#d_status3{
	 display:inline-block;  
	 border-radius:100%;
	 height:60px;width:60px;
     box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);

	 
}
#d_status5 {
	 display:inline-block;  
	 border-radius:100%;
	 height:60px;width:60px;
     box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);

	 
}

#floating-block
{
	display: inline-block;
	width: 32%;
	margin:7px;
	 padding: 70px 0;
    text-align: center;
}


</style>
<script>
 $(document).ready(function(){
	
	// All examples use the commit to function interface for ease of demonstration.
	// If you want to try it against a server, just comment the callback: and 
	// uncomment the url: lines.
	
	$("#editme5").editInPlace({
		saving_animation_color: "#ECF2F8",
		callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
			animationCallbacks.didStartSaving();
			setTimeout(animationCallbacks.didEndSaving, 2000);
			return enteredText;
		}
	});
	
	// If you need to remove an already bound editor you can call

	// > $(selectorForEditors).unbind('.editInPlace')

	// Which will remove all events that this editor has bound. You need to make sure however that the editor is 'closed' when you call this.
	
});
 
 
 
 function status()
 {
	 $.getJSON('button_refresh.php', function(json)
  {
	  
	  //------------------------------------------------------------
	  var UI=document.getElementById("buttony");
					   if (json[0].button1==1)
					   UI.innerHTML = "Switch OFF";
					   else
					   UI.innerHTML = "Switch ON";
				     var swtch;  
					 var Buttonx=document.getElementById("buttonx");
					 if(json[0].button1==1)
						  {
						   swtch = 0;
						  }
						 else 
						 {
						  swtch = 1;
						 }
						Buttonx.href="button_status.php?q="+swtch;   
			//--------------------------------------------------------------------		   
					   var UI2=document.getElementById("buttony_2");
					   if (json[0].button2==1)
					   UI2.innerHTML = "Switch OFF";
					   else
					   UI2.innerHTML = "Switch ON";
				     var swtch2;  
					 var Buttonx2=document.getElementById("buttonx_2");
					 if(json[0].button2==1)
						  {
						   swtch2 = 0;
						  }
						 else 
						 {
						  swtch2 = 1;
						 }
						Buttonx2.href="button_status_2.php?q="+swtch2;
			//--------------------------------------------------------------			
						var UI3=document.getElementById("buttony_3");
					   if (json[0].button3==1)
					   UI3.innerHTML = "Switch OFF";
					   else
					   UI3.innerHTML = "Switch ON";
				   
				     var swtch3;  
					 var Buttonx3=document.getElementById("buttonx_3");
					 if(json[0].button3==1)
						  {
						   swtch3 = 0;
						  }
						 else 
						 {
						  swtch3 = 1;
						 }
						Buttonx3.href="button_status_3.php?q="+swtch3;
						
				//-----------------------------------------------------------------------	
				
					var UI4= document.getElementById("d_status1")
					   if (parseInt(json[0].d_stat1)==0)
					 UI4.style.backgroundColor="red";
				      else 
					 UI4.style.backgroundColor="#20ff20"
				//------------------------------------------------------------------------	 
					var UI5= document.getElementById("d_status3");
					   if (parseInt(json[0].d_stat2)==0)
					 UI5.style.backgroundColor="red";
				      else 
					 UI5.style.backgroundColor="#20ff20"
				//------------------------------------------------------------------------	 		   
					var UI6= document.getElementById("d_status5");
					   if (parseInt(json[0].d_stat3)==0)
					 UI6.style.backgroundColor="red";
				      else 
					 UI6.style.backgroundColor="#20ff20";
					 
					 
				//------------------------------------------------------------------------	
					var UI6= document.getElementById("schedule_box_1");
					var s_stat;
					var fromtime;
					var totime;
					switch(parseInt(json[0].offon1))
					{
						case 1:s_stat="ON";fromtime= json[0].Switch_on1;totime=json[0].Switch_off1;break;
						case 0:s_stat="OFF";fromtime=json[0].Switch_off1;totime=json[0].Switch_on1;break;
						case -1:s_stat="Blink";fromtime=json[0].Switch_off1;totime=json[0].Switch_on1; break;
						
					}
					
				 console.log((json[0].offon1));
				 console.log(parseInt(json[0].Button_change1));
					   if ((parseInt(json[0].Button_change1)==0)&&(parseInt(json[0].offon1)==-2))
					  UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
				   
				      else if ((parseInt(json[0].Button_change1)==1))
					 UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
					 
					 else
					 UI6.innerHTML="SCHEDULED "+ s_stat + "<div>  From:" + fromtime+ "<br>  at:"+ totime +"<div>";
					 
				//------------------------------------------------------------------------	
					var UI6= document.getElementById("schedule_box_2");
					   switch(parseInt(json[0].offon2))
					{
						case 1:s_stat="ON";fromtime= json[0].Switch_on2;totime=json[0].Switch_off2;break;
						case 0:s_stat="OFF";fromtime=json[0].Switch_off2;totime=json[0].Switch_on2;break;
						case -1:s_stat="Blink";fromtime=json[0].Switch_off2;totime=json[0].Switch_on2; break;
						
					}
					
				 console.log((json[0].offon2));
					    if ((parseInt(json[0].Button_change2)==0)&&(parseInt(json[0].offon2)==-2))
					  UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
				   
				      else if ((parseInt(json[0].Button_change2)==1))
					 UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
					 
					 else
					 UI6.innerHTML="SCHEDULED "+ s_stat + "<div>  From:" + fromtime+ "<br>  at:"+ totime +"<div>";
					 
				//------------------------------------------------------------------------	
					var UI6= document.getElementById("schedule_box_3");
					switch(parseInt(json[0].offon3))
					{
						case 1:s_stat="ON";fromtime= json[0].Switch_on3;totime=json[0].Switch_off3;break;
						case 0:s_stat="OFF";fromtime=json[0].Switch_off3;totime=json[0].Switch_on3;break;
						case -1:s_stat="Blink";fromtime=json[0].Switch_off3;totime=json[0].Switch_on3; break;
						
					}
					
				 console.log((json[0].offon3));
					   if ((parseInt(json[0].Button_change3)==0)&&(parseInt(json[0].offon3)==-2))
					  UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
				   
				      else if ((parseInt(json[0].Button_change3)==1))
					 UI6.innerHTML="<br><br>NOT SCHEDULED YET!!";
					 
					 else
					 UI6.innerHTML="SCHEDULED "+ s_stat + "<div>  From:" + fromtime+ "<br>  at:"+ totime +"<div>";
					 
					 
				//------------------------------------------------------------------------	*/
					
 }); 
    var x;
	x++;
	
 }
 setInterval("status()",500);
</script>
  </head>
  <body style="padding:8px">
  <h1>
    <strong>GREEN HOUSE POWER MONITORING</strong>
  </h1>
  
<div id="back_below">  
  <div>
<ul id="choice_buttons">
  <li><a class="active" href="home.php">Home</a></li> 
  <li><a href="current.html">Current Status</a></li>
  <li><a href="past.php">Past 14 Days</a></li>
  <li><a class="active" href="select.php">Schedule ON/OFF</a></li>
</ul>
</div>
  <br>
  
  <div id="date_time_scheduler" style=" height:600px;width:100%;background: linear-gradient(to bottom right, #222, #666);">
  
  <div id="floating-block">
        <div>
            <p id="editme5" style="color:white;font-size:20px">DEVICE 1</p>
        </div>
     <div id="d_status1" style="background-color:red;"></div>
   <div>
<a id="buttonx"><span style="display:block;position:relative;margin:20px ;"><button class="button button1" style="width:300px;height:50px;margin:20pxpadding:10px;background-color:red;color:white"><span id="buttony" /></button></span></a>
</div>
<div >
  <form class="form-inline" action="selection.php" role="form" method="post">
	<span style="color:white;position:relative;">
	<input type="radio" name="Choice" value="ON">ON
	<input type="radio" name="Choice" value="OFF">OFF
	</span>
	<br><br>
  <div id="datetimepicker6" class="input-append date">
 <label style="color:white;vertical-align: middle;">FROM </label>
      <input type="datetime" placeholder="Select Date and Time" name="From"></input> 
    
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
	<br>
  <div id="datetimepicker4" class="input-append date" style="padding:10px;margin-left:20px;">
   <label style="color:white;vertical-align:middle;">TO</label>
	  <input type="datetime" placeholder="Select Date and Time" name="To"></input>
	  
      <span class="add-on" id="select_button">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
	  
    </div>
  
  <br><button type="submit" class="btn btn-default" value="submit" > Schedule </button>
</form>
<div id="schedule_box_1" style="color:white;position:relative"> 
</div>

 
  </div>
  </div>
  <div id="floating-block"> 
  <div>
            <p id="editme5" style="color:white;font-size:20px">DEVICE 2</p>
        </div>
   <div id="d_status3" style="background-color:red"></div>
   
  <div>
<a id="buttonx_2"><span style="display:block;position:relative;margin:20px ;"><button class="button button1" style="width:300px;height:50px;margin:20pxpadding:10px;background-color:red;color:white"><span id="buttony_2" /></button></span></a>
</div>
<div >
  <form class="form-inline" action="selection2.php" role="form" method="post">
	<span style="color:white;position:relative;">
	<input type="radio" name="Choice" value="ON">ON 
	<input type="radio" name="Choice" value="OFF">OFF
	</span>
	<br><br>
  <div id="datetimepicker3" class="input-append date">
 <label style="color:white;vertical-align: middle;">FROM </label>
      <input type="datetime" placeholder="Select Date and Time" name="From"></input> 
    
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
	<br>
  <div id="datetimepicker2" class="input-append date" style="padding:10px;margin-left:20px;">>
   <label style="color:white;vertical-align: middle;">TO</label>
	  <input type="datetime" placeholder="Select Date and Time" name="To"></input>
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
  
  <br><button type="submit" class="btn btn-default" value="submit" > Schedule </button>
</form>
<div id="schedule_box_2" style="color:white"> 
 SCHEDULED 
  <div>  From:<br>  at:
  </div>
</div>

</div>
</div>
  <div id="floating-block"> 
  <div>
            <p id="editme5" style="color:white;font-size:20px">DEVICE 3</p>
        </div>
   <div id="d_status5" style="background-color:red"></div>
  
  <div>
<a id="buttonx_3"><span style="display:block;position:relative;margin:20px ;"><button class="button button1" style="width:300px;height:50px;margin:20pxpadding:10px;background-color:red;color:white"><span id="buttony_3" /></button></span></a>
</div>
<div >
  <form class="form-inline" action="selection3.php" role="form" method="post">
	<span style="color:white;position:relative;">
	<input type="radio" name="Choice" value="ON">ON 
	<input type="radio" name="Choice" value="OFF">OFF
	</span>
	<br><br>
  <div id="datetimepicker" class="input-append date">
 <label style="color:white;vertical-align: middle;">FROM </label>
      <input type="datetime" placeholder="Select Date and Time" name="From"></input> 
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
	<br>
  <div id="datetimepicker5" class="input-append date" style="padding:10px;margin-left:20px;">
   <label style="color:white;vertical-align: middle;">TO</label>
	  <input type="datetime" placeholder="Select Date and Time" name="To"></input>
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>  
  <br><button type="submit" class="btn btn-default" value="submit" > Schedule </button>
</form>
<div id="schedule_box_3" style="color:white"> 
 SCHEDULED 
  <div>  From:<br>  at:
  </div>
</div>

</div>
</div>	
    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="JS/css/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="JS/css/bootstrap-datetimepicker.min.js">
    </script>


    <script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en '
      });
	   $('#datetimepicker5').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en ',
      });
	 $('#datetimepicker6').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en '
      });
	   $('#datetimepicker2').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en ',
      });
	 $('#datetimepicker3').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en '
      });
	   $('#datetimepicker4').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en ',
      });
	 
    </script>
  </body>
<html>