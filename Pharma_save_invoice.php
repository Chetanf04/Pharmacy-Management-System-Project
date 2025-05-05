<?php
ob_start();
session_start();
include "Config2.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_session'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['user_session'];
echo "Admin ID: " . $admin_id; // ✅ Debugging

// ✅ Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['paid_amount']) || empty($_POST['invoice_number']) || empty($_POST['date'])) {
        die("<h3>Error: Some form fields are missing.</h3>");
    }

    $invoice_number = mysqli_real_escape_string($con, $_POST['invoice_number']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $paid_amount = mysqli_real_escape_string($con, $_POST['paid_amount']);

    // Fetch total amount and profit
    $total_amount = 0;
    $total_profit_amount = 0;

    $select_sql = "SELECT amount, profit_amount FROM on_hold WHERE invoice_number = '$invoice_number'";
    $select_query = mysqli_query($con, $select_sql);
    if (!$select_query) {
        die("<h3>Error: " . mysqli_error($con) . "</h3>");
    }

    while ($row = mysqli_fetch_assoc($select_query)) {
        $total_amount += $row['amount'];
        $total_profit_amount += $row['profit_amount'];
    }

    // Calculate change amount
    $change_amount = $paid_amount - $total_amount;

    // Arrays for storing medicine details
    $medicines = [];
    $quantities = [];
    $c_ids = [];

    // Fetch medicines from on_hold
    $select_on_hold = "SELECT * FROM on_hold WHERE invoice_number = '$invoice_number'";
    $select_on_hold_query = mysqli_query($con, $select_on_hold);
    if (!$select_on_hold_query) {
        die("<h3>Error Fetching on_hold: " . mysqli_error($con) . "</h3>");
    }
    $c_id = ''; // Single C_ID store karnya sathi
    while ($row = mysqli_fetch_assoc($select_on_hold_query)) {
        $c_id = mysqli_real_escape_string($con, $row['C_ID']);
        $med_name = mysqli_real_escape_string($con, $row['medicine_name']);
        $category = mysqli_real_escape_string($con, $row['category']);
        $qty = mysqli_real_escape_string($con, $row['qty']);

        // Store for comma-separated data
        $medicines[] = $med_name;
        $quantities[] = $qty;
           // ✅ Debugging - check quantities array
    echo "Medicine: $med_name | Qty: $qty<br>";

        // ✅ Update stock
        $select_stock = "SELECT MED_QTY, Sold_qty FROM meds WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
        $select_stock_query = mysqli_query($con, $select_stock);

        if ($row_stock = mysqli_fetch_assoc($select_stock_query)) {
            $new_sold_qty = $row_stock['Sold_qty'] + $qty;

            $update_stock = "UPDATE meds SET Sold_qty = '$new_sold_qty' WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";
            if (!mysqli_query($con, $update_stock)) {
                die("<h3>Error Updating Stock: " . mysqli_error($con) . "</h3>");
            }

            // ✅ Update status based on stock
            $remain_quantity = $row_stock['MED_QTY'] - $qty;
            $status = ($remain_quantity <= 0) ? 'Unavailable' : 'Available';
            $update_status = "UPDATE meds SET status = '$status' WHERE MED_NAME = '$med_name' AND CATEGORY = '$category'";

            if (!mysqli_query($con, $update_status)) {
                die("<h3>Error Updating Status: " . mysqli_error($con) . "</h3>");
            }
        }
    }

    // ✅ Convert arrays to comma-separated strings
    $medicines_str = implode(',', $medicines);
    $quantities_str = implode(',', $quantities);

    // ✅ Insert into invoicesales
    $insert_sql = "INSERT INTO invoicesales (invoice_number, total_amount, paid_amount, change_amount, date, medicine_name, qty, profit_amount, C_ID, E_ID) 
                   VALUES ('$invoice_number', '$total_amount', '$paid_amount', '$change_amount', '$date', '$medicines_str', '$quantities_str', '$total_profit_amount', '$c_id', '$admin_id')";

    if (!mysqli_query($con, $insert_sql)) {
        die("<h3>Error Inserting Invoice: " . mysqli_error($con) . "</h3>");
    } else {
        echo "<h3>Invoice saved successfully!</h3>";
    }

    // Generate new invoice number
    $new_invoice_number = "CA-" . rand(100000, 999999);

    // Redirect to main page
    header("Location: Pharma_mainpage.php?invoice_number=$new_invoice_number");
    exit();
} else {
    echo "<h3>Form not submitted correctly.</h3>";
}

?>
