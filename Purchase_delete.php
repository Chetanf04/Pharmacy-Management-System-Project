<?php
	include "Config.php";
	$pid=$_GET['pid'];
	$sid=$_GET['sid'];
	$mid=$_GET['mid'];
	$invoice_number = $_GET['invoice_number']; // Invoice number safe store karayla
				
	$sql="DELETE FROM purchase where p_id='$pid' and sup_id='$sid' and med_id='$mid'";

	if ($conn->query($sql))

	header("location:Purchase_view.php?invoice_number=" . urlencode($invoice_number));
	else
	echo "error";
?>