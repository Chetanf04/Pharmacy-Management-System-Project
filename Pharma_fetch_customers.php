<?php
include "Config.php";

$sql = "SELECT c_id, c_fname, c_lname, c_age, c_sex, c_phno, c_mail FROM customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["c_id"] . "</td>";
        echo "<td>" . $row["c_fname"] . "</td>";
        echo "<td>" . $row["c_lname"] . "</td>";
        echo "<td>" . $row["c_age"] . "</td>";
        echo "<td>" . $row["c_sex"] . "</td>";
        echo "<td>" . $row["c_phno"] . "</td>";
        echo "<td>" . $row["c_mail"] . "</td>";
        echo "</tr>";
    }
}
$conn->close();
?>
