<?php
$q = intval($_GET['q']);	

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

//Create a Connection

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);	
}

//Update Current Button Status in database 
 $sql =  "UPDATE power SET button = $q";
 
 if (mysqli_query($conn, $sql)) 
 {
 }
 else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//Update Button_Change in scheduled to 1, which means scheduling has been Overrided and rendered ineffective.
 $sql =  "UPDATE scheduled SET Button_change = 1 WHERE id = 1  ";
 
  if (mysqli_query($conn, $sql)) 
  {
	   //echo "$b_stat";
  }
 else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
//Go back to page
header("Location:select.php");
$conn->close();

?>