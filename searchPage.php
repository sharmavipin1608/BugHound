<?php
    require_once("header.php");
    require_once 'dbConnection.php';
    //Get list of programs from DB
    $programList = mysql_query("SELECT * FROM PROGRAM_INFORMATION order by PROGRAM,P_RELEASE,VERSION;");

    //Get list of report type
    $reportTypeList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(REPORT_TYPE) FROM BUG_INFORMATION);;");

    //Get list of Severity
    $severityList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(SEVERITY) FROM BUG_INFORMATION);");

    //Get list of functional areas
    $functionalAreaList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(FUNCTIONAL_AREA) FROM BUG_INFORMATION);");

    //Get list of employees whom defects are assigned to
    $employeeList = mysql_query("SELECT EMPLOYEE_ID,FIRST_NAME FROM EMPLOYEE_INFORMATION where EMPLOYEE_ID IN (SELECT DISTINCT(ASSIGNED_TO) FROM BUG_INFORMATION);");
    
    //Get list of Status
    $statusList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(STATUS) FROM BUG_INFORMATION);");

    //Get list of Priority
    $priorityList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(PRIORITY) FROM BUG_INFORMATION);");

    //Get list of resolution
    $resolutionList = mysql_query("SELECT CONSTANT_ID,CONSTANT_NAME FROM HARDCODED_VALUES where CONSTANT_ID IN (SELECT DISTINCT(RESOLUTION) FROM BUG_INFORMATION);");
    
    //Get list of employees whom defects are reported by
    $reportedByList = mysql_query("SELECT EMPLOYEE_ID,FIRST_NAME FROM EMPLOYEE_INFORMATION where EMPLOYEE_ID IN (SELECT DISTINCT(REPORTED_BY) FROM BUG_INFORMATION);");
?>

<html>
    <head>
        <title>
            Search Bugs
        </title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="formValidation.js"></script>
        <script>
            $(function () {
                $("#reportedByDate").datepicker({dateFormat: "yy-mm-dd"}).val();
            });
        </script>
        <style>
            fieldset{
                border: 1px solid rgb(0,0,0);
                width: 300px;
                margin: 0 auto;
                text-align: left;
                top: 50%;
            }
        </style>
    </head>
    <body style="font-family:verdana;">
        <form action="searchResults.php" method="POST">
            <fieldset>
                <legend>Search Bugs</legend>
            <table width="100%">
                <tr>
                    <td>
                        Program
                    </td>
                    <td>
                        <select id="program" name="program">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($programList)) { ?>
                                <option value="<?php echo $row['PROGRAM_ID']; ?>"><?php echo $row['PROGRAM']."-".($row["P_RELEASE"]+$row["VERSION"]); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Report Type
                    </td>
                    <td>
                        <select id="reportType" name="reportType">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($reportTypeList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Severity
                    </td>
                    <td>
                        <select id="severity" name="severity">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($severityList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Functional Area
                    </td>
                    <td>
                        <select id="functionalArea" name="functionalArea">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($functionalAreaList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Assigned To 
                    </td>
                    <td>
                        <select id="assignedTo" name="assignedTo">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($employeeList)) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Status
                    </td>
                    <td>
                        <select id="status" name="status">
                            <?php while ($row = mysql_fetch_array($statusList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Priority
                    </td>
                    <td>
                        <select id="priority" name="priority">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($priorityList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Resolution
                    </td>
                    <td>
                        <select id="resolution" name="resolution">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($resolutionList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                
                <tr><td colspan="2"></br></td></tr>
                <tr>
                    <td>
                        Reported Date
                    </td>
                    <td>
                        <input type="text" id="reportedByDate" name="reportedByDate"/> 
                    </td>
                </tr>
                
                <tr><td colspan="2"></br></td></tr>
                <?php
                    if($_SESSION['user_role'] == 'User')
                    {
                ?>
                <input type = "hidden" name="reportedBy" value="<?php echo $_SESSION['user_id'] ?>" />
                <?php 
                    }
                    else
                    {    
                ?>
                <tr>
                    <td>
                        Reported By
                    </td>
                    <td>
                        
                        <select id="reportedBy" name="reportedBy">
                            <option value="%">--Select--</option>
                            <?php while ($row = mysql_fetch_array($reportedByList)) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <?php
                    }
                ?>
                
                <tr><td colspan="2"></br></td></tr>
            </table>
            
            <div align="center">
                <input type="submit" value="Submit"/>
                <input type="reset" value="Reset"/>
                <input type="button" value="Cancel" onClick="cancelAction()"/>
            </div>
            </fieldset>
        </form>
    </body>
</html>

