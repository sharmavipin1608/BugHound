<?php
    require_once 'dbConnection.php';
    
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $role = $_POST['role'];
        
    if($firstName != "")
    {
        if($_GET['employeeId'] != '')
        {
            $employeeId = $_GET['employeeId'];
            $update = true;
        }
        else
        {
            $maxEmployeeId = mysql_query("SELECT max(EMPLOYEE_ID) as ID FROM EMPLOYEE_INFORMATION;");
            $maxEmployeeIdDB = mysql_fetch_array($maxEmployeeId);

            $employeeId = $maxEmployeeIdDB['ID']+1;
            if($employeeId == 1)
                $employeeId = 1001;
            $firstChar = substr($lastName,0,1);
            $password = strtoupper($firstChar).$employeeId;
        }

        if($update)
        {
            $query = "UPDATE EMPLOYEE_INFORMATION SET LAST_NAME = '$lastName', FIRST_NAME = '$firstName', ROLE = '$role' WHERE EMPLOYEE_ID = $employeeId";
        }
        else 
        {
            $query = "INSERT INTO EMPLOYEE_INFORMATION VALUES ($employeeId,'Active','$lastName','$firstName','$role','$password');";
        }

        mysql_query($query);
    }
?>

<html>
    <head>
        <title>Success Page</title>
    </head>
    <body style="font-family:verdana;">
        <?php include("mgmtFuncHomePage.php");?>
        
        <br/>
        <br/><br/>
        <h1 style="background-color:greenyellow">
            <?php if($update) {?>
                Employee Id #<?php echo $employeeId?> updated successfully.
            <?php } else { ?>
                Employee Id #<?php echo $employeeId ?> saved successfully.
            <?php } ?>
        </h1>
        
    </body>
</html>