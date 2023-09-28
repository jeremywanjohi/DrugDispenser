<?php
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $number = $_POST["number"];

    $conn = new mysqli('localhost','root','','patientdet');
    if($conn->connect_error){
        echo json_encode(["message" => "Connection Failed : ". $conn->connect_error]);
    } else {
        $stmt = $conn->prepare("insert into patientdet(firstName, lastName, gender, email, password, number) values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);
        $execval = $stmt->execute();
        $stmt->close();
        $conn->close();

        echo json_encode(["message" => "Registration successful"]);
    }
?>
