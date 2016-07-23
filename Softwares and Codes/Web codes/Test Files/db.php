
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "myDB";// to be added after creation of data base


// -----------------------------------------------------------Create connection--------------------------------------------------------------------------
$conn = new mysqli($servername, $username, $password,$db);//add database name variable after creating database
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else {
    echo "connected" ;
}

/*----------------------------------------------------------REQD WHEN INSERTING NEW VALUES--------------------------------------------------------
$sql = "INSERT INTO Reading(Current1, Voltage ,frequency, Phase)
VALUES ('1.1', '5.3', '5 Hz', '1.57')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

<form>
  First name:<br>
  <input type="text" name="firstname"><br>
  Last name:<br>
  <input type="text" name="lastname">
</form>

/*---------------------------------------------------------REQD WHEN CREATING NEW DATABASE------------------------------------------------------------
*/// sql to create table
$sql = "CREATE TABLE para (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
parameter VARCHAR(30) NOT NULL,
Real FLOAT(10) NOT NULL,
reg_date TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table MyGuests created successfully";
} else 
{
    echo "Error creating table: " . mysqli_error($conn);
}

/* --------------------------------------------------------------REQD FOR FIRST TIME---------------------------------------------------------------------
/ Create database
$sql = "CREATE DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
----------------------------------------------------------------*/
$conn->close();
?>