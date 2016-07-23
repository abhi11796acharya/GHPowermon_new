<!DOCTYPE html>
<html>
<head>
</head>
<style>

h1
{ 
  border: 100%;
  background-color : #50ff50;
  text-align: center;
  color: white;
  font-size: 30px;
  font-family: corbel;
  
}

ul {
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
}

li a:hover {
    background-color: #50ff50;
	color: black;
}
li a:active
{ 
 background-color: #50ff50;
 color: black;
}
#back
{ 
  height: 510px;
  width : 100%;
  background-color: white;
  
}
img
{
 height: 510px;
  width : 100%;
}
#about
{
 height: 300px;
  width : 100%;
  background-color: black;
}
#graph
{
 font-family:impact;
 color:white;
 margin:50px;
 height:300px;
 width:50%;
}
#maindiv
{ 
 background-color:#333;
 margin-top:-33px;
 
 width:100%;
 height:100%;
}
</style>
</head>
<body> 
<h1>
    <strong>GREEN HOUSE POWER MONITORING</strong>
</h1>
<ul>
  <li><a class="active" href="change.html">Home</a></li> 
  <li><a href="current.html">Current Status</a></li>
  <li><a href="past.html">Past 30 Days</a></li>
 <span style = "position:absolute;right:5px"> <li><a id="power" href="test.html">POWER</a></li><span>
</ul>
<div id="maindiv" >
 <div id="graph">
 <p><br>
  PHASE
 </p>
  <img src="chart1.png" alt="mockdata" style="height:300px;width:684px">
</div>
 <div id="graph">
 <p><br>
  FREQUENCY
 </p>
  <img src="chart1.png" alt="mockdata" style="height:300px;width:684px">
</div>
 <div id="graph">
 <p><br>
  VOLTAGE
 </p>
  <img src="chart1.png" alt="mockdata" style="height:300px;width:684px">
  </div>
 <div id='graph'>
  <p><br>
  CURRENT
   </p>
  <img src="chart1.png" alt="mockdata" style="height:300px;width:684px; padding-bottom:30px;">
</div>
<div id="RT" style="background-color:white;height:400px;width:500px;margin:100px;padding:20px">
 <h2>
 Real Time Readings:
 </h2>
 
 <p>
 Current: <p id="curread"></p>	
 </p><br>
 <p>
 Voltage: <p id="volread"></p>
 </p><br>
 <p>
 Phase: <p id="pharead"></p>
 </p><br>
 <p>
 Frequency: <p id="freread"></p>
 </p><br>
</div>
</div>


</body>
</html>
