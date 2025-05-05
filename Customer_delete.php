<?php
session_start();

if (!isset($_SESSION['user_session'])) {  
    header("location:index.php");
    exit();
}                

include "Config.php";

if (isset($_GET['id']) && isset($_GET['invoice_number'])) {
    $id = $_GET['id'];
    $invoice_number = $_GET['invoice_number']; // Invoice number safe store karayla

    $sql = "DELETE FROM customer WHERE c_id='$id'";

    if ($conn->query($sql)) {
        // ✅ Corrected: `header()` madhe `invoice_number` PHP variable use kara
        header("Location: Customer_view.php?invoice_number=" . urlencode($invoice_number));
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>
