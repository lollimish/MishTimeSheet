<?php
include("../includes/requireHeader.php");
$company = $_POST['company'];
//$member = 1;//$_SESSION['SESS_MEMBER_ID']; //mish


$sql_project = "select distinct title, project_id from projects
                join time_data using(project_id)
                join clients using (client_id)
                WHERE company = '".(string)$company."'";
        
       
          //      and member_id =" . (int)$member;//mish

$result_project = mysql_query($sql_project);
while ($row_project = mysql_fetch_array($result_project)) {    
    echo "<option value='" . $row_project['project_id'] . "'";
    echo " name='" . $row_project['project_id'] ."'>" . $row_project['title'] . "</option>";
}
echo "</select>";

?>
