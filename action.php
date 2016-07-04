<?php

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null);
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);

echo $cur,$pha,$fre,$vol;
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

echo "$cur $pha $fre $vol";
// ------------------------------------------------------------------CREATE CONNECTION--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
   echo " connected" ;
}
 
$sql =  "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$vol),(3,$fre),(4,$pha) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";

if (mysqli_query($conn, $sql)) {
   echo "New record1 created successfully";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//header('Location:actionThree.php?cur='.urlencode($cur)."&pha=" . urlencode($pha)."&vol=" . urlencode($vol)."&fre=" . urlencode($fre));
/*----------------------------------------------------------------------RANDOM VALUE GENERATION---------------------------------------------------
/*
 if(!($pha>1000))
 { $cur=rand(1,9);
 $vol=rand(1,9);
  $fre=rand(1,9);
	$pha++;
	
 }  
 else
 {
	$pha=1;
	header('Location:actionTwo.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
 }
 ----------------------------------------------------------------------------------------------------------------------------------------------------*/
 $conn->close();
 //###################################################################################################################################################
 
 $conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
   echo " connected" ;
}
 $sql =  "INSERT INTO reading (Current1,Voltage,frequency,Phase,reg_date) VALUES ($cur,$vol,$fre,$pha,NOW())";
 
 if (mysqli_query($conn, $sql)) {
    echo "New record2 created successfully";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
 
 $conn->close();
?>