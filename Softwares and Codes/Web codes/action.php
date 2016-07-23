<?php


date_default_timezone_set("Asia/Kolkata");  				//Setting default time-zone

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null); 		//GET value of var 'cur'  i.e Current of device 1
$cur2= (isset($_GET['cur2']) ? $_GET['cur2'] : null);		//GET value of var 'cur2' i.e Current of device 2
$cur3 = (isset($_GET['cur3']) ? $_GET['cur3'] : null);		//GET value of var 'cur3' i.e Current of device 3
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);			//GET value of var 'pha'  i.e Current of device 1
$pha2 = (isset($_GET['pha2']) ? $_GET['pha2'] : null);		//GET value of var 'pha2' i.e Current of device 2
$pha3 = (isset($_GET['pha3']) ? $_GET['pha3'] : null);		//GET value of var 'pha3' i.e Current of device 3
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);			//GET value of var 'fre'  i.e Measured Frequency
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);			//GET value of var 'vol'  i.e Measured Voltage
$dstat1 =(isset($_GET['ds1']) ? $_GET['ds1'] : null);		//GET value of var 'ds1'  i.e feedback device 1
$dstat2 =(isset($_GET['ds2']) ? $_GET['ds2'] : null);		//GET value of var 'ds2'  i.e feedback device 2
$dstat3 =(isset($_GET['ds3']) ? $_GET['ds3'] : null);		//GET value of var 'ds3'  i.e feedback device 3
$x =(isset($_GET['x']) ? $_GET['x'] : null);				//Counter variable that checks whether the connected device is trying to update data,
															//or just wants to check button status and provide feedback

if($cur2==0)
{
	$dstat2=0;
}
elseif ($cur2!=0)
{
	$dstat2=1;
}
//echo "$cur $pha $fre $vol" ;

$servername = "localhost"; 
$username = "root";
$password = "";
$db = "mydb";

// ------------------------------------------------------------------CREATE CONNECTION--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
  // echo " Connected   " ;
}

$sql = "SELECT reg_date FROM para WHERE id=1"; /* Selects current date and time without checking request type
											      as the current operation is required in both cases for scheduling purposes. */
	
	 $result = $conn->query($sql);
	 
	if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{
							 //echo $row["reg_date"];
						     $s_date=$row["reg_date"];
							 //echo "$s_date";
						}
					}
					

//Delete old data 
$sql =  "DELETE FROM reading WHERE DATE(reg_date) < DATE_ADD(CURDATE(),INTERVAL -14 DAY)";
if (mysqli_query($conn, $sql))
{
  // echo " Deleted successfully       ";
}
 else 
 {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 }

 
if($x==0)    //checks if request was made to update parameters or not.
{	
$sql =  "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$cur2),(3,$cur3),(4,$vol),(5,$fre),(6,$pha) ,(7,$pha2) ,(8,$pha3) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";
if (mysqli_query($conn, $sql))
{
   //echo " New record1 created successfully       ";
}
 else 
 {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 }
 // Log the data in reading.csv file
 $list = array
(
 "$cur,$cur2,$cur3,$vol,$fre,$pha,$pha2,$pha3,$s_date"
);
 $file = fopen("reading.csv", "a"); 			//open file, "append" mode.
 foreach ($list as $line)
  {
  fputcsv($file,explode(',',$line));			// append in file.
  }
  
  fclose($file); 								// close the file.

 $conn->close();
 
 $conn = new mysqli($servername, $username, $password,$db);	//add database name variable after creating database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else { 
  // echo " Connected" ;
}

//Value inserted in reading(Table)
 $sql =  "INSERT INTO reading (Current1,Current2,Current3,Voltage,frequency,Phase1,Phase2,Phase3,reg_date) VALUES ($cur,$cur2,$cur3,$vol,$fre,$pha,$pha2,$pha3,NOW())";
 
 if (mysqli_query($conn, $sql)) {
  //echo "  New record2 created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}
//Check Button_status
 $sql = "SELECT button,button_2,button_3 FROM power ";
 
   if (mysqli_query($conn, $sql)) {
  // echo "  New record3  created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

					$result = $conn->query($sql);

					if ($result->num_rows > 0)	
					{
						
						while($row = $result->fetch_assoc()) 
						{
						   //echo $row["button"];
						   $old_stat=$row["button"];
						   $old_stat_2=$row["button_2"];
						   $old_stat_3=$row["button_3"];
						   
						}
					}
//Comparing current date and time with Scheduled ON/OFF period. 					
				
$sql = "SELECT Switch_on,Switch_off,Button_change FROM scheduled WHERE id=1";
/*
 *Switch_on 	= Indicates time when the device has to be swithced on. 
 *Switch_off 	= Indicates time when the device has to be switched off
 *Button_change = Indicates if button was pressed or not during the scheduled period,
     			  Checks if Scheduling was overrided or not.  
				  '0' if scheduling is active.
				  '1' if scheduling is inactive.
*/				
   if (mysqli_query($conn, $sql)) {
   //echo "  New record3  created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

					$result = $conn->query($sql);

					if ($result->num_rows > 0)	
					{
						
						while($row = $result->fetch_assoc()) 
						{
						  if($row["Button_change"]==0)   // active scheduling
						  {
							  
						   if($s_date <= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {   
								//echo $old_stat;
					         //  echo "Lower than both";
							   if($old_stat==1)     
							      $b_stat = "1";
							   else
								   $b_stat="0";
							 
						   }
						   else if($s_date >= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							   //echo "greater than ON, lesser than OFF, FOLLOW ON";
							   $b_stat="1";
						   }
						    else if($s_date >= $row["Switch_off"] && $s_date <= $row["Switch_on"] )
						   {
							   //echo "greater than OFF, lesser than ON, FOLLOW OFF";
							   $b_stat="0";
						   }
						    else if($s_date >= $row["Switch_on"] && $s_date >= $row["Switch_off"] )
						   {
							  // echo "greater than Both";
							   if($row["Switch_on"] >= $row["Switch_off"])
								$b_stat="1";
							   else
								 $b_stat="0";
							   
						   }
						}
						
						else   				//inactive scheduling
						{
							 if($old_stat==1)     
							      $b_stat = "1";
							   else
								   $b_stat="0";
						}
					  }	
					}
					
//Same process for  all 3 devices.
					
$sql = "SELECT Switch_on,Switch_off,Button_change FROM scheduled WHERE id=2";
 
   if (mysqli_query($conn, $sql)) {
  // echo "  New record3  created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

					$result = $conn->query($sql);

					if ($result->num_rows > 0)	
					{
						
						while($row = $result->fetch_assoc()) 
						{
						  if($row["Button_change"]==0)
						  {
							   //echo "Success Here"; 
						   if($s_date <= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {   
								//echo $old_stat;
					         // echo "Lower than both";
							   if($old_stat_2==1)     
							      $b_stat_2 = "1";
							   else
								   $b_stat_2="0";
							 
						   }
						   else if($s_date >= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							   echo "greater than ON, lesser than OFF, FOLLOW ON";
							   $b_stat_2="1";
						   }
						    else if($s_date >= $row["Switch_off"] && $s_date <= $row["Switch_on"] )
						   {
							   echo "greater than OFF, lesser than ON, FOLLOW OFF";
							   $b_stat_2="0";
						   }
						    else if($s_date >= $row["Switch_on"] && $s_date >= $row["Switch_off"] )
						   {
							   echo "greater than Both";
							   if($row["Switch_on"] >= $row["Switch_off"])
								$b_stat_2="1";
							   else
								 $b_stat_2="0";
							   
						   }
						}
						
						else 
						{
							 if($old_stat_2==1)     
							      $b_stat_2 = "1";
							   else
								   $b_stat_2="0";
						}
					  }	
					}
					

					
$sql = "SELECT Switch_on,Switch_off,Button_change FROM scheduled WHERE id=3";
 
   if (mysqli_query($conn, $sql)) {
   //echo "  New record3  created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

					$result = $conn->query($sql);

					if ($result->num_rows > 0)	
					{
						
						while($row = $result->fetch_assoc()) 
						{
						  if($row["Button_change"]==0)
						  {
						   if($s_date <= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {   
								//echo $old_stat;
					          //echo "Lower than both";
							   if($old_stat_3==1)     
							      $b_stat_3 = "1";
							   else
								   $b_stat_3="0";
							 
						   }
						   else if($s_date >= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							  // echo "greater than ON, lesser than OFF, FOLLOW ON";
							   $b_stat_3="1";
						   }
						    else if($s_date >= $row["Switch_off"] && $s_date <= $row["Switch_on"] )
						   {
							  // echo "greater than OFF, lesser than ON, FOLLOW OFF";
							   $b_stat_3="0";
						   }
						    else if($s_date >= $row["Switch_on"] && $s_date >= $row["Switch_off"] )
						   {
							  // echo "greater than Both";
							   if($row["Switch_on"] >= $row["Switch_off"])
								$b_stat_3="1";
							   else
								 $b_stat_3="0";
							   
						   }
						}
						
						else 
						{
							 if($old_stat_3==1)     
							      $b_stat_3 = "1";
							   else
								   $b_stat_3="0";
						}
					  }	
					}
					
//Set required button status as analysed above.
 $sql =  "UPDATE power SET button = $b_stat, button_2 = $b_stat_2, button_3 = $b_stat_3, d_status1 = $dstat1, d_status2 = $dstat2, d_status3 = $dstat3";
 
  if (mysqli_query($conn, $sql)) 
  {
	   echo "$b_stat";		//echo '1' or '0' according to $b_stat
	   echo "$b_stat_2";	//echo '1' or '0' according to $b_stat2
	   echo "$b_stat_3";	//echo '1' or '0' according to $b_stat3   , resultant expression in response will be like '100','000','111'... etc.
	   
  }
 else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
	  
 $conn->close();
?>