<?php
include "Config.php";

$sql = "SELECT e_id, e_fname, e_lname, bdate, e_age, e_sex, e_type, e_jdate, e_sal, e_phno, e_mail FROM employee WHERE e_id<>1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['e_id']}</td>
                <td>{$row['e_fname']}</td>
                <td>{$row['e_lname']}</td>
                <td>{$row['bdate']}</td>
                <td>{$row['e_age']}</td>
                <td>{$row['e_sex']}</td>
                <td>{$row['e_type']}</td>
                <td>{$row['e_jdate']}</td>
                <td>{$row['e_sal']}</td>
                <td>{$row['e_phno']}</td>
                <td>{$row['e_mail']}</td>
                <td align='center'>
                    <a class='action-btn edit-btn' href='Employee_update.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['e_id'] . "'>Edit</a>
                    <a class='action-btn del-btn' href='Employee_delete.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['e_id'] . "'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='12'>No Employees Found</td></tr>";
}

$conn->close();
?>
