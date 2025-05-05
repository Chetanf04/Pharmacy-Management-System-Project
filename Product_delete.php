<?php
	include "Config.php";
	$sql="DELETE FROM meds where med_id='$_GET[id]'";
	$invoice_number = isset($_GET['invoice_number']) ? $_GET['invoice_number'] : '';
	if ($conn->query($sql))
	header("location:Product_view.php?invoice_number=" . urlencode($invoice_number));

	else
	echo "error";
?>