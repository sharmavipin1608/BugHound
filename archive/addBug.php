<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'header.php';
?>
<?php
            $con = mysql_connect("localhost", "root", "root");
            if (!$con) {
                die('Could not connect: ' . mysql_error());
            }

            mysql_select_db("BugHound", $con);

            //Get list of programs from DB
            $programList = mysql_query("SELECT * FROM PROGRAM_INFORMATION;");

            //Get list of report type
            $reportTypeList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Report Type';");

            //Get list of Severity
            $severityList = mysql_query("SELECT * FROM HARDCODED_VALUES where FIELD = 'Severity';");

            //Get list of employees
            $employeeList = mysql_query("SELECT * FROM EMPLOYEE_INFORMATION;");
            $result_list = array();
            while ($row = mysql_fetch_array($employeeList)) {
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
            ?>
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
                
                $("#reportedByDate").val(date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate());
                
                $("#datepicker").datepicker({dateFormat: "yy-mm-dd"}).val();

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
                //alert("form validation");//+document.getElementById("programId").value);
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
        
        <script>
            
            
            function loadRelease(program)
            {
                //alert("trial"+inner);
                var ajaxRequest = new XMLHttpRequest();
                document.getElementById("version").innerHTML = '<label for="version">Version<span style="color:red">*</span></label>';
                
                ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                    //alert("success - "+ajaxRequest.responseText);
                    var ajaxDisplay = document.getElementById('release');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
                }
                
                ajaxRequest.open("GET", "ajax-example.php?program="+program, true);
                ajaxRequest.send(null);
            }
            
            function loadVersion(release)
            {
                var e = document.getElementById("program");
                var program = e.options[e.selectedIndex].value;
                //alert(program);
                //alert("load version"+release);
                var ajaxRequest = new XMLHttpRequest();
                
                ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                    alert("success - "+ajaxRequest.responseText);
                    var ajaxDisplay = document.getElementById('version');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
                }
                
                ajaxRequest.open("GET", "ajax-example.php?program="+program+"&release="+release, true);
                ajaxRequest.send(null);
            }
        </script>
    </head>
    
    <body style="font-family:verdana;">
        <form action="saveAndUpdateResultsDB.php" method="POST" id="bugReport">
            

            <table width = "100%">
                <tr>
                    <td>
                        <label for="program">Program<span style="color:red">*</span></label>
                        <select id="program" name="program" onchange="loadRelease(this.value)">
                            <option value="">--Select--</option>
                            <?php while ($row = mysql_fetch_array($programList)) { ?>
                                <option value="<?php echo $row['PROGRAM']; ?>" ><?php echo $row['PROGRAM']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    
                    <td>
                        <label for="release">Release<span style="color:red">*</span></label>
                        <select id="release" name="release" onchange="loadVersion(this.value)">
                            <option value="">--Select--</option>
                        </select>
                    </td>
                    
                    <td>
                        <div id="version">
                            <label for="version">Version<span style="color:red">*</span></label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportType">Report Type<span style="color:red">*</span></label>
                        <select id="reportType" name="reportType">
                            <?php while ($row = mysql_fetch_array($reportTypeList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="severity">Severity<span style="color:red">*</span></label>
                        <select id="severity" name="severity">
                            <?php while ($row = mysql_fetch_array($severityList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="problemSummary">Problem Summary<span style="color:red">*</span></label>
                        <input type="text" id="problemSummary" name="problemSummary" value="" style="width:700px"/>
                    </td>

                    <td>
                        <label for="isReproducible">Reproducible?</label>
                        <input id="isReproducible" type="checkbox" name="isReproducible" value="Yes"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="problem">Problem<span style="color:red">*</span></label>
                        <textarea id="problem" style="width:100%" name="problem"></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="suggestedFix">Suggested Fix<span style="color:red">*</span></label>
                        <textarea id="suggestedFix" style="width:100%" name="suggestedFix"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="reportedBy">Reported By<span style="color:red">*</span></label>
                        <select id="reportedBy" name="reportedBy">
                            <?php foreach ($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="reportedByDate">Date<span style="color:red">*</span></label>
                        <input type="date" id="reportedByDate" name="reportedByDate" readonly="true"/>
                    </td>
                </tr>            

                <tr><td colspan="3"></br><hr/></br></td></tr>

                <tr>
                    <td>
                        <label for="functionalArea">Functional Area</label>
                        <select id="functionalArea" name="functionalArea">
                            <?php while ($row = mysql_fetch_array($functionalAreaList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="assignedTo">Assigned To</label>
                        <select id="assignedTo" name="assignedTo">
                            <?php foreach ($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="comments">Comments</label>
                        <textarea id="comments" name="comments" style="width:100%"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <?php while ($row = mysql_fetch_array($statusList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <?php while ($row = mysql_fetch_array($priorityList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="resolutionVersion">Resolution Version</label>
                        <select id="resolutionVersion" name="resolutionVersion">
                            <option value="Minor">Minor</option>
                            <option value="Serious">Serious</option>
                            <option value="Fatal">Fatal</option>
                        </select>
                    </td>

                    <td>
                        <label for="resolution">Resolution</label>
                        <select id="resolution" name="resolution">
                            <?php while ($row = mysql_fetch_array($resolutionList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="resolvedBy">Resolved By</label>
                        <select id="resolvedBy" name="resolvedBy">
                            <?php foreach ($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="resolvedByDate">Date</label>
                        <input type="text" id="resolvedByDate" name="resolvedByDate" style="width:80px"/>
                    </td>

                    <td>
                        <label for="testedBy">Tested By</label>
                        <select id="testedBy" name="testedBy">
                            <?php foreach ($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="testedByDate">Date</label>
                        <input type="text" id="testedByDate" name="testedByDate" style="width:80px"/>
                    </td>

                    <td>
                        <label for="deferred">Treat as deferred?</label>
                        <input id="deferred" type="checkbox" name="deferred" value="Yes"/>
                    </td>
                </tr>

                <tr><td colspan="3"></br><hr/></br></td></tr>

                <tr>
                    <td>
                        <input type="button" value="Submit" onclick="formValidation()"/>
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
