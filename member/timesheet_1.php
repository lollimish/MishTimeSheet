<?php include("../includes/requireHeader.php"); ?>
<?php include("../includes/header.php"); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#datepicker").datepicker({
            altField: "#alternate",
            altFormat: "DD- d MM- yy",
            dateFormat: "yy-mm-dd",
            onSelect: function() {
                document.getElementById("date").innerHTML = "You have selected<span> " + (document.getElementById("alternate").value)
                        + "</span>, hit save to submit the hour of work.";
            }
        });
    });

    function get_project(company)
    {
        $.ajax({
            type: "POST",
            url: "ddlProject.php", /* company id will be sent to this file */
            beforeSend: function() {
                $("#project").html("<option>Loading projects...</option>");
            },
            data: {company: company},
            success: function(msg) {
                $("#project").html(msg);
            }
        });
    }
    onload = "document.FORMNAME.reset();"
</script>
<style>
    .input{
        width: 250px;
    }
    span{
        color: midnightblue 
    }
</style>
<div id="content_container">
    <div id="content_left">
        <h1>Time Sheet</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table>
                <tr>
                    <td>Company: </td>
                    <td>
                        <!--Retrieve data from first drop down list--> 
                        <?php
                        $member = 5; //$_SESSION['SESS_MEMBER_ID'];//mish
                        $qry_company = "select distinct company,client_id from clients 
                                            inner join projects using(client_id)
                                            inner join project_members using(project_id)
                                            inner join members using(member_id)
                                            inner join time_data using(member_id)                
                                            where member_id =" . $member . " order by company";
                        $result_company = mysql_query($qry_company);
                        ?>
                        <select class="input" name='company' id='company' onChange='get_project(this.value)'>
                            <?php
                            while ($row_company = mysql_fetch_array($result_company)) {
                                echo "<option value='" . $row_company['company'] . "'>" . $row_company['company'] . "</option>";
                            }
                            ?>
                        </select>                        
                    </td>
                </tr>
                <tr>
                    <td>Project: </td>
                    <td>
                        <select class="input" id='project' name="project_id"><option>Project</option></select> 
                    </td>
                </tr>
                <tr>
                    <td>Task: </td>
                    <td>
                        <select class="input" name='task' id='task'>
                            <option value="1">Administration</option>
                            <option value="2">Analytics/SEO</option>
                            <option value="3">Audio/Video Editing</option>
                            <option value="4">Back end - Dev/DB/Planning</option>
                            <option value="5">Client Meeting</option>
                            <option value="6">Content Management</option>
                            <option value="7">Front end - Dev/Graphics/Planning</option>
                            <option value="8">Managed Services</option>
                            <option value="9">Marketing</option>
                            <option value="10">Photography</option>
                            <option value="11">Project Management</option>
                        </select> 
                    </td>
                </tr>
                <tr>
                    <td>Date: </td>
                    <td><input type="text" id="datepicker" name="datepicker" /><input type="text" style="display: none" id="alternate" size="30" /></td>
                </tr>
                <tr>
                    <td>Hour:</td>
                    <td>
                        <select name='hour'>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        hour(s)
                        <select name='decimal'>
                            <option value="0">0</option>
                            <option value="0.25">15</option>
                            <option value="0.5">30</option>
                            <option value="0.75">45</option>
                        </select>
                        minutes
                    </td>
                </tr>
                <tr>
                    <td>Note: </td>
                    <td><textarea class="input" name="notes" rows="5" cols="30"></textarea></td>
                </tr>
            </table>
            <div style="width:100%; height: 30px; padding-top: 10px; padding-left: 2px" id="date"></div>
            <input type="submit" name="submit" value="submit" style="margin-bottom:10px"/>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $company = $_POST['company'];
            $member_id = $member;
            $project_id = $_POST['project_id'];
            $task_id = $_POST['task'];
            $hour = $_POST['hour'];
            $decimal = $_POST['decimal'];
            $hour_worked = (doubleval($hour))+(doubleval($decimal));
            $notes = $_POST['notes'];
            $date = $_POST['datepicker'];
              
            $time_data_query = "insert into time_data(project_id, member_id, task_id, notes, record_updated, date, hour_worked) 
                                                   value(".(int)$project_id.",".(int)$member_id.",".(int)$task_id.",'" . $notes
                                                                            . "',now(),'".($date)."',".$hour_worked.");";
            
            $result = mysql_query($time_data_query);
            if ($result) {
                echo "<p>You have put " .$hour_worked. " hour(s) into '".$company."' for ".$date.".</p>";
                echo '<p>Your data has been saved, click <a href="timesheet.php">here</a> to insert for next row.</p>';
            } else {
                echo '<p>There is problem occured, click <a href="timesheet.php">here</a> to refresh.</p>';
            };
            mysql_close();
            header("Refresh:1; location: {$_SERVER['PHP_SELF']}");
            exit();
             
            
        }
        ?>

        <hr>
        <p class="header">Time sheet Instructions</p>
        <ol>
            <li><strong>Your Projects</strong> - Your time sheet will display only the projects for which you are assigned.  Under each project you can choose a task for which to enter your time.</li><br />
            <li><strong>Task Definitions</strong> - The Tasks shown are used to identify the work as it is invoiced to the client.  If you're unsure what task to use, please see the Task Definitions slide for more help.</li><br />
            <li><strong>Add Time to New Task</strong> - Under the project you have worked on, enter hours on the day worked for desired task.  For further clarification, enter the specifics of the task performed in the Notes field and then click "Add Task".</li><br />
            <li><strong>Add Time to Existing Task</strong> - You can add additional time to an existing task by updating the time worked for a particular day and click "Update Task".</li><br />
            <li><strong>Delete Task</strong> - Zero out all hours for the task and click "Update Task".</li><br />
            <li><strong>View Archives</strong> - Click "Previous Week" or "Next Week" to search through archived records.  NOTE: Once processed by the Administrator these records cannot be updated.</li><br />
        </ol>
    </div><!--content_left-->

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
        </div>
            <?php include("../includes/sideNav.php"); ?>
        <hr />
    </div>
    <div class="clear"></div>
</div>

<div id="slideout">
    <img src="../../images/taskDefin.png" alt="Task Definitions" />
    <div id="slideout_inner">
        <p><strong>Administration</strong> - General tasks performed for company operational.</p>
        <p><strong>Analytics/SEO</strong> - Study website analytics and make recommendations to client.  Implementing techniques to increase Search Engine Optimization for a website.</p>
        <p><strong>Audio/Video Editing</strong> - Production and/or editing of multimedia content.</p>
        <p><strong>Backend (Dev/DB/Planning)</strong> - Server-side scripting/programming in any language.</p>
        <p><strong>Client Meeting</strong> - Lengthly Face to face or telephone conference with client to discuss any stage of a project.</p>
        <p><strong>Content Management</strong> - Manage/review/recommend/implementation of website content to include copy, images, etc...</p>
        <p><strong>Frontend (Dev/Graphics/Planning)</strong> - Client-side scripting/programming in any language.  Layout and graphic design development.</p>
        <p><strong>Managed Services</strong> - Oversight and management of misc services as defined per the clients request.</p>
        <p><strong>Marketing</strong> - Any efforts made to better increase awareness of a brand.</p>
        <p><strong>Photography</strong> - Planning/organizing/executing photoshoots, editing photographs and delivery.</p>
        <p><strong>Project Management</strong> - Consulting and oversight of project development.</p>
    </div>
</div>    
<?php include("../includes/footer.php"); ?>
