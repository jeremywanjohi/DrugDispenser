<?php
    include "header.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Reset some default browser styles */
        body, h1, h2, p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .category {
            background-color: #eee;
            padding: 10px;
            margin: 20px 0;
        }

        .category h2 {
            text-align: center;
        }

        .drug-container {
            display: inline-block;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 10px;
        }

        .drug-container h3 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        .drug-container img {
            max-width: 100%;
            height: auto;
        }

        .view-details-button { /* Add CSS for the view details button */
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    try {
        // Establish a database connection
        $connection = mysqli_connect('localhost', 'root', '', 'patientdet');

        if ($connection->connect_error) {
            throw new Exception('Connection failed: ' . $connection->connect_error);
        }

        // Define the drug categories
        $categories = array("Antibiotics", "Antiviral", "Antifungal");

        foreach ($categories as $category) {
            // Display the category name as a section heading
            echo "<section class='category'>";
            echo "<h2>$category</h2>";

            // Retrieve drugs in this category
            $query = "SELECT DrugName, Image FROM drugdet WHERE Category = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $drugName = $row["DrugName"];
                    $imageUrl = $row["Image"];

                    // Display the drug image with its name and a "View Details" button
                    echo "<div class='drug-container'>";
                    echo "<h3>$drugName</h3>";
                    echo "<img src='$imageUrl' alt='$drugName'>";
                    // Add a button with an onclick event to open the popup
                    echo "<button class='view-details-button' onclick='openDrugDetails(\"$drugName\", \"$category\")'>View Details</button>";
                    echo "</div>";
                }
            } else {
                echo "No drugs found in this category.";
            }

            echo "</section>";
        }

        $connection->close();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    ?>

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
    </style>



    <!-- Hidden pop-up container -->
    <div id="drug-details-popup" class="popup">
        <div class="popup-content">
            <!-- Drug details content goes here -->
            <h2>Drug Details</h2>
            <p>Name: <span id="popup-drug-name"></span></p>
            <p>Category: <span id="popup-category"></span></p>
            <button id="close-popup-button" onclick="closeDrugDetails()">Close</button>
        </div>
    </div>

    <script>
        var popup = document.getElementById("drug-details-popup");

        function openDrugDetails(drugName, category) {
            document.getElementById("popup-drug-name").textContent = drugName;
            document.getElementById("popup-category").textContent = category;
            popup.style.display = "block";
        }

        function closeDrugDetails() {
            popup.style.display = "none";
        }
    </script>
</body>
</html>
