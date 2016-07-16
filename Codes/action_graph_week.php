<?php

 ob_start( );
  
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
				
				$sql = "SELECT Choice FROM power WHERE id=1";
					if (mysqli_query($conn, $sql))
						{
						 //echo "Selection Successful";
						}
							$result = $conn->query($sql);
	 
									if ($result->num_rows > 0) 
											{
													// output data of each row
															while($row = $result->fetch_assoc()) 
																{
																	if($head==0)
																     	$choice=$row["Choice"];
																	else 
																		$choice = intval($_GET['x']);
																}
											}

									else 
											{
												echo "Error: " . $sql . "<br>" . mysqli_error($conn);
											}
										
								

				 if($head==1)
				 {
						$sql = "UPDATE power SET Choice = ".$choice;
					if (mysqli_query($conn, $sql))
						{
						 //echo "update Successful";
						}
						
					
				 }
				
				
				
				
					  /*if($choice==1)
						$selection = " WHERE (MINUTE(reg_date),SECOND(reg_date),HOUR(reg_date),DAY(reg_date),MONTH(reg_date))=($m,$s)";
							else if($choice==0)
						$selection = "";
							else if($choice==2)
						$selection = " WHERE (MINUTE(reg_date))=($m)";
				      */
				
				
				switch ($choice) 
							{
								case 1: $selection=" WHERE DATE(reg_date) = CURDATE()";//FOR TODAY
										break;
								case 2:
										break;
								case 3: $selection=" WHERE DATE(reg_date) = DATE_ADD(CURDATE(),INTERVAL -1 DAY)";
										break;
								case 4:	$selection=" WHERE reg_date LIKE '%:00:00' AND (DATE(reg_date) > DATE_ADD(CURDATE(),INTERVAL -7 DAY))";
										break;
								case 5:  $selection="WHERE reg_date LIKE '%:00:00'";
           								 break;							
						    }
				
					
					$sql = "SELECT Current1,Current2,Current3, Voltage, frequency,Phase1,Phase2,Phase3,reg_date FROM reading ".$selection ;
					
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
							$jsonItem['Current2']=$row['Current2'];
							$jsonItem['Current3']=$row['Current3'];
							$jsonItem['Voltage']=$row['Voltage'];
							$jsonItem['Frequency']=$row['frequency'];
							$jsonItem['Phase1']=$row['Phase1'];
							$jsonItem['Phase2']=$row['Phase2'];
							$jsonItem['Phase3']=$row['Phase3'];
							$jsonItem['Time']=$row['reg_date'];
							array_push($jsonarray,$jsonItem);	
							$Current1=$row['Current1'];
							$Current2=$row['Current2'];
							$Current3=$row['Current3'];
							$Voltage=$row['Voltage'];
							$Frequency=$row['frequency'];
							$Phase1=$row['Phase1'];
							$Phase2=$row['Phase2'];
							$Phase3=$row['Phase3'];
							$Time =$row['reg_date'];
							
							$list=array("$Current1,$Current2,$Current3,$Voltage,$Frequency,$Phase1,$Phase2,$Phase3,$Time");
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