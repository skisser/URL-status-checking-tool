<?php
	
	$config = include('config.php');
	
	$parts = explode("_-_", $_POST['url_col']);
	
	$url_col = $parts[1];
	$url_col_position = $parts[0];
	
	$config_content = "<?php
return array(
    'active_file' => '".$config['active_file']."',
	'url_col' => '".$url_col."',
	'url_col_position' => '".$url_col_position."',
);";
	
	$handle = fopen("config.php", "w+");
	fwrite($handle, $config_content);
	fclose($handle);
	
header('Location: url-tester.php');
exit;

?>