<?php

$config = include('config.php');

$uploaddir = 'files/';
$filename = basename($_FILES['csv_file']['name']);
$uploadfile = $uploaddir . $filename;

if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $uploadfile)) {
	
	$config_content = "<?php
return array(
    'active_file' => '".$filename."',
	'url_col' => '".$config['url_col']."',
	'url_col_position' => '".$config['url_col_position']."',
);";
	
	$handle = fopen("config.php", "w+");
	fwrite($handle, $config_content);
	fclose($handle);
	
	//Add new columns
	
	// create new columns array
	$newCsvData = array();
	if($_POST['separator'] == 'comma')
		$separator = ",";
	else
		$separator = ";";
	
	if (($handle = fopen($uploadfile, "r")) !== FALSE) {
		$loop = 0;
		while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
			if($loop == 0){
				$data[] = 'Status';
				$data[] = 'Status Code';
				$data[] = 'Comment';
			}
			else{
				$data[] = '';
				$data[] = '';
				$data[] = '';
			}
			$newCsvData[] = $data;
			$loop++;
		}
		fclose($handle);
	}
	
	// write updated data to file
	$handle = fopen($uploadfile, 'w');
	foreach ($newCsvData as $line) {
	   fputcsv($handle, $line);
	}	
	fclose($handle);
	
    //echo "Datei ist valide und wurde erfolgreich hochgeladen.\n";
} else {
    //echo "Möglicherweise eine Dateiupload-Attacke!\n";
}

//print_r($_FILES);

header('Location: settings.php');
exit;

?>