<?php
include("mysql_functions.php");

$datei = get_single_value_from_query("select nachweisdatei from nachweis_db.nachweisdatei_wochennr_id where id ='".esc($_GET["id"])."'");
$filename = get_single_value_from_query("select filename from nachweis_db.nachweisdatei_wochennr_id where id ='".esc($_GET["id"])."'");

header("Content-Type: image/png");
header("filename=$filename");

    print base64_decode(base64_decode($datei));

?>