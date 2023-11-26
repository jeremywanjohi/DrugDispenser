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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Dispensing Form</title>
    <link rel="stylesheet" href="styles2.2.css">
    <style>
        body {
            background-image: url('volodymyr-hryshchenko-e8YFkjN2CzY-unsplash (1).jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%; /* Adjust the width as needed */
            max-width: 200px; /* Limit the maximum width */
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Logout Button */
        .logoutbtn {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            background-color: #ff5555;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Welcome Message */
        .welcome-msg {
            margin-bottom: 20px;
        }
    </style>


</head>
<body>
 
    <a href="login.html" class="logoutbtn">Logout</a>
    <div class="container">
        <div class="welcome-msg">
        Welcome, <?php echo $firstName; ?>!
    </div>
        </div>
        <h1>Add Drug Details</h1>
        <form id="drugForm" action="drugdetails.php" method="post" onsubmit="submitForm(event)">

            <label for="drugName">Drug Name:</label>
            <input type="text" id="drugName" name="drugName" required><br><br>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required><br><br>

            <label for="image">Image URL:</label>
            <input type="url" id="image" name="image" required><br><br>

            <button type="submit" >Submit</button>
        </form>
        <a href="table.php" class="button">Go to Drug Table</a>

    </div>

    <script src="script.js"></script>
</body>
</html>

