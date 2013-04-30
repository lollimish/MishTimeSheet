<?php
	session_start();

	if (!defined('ACCESS')) {
		session_destroy;
		header("location: ../index.php");
		exit();
	}

	if (!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) === "")) {
		$errmsg_arr[] = "Access Denied.";
		$errflag = true;	
	}
	if ($_SESSION['SESS_ACTIVE'] === "inactive") {
		$errmsg_arr[] = "Your Account is Inactive.";
		$errflag = true;
	}
	$errflag = false;
        
        if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$_SESSION['COMP_TYPE'] = "error";
		session_write_close();
		header("location: ../index.php");
		exit();
	}
?>