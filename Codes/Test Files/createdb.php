<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE para(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
RT FLOAT NOT NULL,
parameters TEXT NOT NULL,
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table para created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>