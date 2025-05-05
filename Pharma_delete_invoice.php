<?php
session_start();

// Include database connection
include("Config2.php");

// Check if invoice_number and id are provided
if (isset($_GET['invoice_number']) && isset($_GET['id'])) {
    // Escape inputs to prevent SQL injection
    $invoice_number = mysqli_real_escape_string($con, $_GET['invoice_number']);
    $id = mysqli_real_escape_string($con, $_GET['id']); // ✅ Escaping ID

    // Fetch the specific item related to the invoice and ID
    $query = "SELECT medicine_name, qty FROM on_hold WHERE invoice_number = '$invoice_number' AND id = '$id'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $medicine_name = mysqli_real_escape_string($con, $row['medicine_name']);
            $quantity = (int) $row['qty'];

            // ✅ Update stock in meds table
            $update_stock_sql = "UPDATE meds SET MED_QTY = MED_QTY + '$quantity' WHERE MED_NAME = '$medicine_name'";
            if (!mysqli_query($con, $update_stock_sql)) {
                die("Stock update failed: " . mysqli_error($con));
            }
        }

        // ✅ Delete specific record from on_hold table using ID
        $delete_sql = "DELETE FROM on_hold WHERE invoice_number = '$invoice_number' AND id = '$id'";
        if (mysqli_query($con, $delete_sql)) {
            header("Location: Pharma_mainpage.php?invoice_number=$invoice_number&message=Item deleted successfully");
            exit;
        } else {
            die("Error deleting invoice item: " . mysqli_error($con));
        }
    } else {
        echo "No item found for the given invoice number and ID.";
    }
} else {
    echo "Invalid request. Invoice number or ID missing.";
}
?>
