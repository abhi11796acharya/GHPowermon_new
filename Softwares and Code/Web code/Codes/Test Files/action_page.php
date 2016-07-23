<?php
$q = intval($_GET['q']);	

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
					$sql = "SELECT reg_date,RT
						   FROM para
						   WHERE id=$q";
					$result = $conn->query($sql);
					$jsonarray=array();
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{
						  $jsonItem=array();
							$jsonItem['value']=$row['RT'];
							$jsonItem['time']=$row['reg_date'];
						}
					}
					array_push($jsonarray,$jsonItem);
					//$ar = json_encode( array('current'=>$y,'time'=>1523 ));
					//$ar = json_encode( array());
					echo json_encode($jsonarray);
					/*
					$b = json_decode( $ar);
					echo "$b->current";
					*/
$conn->close();
?>