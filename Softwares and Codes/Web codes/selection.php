<?php

															//This page is called when user Schedules ON/OFF, Hence this page is the 'Scheduler page'.
ob_start();													//output buffering

$choice = $_POST['Choice'];									//Choice variable indicates whether user chose 'ON' or 'OFF'  


if($choice=="ON")											
{
$date_to = "'".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['From'])))."'"; //type cast string obtained into php datetime format
$date_from= "'".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['To'])))."'";  //type cast string obtained into php datetime format

}
else
{
$date_from = "'".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['From'])))."'"; //type cast string obtained into php datetime format
$date_to= "'".date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['To'])))."'";		//type cast string obtained into php datetime format

}	

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);	
} 
																										// Update 'Scheduled' Table in database
 $sql =  "UPDATE scheduled 															
		  SET Switch_off=$date_from , Switch_on= $date_to, Button_change = 0  
		  WHERE id=1 ";
 
 if (mysqli_query($conn, $sql)) 
 {
 }
 else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

header("Location:select.php");
$conn->close();

?>