<?php

    session_start();
    
    require_once 'dbConnection.php';
    
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

    //mysql_close($con);
    
//    echo "</br>" . $_POST['program'];
//    echo "</br>" . $_POST['reportType'];
//    echo "</br>" . $_POST['severity'];
//    echo "</br>" . $_POST['problemSummary'];
//    echo "</br>" . $_POST['isReproducible'];
//    echo "</br>" . $_POST['problem'];
//    echo "</br>" . $_POST['suggestedFix'];
//    echo "</br>" . $_POST['reportedByDate'];
//    echo "</br>" . $_POST['functionalArea']."functional area";
//    echo "</br>" . $_POST['assignedTo']."assigned to";
//    echo "</br>" . $_POST['comments'];
//    echo "</br>" . $_POST['status']."status";
//    echo "</br>" . $_POST['priority'];
//    echo "</br>" . $_POST['resolutionVersion'];
//    echo "</br>" . $_POST['resolution'];
//    echo "</br>" . $_POST['resolvedBy']."resolved by";
//    echo "</br>" . $_POST['resolvedByDate'];
//    echo "</br>" . $_POST['testedBy']."tested by";
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
        
        $program = $_POST['version'];
        $reportType = $_POST['reportType'];
        $severity = $_POST['severity'];
        $problemSummary = trim($_POST['problemSummary']);
        $isReproducible = $_POST['isReproducible'];
        $problem = trim($_POST['problem']);
        $suggestedFix = trim($_POST['suggestedFix']);
        $reportedBy = $_SESSION['user_id'];
        $reportedByDate = $_POST['reportedByDate'];
        $functionalArea = $_POST['functionalArea'];
        $assignedTo = $_POST['assignedTo'];
        $comments = trim($_POST['comments']);
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $resolutionVersion = $_POST['resolutionVersion'];
        $resolution = $_POST['resolution'];
        $resolvedBy = $_POST['resolvedBy'];
        $resolvedByDate = $_POST['resolvedByDate'];
        $testedBy = $_POST['testedBy'];
        $testedByDate = $_POST['testedByDate'];
        $deferred = $_POST['deferred'];
        
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
            $cond="";
            if($_POST['status'])
                $cond.=", STATUS = '$status'";
            if($_POST['assignedTo'])
                $cond.=", ASSIGNED_TO = '$assignedTo'";
            if($_POST['resolvedBy'])
                $cond.=", RESOLVED_BY = '$resolvedBy'";
            if($_POST['testedByDate'])
                $cond.=", RESOLUTION_TESTER = '$testedBy'";
            
            $query = "UPDATE BUG_INFORMATION SET FUNCTIONAL_AREA = $functionalArea,"
                    . "COMMENTS = '$comments', PRIORITY = '$priority', "
                    . "RESOLUTION_VERSION = $resolutionVersion, RESOLUTION = '$resolution',"
                    . "RESOLVED_DATE = '$resolvedByDate', TESTING_DATE = '$testedByDate', "
                    . "DEFECT_DEFERRED = '$deferred' $cond where BUG_ID = $bugId;";
            
            //echo $query;
            
            $stmt = $conn->prepare($query);
            
//            $stmt->bindParam(':functionalArea', $functionalArea);
//            $stmt->bindParam(':comments', $comments);
//            $stmt->bindParam(':priority', $priority);
//            $stmt->bindParam(':resolutionVersion', $resolutionVersion);
//            $stmt->bindParam(':resolution', $resolution);
//            $stmt->bindParam(':resolvedByDate', $resolvedByDate);
//            $stmt->bindParam(':testedBy', $testedBy);
//            $stmt->bindParam(':deferred', $deferred);
//            
//            if($_POST['status'])
//                $stmt->bindParam(':status', $status);
//            if($_POST['assignedTo'])
//                $stmt->bindParam(':assignedTo', $assignedTo);
//            if($_POST['resolvedBy'])
//                $stmt->bindParam(':resolvedBy', $resolvedBy);
//            if($_POST['testedByDate'])
//                $stmt->bindParam(':testedByDate', $testedByDate);
            //mysql_query($query);    
        }
        else {
            // prepare sql and bind parameters
            $stmt = $conn->prepare("INSERT INTO BUG_INFORMATION(BUG_ID, PROGRAM_ID, REPORT_TYPE,"
                    . "SEVERITY, SUMMARY, REPRODUCIBLE, REPRODUCTION_STEPS, SUGGESTED_FIX, REPORTED_BY,"
                    . "REPORTED_BY_DATE, STATUS) VALUES (:bugId, :program, :reportType, :severity,"
                    . ":problemSummary, :isReproducible, :problem, :suggestedFix, :reportedBy, :reportedByDate, :status);");
        
            $statusOpen = 'ST101';
            $stmt->bindParam(':bugId', $bugId);
            $stmt->bindParam(':program', $program);
            $stmt->bindParam(':reportType', $reportType);
            $stmt->bindParam(':severity', $severity);
            $stmt->bindParam(':problemSummary', $problemSummary);
            $stmt->bindParam(':isReproducible', $isReproducible);
            $stmt->bindParam(':problem', $problem);
            $stmt->bindParam(':suggestedFix', $suggestedFix);
            $stmt->bindParam(':reportedBy', $reportedBy);
            $stmt->bindParam(':reportedByDate', $reportedByDate);
            $stmt->bindParam(':status', $statusOpen);
            
            //Make directory for the current bug id 
            $target_dir = "/Users/vipinsharma/NetBeansProjects/BugHound/uploadedAttachments/".$bugId."/";
            mkdir($target_dir);
            
            //save attachments in the directory created
            //$target_dir = "/Users/vipinsharma/NetBeansProjects/BugHound/uploadedAttachments/";

            $count=sizeof($_FILES["fileToUpload"]["name"]);

            for($i=0;$i<$count;$i++)
            {
                $fileName = basename($_FILES["fileToUpload"]["name"][$i]);
                $target_file = $target_dir . $fileName;
                $uploadOk = 1;
                
                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
                
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                        //echo "<br/>The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                    } else {
                        //echo "<br/>Sorry, there was an error uploading your file.";
                    }
                }
                $attachmentQuery = "INSERT INTO BUG_ATTACHMENTS VALUES ($bugId,'$fileName','$target_file');";
                //echo $attachmentQuery;
                mysql_query($attachmentQuery);
            }
        }

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