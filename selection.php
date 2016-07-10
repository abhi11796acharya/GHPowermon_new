<?php
ob_start();

$date_from = "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['From'])))."'";
$date_to= "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['To'])))."'";


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);	
} 

 $sql =  "UPDATE scheduled 
		  SET Switch_off=$date_from , Switch_on= $date_to
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