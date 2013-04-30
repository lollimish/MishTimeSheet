<?php
	session_start();    
	$start = $_SESSION['SESS_START'];
	if ($start == 0) {
		header("location: timesheet.php");
		exit();
	} else if ($start == 1) {
		header("location: projectList.php");
		exit();
	} else {
		die("Session Not Initiated");
	}
?>
