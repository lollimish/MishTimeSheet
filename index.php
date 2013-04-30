<?php
session_start();
define('ACCESS', true);
?>

<?php include("includes/header.php"); ?>

<div id="content_container">
    
    <div id="content_left">
        <h1>Project Tracking System</h1>
        <p>Login to your account to view or manage your recent activity.</p>        
    </div>

    <div id="side_menu">
        <div id="message">
            <?php
            if (isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) > 0) {
                $compType = $_SESSION['COMP_TYPE'];
                echo "<div id=\"" . $compType . "\">";
                echo "<ul>";
                foreach ($_SESSION['ERRMSG_ARR'] as $msg) {
                    echo "<li><p style=\"padding: 8px;\">" . $msg . "</p></li>";
                }
                echo "</ul>";
                echo "</div>";
                unset($_SESSION['ERRMSG_ARR']);
            }
            ?>
        </div><!-- message -->

        <?php
        if (isset($_SESSION['COMP_TYPE']) && $_SESSION['COMP_TYPE'] == "error") {
            session_destroy();
        }
        ?>
        <p class="header">User Login</p>
        <form action="includes/loginCheck.php" method="post">
            <p><strong>Login</strong><br />
                <input name="login" type="text" size="25" /></p>
            <p><strong>Password</strong><br />
                <input name="password" type="password" size="25" /></p>
            <p><input type="submit" class="submitbutton" value="Login" /></p>
        </form>

    </div>

    <div class="clear"></div>

</div>
<?php include("includes/footer.php"); ?>
