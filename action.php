<?php

date_default_timezone_set("Asia/Kolkata"); 

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null);
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);

echo "$cur $pha $fre $vol" ;
/*
$cur = $_POST['cur'];
$pha = $_POST['pha'];
$fre = $_POST['fre'];
$vol = $_POST['vol'];
*/
$servername = "localhost"; 
$username = "root";
$password = "";
$db = "myDB";// to be added after creation of data base

// ------------------------------------------------------------------CREATE CONNECTION--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
   echo " Connected " ;
}
 
$sql =  "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$vol),(3,$fre),(4,$pha) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";

if (mysqli_query($conn, $sql)) {
   echo " New record1 created successfully";
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
   echo " Connected" ;
}
 $sql =  "INSERT INTO reading (Current1,Voltage,frequency,Phase,reg_date) VALUES ($cur,$vol,$fre,$pha,NOW())";
 
 if (mysqli_query($conn, $sql)) {
    echo "  New record2 created successfully";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$p=1;
$sql =  "UPDATE power SET button=$p";

if (mysqli_query($conn, $sql)) {
    echo "  New record3 created successfully";
	echo " Button Status: $p ";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



//$sql="CREATE EVENT del_entries ON SCHEDULE EVERY 1 DAY DO DELETE FROM reading WHERE reg_date < NOW() - INTERVAL 1 DAY";

 $conn->close();
?>