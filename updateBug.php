<html>
    <head>
        <meta charset="UTF-8">
        <title>BugHound</title>
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="formValidation.js"></script>
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
    </head>
    <body style="font-family:verdana;">
        <form action="saveOrUpdateBug.php?BUG_ID=<?php echo $_GET['BUG_ID'] ?>" method="POST" id="bugReport">
            <?php
                require_once 'dbConnection.php';
                require_once 'header.php';

                $bugId = $_GET['BUG_ID'];
                
                //Get Bug details from DB
                $retrieveBug = mysql_query("SELECT * FROM BUG_INFORMATION where BUG_ID = $bugId;");
                $bugDetails = mysql_fetch_array($retrieveBug);
                
                //echo $bugDetails['RESOLUTION_VERSION'];
                
                //populate resolution version list
                $query = "SELECT * FROM PROGRAM_INFORMATION WHERE PROGRAM LIKE ("."SELECT PROGRAM FROM PROGRAM_INFORMATION WHERE PROGRAM_ID = ".$bugDetails['PROGRAM_ID'].") order by PROGRAM,P_RELEASE,VERSION;";
                $programResolutionVersion = mysql_query($query);
                
                //Get list of programs from DB
//                $query = "SELECT * FROM PROGRAM_INFORMATION where PROGRAM_ID = ".$bugDetails['PROGRAM_ID'];
//                $programList = mysql_query($query);
//                $programDetails = mysql_fetch_array($programList);

                //Get list of report type
                $reportTypeList = mysql_query("SELECT CONSTANT_NAME FROM HARDCODED_VALUES, BUG_INFORMATION where BUG_ID = $bugId AND REPORT_TYPE = CONSTANT_ID;");
                $reportType = mysql_fetch_array($reportTypeList);
                
                //Get list of Severity
                $severityList = mysql_query("SELECT CONSTANT_NAME FROM HARDCODED_VALUES, BUG_INFORMATION where BUG_ID = $bugId AND SEVERITY = CONSTANT_ID;");
                $severity = mysql_fetch_array($severityList);
                
                //Get list of employees
                $employeeList = mysql_query("SELECT * FROM EMPLOYEE_INFORMATION;");
                $result_list = array();
                while($row = mysql_fetch_array($employeeList)) {
                   $result_list[] = $row;
                }
                //Get list of functional areas
                //$programName = $programDetails["PROGRAM"];
                $query = "SELECT * FROM FUNCTIONAL_AREA where PROGRAM_ID = ".$bugDetails['PROGRAM_ID'];
                //echo $query;
                $functionalAreaList = mysql_query($query);

                //Get list of Status
                $statusList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Status';");

                //Get list of Priority
                $priorityList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Priority';");

                //Get list of resolution
                $resolutionList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Resolution';");
                
                //Get list of attachments
                $query = "SELECT * FROM BUG_ATTACHMENTS WHERE BUG_ID = ".$bugDetails['BUG_ID'];
                $attachmentList = mysql_query($query);
                //echo sizeof($attachmentList).$query;
                
                //echo $bugDetails['TESTING_DATE'];
            ?>
            
            <h2 align = "center">Bug Id # <?php echo $bugId ?></h2>
            
            <table width = "100%">
                <tr>
                    <td>
                        <label for="program">Program</label>
                        &nbsp;&nbsp;
                        <b><?php echo $programDetails['PROGRAM']; ?></b>
                    </td>

                    <td>
                        <label for="release">Release</label>
                        &nbsp;&nbsp;
                        <b><?php echo $programDetails['P_RELEASE']; ?></b>
                    </td>
                    
                    <td>
                        <label for="version">Version</label>
                        &nbsp;&nbsp;
                        <b><?php echo $programDetails['VERSION']; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportType">Report Type</label>
                        &nbsp;&nbsp;
                        <b><?php echo $reportType['CONSTANT_NAME'] ?></b>
                    </td>

                    <td>
                        <label for="severity">Severity</label>
                        &nbsp;&nbsp;
                        <b><?php echo $severity['CONSTANT_NAME'] ?></b>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="problemSummary">Problem Summary</label>
                        <input type="text" id="problemSummary" name="problemSummary" value="<?php echo $bugDetails['SUMMARY']; ?>" style="width:700px" readonly="true"/>
                    </td>

                    <td>
                        <label for="isReproducible">Reproducible?</label>
                        <input id="isReproducible" type="checkbox" name="isReproducible" value="Yes" <?php if($bugDetails['REPRODUCIBLE'] == 'Yes') print checked; ?> disabled="true"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="problem">Problem</label>
                        <textarea readonly="true" id="problem" style="width:100%" name="problem"><?php echo $bugDetails['REPRODUCTION_STEPS']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="suggestedFix">Suggested Fix</label>
                        <textarea readonly="true" id="suggestedFix" style="width:100%" name="suggestedFix"><?php echo $bugDetails['SUGGESTED_FIX']; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportedBy">Reported By</label>
                        <select id="reportedBy" name="reportedBy" disabled="true">
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
                                <option value="<?php echo $row['FUNCTIONAL_AREA_ID']; ?>" <?php if($bugDetails['FUNCTIONAL_AREA'] == $row['FUNCTIONAL_AREA_ID']) print 'selected = "selected"' ?> ><?php echo $row['FUNCTIONAL_AREA_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="assignedTo">Assigned To</label>
                        <select id="assignedTo" name="assignedTo" <?php if($_SESSION['user_role'] != 'Manager') print 'disabled = "true"'?> >
                            <?php 
                                foreach($result_list as $row) {
                                    if($row['ROLE'] == 'Manager'){?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['ASSIGNED_TO'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php }} ?>
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
                        <select id="status" name="status" <?php if($_SESSION['user_role'] != 'Manager') print 'disabled = "true"'?> >
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
                            <option value="">--Select--</option>
                            <?php while ($row = mysql_fetch_array($programResolutionVersion)) { ?>
                                <option value="<?php echo $row['PROGRAM_ID']; ?>" <?php if($bugDetails['RESOLUTION_VERSION'] == $row['PROGRAM_ID']) print 'selected = "selected"' ?> ><?php echo $row['PROGRAM']."-".($row["P_RELEASE"]+$row["VERSION"]); ?></option>
                            <?php } ?>
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
                        <select id="resolvedBy" name="resolvedBy" <?php if($_SESSION['user_role'] != 'Manager') print 'disabled = "true"'?> >
                            <?php 
                                foreach($result_list as $row) { 
                                    if($row['ROLE'] == 'Programmer'){
                            ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['RESOLVED_BY'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                                <?php }} ?>
                        </select>

                        <label for="resolvedByDate">Date</label>
                        <input type="text" id="resolvedByDate" name="resolvedByDate" style="width:80px" value="<?php if($bugDetails['RESOLVED_DATE'] != '0000-00-00') echo $bugDetails['RESOLVED_DATE']; ?>"/>
                    </td>

                    <td>
                        <label for="testedBy">Tested By</label>
                        <select id="testedBy" name="testedBy" <?php if($_SESSION['user_role'] != 'Manager') print 'disabled = "true"'?> >
                            <?php 
                                foreach($result_list as $row) { 
                                    if($row['ROLE'] == 'Tester'){
                            ?>        
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>" <?php if($bugDetails['RESOLUTION_TESTER'] == $row['EMPLOYEE_ID']) print 'selected = "selected"' ?> ><?php echo $row['FIRST_NAME']; ?></option>
                            <?php }} ?>
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
            </table>
            
            <?php
            while($row = mysql_fetch_array($attachmentList))
            {
                $url = "downloadAttachments.php?file=".$row['ATTACHMENT_PATH'];
//                echo $url;
            ?>
                <a href="<?php echo $url ?>" > <?php echo $row['ATTACHMENT_NAME'] ?> </a>
                <br/>
                
            <?php
            }
            ?>
            <div align="center">
                    <input type="button" value="Submit" onclick="formValidation(this.form.id)"/>
                    <input type="reset" value="Reset"/>
                    <input type="button" value="Cancel" onClick="cancelAction()"/>
            </div>
        </form>
    </body>
</html>
