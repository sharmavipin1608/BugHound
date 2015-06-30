<?php

    require_once 'header.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<html>
    <head>
        <script src="formValidation.js"></script>
    </head>
    <body>
        <form id="exportData" action="" method="POST">
        <div align="center">
            <br/><br/><br/>
            Table Names
            <select id="tableList" name="tableList" onchange="checkTableName(this.value)">
                <option value="">--Select--</option>
                <option value="EMPLOYEE_INFORMATION">Employee</option>
                <option value="BUG_INFORMATION">Bug</option>
                <option value="PROGRAM_INFORMATION">Program</option>
                <option value="FUNCTIONAL_AREA">Functional Area</option>
            </select>
            <br/><br/><br/>
            <div id="buttonPanel" style="display:none">
                <input type="button" value="Export data as XML" onclick="exportDataAsXml(this.form.id)"/>
                <input type="button" value="Export data as ASCII" onclick="exportDataAsAscii(this.form.id)"/>
            </div>
        </div>
        </form>
    </body>
</html>