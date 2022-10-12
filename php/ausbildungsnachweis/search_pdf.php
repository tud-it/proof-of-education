<?php

include("mysql_functions.php");

$datei = get_single_value_from_query("select nachweisdatei from nachweisdatei_wochennr_id where wochennr ='".esc($_GET["wochennr"])."'");
$filename = get_single_value_from_query("select filename from nachweisdatei_wochennr_id where wochennr ='".esc($_GET["wochennr"])."'");
$signiert = get_single_value_from_query("select signiert from nachweisdatei_wochennr_id where wochennr ='".esc($_GET["wochennr"])."'");

$query = "select filename, id, signiert from nachweisdatei_wochennr_id where wochennr ='".esc($_GET["wochennr"])."'";
$result = run_query($query);
while($row = $result->fetch_assoc()) {
	$ergebnisse[] = $row;
}

header('Content-Type: application/json');

	//alle pdfs der woche sollen ausgegeben werden mit dem hinweis ob sie signiert sind
	print json_encode($ergebnisse);

?>
