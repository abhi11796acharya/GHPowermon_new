<?php
$q = intval($_GET['q']);	
$x = intval($_GET['x']);	

$q2=$q+1;$q3=$q+2;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

            if($x==1)
			{
				$selection=" OR id=$q2 OR id=$q3";
				
			}
			else 
			{
				$selection="";
			}
			
			
			 $value1=NULL;
			 $value2=NULL;
			 $value3=NULL;
						  
					//select from database
					$sql = "SELECT reg_date,RT
						   FROM para
						   WHERE id=$q " .$selection;
						   
					$result = $conn->query($sql);
					$jsonarray=array();
					if ($result->num_rows > 0) {
						$q=1;
						// output data of each row
						while($row = $result->fetch_assoc()) 
						{ 
						 
						  $jsonItem=array();
						if($x==1)
						{  
						  if($q==1)
						{
							$value1=$row['RT'];
						}
						  
						if($q==2)
						{
							$value2=$row['RT'];  
						}
						if($q==3)
						{
							$value3=$row['RT'];
						}
							
							$jsonItem['value1']=$value1;
							$jsonItem['value2']=$value2;
							$jsonItem['value3']=$value3;
							$jsonItem['time']=$row['reg_date'];
							
							$q++;
						}
						
						else
						{
							$jsonItem['value']=$row['RT'];
							$jsonItem['time']=$row['reg_date'];
						}
						
						
						
						}
						
					}
					array_push($jsonarray,$jsonItem);
					//$ar = json_encode( array('current'=>$y,'time'=>1523 ));
					//$ar = json_encode( array());
					echo json_encode($jsonarray);
					/*
					$b = json_decode( $ar);
					echo "$b->current";
					*/
$conn->close();
?>