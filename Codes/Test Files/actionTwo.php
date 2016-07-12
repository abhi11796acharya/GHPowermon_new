<?php

$cur = (isset($_GET['cur']) ? $_GET['cur'] : null);
$pha = (isset($_GET['pha']) ? $_GET['pha'] : null);
$fre = (isset($_GET['fre']) ? $_GET['fre'] : null);
$vol = (isset($_GET['vol']) ? $_GET['vol'] : null);
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
// -----------------------------------------------------------Create connection--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
   echo " connected" ;
}
/*
for ($x = 1; $x <= 4; $x++) 
{
	 switch($x)
	 {
    case 1:
		$sql = "UPDATE para SET RT='$cur' WHERE id=1";
		echo "current updtd";
        break;
    case 2:
		$sql = "UPDATE para SET RT='$vol' WHERE id=2";
		echo "voltage updtd";
        break;
    case 3:
		$sql = "UPDATE para SET RT='$fre' WHERE id=3";
		echo "frequency updtd";
        break;
	case 4:
		$sql = "UPDATE para SET RT='$pha' WHERE id=4";
		echo " phase updtd";
        break;
    default:
        echo "unsucessful";
      }
	 
}
*/

//----------------------------------------------MULTIPLE  UPDATES IN ONE QUERY-----------------------------------------
							
$sql = "INSERT INTO para (id,RT) VALUES (1,$cur),(2,$vol),(3,$fre),(4,$pha) ON DUPLICATE KEY UPDATE RT=VALUES(RT),reg_date=NOW()";


if (mysqli_query($conn, $sql)) {
  //  echo "New record created successfully";
} else {
   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

if(!($pha>1000))
 {  
 $cur=rand(1,9);
 $vol=rand(1,9);
  $pha=rand(1,9);
	$pha++;
	header('Location:actionTwo.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
 }  
 
 else
 {
	$pha=1;
	header('Location:actionTwo.php?cur='.urlencode($cur)."&vol=" . urlencode($vol)."&pha=" . urlencode($pha)."&fre=" . urlencode($fre));
 }
?>