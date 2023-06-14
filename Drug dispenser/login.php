<?php
$email = $_POST['email'];
$password = $_POST['password'];
$occupation = $_POST['occupation'];

// Check the email and password against your authentication logic
// For demonstration purposes, let's assume the email is 'test@example.com' and the password is 'password123'

if ($email == 'jeremykwanjohi@gmail.com' && $password == 'Karis2023') {
  // Authentication successful

  // Redirect the user to the appropriate page based on their occupation
  if ($occupation == 'doctor') {
    header('Location: doctor.php');
  } elseif ($occupation == 'patient') {
    header('Location: patient.php');
  } elseif ($occupation == 'pharmacist') {
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
