<?php
$m = intval($_GET['m']);
$s = intval($_GET['s']);
$choice = intval($_GET['x']);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
			if ($conn->connect_error)
				{
					die("Connection failed: " . $conn->connect_error);
				} 
				
				$selection=array();
				 
				  if($choice==1)
					$selection = " WHERE (MINUTE(reg_date),SECOND(reg_date))=($m,$s)";
				  else if($choice==0)
					$selection = "";
				  else if($choice==2)
					$selection = " WHERE (MINUTE(reg_date))=($m)";
				
					$sql = "SELECT Current1, Voltage, frequency,phase,reg_date FROM reading".$selection;
					
					$result = $conn->query($sql);
$jsonarray=array();
if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
		  $jsonItem=array();
							$jsonItem['Current']=$row['Current1'];
							$jsonItem['Voltage']=$row['Voltage'];
							$jsonItem['Frequency']=$row['frequency'];
							$jsonItem['Phase']=$row['phase'];
							$jsonItem['Time']=$row['reg_date'];
							array_push($jsonarray,$jsonItem);
							echo json_encode($jsonarray);
       
    }
} else 
{
    echo "0 results";
}

$conn->close();
?>
