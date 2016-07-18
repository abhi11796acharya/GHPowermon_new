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
						// Output data of each row 
						// Create name:value pair for "past.php" page.
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
					//$jsonarray created from the selected data.
					//array_push($jsonarray,$jsonitem);
					//echo JSON.
						
					
					$sql = "SELECT Button_change,Switch_off,Switch_on
						   FROM scheduled";
					 $g=1;
					$result = $conn->query($sql);while($row = $result->fetch_assoc()) 
						{ 		
							
						if($g==1)
						{ $jsonitem['Button_change1'] = $row["Button_change"];
						   $jsonitem['Switch_off1'] = $row["Switch_off"];
						   $jsonitem['Switch_on1'] = $row["Switch_on"];
						   if($row["Switch_off"]>$row["Switch_on"])
						   {
							   $jsonitem['offon1'] = "1";
						   }
						   else if ($row["Switch_on"]>$row["Switch_off"])
						   {
							  $jsonitem['offon1'] = "0"; 
						   }
						   else if ($row["Switch_off"]==$row["Switch_on"])
						   {
							  $jsonitem['offon1'] = "-1"; 
						   }
						    else if ($row["Switch_off"]==$row["Switch_on"])
						   {
							  $jsonitem['offon1'] = "-1"; 
						   }
						   
						   if((date('Y-m-d H:i:s')>$row["Switch_on"])&&(date('Y-m-d H:i:s')>$row["Switch_off"]))
						   {
							   $jsonitem['offon1'] = "-2"; 
						   }
						}
					    else if($g==2)
						{  $jsonitem['Button_change2'] = $row["Button_change"];
						   $jsonitem['Switch_on2'] = $row["Switch_on"];
						   $jsonitem['Switch_off2'] = $row["Switch_off"];
						    if($row["Switch_off"]>$row["Switch_on"])
						   {
							   $jsonitem['offon2'] = "1";
						   }
						   else if ($row["Switch_on"]>$row["Switch_off"])
						   {
							  $jsonitem['offon2'] = "0"; 
						   }
						   else if ($row["Switch_off"]==$row["Switch_on"])
						   {
							  $jsonitem['offon2'] = "-1"; 
						   }
						   if((date('Y-m-d H:i:s')>$row["Switch_on"])&&(date('Y-m-d H:i:s')>$row["Switch_off"]))
						   {
							   $jsonitem['offon2'] = "-2"; 
						   }
						}					   
					    else if($g==3)
						{
							$jsonitem['Button_change3'] = $row["Button_change"];
						   $jsonitem['Switch_off3'] = $row["Switch_off"];
						   $jsonitem['Switch_on3'] = $row["Switch_on"];
						    if($row["Switch_off"]>$row["Switch_on"])
						   {
							   $jsonitem['offon3'] = "1";
						   }
						   else if ($row["Switch_on"]>$row["Switch_off"])
						   {
							  $jsonitem['offon3'] = "0"; 
						   }
						   else if ($row["Switch_off"]==$row["Switch_on"])
						   {
							  $jsonitem['offon3'] = "-1"; 
						   }
						   
						   if((date('Y-m-d H:i:s')>$row["Switch_on"])&&(date('Y-m-d H:i:s')>$row["Switch_off"]))
						   {
							   $jsonitem['offon3'] = "-2"; 
						   }
						}   
						   $g++;
						}
					
					array_push($jsonarray,$jsonitem);
					echo json_encode($jsonarray);
					
					
					
					
					
					
					
$conn->close();
 
?>


