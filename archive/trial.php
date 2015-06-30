<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
echo $_SESSION['user_id'] ;
if($_SESSION['user_id'] == '')
{
//    echo "cond";
    header("Location: loginPage.php");
    exit();
}
//if(!isset($_SESSION['user_id']))
//{
//    echo "nothing set as such";
//    header("Location:BugHound.php");
//    exit();
//}
?>
