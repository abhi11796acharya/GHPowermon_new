<?php

 ob_start( );
 /*
$m = intval($_GET['m']);
$s = intval($_GET['s']);*/
$choice = intval($_GET['x']);
$head = intval($_GET['c']);

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
				 
				  /*if($choice==1)
					$selection = " WHERE (MINUTE(reg_date),SECOND(reg_date),HOUR(reg_date),DAY(reg_date),MONTH(reg_date))=($m,$s)";
				  else if($choice==0)
					$selection = "";
				  else if($choice==2)
					$selection = " WHERE (MINUTE(reg_date))=($m)";
				*/
				
				switch ($choice) 
							{
								case 1: $selection="DATE(reg_date) = CURDATE()"; //FOR TODAY
										break;
								case 2:
										break;
								case 3: $selection="DATE(reg_date) = DATE_ADD(CURDATE(),INTERVAL -1 DAY)";
										break;
								case 4:	$selection="reg_date LIKE '%:00:00' AND (DATE(reg_date) > DATE_ADD(CURDATE(),INTERVAL -7 DAY))";
										break;
								case 5: $selection=" reg_date LIKE '%:00:00'";
								        break;							
						    }
				
					$sql = "SELECT Current1, Voltage, frequency,phase,reg_date FROM reading WHERE ".$selection ;
					
					$result = $conn->query($sql);
	
					
					
$jsonarray=array();
$list = array();

$file = fopen("log.csv", "w");
foreach ($list as $line)
  {
  fputcsv($file,explode(',',$line));
  }
fclose($file); 
$file = fopen("log.csv", "a");

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
							$Current=$row['Current1'];
							$Voltage=$row['Voltage'];
							$Frequency=$row['frequency'];
							$Phase=$row['phase'];
							$Time =$row['reg_date'];
							
							$list=array("$Current,$Voltage,$Frequency,$Phase,$Time");
							foreach ($list as $line)
									{
										fputcsv($file,explode(',',$line));
									}
							
    }
}
 else 
{
    echo "0 results";
} 
echo json_encode($jsonarray);					  
fclose($file);	

if($head=='1')
 { 
    echo "success";
	header("Location:past.php");
 }
						
$conn->close();




?>