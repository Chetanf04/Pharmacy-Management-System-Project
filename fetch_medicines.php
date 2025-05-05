<?php
include "Config.php";

$sql = "SELECT m.*, p.EXP_DATE FROM meds m 
        JOIN purchase p ON m.MED_ID = p.MED_ID";  // ✅ JOIN purchase table

$result = $conn->query($sql);

$total_meds = $result->num_rows; // ✅ Count Total Medicines

$output = ""; // To store table rows

if ($total_meds > 0) {
    $invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';

    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>{$row['MED_ID']}</td>";
        $output .= "<td>{$row['MED_NAME']}</td>";
        $output .= "<td>{$row['CATEGORY']}</td>";
        $output .= "<td>{$row['MED_QTY']} &nbsp;&nbsp;(<strong><i>{$row['Sell_type']}</i></strong>)</td>";                                                                    
        $output .= "<td>{$row['EXP_DATE']}</td>"; // ✅ EXP_DATE from Purchase
        $output .= "<td>{$row['actual_price']}</td>";
        $output .= "<td>{$row['selling_price']}</td>";
        $output .= "<td>{$row['profit_price']}</td>";
        $output .= "<td>{$row['LOCATION_RACK']}</td>";

        // ✅ Proper Status Handling
        $status = $row['status'];
        if ($status == 'Available') {
            $output .= "<td><span class='label label-success'>{$status}</span></td>";
        } else {
            $output .= "<td><span class='label label-danger'>{$status}</span></td>";
        }

        // ✅ Action Buttons
        $output .= "<td>
                        <a class='action-btn edit-btn' href='Product_update.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['MED_ID'] . "'>Edit</a>
                        <a class='action-btn del-btn' href='Product_delete.php?invoice_number=" . urlencode($invoice_number) . "&id=" . $row['MED_ID'] . "'>Delete</a>
                    </td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='11'>No records found</td></tr>";
}

// ✅ Return both data & total count as JSON
$response = [
    'tableRows' => $output,
    'totalCount' => $total_meds
];

echo json_encode($response); // 🔄 Send data as JSON

$conn->close();
?>
