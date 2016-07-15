<!DOCTYPE HTML>
<html>
  <head>
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
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

#d_status {
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
setInterval("getbutton1(),getbutton2(),getbutton3()",1000);
           function getbutton1() 
				{
				 if (window.XMLHttpRequest)
				  {
					var xmlhttp1=new XMLHttpRequest();
				  } else 
				  {
					var xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				  xmlhttp1.onreadystatechange=function()
				  {
					if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
					{
			var store = xmlhttp1.responseText;
					 
 					 var UI=document.getElementById("buttony");
					   if (store==1)
					   UI.innerHTML = "Switch OFF";
					   else
					   UI.innerHTML = "Switch ON";
					   
					   
					 var swtch;  
					 var Buttonx=document.getElementById("buttonx");
					 if(store==1)
						  {
						   swtch = 0;
						  }
						 else 
						 {
						  swtch = 1;
						 }
						Buttonx.href="button_status.php?q="+swtch;   
					}
				  }
				  xmlhttp1.open("GET","button_refresh.php",true);
				  xmlhttp1.send();
				}
			

 function getbutton2() 
				{
				 if (window.XMLHttpRequest)
				  {
					var xmlhttp2=new XMLHttpRequest();
				  } else 
				  {
					var xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				  xmlhttp2.onreadystatechange=function()
				  {
					if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
					{
			var store = xmlhttp2.responseText;
					 
 					 var UI=document.getElementById("buttony_2");
					   if (store==1)
					   UI.innerHTML = "Switch OFF";
					   else
					   UI.innerHTML = "Switch ON";
					   
					   
					 var swtch;  
					 var Buttonx_2=document.getElementById("buttonx_2");
					 if(store==1)
						  {
						   swtch = 0;
						  }
						 else 
						 {
						  swtch = 1;
						 }
						Buttonx_2.href="button_status_2.php?q="+swtch;   
					}
				  }
				  xmlhttp2.open("GET","button_refresh_2.php",true);
				  xmlhttp2.send();
				}
			


 function getbutton3() 
				{
				 if (window.XMLHttpRequest)
				  {
					var xmlhttp3=new XMLHttpRequest();
				  } else 
				  {
					var xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				  xmlhttp3.onreadystatechange=function()
				  {
					if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
					{
			var store = xmlhttp3.responseText;
					 
 					 var UI=document.getElementById("buttony_3");
					   if (store==1)
					   UI.innerHTML = "Switch OFF";
					   else
					   UI.innerHTML = "Switch ON";
					   
					   
					 var swtch;  
					 var Buttonx_3=document.getElementById("buttonx_3");
					 if(store==1)
						  {
						   swtch = 0;
						  }
						 else 
						 {
						  swtch = 1;
						 }
						Buttonx_3.href="button_status_3.php?q="+swtch;   
					}
				  }
				  xmlhttp3.open("GET","button_refresh_3.php",true);
				  xmlhttp3.send();
				}
			
			
</script>
  </head>
  <body style="padding:8px">
  <h1>
    <strong>GREEN HOUSE POWER MONITORING</strong>
  </h1>
  
<div id="back_below">  
  <div>
<ul id="choice_buttons">
  <li><a class="active" href="change.html">Home</a></li> 
  <li><a href="current.html">Current Status</a></li>
  <li><a href="past.php">Past 14 Days</a></li>
  <li><a class="active" href="select.php">Schedule</a></li>
 <span style = "position:absolute;right:5px"> <li><a id="power" href="test.html">POWER</a></li><span>
</ul>
</div>
  <br>
 
  <div id="date_time_scheduler" style=" height:600px;width:100%;background: linear-gradient(to bottom right, #222, #666);">
  <div id="floating-block">
     <div id="d_status" style="background-color:red"></div>
   <div id="d_status" style="background-color:#20ff20"></div>
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
  </div>
  </div>
  <div id="floating-block"> 
   <div id="d_status" style="background-color:red"></div>
   <div id="d_status" style="background-color:#20ff20"></div>
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
</div>
</div>
  <div id="floating-block"> 
   <div id="d_status" style="background-color:red"></div>
   <div id="d_status" style="background-color:#20ff20"></div>
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