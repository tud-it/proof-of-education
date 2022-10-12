<?php

$response_code = 400;

if(preg_match("/^[0-9]{1-3}$/", $_GET["wochennr"], $match)) {
		$response_code = 200;
}

include("mysql_functions.php");

$search = base64_decode($_POST["uploaded_file"]);
if(file_is_signed($search)) {
	print "true\n";
	$signed = 1;
} else {
	print "false\n";
	$signed = 0;
}

$datei = base64_encode($_POST["uploaded_file"]);

if(array_key_exists("wochennr", $_GET)) {
	$query = "insert into nachweis_db.nachweisdatei_wochennr_id(wochennr, nachweisdatei, filename, signiert) values ('".esc($_GET["wochennr"])."', '$datei', '".esc($_GET["filename"])."', $signed)";
	run_query($query);
	$response_code = 200;
}

http_response_code($response_code);
?>
