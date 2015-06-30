<?php
    require_once 'header.php';
    
    require_once 'dbConnection.php';
    
    $query = "SELECT * FROM EMPLOYEE_INFORMATION WHERE STATUS = 'Active';";
    
    $employeeList = mysql_query($query);
?>

<html>
    <head>
        <style>
            tr:nth-of-type(odd) {
                background-color:#ccc;
            }
            
            tr, td, th {
                border-top-color:#DDDDDD;
                border-top-style:solid;
                border-top-width:1px;
                line-height:1.42857143;
                padding:7px;
                vertical-align:top;
            }
        </style>
    </head>
    <body style="font-family:verdana;">
        <table width='100%' align='center' border='0.2'>
            <tr>
                <th>Employee Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
            </tr>
            
            <?php while($row = mysql_fetch_array($employeeList)){
            ?>
            <tr>
                <td>
                    <a href='updateEmployee.php?id=<?php echo $row['EMPLOYEE_ID']?>' ><?php echo $row['EMPLOYEE_ID']?></a>
                </td>
                <td>
                    <?php echo $row['FIRST_NAME']?>
                </td>
                <td>
                    <?php echo $row['LAST_NAME']?>
                </td>
                <td>
                    <?php echo $row['ROLE']?>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </body>
</html>
