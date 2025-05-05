<?php
include "Config.php";

$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

$sql = "SELECT c_id, c_fname, c_lname, c_age, c_sex, c_phno, c_mail FROM customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['c_id']}</td>";
        echo "<td>{$row['c_fname']}</td>";
        echo "<td>{$row['c_lname']}</td>";
        echo "<td>{$row['c_age']}</td>";
        echo "<td>{$row['c_sex']}</td>";
        echo "<td>{$row['c_phno']}</td>";
        echo "<td>{$row['c_mail']}</td>";
        echo "<td align='center'>";
        echo "<a href='Customer_update.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['c_id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
        echo "<a href='Customer_delete.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['c_id'] . "' class='btn btn-danger btn-sm'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No Data Found</td></tr>";
}
$conn->close();
?>


