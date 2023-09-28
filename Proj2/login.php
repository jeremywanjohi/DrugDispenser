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

    // Fetch the occupation from the database
    $row = $result->fetch_assoc();
    $occupation = $row['occupation'];
    $firstName = $row['firstName']; // Assuming 'firstName' is the column name in your table
    echo "First Name: " . $firstName;

    // Store user's email and first name in the session
    $_SESSION['email'] = $email;
    $_SESSION['firstName'] = $firstName;

    // Redirect the user to the appropriate page based on their occupation
    if ($occupation == 'Admin') {
        $_SESSION['email'] = $email;
        header('Location: home.php');
    } elseif ($occupation == 'patient') {
        $_SESSION['email'] = $email;
        header('Location: patient.php');
    } elseif ($occupation == 'pharmacist') {
        $_SESSION['email'] = $email;
        header('Location: pharmacist.php');
    } elseif ($occupation == 'doctor') {
        $_SESSION['email'] = $email;
        header('Location: doctor.php');
    } else {
        // Invalid occupation
        echo "Invalid occupation!";
    }
} else {
    // Authentication failed
    echo "Invalid email or password!";
}
?>
