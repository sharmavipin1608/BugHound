<?php

    require_once 'dbConnection.php';
    $program = $_GET['program'];

    if ($_GET['release']) {
        $release = $_GET['release'];
        $resultText = "<option>--Select--</option>";

        $programList = mysql_query("SELECT * FROM PROGRAM_INFORMATION where PROGRAM = '$program' and P_RELEASE = '$release'");

        while ($row = mysql_fetch_array($programList)) {
            $resultText .= "<option value = '" . $row['PROGRAM_ID'] . "'>" . $row['VERSION'] . "</option>";
        }
    } else {
        $resultText = "<option>--Select--</option>";

        //Get list of programs from DB
        $programList = mysql_query("SELECT DISTINCT(P_RELEASE) AS P_RELEASE FROM PROGRAM_INFORMATION where PROGRAM = '$program'");
        while ($row = mysql_fetch_array($programList)) {
            $resultText .= "<option value = '" . $row['P_RELEASE'] . "'>" . $row['P_RELEASE'] . "</option>";
        }
    }

    echo $resultText;
?>
