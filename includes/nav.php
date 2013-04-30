<?php
if (isset($_SESSION['SESS_FIRST_NAME'])) {
    echo "<span>Hello, ";
    echo $_SESSION['SESS_FIRST_NAME'];
    echo "! <a href='myProfile.php' class='mainNav'>Edit My Profile</a></span>";
    
    if (isset($_SESSION['SESS_LEVEL']) && ($_SESSION['SESS_LEVEL'] == 'member' || $_SESSION['SESS_LEVEL'] == 'client')) {
        echo " | ";
    } else if (isset($_SESSION['SESS_LEVEL']) && $_SESSION['SESS_LEVEL'] == 'admin') {
        echo " | <a href=\"../admin\" class=\"mainNav\">Admin Area</a> | ";
    }
    echo "<a href='../logout.php' class='mainNav'>Log Out</a>";
}
?>