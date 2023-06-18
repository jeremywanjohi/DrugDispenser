<?php
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$gender = $_POST["gender"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$number = $_POST["number"];

	$conn = new mysqli('localhost','root','','patientdetails');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into patientdet(firstName, lastName, gender, email, password, number) values(?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssi", $firstName, $lastName, $gender, $email, $password, $number);
		$execval = $stmt->execute();
		echo $execval;

		echo "Registration successful \n";
		$sql = "SELECT *FROM patientdet";
		$result = $conn->query($sql);
		$row=$result->fetch_assoc();
		print_r($row);
	
		$stmt->close();
		$conn->close();
    }

?>