<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>KMJ Web Design | Project Tracking System</title>
        <link rel="stylesheet" type="text/css" href="https://kmjwebdesign.com/hosting/templates/kmjPortal/style.css" />
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $("#message").fadeTo("slow", 0.00, function() { //fade
                        $(this).slideUp("slow", function() { //slide up
                            $(this).remove(); //then remove from the DOM
                        });
                    });
                }, 4000);
            });
        </script>
    </head>
    <body>
        <div id="top_container">
            <div id="top">
                <div id="logo">
                    <a href="/MishTimeSheet/index.php"><img src="/MishTimeSheet/images/logoNew.gif" alt="KMJ Web Design" border="0"></a>
                </div><!--logo-->

                <div id="nav">
                    <?php
                    //this script make "MishTimeSheet/includes/nav.php" can be access from any subdirectory.
                    $times = substr_count($_SERVER['PHP_SELF'], "/");
                    $rootaccess = "";
                    $i = 1;
                    while ($i < $times) {
                        $rootaccess .= "../";
                        $i++;
                    }
                    include ($rootaccess . "MishTimeSheet/includes/nav.php");
                    ?>
                </div><!--nav-->
            </div><!--top-->
        </div><!--top_container-->
