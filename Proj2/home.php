<?php
session_start();

// Check if the user is logged in, or redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Establish a database connection

$connection = mysqli_connect('localhost','root','','patientdet');

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
    <title>Admin Page</title>
    <style>
        .logoutbtn{

        
            position :absolute;
            top: 30px;
            right:30px;
        }
    </style>
</head>
<body>
    <div style="text-align: right;">
        Welcome, <?php echo $firstName; ?>!
    </div>

    <a href="login.html" class="logoutbtn">Logout</a>
</body>
</html>