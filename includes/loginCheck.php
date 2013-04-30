<?php
	session_start();
	define('ACCESS',true);
	require_once('config.php');
	require_once('connect.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['login']);
	$password = clean($_POST['password']);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login Missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password Missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		$_SESSION['COMP_TYPE'] = "error";
		session_write_close();
		header("location: index.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM members WHERE login='$login' AND passwd='".md5($_POST['password'])."'";
	$result=mysql_query($qry);
	
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
			$_SESSION['SESS_ACTIVE'] = $member['active'];
			$_SESSION['SESS_LEVEL'] = $member['level'];
			$_SESSION['SESS_START'] = $member['start'];
			if($member['level'] == 'admin' || $member['level'] == 'member') {
			  session_write_close();
			  header("location: ../member/index.php");
			  exit();
			}
			if($member['level'] == 'client') {
			  session_write_close();
			  header("location: ../client/index.php");
			  exit();
			}
		} else {
			$errmsg_arr[] = 'Login Failed, Try Again';
			$errflag = true;
			
			if($errflag) {
			  $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			  $_SESSION['COMP_TYPE'] = "error";
			  session_write_close();
			  header("location: ../index.php");
			  exit();
			}
		}
	} else {
		die("Query failed");
	}
?>