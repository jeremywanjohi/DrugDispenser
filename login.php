<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Create a connection to the database
$conn = mysqli_connect('localhost', 'root', '', 'patientdet');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query to check email and password
$query = "SELECT * FROM patientdet WHERE email = '$email' AND password = '$password'";

// Execute the query
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Authentication successful

    // Retrieve the userType from the database
    $row = $result->fetch_assoc();
    $userType = $row['occupation'];

    // Redirect the user to the appropriate page based on their userType
    if ($userType == 'Patient') {
        $_SESSION['email'] = $email;
        header('Location: products.php');
    } elseif ($userType == 'api_regular') {
        $_SESSION['email'] = $email;
        header('Location: tokens.php');
    } elseif ($userType == 'api_premium') {
        $_SESSION['email'] = $email;
        header('Location: tokens.php');
    } elseif ($userType == 'Admin') {
        $_SESSION['email'] = $email;
        header('Location: admin.php');
    } else {
        // Invalid userType
        echo "Invalid userType!";
    }
} else {
    // Authentication failed
    echo "Invalid email or password!";
}

// Close the database connection
$conn->close();
?>
