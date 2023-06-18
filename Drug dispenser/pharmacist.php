<?php
session_start();

// Check if the user is logged in, or redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Establish a database connection

$connection = mysqli_connect('localhost','root','','patientdetails');

if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Retrieve the doctor's first name using their email
$email = $_SESSION['email'];
$query = "SELECT firstName FROM patientdet WHERE email = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($firstName);
$stmt->fetch();
$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Page</title>
</head>
<body>
    <div style="text-align: right;">
        Welcome, <?php echo $firstName; ?>!
    </div>
    <!-- Rest of your doctor page content -->
</body>
</html>
