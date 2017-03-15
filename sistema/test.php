<html>
  <head>
    <link href="../jsTest/datepicker.css" rel="stylesheet">
    <link href="../jsTest/bootstrap-combined.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="input-append date" id="datepicker" data-date="02-2012" data-date-format="mm-yyyy">
	 <input  type="text" readonly="readonly" name="date" >
	 <span class="add-on"><i class="icon-th"></i></span>
    </div>
  </body>
  <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="../js/jquery-ui.min.js" type="text/javascript"></script>
  <script src="../js/bootstrap.min.js" type="text/javascript"></script> 
  <script src="../jsTest/bootstrap-datepicker.js" type="text/javascript"></script>
  <script>
  $("#datepicker").datepicker( {
      format: "mm-yyyy",
      viewMode: "months",
      minViewMode: "months"
  });
  </script>
</html>
