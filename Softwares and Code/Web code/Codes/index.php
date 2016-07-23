<!DOCTYPE html>
<html>
<head>
<style>

h1
{ 
  border: 100%;
  background-color : #50ff50;
  text-align: center;
  color: white;
  font-size: 30px;
  font-family: corbel;
   margin: 10px 0px 10px 0px ;
  
}
p
{ color: white;
    width: 360px;
    padding: 10px;
    border: 5px solid gray;
    margin: 10px 50px; 
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

span a:hover{
    background-color: red;
	color: black;
}
li a:active
{  
 background-color: green;
 color: black;
}
#back
{ 
  height: 510px;
  width : 100%;
  background: linear-gradient(to bottom right, #222, #666);
   
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
  background-color: white;
}

h2
{
 color: white;
 font-size:20px;
 font-family:Verdana;
 padding-top:30px;
 padding-left:18px;
 padding-bottom:0px;
 font-family:corbel;
 width:30%;

}
.button1 {
  border-radius: 4px;
 
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button1:hover
{
 background-color:white;
 color:black;
}
.button2 {
  border-radius: 4px;
 
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 28px;
  padding: 20px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button2:hover
{
 background-color:white;
 color:black;
}
.button1 {
	 background-color: #f4511e;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}
.button2 {
	 background-color: #1e51f4;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}
</style>
</head>
<body> 
<h1>
    <strong>GREEN HOUSE POWER MONITORING</strong>
</h1>
<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li><a class="active" href="current.html">Current Status</a></li>
  <li><a class="active" href="past.php">Past 30 Days</a></li>
  <li><a class="active" href="select.php">Schedule ON/OFF</a></li>
 <span style = "position:absolute;right:5px"> <li><a id="power" href="test.html">LOG IN/OUT</a></li><span>
</ul>
<div id="back" >
<b><h2>ABOUT</h2></b>
<p id="abboz" style="float:left; border:none;width:35%;text-align:justify;margin-top:0px;">With IoT, things have now become "smart". With this project we aim to make a "smart" device which is able to monitor electrical consumptions of various appliances(exhaust fan,fogger, water pump etc), inform the user about consumption and provide options for scheduling turn on/off time of appliance. The system will consist of a wi-fi enabled device which measure and display power consumption of an appliance. Device should be capable of turning on/off the device from web, scheduling the on/off time of the device.
<br>System will have following components:<br>

<br>1. A Voltage, Current, Phase and frequency measuring Circuit.<br>
<br>2. Microcontroller based system which is wifi enabled and after measuring the electrical parameters, it is able to log those parameters in database and display it on web interface with proper visualization
<br><br>3. User interface for controlling devices from web<br>
<br>4. Feature to turn on/off device based on rules/schedule set by user
<br><br>5. Design PCB of circuit and a miniaturized device which can fit in spike guard/switch board for ensuring easy installation in existing system.   

</p>
<a href="current.html"><span style="display:block"><button class="button button1" style="width:500px;margin:0px 60px">START MONITORING</button></span></a>
<a href="past.php"><span style="display:block"><button class="button button1" style="width:500px;margin:20px 60px">GET LOG DATA</button></span></a>
<a href="select.php"><span style="display:block"><button class="button button1" style="width:500px;margin:0px 60px">SCHEDULE ON/OFF</button></span></a>
<a href="test.html"><span style="display:block"><button class="button button2" style="width:500px;margin:20px 60px;">SIGN UP</button></span></a>
 </div>
 
 
</body>
</html>
