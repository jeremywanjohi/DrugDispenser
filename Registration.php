<?php
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$password = $_POST["password"];
$phoneNumber = $_POST["phoneNumber"];

$conn = new mysqli('localhost','root','','patientdb');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} else {
    $stmt = $conn->prepare("insert into patientdet(firstName, lastName, gender, email, password, phoneNumber) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $phoneNumber);
    $execval = $stmt->execute();
    echo $execval;
    echo "Registration successful.";
    $stmt->close();
    $conn->close();
}
?>

