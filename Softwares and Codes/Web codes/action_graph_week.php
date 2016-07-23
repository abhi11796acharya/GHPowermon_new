<?php

 ob_start( );
  
$head = intval($_GET['c']);
// if c==0, then stable_chart is accessing this page and 'choice' needs to checked and data has to be 'echo'edin JSON format.
// if c==1, then it indicates that user wants to change the 'choice'.
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
				// Select 'Choice' which represents old Choice of user [PAST 2 WEEKS/PAST WEEK/YESTERDAY/TODAY]
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
																     	$choice=$row["Choice"]; // Choice wont be changed.
																	else 
																		$choice = intval($_GET['x']);
																								// User wants to change the choice, get the new choice.
																}
											}

									else 
											{
												echo "Error: " . $sql . "<br>" . mysqli_error($conn);
											}
										
								

				 if($head==1)
				 {
						$sql = "UPDATE power SET Choice = ".$choice; //$head == 1, which means new choice has been made.hence Update Choice. 
					if (mysqli_query($conn, $sql))
						{
						 //echo "update Successful";
						}
						
					
				 }
				
				switch ($choice) // Varying selection criteria according to user's choice
							{
								case 1: $selection=" WHERE DATE(reg_date) = CURDATE()";//FOR TODAY
										break;
								case 3: $selection=" WHERE DATE(reg_date) = DATE_ADD(CURDATE(),INTERVAL -1 DAY)";
										break;
								case 4:	$selection=" WHERE reg_date LIKE '%:00:00' AND (DATE(reg_date) > DATE_ADD(CURDATE(),INTERVAL -7 DAY))";
										break;
								case 5:  $selection="WHERE (reg_date LIKE '%:00:00') OR (reg_date LIKE '%:00:01') OR (reg_date LIKE '%:00:02')OR (reg_date LIKE '%:00:03')" ;
           								 break;							
						    }
				
					
					$sql = "SELECT Current1,Current2,Current3, Voltage, frequency,Phase1,Phase2,Phase3,reg_date FROM reading ".$selection ;
					
					$result = $conn->query($sql);
	
					
					
$jsonarray=array();
$list = array();
//Overwrite previous existing .csv file.
$file = fopen("log.csv", "w");
foreach ($list as $line)
  {
  fputcsv($file,explode(',',$line));
  }
fclose($file);
//Append into the current .csv file. 
$file = fopen("log.csv", "a");

if ($result->num_rows > 0) 
{
    // output data of each row
    while($row = $result->fetch_assoc()) 
	{
		  $jsonItem=array();
							$jsonItem['Current']=$row['Current1'];		//*Creating name value pairs
							$jsonItem['Current2']=$row['Current2'];		//*
							$jsonItem['Current3']=$row['Current3'];		//*
							$jsonItem['Voltage']=$row['Voltage'];		//*
							$jsonItem['Frequency']=$row['frequency'];	//*
							$jsonItem['Phase1']=$row['Phase1'];			//*
							$jsonItem['Phase2']=$row['Phase2'];			//*
							$jsonItem['Phase3']=$row['Phase3'];			//*
							$jsonItem['Time']=$row['reg_date'];			//*
							array_push($jsonarray,$jsonItem);			//Pushed in $jsonarray
							$Current1=$row['Current1'];					//*Assigning values
							$Current2=$row['Current2'];					//*
							$Current3=$row['Current3'];					//*
							$Voltage=$row['Voltage'];					//*
							$Frequency=$row['frequency'];				//*
							$Frequency=$row['frequency'];				//*
							$Phase1=$row['Phase1'];						//*
							$Phase2=$row['Phase2'];						//*
							$Phase3=$row['Phase3'];						//*
							$Time =$row['reg_date'];					//*
							
							$list=array("$Current1,$Current2,$Current3,$Voltage,$Frequency,$Phase1,$Phase2,$Phase3,$Time");//Compiled List
							// Create a .csv file
							foreach ($list as $line)
									{
										fputcsv($file,explode(',',$line));												  //Append in overwrited log.csv file.
									}
							
    }
}
 else 
{
    echo "0 results";
} 
//echo JSON 
echo json_encode($jsonarray);					  
fclose($file);	

if($head=='1')
 { 
    echo "success";
	header("Location:past.php");
 }
						
$conn->close();




?>