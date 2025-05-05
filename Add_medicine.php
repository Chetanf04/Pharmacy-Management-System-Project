<?php
include "Config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['medid'];
    $name = $_POST['medname'];
    $category = $_POST['cat'];
    $qty = $_POST['qty'];
    $sell_type = trim($_POST['sell_type']); // remove unwanted spaces
    $actual_price = $_POST['actual_price'];
    $selling_price = $_POST['selling_price'];
    $location = $_POST['loc'];
    $status = "Available";

    $profit = $selling_price - $actual_price;
    $profit_percent = $actual_price > 0 ? ($profit / $actual_price) * 100 : 0;
    $profit_price = "$profit (" . round($profit_percent, 2) . "%)";

    $sql = "INSERT INTO meds (MED_ID, MED_NAME, CATEGORY, MED_QTY, `Sell_type`, actual_price, selling_price, profit_price, LOCATION_RACK, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississdsss", $id, $name, $category, $qty, $sell_type, $actual_price, $selling_price, $profit_price, $location, $status);

    if ($stmt->execute()) {
        echo "✅ Medicine added successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
