
<?php
include("Config.php");

if (isset($_GET['bar_code'])) {
    $bar_code = $_GET['bar_code'];

    // Sanitize input
    $bar_code = mysqli_real_escape_string($con, $bar_code);

    // Fix the column name based on actual database structure
    $query = "SELECT MED_NAME, MED_QTY FROM meds WHERE bar_code = '$bar_code'";

    $result = mysqli_query($con, $query);

    if (!$result) {
        echo json_encode([
            'success' => false,
            'message' => 'Database query failed: ' . mysqli_error($con)
        ]);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'product_name' => $row['MED_NAME'],
            'available_quantity' => $row['MED_QTY']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No product found for the given barcode.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Barcode is missing in the request.'
    ]);
}
?>
