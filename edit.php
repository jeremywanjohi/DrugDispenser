<?php
// update_user.php

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "''";
$dbname = "patientdb";

$conn = new mysqli('localhost','root','','patientdb');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve updated user information from the form
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender=$_POST['gender'];
$email = $_POST['email'];
$password=$_POST['password'];
$phoneNumber=$_POST['phoneNumber']
// Retrieve other updated fields here

// Update user information in the database
$sql = "UPDATE patientdet SET firstName='$firstName',lastName='$lastName', email='$email',password='$password',phoneNumber='$phoneNumber' WHERE id=$ID";

if ($conn->query($sql) === TRUE) {
  echo "User information updated successfully.";
} else {
  echo "Error updating user information: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
