<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dispenser";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());


}

$sql = "CREATE TABLE drugs  
(TradeName varchar (255) PRIMARY KEY,
PharmID int(255),
Formula varchar(255),
Price int(20))
";
    
$sql = "INSERT INTO drugs(TradeName,PharmID,Formula,Price)
VALUES('Panadol','89999','Tablet','899')";
$sql = "INSERT INTO drugs(TradeName,PharmID,Formula,Price)
VALUES('Paracetamol','9000','Pill','90')";


if (mysqli_query($conn, $sql)) {
  echo "Table Patient1 created successfully";
} else {
  echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>