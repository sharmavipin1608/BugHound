<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo "login";
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_role']);
?>


<html>
    <head>
        <title>Login Page</title>
        <script src="formValidation.js"></script>
        <style>
            fieldset{
                border: 1px solid rgb(255,232,57);
                width: 300px;
                margin: 0 auto;
                text-align: left;
                top: 50%;
            }

            form
            {
                text-align: center;
            }
        </style>
    </head>
    
    <body style="font-family:verdana;">
        <?php include("header.html");?>
        <br/><br/><br/><br/><br/><br/><br/><br/>
        
        
        
        <fieldset>
            <legend>Login details</legend>
            
            <?php 
            if($_GET['invalid'] == true)
            {
            ?>
            <h3 style='background-color:red' align="center">Login details invalid</h3>
            <?php } ?>
            
            <form name="loginPage" id="loginPage" method="POST" action="validateLoginDetails.php">
                <table>
                    <tr>
                        <td>Employee Id</td>
                        <td>
                            <input class="mandatory" type="text" name="employeeId" id="employeeId"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Password</td>
                        <td>
                            <input class="mandatory" type="password" name="employeePassword" id="employeePassword"/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <input type="button" value="Submit" onclick="formValidation(this.form.id);"/>
                        </td>
                    </tr>
                </table>
            </form>
            
        </fieldset>
    </body>
</html>
