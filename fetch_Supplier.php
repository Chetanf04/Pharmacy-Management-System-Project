<?php
include "Config.php";

$sql = "SELECT sup_id, sup_name, sup_add, sup_phno, sup_mail FROM suppliers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the invoice_number from URL
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['sup_id']}</td>";
        echo "<td>{$row['sup_name']}</td>";
        echo "<td>{$row['sup_add']}</td>";
        echo "<td>{$row['sup_phno']}</td>";
        echo "<td>{$row['sup_mail']}</td>";
        echo "<td align='center'>
                <a href='Supplier_update.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['sup_id'] . "' class='btn btn-warning btn-sm'>Edit</a> 
                <a href='Supplier_delete.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['sup_id'] . "' class='btn btn-danger btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No Data Found</td></tr>";
}

$conn->close();
?>
