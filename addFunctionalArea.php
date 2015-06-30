<?php
    require_once 'header.php';
    require_once 'dbConnection.php';
    
//    $query = "SELECT DISTINCT(PROGRAM) AS PROGRAM FROM PROGRAM_INFORMATION ORDER BY PROGRAM;";
//    
//    $result = mysql_query($query);
    
    $query = "SELECT * FROM PROGRAM_INFORMATION order by PROGRAM,P_RELEASE,VERSION;";
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
        <h1 style="background-color:greenyellow" align="center" id="message"></h1>
        
        <fieldset>
            <legend>Add Program</legend>
            <form id="addFunctionalArea" action="saveOrUpdateFunctionalArea.php" method="POST">
                <table width='100%'>
                    <tr>
                        <td>Program</td>
                        <td>
                            <select id='programName' name='programName' class='mandatory' onchange="loadFunctionalArea(this.value,true)">
                                <option value="">--Select--</option>
                                <?php while ($row = mysql_fetch_array($result)) { ?>
                                    <option value="<?php echo $row['PROGRAM_ID']; ?>" ><?php echo $row['PROGRAM'] . "-" . ($row["P_RELEASE"] + $row["VERSION"]); ?></option>
                                <?php } ?>
                            </select>
                        </td>    
                    </tr>
                    
                    <tr>
                        <td>Functional Area</td>
                        <td>
                            <input type='text' id='functionalArea' name='functionalArea' class='mandatory'/>
                        </td>
                    </tr>
                </table>
                
                <div align="center">
                    <input type="button" value="Add Functional Area" onclick="saveFunctionalArea(this.form.id)"/>
                    <input type="button" value="Cancel" onclick="cancelAction()"/>
                </div>
            </form>
        </fieldset>
        <br/><br/><br/>
        <div id="functionalAreaList" align="center">
            
        </div>
    </body>
</html>
    

