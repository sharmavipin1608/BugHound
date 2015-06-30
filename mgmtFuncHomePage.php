<?php
    require_once("header.php");
?>

<html>
    <body style="font-family:verdana;">
        <?php
        if(isset($_SESSION['message']))
        {
        ?>
        <h1 style="background-color:greenyellow">
            <?php echo  $_SESSION['message'];?>
        </h1>
        <?php 
        } 
        unset($_SESSION['message']);
        ?>
        
        <table>
            <tr>
                <td><a href="addEmployee.php">Add Employee</a></td>
            </tr>
            <tr><td><br/></td></tr>
        
            <tr>
                <td><a href="selectEmployeeForUpdate.php">Update Employee</a></td>
            </tr>
            <tr><td><br/></td></tr>
            
            <tr>
                <td><a href="addProgram.php">Add Program</a></td>
            </tr>
            <tr><td><br/></td></tr>
            
            <tr>
                <td><a href="addFunctionalArea.php">Add Functional Area</td>
            </tr>
            <tr><td><br/></td></tr>
        </table>
    </body>
</html>