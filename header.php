<?php

    require_once 'authorizeUser.php';

?>

<html>
    <head>

    </head>
    <body style="font-family:verdana;">
        <div align="right">
            Hi <?php echo $_SESSION['user_name'] ?> , <?php echo $_SESSION['user_role'] ?>
            &nbsp;&nbsp;
            <a href="homePage.php">Home</a>
            &nbsp;&nbsp;
            <a href="loginPage.php">Logout</a>
        </div>

        <div>
            <h1>BugHound</h1>
        </div>
        <hr>
    </body>
</html>