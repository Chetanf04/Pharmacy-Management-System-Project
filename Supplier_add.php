<?php
include "Config.php";

if(isset($_POST['sid'])) {
    $id = mysqli_real_escape_string($conn, $_POST['sid']);
    $name = mysqli_real_escape_string($conn, $_POST['sname']);
    $add = mysqli_real_escape_string($conn, $_POST['sadd']);
    $phno = mysqli_real_escape_string($conn, $_POST['sphno']);
    $mail = mysqli_real_escape_string($conn, $_POST['smail']);

    $sql = "INSERT INTO suppliers (sup_id, sup_name, sup_add, sup_phno, sup_mail) 
            VALUES ($id, '$name', '$add', $phno, '$mail')";

    if(mysqli_query($conn, $sql)){
        echo "✅ Supplier added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$conn->close();
?>
