<?php
	include "Config.php";
	$id = $_GET['id'];
    $invoice_number = $_GET['invoice_number'];

$sql1 = "DELETE FROM emplogin WHERE E_ID='$id'";
$conn->query($sql1);

$sql2 = "DELETE FROM employee WHERE e_id='$id'";
if ($conn->query($sql2)) {
    header("Location: Employee_view.php?invoice_number=" . urlencode($invoice_number));
    exit();
} else {
    echo "Error: " . $conn->error;
}

?>