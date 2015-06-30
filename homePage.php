<?php
    require_once('header.php');
?>

<html>
    <body style="font-family:verdana;">
        <ul>            
            <li><a href="addBug.php">Add new Bug</a></li>
            <br/>
            <li><a href ="searchPage.php">Search Bugs</a></li>
            <br/>
            <?php if($_SESSION['user_role'] == 'Manager')
                  {
            ?>
            <li><a href ="mgmtFuncHomePage.php">Management Functions</a></li>
            <br/>
            <li><a href ="exportTableData.php">Export Data</a></li>
            <?php
            }
            ?>
        </ul>
    </body>
</html>