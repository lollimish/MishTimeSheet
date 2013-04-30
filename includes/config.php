<?php
	if (!defined('ACCESS')) {
		session_destroy;
		header("location: ../index.php");
		exit();
	}
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '12345678');
    define('DB_DATABASE', 'kahmai_tracking');
    /*
    define('DB_HOST', 'localhost');
    define('DB_USER', 'kahmai_access');
    define('DB_PASSWORD', 'track2011');
    define('DB_DATABASE', 'kahmai_tracking');
     * 
     * 
     */
?>