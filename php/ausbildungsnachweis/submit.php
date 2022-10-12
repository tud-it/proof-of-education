<?php
	$response_code = 400;

	include("mysql_functions.php");
	$datum = $_GET["datum"];

	function double_or_null ($value) {
		if($value) {
			return '"'.esc($value).'"';
		}

		return "NULL";
	}

	function get_nachweis_id_nachweisnummer($nachweisnummer) {
		$query = "select id from (select id, concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) as nachweisnummer from nachweis having nachweisnummer = '".esc($nachweisnummer)."') a;";
		return get_single_value_from_query($query);
	}

	if(array_key_exists("tag_id", $_GET)) {
		$nachweis_ids = preg_split("/\s*,\s*/", $_GET["nachweisnummer"]);
		foreach($nachweis_ids as $nachweisnummer) {
			$nachweis_id = get_nachweis_id_nachweisnummer($nachweisnummer);
			if($nachweis_id != "") {
				$tag_id = get_single_value_from_query("SELECT id FROM nachweis_db.kommentare_id_datum_stunden WHERE datum = '$datum';");

				if($tag_id == "") {
					$query = "insert into nachweis_db.kommentare_id_datum_stunden(datum) values ('".esc($_GET["datum"])."'";
					run_query($query);
				}
				$tag_id = get_single_value_from_query("SELECT id FROM nachweis_db.kommentare_id_datum_stunden WHERE datum = '$datum';");

				$query_nr = "INSERT INTO nachweis_db.tag_nachweise (tag_id, kommentarnummer, nachweis_id, user_id) VALUES ('$tag_id', '".esc($_GET["kommentarnummer"])."', $nachweis_id, '1') on duplicate key update tag_id=values(tag_id), kommentarnummer=values(kommentarnummer), nachweis_id=values(nachweis_id), user_id=values(user_id)";
				run_query($query_nr);
				$response_code = 200;
			}
		}

	}

	if(array_key_exists("new_nachweisnr", $_GET)) {
		$query = "insert into nachweis_db.woche_ausbildungsnachweisnr (woche, ausbildungsnachweisnr) values ('".$_GET["woche"]."', '".$_GET["new_nachweisnr"]."') on duplicate key update woche=values(woche), ausbildungsnachweisnr=values(ausbildungsnachweisnr)";
		run_query($query);
		$response_code = 200;
	}

	$row_nr = "";
	foreach ($_GET as $key => $value) {
		if(preg_match("/kommentar_(\d+)/", $key, $match)) {
			$row_nr = $match[1];
		}
	}

	if($row_nr != "") {
		$query="INSERT INTO nachweis_db.kommentare_id_datum_stunden (datum, kommentar_$row_nr, einzelstunde_$row_nr) VALUES ('".esc($datum)."', '".esc($_GET["kommentar_$row_nr"])."', ".double_or_null($_GET["einzelstunde_$row_nr"]).") on duplicate key update kommentar_$row_nr=values(kommentar_$row_nr), einzelstunde_$row_nr=values(einzelstunde_$row_nr)";
		run_query($query);
		$response_code = 200;
	}

	http_response_code($response_code);
	print "OK";
?>
