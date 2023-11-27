<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drugdispenser";

$conn = new mysqli("localhost", "root", "", "drugdispenser");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get all users from the database
function getAllUsers() {
    global $conn;
    $sql = "SELECT  firstName, lastName FROM patientdet";
    $result = $conn->query($sql);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

// Function to get user details by email
function getUserByEmail($email) {
    global $conn;
    $sql = "SELECT * FROM patientdet WHERE email = '$email'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Add more functions for other database interactions as needed
