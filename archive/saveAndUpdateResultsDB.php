<?php

    $con = mysql_connect("localhost", "root", "root");
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db("BugHound", $con);
    
    //echo "reporteddate".$_POST['reportedByDate'];
    
    //Updating record
    if($_GET['BUG_ID'] != ""){
        $bugId = $_GET['BUG_ID'];
        $update = true;
    }
    else{
        //Get list of programs from DB
        $maxBugId = mysql_query("SELECT max(BUG_ID) as BUG_ID FROM BUG_INFORMATION;");

        while ($row = mysql_fetch_array($maxBugId))
            $bugId = $row['BUG_ID'] + 1;
        if($bugId == 1)
            $bugId = 101;
        //echo $max . "max";
    }

    mysql_close($con);
    
//    echo "</br>" . $_POST['program'];
//    echo "</br>" . $_POST['reportType'];
//    echo "</br>" . $_POST['severity'];
//    echo "</br>" . $_POST['problemSummary'];
//    echo "</br>" . $_POST['isReproducible'];
//    echo "</br>" . $_POST['problem'];
//    echo "</br>" . $_POST['suggestedFix'];
//    echo "</br>" . $_POST['reportedByDate'];
//    echo "</br>" . $_POST['functionalArea']."functional area";
//    echo "</br>" . $_POST['assignedTo'];
//    echo "</br>" . $_POST['comments'];
//    echo "</br>" . $_POST['status'];
//    echo "</br>" . $_POST['priority'];
//    echo "</br>" . $_POST['resolutionVersion'];
//    echo "</br>" . $_POST['resolution'];
//    echo "</br>" . $_POST['resolvedBy'];
//    echo "</br>" . $_POST['resolvedByDate'];
//    echo "</br>" . $_POST['testedBy'];
//    echo "</br>" . $_POST['testedByDate'];
//    echo "</br>" . $_POST['deferred'] . "DEFERRED";

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "BugHound";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if($update)
        {
            /*
             * , REPRODUCTION_STEPS :problem,"
                    . " REPORTED_BY :reportedBy, REPORTED_BY_DATE :reportedByDate, FUNCTIONAL_AREA :functionalArea,"
                    . "ASSIGNED_TO :assignedTo, COMMENTS :comments, STATUS :status, PRIORITY :priority, "
                    . "RESOLUTION_VERSION :resolutionVersion, RESOLUTION :resolution, RESOLVED_BY :resolvedBy,"
                    . "RESOLVED_DATE :resolvedByDate, RESOLUTION_TESTER :testedBy, TESTING_DATE :testedByDate, "
                    . "DEFECT_DEFERRED :deferred
             */
            $stmt = $conn->prepare("UPDATE BUG_INFORMATION SET PROGRAM_ID = :program, REPORT_TYPE = :reportType, SEVERITY = :severity,"
                    . "SUMMARY = :problemSummary, REPRODUCIBLE = :isReproducible, REPRODUCTION_STEPS = :problem,"
                    . "SUGGESTED_FIX = :suggestedFix, REPORTED_BY = :reportedBy, REPORTED_BY_DATE = :reportedByDate, FUNCTIONAL_AREA = :functionalArea,"
                    . "ASSIGNED_TO = :assignedTo, COMMENTS = :comments, STATUS = :status, PRIORITY = :priority, "
                    . "RESOLUTION_VERSION = :resolutionVersion, RESOLUTION = :resolution, RESOLVED_BY = :resolvedBy,"
                    . "RESOLVED_DATE = :resolvedByDate, RESOLUTION_TESTER = :testedBy, TESTING_DATE = :testedByDate, "
                    . "DEFECT_DEFERRED = :deferred where BUG_ID = $bugId;");
        }
        else {
            // prepare sql and bind parameters
            $stmt = $conn->prepare("INSERT INTO BUG_INFORMATION VALUES (:bugId, :program, :reportType, :severity,"
                    . ":problemSummary, :isReproducible, :problem, :suggestedFix, :reportedBy, :reportedByDate, :functionalArea,"
                    . ":assignedTo, :comments, :status, :priority, :resolutionVersion, :resolution, :resolvedBy,"
                    . ":resolvedByDate, :testedBy, :testedByDate, :deferred);");
        
            $stmt->bindParam(':bugId', $bugId);
        }

        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':reportType', $reportType);
        $stmt->bindParam(':severity', $severity);
        $stmt->bindParam(':problemSummary', $problemSummary);
        $stmt->bindParam(':isReproducible', $isReproducible);
        $stmt->bindParam(':problem', $problem);
        $stmt->bindParam(':suggestedFix', $suggestedFix);
        $stmt->bindParam(':reportedBy', $reportedBy);
        $stmt->bindParam(':reportedByDate', $reportedByDate);
        $stmt->bindParam(':functionalArea', $functionalArea);
        $stmt->bindParam(':assignedTo', $assignedTo);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':resolutionVersion', $resolutionVersion);
        $stmt->bindParam(':resolution', $resolution);
        $stmt->bindParam(':resolvedBy', $resolvedBy);
        $stmt->bindParam(':resolvedByDate', $resolvedByDate);
        $stmt->bindParam(':testedBy', $testedBy);
        $stmt->bindParam(':testedByDate', $testedByDate);
        $stmt->bindParam(':deferred', $deferred);

        //echo "maximum value : ".$bugId;
        //$bugId = $max + 1;
        $program = $_POST['programId'];
        $reportType = $_POST['reportType'];
        $severity = $_POST['severity'];
        $problemSummary = $_POST['problemSummary'];
        $isReproducible = $_POST['isReproducible'];
        $problem = $_POST['problem'];
        $suggestedFix = $_POST['suggestedFix'];
        $reportedBy = $_POST['reportedBy'];
        $reportedByDate = $_POST['reportedByDate'];
        $functionalArea = $_POST['functionalArea'];
        $assignedTo = $_POST['assignedTo'];
        $comments = $_POST['comments'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $resolutionVersion = $_POST['resolutionVersion'];
        $resolution = $_POST['resolution'];
        $resolvedBy = $_POST['resolvedBy'];
        $resolvedByDate = $_POST['resolvedByDate'];
        $testedBy = $_POST['testedBy'];
        $testedByDate = $_POST['testedByDate'];
        $deferred = $_POST['deferred'];

        $stmt->execute();

        //echo "New records created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
?>

<html>
    <head>
        <title>Success Page</title>
    </head>
    <body style="font-family:verdana;">
        <?php include("homePage.php");?>
        
        <br/>
        <br/><br/>
        <h1 style="background-color:greenyellow">
            <?php if($update) {?>
                Bug Id #<?php echo $bugId?> updated successfully.
            <?php } else { ?>
                Bug Id #<?php echo $bugId?> saved successfully.
            <?php } ?>
        </h1>
        
    </body>
</html>