<?php

$config = include('config.php');
//echo $config['active_file'];
/*if($config['active_file'] != ""){

	$row = 1;
	if (($handle = fopen("files/".$config['active_file'], "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			var_dump($data);
			echo " <p> $num Felder in Zeile $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
		}
		fclose($handle);
	}
	else{
		echo "Keine csv Datei vorhanden";
	}
}
*/


?>
<!doctype html>
<html lang="de">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>URL status check tool</title>
    <!-- Bootstrap -->
    <link href="bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="DataTables-1.10.15/datatables.min.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#csvTable').DataTable();
	} );
	</script>
</head>

<body>
<div class="container">
	<h1>URL Statuscheck Tool</h1>
</div>
<div class="container">
	<form action="fileupload.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="exampleInputFile">*.csv Datei</label>
        <input type="file" id="csv_file" name="csv_file">
        <label for="separator">Trennzeichen</label>
        <div class="radio">
          <label>
            <input type="radio" name="separator" id="separator1" value="comma">
            ,
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="separator" id="separator2" value="semikolon" checked="checked">
            ;
          </label>
        </div>
        <!--<p class="help-block">*.csv Dateiupload für URL Statuscheck</p>-->
      </div>
      <button type="submit" class="btn btn-default">Datei hochladen</button>
    </form>
    <br/>
    <a class="btn btn-default" href="check_urls.php" role="button">Links überprüfen</a>
    <a class="btn btn-default" href="files/<?php echo $config['active_file'] ?>" role="button">download csv Datei</a>
    <a class="btn btn-default" href="files/msoffice_<?php echo $config['active_file'] ?>" role="button">download MS Office csv Datei</a>
    <br/>
</div>

<div class="container">
<?php

if($config['active_file'] != ""){
	echo '<table id="csvTable" class="display table table-striped table-hover" cellspacing="0" width="100%">';
	$row = 1;
	if (($handle = fopen("files/".$config['active_file'], "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($row == 1){
				echo "<thead><tr>";
				foreach($data as $field){
					echo "<th>".$field."</th>";
				}
				echo "</tr></thead><tfoot><tr>";
				foreach($data as $field){
					echo "<th>".$field."</th>";
				}
				echo "</tr></tfoot>";
			}
			
			if($row > 1){
				if($row == 2)
					echo "<tbody>";
				
				echo "<tr>";
				foreach($data as $field){
					echo "<td>".$field."</td>";
				}
				echo "</tr>";
			}
			
			//$num = count($data);
			//var_dump($data);
			//echo " <p> $num Felder in Zeile $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++) {
				echo $data[$c] . "<br />\n";
			}
		}
		fclose($handle);
	}
	echo '</tbody></table>';
}
else{
	echo "Keine csv Datei vorhanden";
}

?>

</div>
<div class="container">
</div>



    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="DataTables-1.10.15/datatables.min.js"></script>
</body>
</html>