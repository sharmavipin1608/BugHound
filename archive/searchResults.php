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

        $con = mysql_connect("localhost", "root", "root");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db("BugHound", $con);

        //Get list of programs from DB
        $resultSet = mysql_query("SELECT DISTINCT(BUG_ID),PROGRAM,"
                . "(select constant_name from HARDCODED_VALUES where CONSTANT_ID = BI.REPORT_TYPE) as REPORT_TYPE, "
                . "(select constant_name from HARDCODED_VALUES where CONSTANT_ID = BI.SEVERITY) as SEVERITY"
                . ",SUMMARY FROM BUG_INFORMATION BI,PROGRAM_INFORMATION PI WHERE BI.PROGRAM_ID = PI.PROGRAM_ID "
                . "and BI.PROGRAM_ID like ('$program') and BI.REPORT_TYPE like ('$reportType') "
                . "and BI.SEVERITY like ('$severity') and BI.REPORTED_BY like ('$reportedBy') and BI.FUNCTIONAL_AREA "
                . "like ('$functionalArea') and BI.ASSIGNED_TO like ('$assignedTo') "
                . "and BI.STATUS like ('$status') and BI.REPORTED_BY_DATE like ('$reportedByDate')"
                . "and BI.PRIORITY like ('$priority') and BI.RESOLUTION like ('$resolution') order by BUG_ID;");

        $resultsArray = array();
        while ($row = mysql_fetch_array($resultSet))
            $resultsArray[] = $row;

        $size = sizeof($resultsArray);
//    echo "</br>".$size;
//    foreach($resultsArray as $row)
//        echo "</br>".$row['BUG_ID'];

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
                    <th>Problem Summary</th>
                </tr>
        <?php
        foreach ($resultsArray as $row) {
        ?>
                    <tr>
                        <td>
                            <a href="updateBug.php?BUG_ID=<?php echo $row['BUG_ID'] ?>" target="_parent"><?php echo $row['BUG_ID'] ?></a>
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
