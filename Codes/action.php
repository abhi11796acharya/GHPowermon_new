<?php

date_default_timezone_set("Asia/Kolkata"); 

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null);
$cur2= (isset($_GET['cur2']) ? $_GET['cur2'] : null);
$cur3 = (isset($_GET['cur3']) ? $_GET['cur3'] : null);
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);
$pha2 = (isset($_GET['pha2']) ? $_GET['pha2'] : null);
$pha3 = (isset($_GET['pha3']) ? $_GET['pha3'] : null);
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);
$dstat1 =(isset($_GET['ds1']) ? $_GET['ds1'] : null);
$dstat2 =(isset($_GET['ds2']) ? $_GET['ds2'] : null);
$dstat3 =(isset($_GET['ds3']) ? $_GET['ds3'] : null);

//echo "$cur $pha $fre $vol" ;

$servername = "localhost"; 
$username = "root";
$password = "";
$db = "mydb";// to be added after creation of data base

// ------------------------------------------------------------------CREATE CONNECTION--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
  // echo " Connected   " ;
}
//Value inserted in para(Table)
$sql =  "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$cur2),(3,$cur3),(4,$vol),(5,$fre),(6,$pha) ,(7,$pha2) ,(8,$pha3) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";
if (mysqli_query($conn, $sql))
{
   //echo " New record1 created successfully       ";
   $sql = "SELECT reg_date FROM para WHERE id=1";
   
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
}
 else 
 {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 }

 $list = array
(
 "$cur,$cur2,$cur3,$vol,$fre,$pha,$pha2,$pha3,$s_date"
);
 $file = fopen("reading.csv", "a");
 foreach ($list as $line)
  {
  fputcsv($file,explode(',',$line));
  }
  
  fclose($file); 

 $conn->close();
 
 $conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else { 
  // echo " Connected" ;
}

//Value inserted in reading(Table)
 $sql =  "INSERT INTO reading (Current1,Current2,Current3,Voltage,frequency,Phase1,Phase2,Phase3,reg_date) VALUES ($cur,$cur2,$cur3,$vol,$fre,$pha,$pha2,$pha3,NOW())";
 
 if (mysqli_query($conn, $sql)) {
   // echo "  New record2 created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
					
				
$sql = "SELECT Switch_on,Switch_off,Button_change FROM scheduled WHERE id=1";
 
   if (mysqli_query($conn, $sql)) {
   echo "  New record3  created successfully    ";
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
						
						else 
						{
							 if($old_stat==1)     
							      $b_stat = "1";
							   else
								   $b_stat="0";
						}
					  }	
					}
					

					
$sql = "SELECT Switch_on,Switch_off,Button_change FROM scheduled WHERE id=2";
 
   if (mysqli_query($conn, $sql)) {
   echo "  New record3  created successfully    ";
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
							   echo "Success Here"; 
						   if($s_date <= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {   
								//echo $old_stat;
					          echo "Lower than both";
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
   echo "  New record3  created successfully    ";
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
					          echo "Lower than both";
							   if($old_stat_3==1)     
							      $b_stat_3 = "1";
							   else
								   $b_stat_3="0";
							 
						   }
						   else if($s_date >= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							   echo "greater than ON, lesser than OFF, FOLLOW ON";
							   $b_stat_3="1";
						   }
						    else if($s_date >= $row["Switch_off"] && $s_date <= $row["Switch_on"] )
						   {
							   echo "greater than OFF, lesser than ON, FOLLOW OFF";
							   $b_stat_3="0";
						   }
						    else if($s_date >= $row["Switch_on"] && $s_date >= $row["Switch_off"] )
						   {
							   echo "greater than Both";
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
					
/*
 $sql =  "UPDATE power SET button = $b_stat, button_2 = $b_stat_2, button_3 = $b_stat_3 ";
 
  if (mysqli_query($conn, $sql)) 
  {
	   echo "$b_stat";
	   echo "$b_stat_2";
	   echo "$b_stat_3";
	   
  }
 else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
*/
 $sql =  "UPDATE power SET button = $b_stat, button_2 = $b_stat_2, button_3 = $b_stat_3, d_status1 = $dstat1, d_status2 = $dstat2, d_status3 = $dstat3  ";
 
  if (mysqli_query($conn, $sql)) 
  {
	   echo "$b_stat";
	   echo "$b_stat_2";
	   echo "$b_stat_3";
	   
  }
 else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
	  
 $conn->close();
?>