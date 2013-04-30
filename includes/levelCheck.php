<?php
	if (!defined('ACCESS')) {
		session_destroy;
		header("location: ../index.php");
		exit();
	}
	
        if($_SESSION['SESS_LEVEL'] != 'admin' && $_SESSION['SESS_LEVEL'] != 'member') {
		session_destroy;
		header("location: ../index.php");
		exit();
	}
	
?>