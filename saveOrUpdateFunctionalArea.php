<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$functionalAreaId = $_GET['functionalAreaId'];
$functionalArea = trim($_GET['functionalArea']);
$programName = $_GET['programName'];

require_once 'dbConnection.php';

if ($functionalAreaId == "") {
    $resultProgram = mysql_query("SELECT MAX(FUNCTIONAL_AREA_ID) as FUNCTIONAL_AREA_ID FROM FUNCTIONAL_AREA;");

    while ($row = mysql_fetch_array($resultProgram))
        $functionId = $row['FUNCTIONAL_AREA_ID'] + 1;

    if ($functionId == 1)
        $functionId = 101;
    
    $query = "INSERT INTO FUNCTIONAL_AREA VALUES ($functionId,'$functionalArea',$programName);";
    
    mysql_query($query);
    
    $message = "Functional Area Id #".$functionId." saved successfully.";
    
    echo $message;
}
else{
    $query = "UPDATE FUNCTIONAL_AREA SET FUNCTIONAL_AREA_NAME='$functionalArea' WHERE FUNCTIONAL_AREA_ID=$functionalAreaId";
    mysql_query($query);
}
?>