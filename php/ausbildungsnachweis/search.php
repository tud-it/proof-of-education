<?php
header('Content-Type: application/json; charset=utf-8');
	include("mysql_functions.php");



	if(array_key_exists("datum", $_GET)) {
		print json_encode(get_single_value_from_query("SELECT id FROM nachweis_db.kommentare_id_datum_stunden WHERE datum = '".$_GET["datum"]."'"));
	} else {
		if(array_key_exists("terms", $_GET)) {
			$query = "SELECT id, concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) AS nachweisnummer, fertigkeiten FROM nachweis_db.nachweis HAVING fertigkeiten LIKE '%".esc($_GET["terms"])."%' OR nachweisnummer LIKE '%".esc($_GET['terms'])."%'";
			$result = run_query($query);
			while($row = $result->fetch_assoc()) {
				$ergebnisse[] = $row;
			}

			// erstellt eine Datenstruktur
			$terms_array = preg_split("/\s*,\s*/", $_GET["terms"]);
			for($i = 0, $number_terms = count($terms_array); $i < $number_terms; ++$i) {
				if(is_nachweisnummer($terms_array[$i])) {
					$terms_and_properties[] = array('eingabe' => $terms_array[$i], 'is_nachweisnummer' => 'true', 'nachweisnummer_id' => get_single_value_from_query("SELECT id, concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) AS nachweisnummer FROM nachweis_db.nachweis HAVING nachweisnummer = '$terms_array[$i]'"));

				} else {
					$query = "SELECT concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) AS nachweisnummer, fertigkeiten, id FROM nachweis_db.nachweis WHERE fertigkeiten like '%$terms_array[$i]%'";
					$result = run_query($query);
					$terms_and_properties[] = array('eingabe' => $terms_array[$i], 'is_nachweisnummer' => 'false', 'candidates' => array());
					while($row = $result->fetch_assoc()) {
						$terms_and_properties[$i]['candidates'][] = $row;
					}
				}
			}

			$query = "INSERT INTO nachweis_db.tag_nachweise (tag_id, kommentar_nummer, nachweis_id) VALUES ('307', '01', '2')";

			print json_encode($terms_and_properties);

		} else {
			print json_encode(array("error " => "no 'terms' specified"));
		}
	}


?>
