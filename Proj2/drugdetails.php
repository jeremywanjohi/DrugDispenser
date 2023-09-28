<?php

class DrugpageConn {
    public $conn;

    public function __construct(){
        $this->conn = new mysqli("localhost", "root", "", "patientdet");
        if ($this->conn->connect_error) {
            echo json_encode(["Message" => "Connection Error: " . $this->conn->connect_error]);
        }
    }

    public function insert($Drug_Name, $Category, $Image){
        $stmt = $this->conn->prepare("INSERT INTO drugdet (DrugName, Category, Image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $Drug_Name, $Category, $Image);
        $execval = $stmt->execute();
        $stmt->close();
        return $execval;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

$drugpage = new DrugpageConn();
$Drug_Name = $_POST["drugName"];
$Category = $_POST["category"];
$Image = $_POST["image"];

$result = $drugpage->insert($Drug_Name, $Category, $Image);

if ($result) {
    echo json_encode(["message" => "Registration successful"]);
} else {
    echo json_encode(["message" => "Registration failed"]);
}

$drugpage->closeConnection();
?>
