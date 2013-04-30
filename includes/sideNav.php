<?php
	if (!defined('ACCESS')) {
		session_destroy;
		header("location: ../index.php");
		exit();
	}
        
        if($_SESSION['SESS_LEVEL'] == 'admin'){
            echo '<p class="header">Admin Navigation</p>';
            echo '<p><a href="manageTime.php">Manage Time</a></p>';
            echo '<p><a href="manageUsers.php">Manage Users</a></p>';
            echo '<p><a href="manageClients.php">Manage Clients</a></p>';
            echo '<p><a href="manageProjects.php">Manage Projects</a></p>';
        }
        
        if($_SESSION['SESS_LEVEL'] == 'member'||$_SESSION['SESS_LEVEL'] == 'admin'){
            echo '<p class="header">Member Navigation</p>';
            echo '<p><a href="timesheet.php">Timesheet / Archive</a></p>';
            echo '<p><a href="projectList.php">Project List</a></p>';
        }
?>



