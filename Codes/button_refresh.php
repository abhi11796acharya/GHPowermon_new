<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
					//select from database
					$sql = "SELECT *
						   FROM power";
					$result = $conn->query($sql);
					$jsonarray=array();
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{
						   $jsonitem['button1'] = $row["button"];
						   $jsonitem['button2'] = $row["button_2"];
						   $jsonitem['button3'] = $row["button_3"];
						   $jsonitem['d_stat1'] = $row["d_status1"];
						   $jsonitem['d_stat2'] = $row["d_status2"];
						   $jsonitem['d_stat3'] = $row["d_status3"];
						}
					}
					array_push($jsonarray,$jsonitem);
					echo json_encode($jsonarray);
$conn->close();
?>


