<?php
// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "''";
$dbname = "patientdetails";

$conn =  mysqli_connect("localhost", "root", '', 'patientdetails');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch data from the database
$sql = "SELECT * FROM patientdet";
$result = $conn->query($sql);

// Step 3: Generate the HTML table dynamically
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>firstName</th><th>LastName</th><th>gender</th><th>email</th><th>password</th><th>Number</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["firstName"] . "</td>";
        echo "<td>" . $row["lastName"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["number"] . "</td>";


        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

// Step 4: Close the database connection
$conn->close();
?>
