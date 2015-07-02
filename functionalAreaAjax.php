<?php

    require_once 'dbConnection.php';
    
    $query = "SELECT * FROM FUNCTIONAL_AREA WHERE PROGRAM_ID = ".$_GET['programId'];
    $result = mysql_query($query);
    $functionalAreasForProgram = "";
    $count = 0;
    $resultText.="<table width='30%' align='center' border='1px solid black'>";
    $resultText.="<tr>";
    $resultText.="<th>Functional Area</th>";
    $resultText.="<th>Update</th>";
    while($row = mysql_fetch_array($result)){
        $resultText.="<tr><td>";
        $functionalAreaName = $row["FUNCTIONAL_AREA_NAME"];
        $functionalAreasForProgram.=$functionalAreaName.",";
        $functionalAreaFieldId = "functionalArea".$count;
        $resultText.="<input type='text' value='$functionalAreaName' id='$functionalAreaFieldId'/>";
        $resultText.="</td>";
        $resultText.="<td>";
        $functionalAreaId = $row["FUNCTIONAL_AREA_ID"];
        $resultText.="<input type='button' value='Update' onclick='updateFunctionalArea($count,$functionalAreaId)'/>";
        $resultText.="</td></tr>";
        $count++;
    }
    $resultText.="</table>";
    $resultText.="<input type='hidden' value='$functionalAreasForProgram' id='functionalAreasForProgram'/>";
    
    if($count == 0)
        $resultText = "No records to be displayed";
    
    echo $resultText;
?>
    

