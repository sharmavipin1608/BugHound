<?php
    require_once 'header.php';
    
    require_once('dbConnection.php');

    //Get list of programs from DB
    $programList = mysql_query("SELECT DISTINCT(PROGRAM) FROM PROGRAM_INFORMATION;");

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
        <script src="formValidation.js"></script>
        <script>
            $(function () {
                var date = new Date();
                
                $("#reportedByDate").val(date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate());
                
                //$("#datepicker").datepicker({dateFormat: "yy-mm-dd"}).val();

//                $("#resolvedByDate").datepicker(
//                        {
//                            maxDate: new Date(),
//                            beforeShow: function ()
//                            {
//                                jQuery(this).datepicker('option', 'minDate', jQuery('#reportedByDate').val());
//                            },
//                            altFormat: "dd/mm/yy",
//                            dateFormat: 'yy-mm-dd'
//                        }
//                );
//
//                $("#testedByDate").datepicker(
//                        {
//                            maxDate: new Date(),
//                            beforeShow: function ()
//                            {
//                                jQuery(this).datepicker('option', 'minDate', jQuery('#resolvedByDate').val());
//                            },
//                            altFormat: "dd/mm/yy",
//                            dateFormat: 'yy-mm-dd'
//                        }
//                );
            });
        </script>
        
        <script>
            
            
            function loadRelease(program)
            {
                //alert("trial"+inner);
                var ajaxRequest = new XMLHttpRequest();
                document.getElementById("version").innerHTML = '<option value="">--Select--</option>';
                
                ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                    //alert("success - "+ajaxRequest.responseText);
                    var ajaxDisplay = document.getElementById('release');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
                }
                
                ajaxRequest.open("GET", "releaseAndVersionAjax.php?program="+program, true);
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
                    //alert("success - "+ajaxRequest.responseText);
                    var ajaxDisplay = document.getElementById('version');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
                }
                
                ajaxRequest.open("GET", "releaseAndVersionAjax.php?program="+program+"&release="+release, true);
                ajaxRequest.send(null);
            }
        </script>
    </head>
    
    <body style="font-family:verdana;">
        <form action="saveOrUpdateBug.php" method="POST" id="bugReport" enctype="multipart/form-data">
            <table width = "100%">
                <tr>
                    <td>
                        <label for="program">Program<span style="color:red">*</span></label>
                        <select id="program" name="program" class="mandatory" onchange="loadRelease(this.value)">
                            <option value="">--Select--</option>
                            <?php while ($row = mysql_fetch_array($programList)) { ?>
                                <option value="<?php echo $row['PROGRAM']; ?>" ><?php echo $row['PROGRAM']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    
                    <td>
                        <label for="release">Release<span style="color:red">*</span></label>
                        <select id="release" name="release" class="mandatory" onchange="loadVersion(this.value)">
                            <option value="">--Select--</option>
                        </select>
                    </td>
                    
                    <td>
                        <label for="version">Version<span style="color:red">*</span></label>
                        <select id="version" name="version" class="mandatory">
                            <option value="">--Select--</option>
                        </select>
                    </td>
                </tr>
                
                <tr><td colspan="3"></br></td></tr>
                
                <tr>
                    <td>
                        <label for="reportType">Report Type<span style="color:red">*</span></label>
                        <select id="reportType" name="reportType" class="mandatory">
                            <option value="">--Select--</option>
                            <?php while ($row = mysql_fetch_array($reportTypeList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>

                    <td>
                        <label for="severity">Severity<span style="color:red">*</span></label>
                        <select id="severity" name="severity" class="mandatory">
                            <option value="">--Select--</option>
                            <?php while ($row = mysql_fetch_array($severityList)) { ?>
                                <option value="<?php echo $row['CONSTANT_ID']; ?>"><?php echo $row['CONSTANT_NAME']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                
                <tr><td colspan="3"></br></td></tr>

                <tr>
                    <td colspan="2">
                        <label for="problemSummary">Problem Summary<span style="color:red">*</span></label>
                        <input type="text" id="problemSummary" name="problemSummary" class="mandatory" value="" style="width:700px"/>
                    </td>

                    <td>
                        <label for="isReproducible">Reproducible?</label>
                        <input id="isReproducible" type="checkbox" name="isReproducible" value="Yes"/>
                    </td>
                </tr>
                
                <tr><td colspan="3"></br></td></tr>

                <tr>
                    <td colspan="3">
                        <label for="problem">Problem<span style="color:red">*</span></label>
                        <textarea id="problem" style="width:100%" name="problem" class="mandatory"></textarea>
                    </td>
                </tr>
                
                <tr><td colspan="3"></br></td></tr>

                <tr>
                    <td colspan="3">
                        <label for="suggestedFix">Suggested Fix</label>
                        <textarea id="suggestedFix" style="width:100%" name="suggestedFix"></textarea>
                    </td>
                </tr>
                
                <tr><td colspan="3"></br></td></tr>

                <tr>
                    <td>
                        <label for="reportedBy">Reported By<span style="color:red">*</span></label>
<!--                        <select id="reportedBy" name="reportedBy">
                            <?php foreach ($result_list as $row) { ?>
                                <option value="<?php echo $row['EMPLOYEE_ID']; ?>"><?php echo $row['FIRST_NAME']; ?></option>
                            <?php } ?>
                        </select>-->
                        &nbsp;&nbsp;
                        <b><?php echo $_SESSION['user_name'] ?></b>
                    </td>

                    <td>
                        <label for="reportedByDate">Date<span style="color:red">*</span></label>
                        <input type="date" id="reportedByDate" name="reportedByDate" readonly="true"/>
                    </td>
                </tr>            

                <tr><td colspan="3"></br><hr/></br></td></tr>                
            </table>
            
            <fieldset>
                <legend>Attachments</legend>
                <div id="attachmentSection">
                    <input type="file" name="fileToUpload[]"/>
                </div>
                <div width="100%" align="right">
                    <input type="button" value="Add Another Attachment" onclick="addAttachment();"/>
                </div>
            </fieldset>
            
            <div align="center">
                <input type="button" value="Submit" onclick="formValidation(this.form.id)"/>
                <input type="reset" value="Reset"/>
                <input type="button" value="Cancel" onClick="cancelAction()"/>
            </div>
        </form>
    </body>
</html>

