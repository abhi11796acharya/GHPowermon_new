<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="JS/loader.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="JS/jquery-ui.min.js"></script>
<script type="text/javascript" src="JS/jquery-ui.js"></script>
<script type="text/javascript" src="Stable_chart_loop.js"></script>


<style>

h1
{ 
  border: 100%;
  background-color : #50ff50;
  text-align: center;
  color: white;
  font-size: 30px;
  font-family: corbel;
  margin: 10px 0px;
  
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

.button1 {
  float: right;
  border-radius: 4px;
  background-color: #404090;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 16px;
  padding: 20px;
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

</style>

</head>
<body> 
<h1>
    <strong>GREEN HOUSE POWER MONITORING</strong>
</h1>
<div>
<ul>
  <li><a class="active" href="home.php">Home</a></li> 
  <li><a href="current.html">Current Status</a></li>
  <li><a href="past.php">Past 14 Days</a></li>
  <li><a class="active" href="select.php">Schedule ON/OFF</a></li>
 </ul>
</div>

<div style="position:relative;background-color:black;margin:0px 30px">
<a href="reading.csv"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">FULL LOG (.csv)</button></span></a>
<a href="log.csv"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">GRAPH DATA (.csv)</button></span></a>
<a href="action_graph_week.php?x=1&c=1"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">TODAY</button></span></a>
<a href="action_graph_week.php?x=3&c=1"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">YESTERDAY</button></span></a>
<a href="action_graph_week.php?x=4&c=1"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">Past WEEK</button></span></a>
<a href="action_graph_week.php?x=5&c=1"><span style="display:block;"><button class="button button1" style="width:200px;height:50px;padding:10px">Past 2 WEEKS</button></span></a>
</div>
<div style="margin:100px;">
</div>
<div style="background-color:#333;background: linear-gradient(to bottom right, #222, #666);">
<span style="position:relative;color:white;left:1000px;top:300px;position:relative;font-family:impact;font-size:50px" id="curread" ></span>
<div><p style="text-align:center;padding:10px;color:white;font-family:impact;font-size:20px;background-color:red;width=100%;margin-top:-40px"> CURRENT </p>

<div id="line_chart1" style="width:98%;margin:10px; height: 500px;background-color:white"></div>
<span style="position:relative;color:white;left:1000px;top:300px;position:relative;font-family:impact;font-size:50px" id="volread" ></span>
<div><p style="text-align:center;padding:10px;color:white;font-family:impact;font-size:20px;background-color:red;width=100%"> VOLTAGE </p>

<div id="line_chart2" style="width:98%;margin:10px; height: 500px;background-color:white"></div>
<span style="position:relative;color:white;left:1000px;top:300px;position:relative;font-family:impact;font-size:50px" id="freread" ></span>
<div><p style="text-align:center;padding:10px;color:white;font-family:impact;font-size:20px;background-color:red;width=100%"> FREQUENCY </p>

<div id="line_chart3" style="width:98%;margin:10px; height: 500px;background-color:white"></div>
<span style="position:relative;color:white;left:1000px;top:300px;position:relative;font-family:impact;font-size:50px" id="pharead" ></span>
<div><p style="text-align:center;padding:10px;color:white;font-family:impact;font-size:20px;background-color:red;width=100%"> PHASE </p>
<div id="line_chart4" style="width:98%;margin:10px; height: 500px;background-color:white"></div>
</div>   
</div>
</div>
</div>
</div>

</div>
</body>
</html>
