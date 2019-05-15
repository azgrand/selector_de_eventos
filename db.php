<?php
$con = mysqli_connect("localhost","root","","irontec_eventos");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
?>