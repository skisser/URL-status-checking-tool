<?php
$config = include('config.php');

$headers = null;
if (($handle = fopen("files/".$config['active_file'], "r")) !== FALSE) {
	$loop = 0;
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $loop == 0) {
		$headers = $data;
		$loop = 1;
	}
}


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
</head>

<body>
<div class="container">
	<h1>URL Statuscheck Tool Einstellungen</h1>
</div>
<div class="container">
	<form action="save_settings.php" method="post">
      <label for="url_col">URL Spalte</label>
      <select class="form-control" id="url_col" name="url_col">
      	<option value="">Bitte auswählen</option>
      	<?php
			if($headers != null){
				foreach($headers as $key => $col){
					$position = $key + 1;
					if($col == $config['url_col'])
						echo '<option selected="selsected" value="'.$position.'_-_'.$col.'">'.$col.'</option>';
					else
						echo '<option value="'.$position.'_-_'.$col.'">'.$col.'</option>';
				}
			}
		?>
      </select>
      <button type="submit" class="btn btn-default">Einstellungen speichern</button>
    </form>
</div>

<div class="container">
</div>



    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="DataTables-1.10.15/datatables.min.js"></script>
</body>
</html>