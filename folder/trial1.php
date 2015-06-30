<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<html>
    <head>
        <script type="text/javascript">
            function callFunction()
            {
                alert("callFunction");
                document.getElementById("hiddenField").value = "value passed";
                document.getElementById("trial").submit();
            }
        </script>
    </head>
    <body>
        <form id="trial" action="trial2.php" method="POST">
            <a href="#" onclick="callFunction()">try this</a>
            <input type="hidden" name="hiddenField" id="hiddenField"/>
           </form>
    </body>
</html>