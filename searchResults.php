<?php
    require_once 'header.php';
?>

<html>
    <head>
        <style>
            tr:nth-of-type(odd) {
                background-color:#ccc;
            }
            
            tr, td, th {
                border-top-color:#DDDDDD;
                border-top-style:solid;
                border-top-width:1px;
                line-height:1.42857143;
                padding:7px;
                vertical-align:top;
            }
        </style>
    </head>
    <body style="font-family:verdana;">
        
    <?php
//    echo "</br>" . $_POST['program']."program";
//    echo "</br>" . $_POST['reportType'];
//    echo "</br>" . $_POST['severity'];
//    echo "</br>" . $_POST['functionalArea']."functional area";
//    echo "</br>" . $_POST['assignedTo'];
//    echo "</br>" . $_POST['status'];
//    echo "</br>" . $_POST['priority'];
//    echo "</br>" . $_POST['resolution'];
//    echo "</br>" . $_POST['reportedBy']."reportedby";
//    echo "</br>" . $_POST['reportedByDate'];

        $program = $_POST['program'];
        $reportType = $_POST['reportType'];
        $severity = $_POST['severity'];
        $reportedBy = $_POST['reportedBy'];
        $reportedByDate = $_POST['reportedByDate'];
        if($reportedByDate == "")
            $reportedByDate="%";
        $functionalArea = $_POST['functionalArea'];
        $assignedTo = $_POST['assignedTo'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $resolution = $_POST['resolution'];

        require_once 'dbConnection.php';
        
        $cond = "";
        if($functionalArea != '%')
            $cond.="and BI.FUNCTIONAL_AREA like ('$functionalArea')";
        if($assignedTo != '%')
            $cond.="and BI.ASSIGNED_TO like ('$assignedTo')";
        if($priority != '%')
            $cond.="and BI.PRIORITY like ('$priority')";
        if($resolution != '%')
            $cond.="and BI.RESOLUTION like ('$resolution')";
        
        //Get list of programs from DB
        $query = "SELECT DISTINCT(BUG_ID),PROGRAM,"
                . "(select constant_name from HARDCODED_VALUES where CONSTANT_ID = BI.REPORT_TYPE) as REPORT_TYPE, "
                . "(select constant_name from HARDCODED_VALUES where CONSTANT_ID = BI.SEVERITY) as SEVERITY,"
                . "(select constant_name from HARDCODED_VALUES where CONSTANT_ID = BI.STATUS) as STATUS_NAME"
                . ",SUMMARY,RESOLVED_BY,RESOLUTION_TESTER,(select FIRST_NAME from EMPLOYEE_INFORMATION where BI.ASSIGNED_TO=EMPLOYEE_ID) as ASSIGNED"
                . " FROM BUG_INFORMATION BI,PROGRAM_INFORMATION PI WHERE BI.PROGRAM_ID = PI.PROGRAM_ID "
                . "and BI.PROGRAM_ID like ('$program') and BI.REPORT_TYPE like ('$reportType') "
                . "and BI.SEVERITY like ('$severity') and BI.REPORTED_BY like ('$reportedBy')"
                . "and BI.STATUS like ('$status') and BI.REPORTED_BY_DATE like ('$reportedByDate')"
                . "$cond order by BUG_ID;";
        
        //echo $query;
        $resultSet = mysql_query($query);

        sizeOf($resultSet);
        $resultsArray = array();
        while ($row = mysql_fetch_array($resultSet)){
            //echo "bug_id".$row['BUG_ID'];
            $resultsArray[] = $row;
        }
        $size = sizeof($resultsArray);

        if ($size == 0) {
            ?>
            No results for the given search criteria.
        <?php
        } else {
            ?>
            <table align = "center" border="0.5">
                <tr>
                    <th>Bug Id</th>
                    <th>Program</th>
                    <th>Report Type</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Problem Summary</th>
                </tr>
        <?php
        foreach ($resultsArray as $row) {
        ?>
                    <tr>
                        <td>
                            <?php
                            if(($_SESSION['user_role'] == 'User') ||
                                    (($_SESSION['user_role'] == 'Programmer') &&
                                    ($_SESSION['user_id'] != $row['RESOLVED_BY']))
                                    || (($_SESSION['user_role'] == 'Tester') &&
                                    ($_SESSION['user_id'] != $row['RESOLUTION_TESTER'])))
                            {
                                echo $row['BUG_ID'];
                            }
                            else
                            {
                            ?>
                            <a href="updateBug.php?BUG_ID=<?php echo $row['BUG_ID'] ?>" ><?php echo $row['BUG_ID'] ?></a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['PROGRAM'] ?>
                        </td>
                        <td>
                            <?php echo $row['REPORT_TYPE'] ?>
                        </td>
                        <td>
                            <?php echo $row['SEVERITY'] ?>
                        </td>
                        <td>
                            <?php echo $row['STATUS_NAME'] ?>
                        </td>
                        <td>
                            <?php echo $row['ASSIGNED'] ?>
                        </td>
                        <td>
                            <?php echo $row['SUMMARY'] ?>
                        </td>
                    </tr>
        <?php
            }
        ?>
            </table>
        <?php } ?>
    </body>
</html>
