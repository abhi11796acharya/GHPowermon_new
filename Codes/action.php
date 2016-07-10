<?php

date_default_timezone_set("Asia/Kolkata"); 

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null);
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);

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
$sql =  "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$vol),(3,$fre),(4,$pha) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";
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
 "$cur,$vol,$fre,$pha,$s_date"
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
 $sql =  "INSERT INTO reading (Current1,Voltage,frequency,Phase,reg_date) VALUES ($cur,$vol,$fre,$pha,NOW())";
 
 if (mysqli_query($conn, $sql)) {
   // echo "  New record2 created successfully    ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


//Check Button_status
 $sql = "SELECT button FROM power ";
 
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
						   echo $row["button"];
						}
					}
					
$sql = "SELECT Switch_on,Switch_off FROM scheduled";
 
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
						  
						   echo $row["Switch_on"];
						   echo $row["Switch_on"];
						   if($s_date <= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							   echo "Lower than both";
						   }
						   else if($s_date >= $row["Switch_on"] && $s_date <= $row["Switch_off"] )
						   {
							   echo "greater than ON, lesser than OFF, FOLLOW ON";
						   }
						    else if($s_date >= $row["Switch_off"] && $s_date <= $row["Switch_on"] )
						   {
							   echo "greater than OFF, lesser than ON, FOLLOW OFF";
						   }
						    else if($s_date >= $row["Switch_on"] && $s_date >= $row["Switch_off"] )
						   {
							   echo "greater than Both";
						   }
						}
					}
										
					
 $conn->close();
?>