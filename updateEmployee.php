<?php

    $employeeId = $_GET['id'];
    
    require_once 'header.php';
    require_once 'dbConnection.php';
    
    $query = "SELECT * FROM EMPLOYEE_INFORMATION";
    $employeeDataDump = mysql_query($query);
    
    while($row = mysql_fetch_array($employeeDataDump))
    {
        $employeeList.=$row['FIRST_NAME']." ".$row['LAST_NAME'].",";
    }
    
    $query = "SELECT * FROM EMPLOYEE_INFORMATION WHERE EMPLOYEE_ID = $employeeId";
    $employeeData = mysql_query($query);
    $employee = mysql_fetch_array($employeeData);
    
?>
<html>
    <head>
        <script src="formValidation.js"></script>
        <style>
            fieldset{
                border: 1px solid rgb(0,0,0);
                width: 300px;
                margin: 0 auto;
                text-align: left;
                top: 50%;
            }
        </style>
    </head>
    <body style="font-family:verdana;">
        <fieldset>
            <legend>Update Employee</legend>
        
            <form id="updateEmployee" action="saveOrUpdateEmployee.php?employeeId=<?php echo $employeeId ?>" method="POST">
                <table width="100%">
                    <tr>
                        <td>First Name</td>
                        <td>
                            <input type="text" name="firstName" id="firstName" class="mandatory" value="<?php echo $employee['FIRST_NAME'] ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Last Name</td>
                        <td>
                            <input type="text" name="lastName" id="lastName" class="mandatory" value="<?php echo $employee['LAST_NAME'] ?>" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Role</td>
                        <td>
                            <select name="role" id="role" class="mandatory">
                                <option value="">--Select--</option>
                                <option value="User" <?php if($employee['ROLE'] == 'User') print 'selected = "selected"' ?> >User</option>
                                <option value="Programmer" <?php if($employee['ROLE'] == 'Programmer') print 'selected = "selected"' ?> >Programmer</option>
                                <option value="Tester" <?php if($employee['ROLE'] == 'Tester') print 'selected = "selected"' ?> >Tester</option>
                                <option value="Manager" <?php if($employee['ROLE'] == 'Manager') print 'selected = "selected"' ?> >Manager</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                </table>
                
                <div align="center">
                    <input type="button" value="Submit" onclick="validateEmployee(this.form.id)"/>
                    <input type="reset" value="Reset"/>
                    <input type="button" value="Cancel" onClick="cancelAction()"/>
                </div>
                
                <input type="hidden" id="employeesDB" value="<?php echo $employeeList; ?>"/>
            </form>
        </fieldset>
    </body>
</html>