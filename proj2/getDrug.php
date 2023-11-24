<?php
$connection = mysqli_connect('localhost', 'root', '', 'patientdet');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$drugName = $_GET['drugName'];
$Category = $_GET['Category']; // Note: Corrected variable name to match the case

$query = "SELECT * FROM drugdet WHERE DrugName = '$drugName' AND Category = '$Category'"; // Fixed the typo
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $drugDetails = [
        'drugName' => $row['DrugName'],
        'Category' => $row['Category'],
    ];
    header('Content-Type: application/json');
    echo json_encode($drugDetails); // Corrected json_encode usage
} else {
    echo "Error fetching drug details: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
