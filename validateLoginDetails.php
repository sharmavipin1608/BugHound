<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    session_start();
    
    require_once('dbConnection.php');

    $employeeId = $_POST['employeeId'];
    $employeePassword = $_POST['employeePassword'];
    
    $employee = mysql_query("SELECT * FROM EMPLOYEE_INFORMATION where EMPLOYEE_ID"
            . "=$employeeId and PASSWORD like ('$employeePassword');");
    
    $authenticate = mysql_fetch_array($employee);
    
    if(sizeof($authenticate) > 1)
    {
        $_SESSION['user_id']=$authenticate['EMPLOYEE_ID'];
        $_SESSION['user_name']=$authenticate['FIRST_NAME'];
        $_SESSION['user_role']=$authenticate['ROLE'];
        header("Location:homePage.php");
        exit();
    }
    else
    {
        header("Location:loginPage.php?invalid=true");
    }

?>

