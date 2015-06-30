<?php
    require_once 'header.php';
    require_once 'dbConnection.php';
    
    $query = "SELECT * FROM EMPLOYEE_INFORMATION";
    $employeeData = mysql_query($query);
    
    while($row = mysql_fetch_array($employeeData))
    {
        //echo $row['FIRST_NAME']." ".$row['LAST_NAME'];
        $employeeList.=$row['FIRST_NAME']." ".$row['LAST_NAME'].",";
    }
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
            <legend>Add Employee</legend>
            <form action="saveOrUpdateEmployee.php" id="addEmployee" name="addEmployee" method="POST">
                <table width='100%'>
                    <tr>
                        <td>
                            First Name
                        </td>
                        <td>
                            <input type="text" id="firstName" name="firstName" class="mandatory"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Last Name
                        </td>
                        <td>
                            <input type="text" id="lastName" name="lastName" class="mandatory"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Role
                        </td>
                        <td>
                            <select name="role" id="role" class="mandatory">
                                <option value="">--Select--</option>
                                <option value="User">User</option>
                                <option value="Programmer">Programmer</option>
                                <option value="Tester">Tester</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </td>
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