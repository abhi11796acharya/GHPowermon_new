<!DOCTYPE HTML>
<html>
  <head>
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
	
  </head>
  <body>
  
  
  
  <form class="form-inline" action="selection.php" role="form" method="post">
	
	<input type="radio" name="Choice" value="ON">ON
	<input type="radio" name="Choice" value="OFF">OFF
	<br><br>
  <div id="datetimepicker" class="input-append date">
  <label style="background-color:red">FROM</label>  
      <input type="datetime" placeholder="Select Date and Time" name="From"></input> 
    
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
	
  <div id="datetimepicker5" class="input-append date">
    <span style="height:5000px;"><label style="background-color:red">TO</label></span>
	  <input type="datetime" placeholder="Select Date and Time" name="To"></input>
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
  
  <button type="submit" class="btn btn-default" value="submit" > Submit</button>
</form>

    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
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
	 
    </script>
  
  
  
  
  </body>
<html>