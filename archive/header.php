<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'authorizeUser.php';

?>

<html>
    <head>
        
    </head>
    <body style="font-family:verdana;">
        <table width ="100%">
            <tr>
                <td align="right">
                    Hi <?php echo $_SESSION['user_name'] ?> , <?php echo $_SESSION['user_role'] ?>
                    &nbsp;&nbsp;
                    <a href="loginPage.php">Logout</a>
                </td>
            </tr>
            
            <tr>
                <td>
                    <h1>BugHound</h1>
                </td>
            </tr>
            
        </table>
        
        <hr>
    </body>
</html>