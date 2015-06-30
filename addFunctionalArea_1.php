<?php
    require_once 'header.php';
    require_once 'dbConnection.php';
    
    $query = "SELECT DISTINCT(PROGRAM) AS PROGRAM FROM PROGRAM_INFORMATION ORDER BY PROGRAM;";
    
    $result = mysql_query($query);
    
?>

<html>
    <head>
        <script src="formValidation.js?<?php echo time()?>"></script>
        
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
    <body>
        <fieldset>
            <legend>Add Program</legend>
            <form id="addFunctionalArea" action="saveOrUpdateFunctionalArea.php" method="POST">
                <table width='100%'>
                    <tr>
                        <td>Functional Area</td>
                        <td>
                            <input type='text' id='functionalArea' name='functionalArea' class='mandatory'/>
                        </td>
                    </tr>
                    <tr>
                        <td>Program</td>
                        <td>
                            <select id='programName' name='programName' class='mandatory'>
                                <option value="">--Select--</option>
                                <?php while ($row = mysql_fetch_array($result)) { ?>
                                    <option value="<?php echo $row['PROGRAM']; ?>" ><?php echo $row['PROGRAM']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                
                <div align="center">
                    <input type="button" value="Submit" onclick="formValidation(this.form.id)"/>
                    <input type="reset" value="Reset"/>
                    <input type="button" value="Cancel"/>
                </div>
            </form>
        </fieldset>
    </body>
</html>
    

