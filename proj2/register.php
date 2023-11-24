<?php
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$password = $_POST["password"];
$number = $_POST["number"];
$userType = $_POST["userType"];

$conn = new mysqli('localhost', 'root', '', 'patientdet');

// Check connection
if ($conn->connect_error) {
    echo json_encode(["message" => "Connection Failed: " . $conn->connect_error]);
} else {
    $stmt = $conn->prepare("INSERT INTO patientdet(firstName, lastName, gender, email, password, number, occupation) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepare statement succeeded
    if ($stmt === false) {
        echo json_encode(["message" => "Prepare statement failed: " . $conn->error]);
    } else {
        // Bind parameters
        $stmt->bind_param("sssssis", $firstName, $lastName, $gender, $email, $password, $number, $userType);

        // Execute the statement
        $execval = $stmt->execute();

        // Check if the execution succeeded
        if ($execval === false) {
            echo json_encode(["message" => "Execute statement failed: " . $stmt->error]);
        } else {
            // Registration successful, redirect to login.html
            header("Location: login.html");
            exit();
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>
