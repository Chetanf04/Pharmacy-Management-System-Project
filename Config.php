<?php
		$conn = mysqli_connect("localhost", "root", "", "PharmacyDB");
		// $conn = mysqli_connect("localhost", "root", "", "pharmacy");
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		}
?>

