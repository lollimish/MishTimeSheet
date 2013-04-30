<?php
	if (!defined('ACCESS')) {
		session_destroy;
		header("location: ../index.php");
		exit();
	}

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if (!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
				
	$db = mysql_select_db(DB_DATABASE);
	if (!$db) {
		die("Unable to select database");
	}
?>