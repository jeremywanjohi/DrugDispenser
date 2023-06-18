<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$occupation=$_POST['occupation'];


// Get the email and password from the user


// Create a connection to the database
$conn = mysqli_connect('localhost','root','','patientdetails');

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

  // Redirect the user to the appropriate page based on their occupation
  if ($occupation == 'doctor') {
    $_SESSION['email'] = $email;
    header('Location: doctor.php');
  } elseif ($occupation == 'patient') {
    $_SESSION['email'] = $email;
    header('Location: patient.php');
  } elseif ($occupation == 'pharmacist') {
    $_SESSION['email'] = $email;
    header('Location: pharmacist.php');
  } else {
    // Invalid occupation
    echo "Invalid occupation!";
  }
} else {
  // Authentication failed
  echo "Invalid email or password!";
}
?>
