<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>BugHound</title>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            $(function () {
                var date = new Date();
                
                $("#resolvedByDate").datepicker(
                        {
                            maxDate: new Date(),
                            beforeShow: function ()
                            {
                                jQuery(this).datepicker('option', 'minDate', jQuery('#reportedByDate').val());
                            },
                            altFormat: "dd/mm/yy",
                            dateFormat: 'yy-mm-dd'
                        }
                );

                $("#testedByDate").datepicker(
                        {
                            maxDate: new Date(),
                            beforeShow: function ()
                            {
                                jQuery(this).datepicker('option', 'minDate', jQuery('#resolvedByDate').val());
                            },
                            altFormat: "dd/mm/yy",
                            dateFormat: 'yy-mm-dd'
                        }
                );
            });
        </script>
        
        <script type="text/javascript">
            
            function formValidation(){
                //alert("form validation");
                var mandatoryFields = ["problemSummary","problem","suggestedFix"];
                var submit = true;
                for(var i=0;i<mandatoryFields.length;i++){
                    if(document.getElementById(mandatoryFields[i]).value == ""){
                        document.getElementById(mandatoryFields[i]).style.borderColor = "red";
                        submit = false;
                    }
                }
                
                if(submit)
                    document.getElementById('bugReport').submit();
            }
                       
        </script>
    </head>
    <body style="font-family:verdana;">
        <form action="saveAndUpdateResultsDB.php?BUG_ID=<?php echo $_GET['BUG_ID'] ?>" method="POST" target="_parent" id="bugReport">
            <?php
                $con = mysql_connect("localhost","root","root");
                if (!$con)
                {
                    die('Could not connect: ' . mysql_error());
                }

                mysql_select_db("BugHound", $con);

                $bugId = $_GET['BUG_ID'];
                
                //Get Bug details from DB
                $retrieveBug = mysql_query("SELECT * FROM BUG_INFORMATION where BUG_ID = $bugId;");
                $bugDetails = mysql_fetch_array($retrieveBug);
                
                //Get list of programs from DB
                $query = "SELECT * FROM PROGRAM_INFORMATION where PROGRAM_ID = ".$bugDetails['PROGRAM_ID'];
                $programList = mysql_query($query);
                $programDetails = mysql_fetch_array($programList);

                //Get list of report type
                $reportTypeList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Report Type';");

                //Get list of Severity
                $severityList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Severity';");

                //Get list of employees
                $employeeList = mysql_query("SELECT * FROM EMPLOYEE_INFORMATION;");
                $result_list = array();
                while($row = mysql_fetch_array($employeeList)) {
                   $result_list[] = $row;
                }
                //Get list of functional areas
                $functionalAreaList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Functional Area';");

                //Get list of Status
                $statusList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Status';");

                //Get list of Priority
                $priorityList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Priority';");

                //Get list of resolution
                $resolutionList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Resolution';");
                
                //echo $bugDetails['TESTING_DATE'];
            ?>

            <table width = "100%">
                <h1>BugHound</h1>
                <hr>

                <h2 align = "center">Bug Id # <?php echo $bugId ?></h2>
                <tr>
                    <td>
                        <label for="program">Program</label>
                        <!--<select id="program" name="program">
                            <?php 
                                //while ( $row = mysql_fetch_array($programList) ) { ?>
                                <option value="<?php echo $row['PROGRAM_ID']; ?>" <?php if($bugDetails['PROGRAM_ID'] == $row['PROGRAM_ID']) print 'selected = "selected"' ?> ><?php echo $row['PROGRAM']; ?></option>
                            <?php //} ?>
                        </select>-->
                        <input type="text" readonly="true" id="program" value="<?php echo $programDetails['PROGRAM']; ?>"/>
                        <input type="hidden" id="programId" name="programId" value="<?php echo $programDetails['PROGRAM_ID']; ?>" />
                    </td>

                    <td>
                        <label for="release">Release<span style="color:red">*</span></label>
                        <!--<select id="release" name="release" >
                            <option value="">--Select--</option>
                        </select>-->
                        <input type="text" id="release" readonly="true" value="<?php echo $programDetails['P_RELEASE']; ?>" />
                    </td>
                    
                    <td>
                        <label for="version">Version<span style="color:red">*</span></label>
                        <input type="text" id="version" readonly="true" value="<?php echo $programDetails['VERSION']; ?>" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportType">Report Type</label>
                        <select id="reportType" name="reportType">
                            <?php 
                                while ( $row = mysql_fetch_array($reportTypeList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['REPORT_TYPE'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="severity">Severity</label>
                        <select id="severity" name="severity">
                            <?php 
                                while ( $row = mysql_fetch_array($severityList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['SEVERITY'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="problemSummary">Problem Summary</label>
                        <input type="text" id="problemSummary" name="problemSummary" value="<?php echo $bugDetails['SUMMARY']; ?>" style="width:700px"/>
                    </td>

                    <td>
                        <label for="isReproducible">Reproducible?</label>
                        <input id="isReproducible" type="checkbox" name="isReproducible" value="Yes" <?php if($bugDetails['REPRODUCIBLE'] == 'Yes') print checked; ?> />
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="problem">Problem</label>
                        <textarea id="problem" style="width:100%" name="problem"><?php echo $bugDetails['REPRODUCTION_STEPS']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="suggestedFix">Suggested Fix</label>
                        <textarea id="suggestedFix" style="width:100%" name="suggestedFix"><?php echo $bugDetails['SUGGESTED_FIX']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportedBy">Reported By</label>
                        <select id="reportedBy" name="reportedBy">
                            <?php 
                                foreach($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['REPORTED_BY'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="reportedByDate">Date</label>
                        <input type="text" readonly="true" id="reportedByDate" name="reportedByDate" value="<?php echo $bugDetails['REPORTED_BY_DATE']; ?>"/>
                    </td>
                </tr>            

                <tr><td colspan="3"></br><hr/></br></td></tr>

                <tr>
                    <td>
                        <label for="functionalArea">Functional Area</label>
                        <select id="functionalArea" name="functionalArea">
                            <?php 
                                while ( $row = mysql_fetch_array($functionalAreaList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['FUNCTIONAL_AREA'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="assignedTo">Assigned To</label>
                        <select id="assignedTo" name="assignedTo">
                            <?php 
                                foreach($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['ASSIGNED_TO'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="comments">Comments</label>
                        <textarea id="comments" name="comments" style="width:100%"><?php echo $bugDetails['COMMENTS']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <?php 
                                while ( $row = mysql_fetch_array($statusList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['STATUS'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <?php 
                                while ( $row = mysql_fetch_array($priorityList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['PRIORITY'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="resolutionVersion">Resolution Version</label>
                        <select id="resolutionVersion" name="resolutionVersion">
                            <option value="Minor" <?php if($bugDetails['RESOLUTION_VERSION'] == "Minor") print 'selected = "selected"' ?> >Minor</option>
                            <option value="Serious" <?php if($bugDetails['RESOLUTION_VERSION'] == "Serious") print 'selected = "selected"' ?>>Serious</option>
                            <option value="Fatal" <?php if($bugDetails['RESOLUTION_VERSION'] == "Fatal") print 'selected = "selected"' ?>>Fatal</option>
                        </select>
                    </td>

                    <td>
                        <label for="resolution">Resolution</label>
                        <select id="resolution" name="resolution">
                            <?php 
                                while ( $row = mysql_fetch_array($resolutionList) ) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>" <?php if($bugDetails['RESOLUTION'] == $row['CONSTANT_ID']) print 'selected = "selected"' ?> ><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="resolvedBy">Resolved By</label>
                        <select id="resolvedBy" name="resolvedBy">
                            <?php 
                                foreach($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['RESOLVED_BY'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="resolvedByDate">Date</label>
                        <input type="text" id="resolvedByDate" name="resolvedByDate" style="width:80px" value="<?php if($bugDetails['RESOLVED_DATE'] != '0000-00-00') echo $bugDetails['RESOLVED_DATE']; ?>"/>
                    </td>

                    <td>
                        <label for="testedBy">Tested By</label>
                        <select id="testedBy" name="testedBy">
                            <?php 
                                foreach($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['RESOLUTION_TESTER'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="testedByDate">Date</label>
                        <input type="text" id="testedByDate" name="testedByDate" style="width:80px" value="<?php if($bugDetails['TESTING_DATE'] != '0000-00-00') echo $bugDetails['TESTING_DATE']; ?>"/>
                    </td>

                    <td>
                        <label for="deferred">Treat as deferred?</label>
                        <input id="deferred" type="checkbox" name="deferred" value="Yes" <?php if($bugDetails['DEFECT_DEFERRED'] == 'Yes') print checked; ?>/>
                    </td>
                </tr>

                <tr><td colspan="3"></br><hr/></br></td></tr>

                <tr>
                    <td>
                        <input type="button" value="Submit" onclick="formValidation();"/>
                    </td>

                    <td>
                        <input type="reset" value="Reset"/>
                    </td>

                    <td>
                        <input type="button" value="Cancel"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
