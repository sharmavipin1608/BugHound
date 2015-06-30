<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    
    
    $con = mysql_connect("localhost", "root", "root");
            if (!$con) {
                die('Could not connect: ' . mysql_error());
            }

            mysql_select_db("BugHound", $con);
            
            $program = $_GET['program'];
            
            if($_GET['release']){
                $release = $_GET['release'];
                $resultText='<label for="version">Version<span style="color:red">*</span></label>';
                
                $programList = mysql_query("SELECT * FROM PROGRAM_INFORMATION where PROGRAM = '$program' and P_RELEASE = '$release'");
                
                $row = mysql_fetch_array($programList);
                
                $resultText .='<label>&nbsp;&nbsp'.$row['VERSION'].'</label>';
                $resultText .='<input type="hidden" id="programId" name="programId" value="'.$row['PROGRAM_ID'].'"/>';
            }
            else{
                $resultText = "<option>--Select--</option>";
    
                //Get list of programs from DB
                $programList = mysql_query("SELECT * FROM PROGRAM_INFORMATION where PROGRAM = '$program'");
                while($row = mysql_fetch_array($programList)){
                    $resultText .= "<option value = '".$row['P_RELEASE']."'>".$row['P_RELEASE']."</option>";
                }
            }    
           
            echo $resultText;
?>
