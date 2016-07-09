<html>
<head></head>
<body>
<form action="form.php" method="POST">
	Cur:<br>
  <input type="text" name="Current"><br>
	Vol:<br>
  <input type="text" name="Voltage"><br>
	freq:<br>
  <input type="text" name="freq"><br>
	phase:<br>
  <input type="text" name="phase">
  <input type="submit" value="Submit">
</form>
<?php

 $Current1 = $_POST["Current"];
 $Voltage  = $_POST["Voltage"];
 $frequency = $_POST["freq"];
 $Phase = $_POST["phase"];
 
 
$servername = "localhost";
$username = "root";
$password = "";
$db = "myDB";// to be added after creation of data base


// -----------------------------------------------------------Create connection--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
  // echo "connected" ;
}
//Current1, Voltage ,frequency, Phase


 
 
 $sql = "INSERT INTO Reading(Current1, Voltage ,frequency, Phase)
VALUES('$Current1', '$Voltage', '$frequency', '$Phase')";

if (mysqli_query($conn, $sql)) {
  //  echo "New record created successfully";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

?>


</body>
</html>