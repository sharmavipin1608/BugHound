<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    var date = new Date();
    date.getFullYear()+"-"+date.getMonth()+"-"
    $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" }).val;
    
    $( "#start_date" ).datepicker(
	
			{ 
				maxDate: new Date(), 
				beforeShow : function()
				{
					jQuery( this ).datepicker('option','maxDate', jQuery('#end_date').val() );
				},
				altFormat: "dd/mm/yy", 
				dateFormat: 'dd/mm/yy'
				
			}
			
	);

	$( "#end_date" ).datepicker( 
	
			{
				maxDate: new Date(), 
				beforeShow : function()
				{
					jQuery( this ).datepicker('option','minDate', jQuery('#start_date').val() );
				} , 
				altFormat: "dd/mm/yy", 
				dateFormat: 'dd/mm/yy'
				
			}
			
	);

  });
  </script>
</head>
<body>
 
<p>Date: <input type="text" id="datepicker"></p>
 
 
</body>
</html>