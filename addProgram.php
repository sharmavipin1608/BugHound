<?php

    require_once 'header.php';
    require_once 'dbConnection.php';
    
    $query = "SELECT DISTINCT(PROGRAM) FROM PROGRAM_INFORMATION;";
    $result = mysql_query($query);
    
    $programNameArray = array();
    
    while($row = mysql_fetch_array($result))
    {
        $programList.=$row['PROGRAM'].',';
        $programNameArray[] = $row['PROGRAM'];
    }
    
//    echo sizeof($trial);
//    
//    foreach ($trial as $row)
//        echo $row;
    
    //forea
    //echo $programList;
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
    
    <body style="font-family:verdana;">
        <div align ="center" id="buttonPanel">
            <input type="button" value="Add New Program" onclick="addProgram();"/>
            <input type="button" value="Add New Release" onclick="addRelease();"/>
            <input type="button" value="Add New Version" onclick="addVersion();"/>
        </div>
        <div id="addProgram" hidden="true">
            <fieldset>
                <legend>Add a new Program</legend>
                <form id="addProgramForm" action="saveOrUpdateProgram.php?operation=addProgram" method="POST">
                    <table width="100%">
                        <tr>
                            <td>
                               Program Name 
                            </td>
                            <td>
                                <input class="mandatory" type="text" name="programName" id="programName"/>
                            </td>
                        </tr>
                    </table>

                    <br/>
                    
                    <input type='hidden' id="programListInDB" value='<?php echo $programList; ?>'/>
                    
                    <span style="color:red"><i>Release will be set to 1 and Version to .01</i></span>

                    <div align="center">
                        <input type="button" value="Submit" onclick="validateProgramName(this.form.id)"/>
                        <input type="reset" value="Reset"/>
                        <input type="button" value="Cancel" onClick="cancelAction()"/>
                    </div>    
                </form>
            </fieldset>
        </div>
        
        <div id="addRelease" hidden="true">
            <fieldset>
                <legend>Add a new Release</legend>
                <form id="addReleaseForm" action="saveOrUpdateProgram.php?operation=addRelease" method="POST">
                    <table width="100%">
                        <tr>
                            <td>
                                Program Name
                            </td>
                            <td>
                                <select id="programName" name="programName" class="mandatory">
                                    <option value="">--Select--</option>
                                    <?php 
                                        foreach($programNameArray as $row)
                                        {
                                    ?>
                                    <option value="<?php echo $row ?>"><?php echo $row ?></option>     
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <br/>

                    <span style="color:red"><i>Release will be incremented by 1 and Version will be set to .01</i></span>
                    
                    <div align="center">
                        <input type="button" value="Submit" onclick="formValidation(this.form.id)"/>
                        <input type="reset" value="Reset"/>
                        <input type="button" value="Cancel" onClick="cancelAction()"/>
                    </div>
                </form>
            </fieldset>
        </div>
        
        <div id="addVersion" hidden="true" disabled="true">
            <fieldset>
                <legend>Add a new Version</legend>
                <form id="addVersionForm" action="saveOrUpdateProgram.php?operation=addVersion" method="POST">
                    <table width="100%">
                        <tr>
                            <td>
                                Program Name
                            </td>
                            <td>
                                <select id="programName" name="programName" class="mandatory" onchange="loadRelease(this.value)">
                                    <option value="">--Select--</option>
                                    <?php 
                                        foreach($programNameArray as $row)
                                        { 
                                    ?>
                                        <option value="<?php echo $row ?>" ><?php echo $row ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Release
                            </td>
                            <td>
                                <select id="release" name="release" class="mandatory" onchange="loadVersion(this.value)">
                                    <option value="">--Select--</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <br/>

                    <span style="color:red"><i>Version will be incremented by .01</i></span>

                    <div align="center">
                        <input type="button" value="Submit" onclick="formValidation(this.form.id)"/>
                        <input type="reset" value="Reset"/>
                        <input type="button" value="Cancel" onClick="cancelAction()"/>
                    </div>
                </form>
            </fieldset>
        </div>
    </body>
</html>
