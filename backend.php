<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_GET['action'] ?? '';

if ($action === 'create') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $price = $data['price'];
    $stock = $data['stock'];

    $stmt = $conn->prepare("INSERT INTO medicines (name, price, stock) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name, $price, $stock);
    $stmt->execute();
    echo json_encode(["message" => "Medicine added successfully"]);
} elseif ($action === 'read') {
    $result = $conn->query("SELECT * FROM medicines");
    $medicines = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($medicines);
} elseif ($action === 'delete') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM medicines WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["message" => "Medicine deleted successfully"]);
}

$conn->close();
?>
