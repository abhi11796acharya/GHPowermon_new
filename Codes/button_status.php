<?php
$q = intval($_GET['q']);	

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);	
} 
 $sql =  "UPDATE power SET button = $q";
 
 if (mysqli_query($conn, $sql)) 
 {
 }
 else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
header("Location:test.html");
$conn->close();

?>