<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit (600);

$config = include('config.php');


function check_url_status($url){
	$url_handle = curl_init($url);
	$output = array('httpCode','msg');
	curl_setopt($url_handle, CURLOPT_HEADER, true);
	curl_setopt($url_handle, CURLOPT_RETURNTRANSFER, TRUE);
	
	$response = curl_exec($url_handle);
	
	$output['httpCode'] = curl_getinfo($url_handle, CURLINFO_HTTP_CODE);
	curl_close($url_handle);
	
	$output['msg'] = "";
	if($output['httpCode'] != 200){
		$url_second_handle = curl_init($url);
		curl_setopt($url_second_handle,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($url_second_handle, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($url_second_handle);
		$target = curl_getinfo($url_second_handle, CURLINFO_EFFECTIVE_URL);
		curl_close($url_second_handle);
		$output['msg'] = "redirects to $target";
	}
	
	return $output;
}


if (($handle = fopen("files/".$config['active_file'], "r")) !== FALSE) {
	$loop = 0;
	$fine_url_arr = array();
	$newCsvData = array();
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		if($loop != 0){
			$url_data_position = $config['url_col_position'] - 1;
			$url_to_check = $data[$url_data_position];
			$cols = count($data);
			
			$status['httpCode'] = 200;
			$status['msg'] = "";
			if(!in_array($url_to_check, $fine_url_arr)){
				$status = check_url_status($url_to_check);
				if($status['httpCode'] == 200)
					$fine_url_arr[] = $url_to_check;
			}
			
			$status_pos = $cols - 3;
			$status_code_pos = $cols - 2;
			$comment_pos = $cols - 1;
			
			$data[$status_pos] = "checked";
			$data[$status_code_pos] = $status['httpCode'];
			$data[$comment_pos] = $status['msg'];
			$newCsvData[] = $data;
		}
		else
			$newCsvData[] = $data;
		
		$loop++;
	}
	
	// write updated data to file
	$handle = fopen("files/".$config['active_file'], 'w');
	foreach ($newCsvData as $line) {
	   fputcsv($handle, $line);
	}	
	fclose($handle);
	
	// write updated data to file
	$handle = fopen("files/msoffice_".$config['active_file'], 'w+');
	foreach ($newCsvData as $line) {
	   fputcsv($handle, $line, ";");
	}	
	fclose($handle);
}
else
	echo "FAILURE";
	
header('Location: url-tester.php');
exit;


?>