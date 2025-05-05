<?php
	include "Config.php";
	$invoice_number = $_GET['invoice_number']; // Invoice number safe store karayla
	$sql="DELETE FROM suppliers where sup_id='$_GET[id]'";
	if ($conn->query($sql))
	header("location:Supplier_view.php?invoice_number=" . urlencode($invoice_number));
	else
	echo "error";
?>