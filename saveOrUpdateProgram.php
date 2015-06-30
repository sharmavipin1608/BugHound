<?php
    require_once 'dbConnection.php';

    $operation = $_GET['operation'];
    
    if($_POST['programName'] != "")
    {
        $resultProgram = mysql_query("SELECT MAX(PROGRAM_ID) as PROGRAM_ID FROM PROGRAM_INFORMATION;");

        while ($row = mysql_fetch_array($resultProgram))
            $programId = $row['PROGRAM_ID'] + 1;
        
        if($programId == 1)
            $programId = 101;
            
        if($operation == 'addProgram')
        {
            $programName = strtoupper($_POST['programName']);
            $programRelease = '1.0';
            $programVersion = '.01';
        }
        
        else if($operation == 'addRelease')
        {
            $programName = $_POST['programName'];
            
            $result = mysql_query("SELECT MAX(P_RELEASE) as P_RELEASE FROM PROGRAM_INFORMATION WHERE PROGRAM = '$programName';");

            while ($row = mysql_fetch_array($result)){
                $programRelease = $row['P_RELEASE'] + 1.0;
            }
            
            $programVersion = '.01';
        }
        
        else if($operation == 'addVersion')
        {
            $programName = $_POST['programName'];
            
            $programRelease = $_POST['release'];
            $result = mysql_query("SELECT MAX(VERSION) as VERSION FROM PROGRAM_INFORMATION WHERE PROGRAM = '$programName' and P_RELEASE = $programRelease;");

            while ($row = mysql_fetch_array($result)){
                $programVersion = $row['VERSION'] + .01;
            }
        }
        
        $query = "INSERT INTO PROGRAM_INFORMATION VALUES ($programId,'$programName',$programRelease,$programVersion);";

        mysql_query($query);
        
        $message = "Program Id #".$programId." saved successfully.";
        //echo $message;
        session_start();
        $_SESSION['message'] = $message;
        
        header("Location:mgmtFuncHomePage.php");
        exit();
    }
?>

