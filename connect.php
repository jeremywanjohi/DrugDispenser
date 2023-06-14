<?php
$serverName="localhost";
$userName="root";
$password="";
$dbName="patientdb";

$conn= new mysqli($serverName,$userName ,$password,$dbName);
//Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);}

//Create database 
/*$sql="CREATE DATABASE patientdb";
if($conn->query($sql)===TRUE){
    echo "Database created successfully";

}
else {
    echo "Error occurred while creating database :" .$conn->error;
}
$conn->close();*/

//Create table
/*$sql="CREATE TABLE patientdet(
    firstName varchar(20),
    lastName varchar(20),
    gender char(5),
    email varchar (20),
    password varchar(20),
    phoneNumber varchar(20) )
    ";

    if ($conn->query($sql)===TRUE){
        echo "Table patientdet created successfully";

    }
    else{
        echo"Error creating table:" . $conn->error;
    }

    $conn->close();*/
    //delete table 





  
?>