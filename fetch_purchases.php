<?php
include "Config.php";

$sql = "SELECT p.p_id, p.sup_id, p.med_id, p.p_qty, p.p_cost, p.pur_date, 
               p.mfg_date, p.exp_date, m.med_name 
        FROM purchase p
        JOIN meds m ON p.med_id = m.med_id";  // JOIN वापरला आहे

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["p_id"] . "</td>";
        echo "<td>" . $row["sup_id"] . "</td>";
        echo "<td>" . $row["med_id"] . "</td>";
        echo "<td class='med-name'>" . $row["med_name"] . "</td>";
        echo "<td>" . $row["p_qty"] . "</td>";
        echo "<td>" . $row["p_cost"] . "</td>";
        echo "<td>" . $row["pur_date"] . "</td>";
        echo "<td>" . $row["mfg_date"] . "</td>";
        echo "<td>" . $row["exp_date"] . "</td>";
        echo "<td class='action-buttons d-flex justify-content-center gap-2'>";

        // get Invoice number in parametere
        $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

        
        echo "<a href='Purchase_update.php?invoice_number=" . urlencode($invoice_number) . "&pid=" . $row['p_id'] . "&sid=" . $row['sup_id'] . "&mid=" . $row['med_id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
        echo "<a href='Purchase_delete.php?invoice_number=" . urlencode($invoice_number) . "&pid=" . $row['p_id'] . "&sid=" . $row['sup_id'] . "&mid=" . $row['med_id'] . "' class='btn btn-danger btn-sm'>Delete</a>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10' class='text-center'>No records found</td></tr>";
}

$conn->close();
?>

