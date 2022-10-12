<?php
	include("mysql_functions.php");

	function get_nervnummer_by_id ($id) {
		$query = "select concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) from nachweis_db.nachweis where id = ".esc_or_null($id);
		return get_single_value_from_query($query);
	}

	if(count($_POST)) {
		if(array_key_exists("nachweis_id", $_POST)) {
			$nachweis_id = $_POST["nachweis_id"];
?>
			<script>
				function jumpto(anchor){
					window.location.href = "#"+anchor;
				}

				jumpto("<?php print htmlentities(get_nervnummer_by_id($nachweis_id)); ?>");
			</script>
<?php
			if(array_key_exists("fertigkeiten", $_POST)) {
				$fertigkeiten = $_POST["fertigkeiten"];
				$query = "update nachweis_db.nachweis set fertigkeiten = ".esc_or_null($fertigkeiten)." where id = ".esc_or_null($nachweis_id);

				run_query($query);

				run_query("delete from nachweis_to_time_category where nachweis_id = ".esc_or_null($nachweis_id));

				foreach ($_POST as $key => $value) {
					if(preg_match("/time_category_(\d+)_richtwert/", $key, $match)) {
						$time_category = $match[1];
						if($_POST[$key]) {
							$insert_query = "insert into nachweis_to_time_category (nachweis_id, time_category_id) values (".esc_or_null($nachweis_id).", ".esc_or_null($time_category).")";
							run_query($insert_query);
						}
					}
				}
			}
		}
	}

	$alle_nachweise_query = "select id, teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe, teil_ausbildungsberuf_beschreibung, fertigkeiten from nachweis_db.nachweis";
	$result = run_query($alle_nachweise_query);

	$time_categories = [];
	$time_categories_result = run_query("select id, woche_start, woche_end from time_categories");

	while ($row = $time_categories_result->fetch_row()) {
		$time_categories[] = $row;
	}


?>

	<table border=1>
		<tr>
			<th>Nervnummer</th>
			<th>Fertigkeiten</th>
<?php
			foreach ($time_categories as $time_category) {
?>

				<th>Von Woche <?php print $time_category[1]; ?> - Woche <?php print $time_category[2]; ?></th>
<?php
			}
?>
			<th>Speichern</th>
			<th>Anzahl Eintragungen bisher</th>
		</tr>
<?php

	function how_many_days_have_this_nachweis_id ($nachweis_id) {
		$query = "select count(*) from nachweis_db.tag_nachweise where user_id = 1 and nachweis_id = ".esc($nachweis_id);
		return get_single_value_from_query($query);;
	}

	$letzter_teil = '';
	$letzte_lfd_nr = '';


	while ($row = $result->fetch_row()) {
		$nachweis_id = $row[0];
		$nervnummer = $row[1].$row[2].$row[3];
		$teil_ausbildungsberuf_beschreibung = $row[4];
		$fertigkeiten = $row[5];

		$how_many_days_have_this_nachweis_id = how_many_days_have_this_nachweis_id($nachweis_id);
?>
<?php
			if($letzter_teil != $row[1]) {
?>
				<tr><td colspan=6><h2>Abteilung <?php print $row[1]; ?></h2></td></tr>
<?php
				$letzter_teil = $row[1];
			}
?>
<?php
			if($letzte_lfd_nr!= $row[2]) {
?>
				<tr>
					<td colspan=6>
						<h3><?php print $row[2].': '.$teil_ausbildungsberuf_beschreibung ?></h3>
					</td>
				</tr>
<?php
				$letzte_lfd_nr = $row[2];
			}
?>
			<tr <?php print $how_many_days_have_this_nachweis_id == 0 ? "style='color: red'" : '' ?>>
				<form method="post">
					<input type="hidden" name="nachweis_id" value="<?php print htmlentities($nachweis_id); ?>" />
					<td><a id="<?php print htmlentities($nervnummer); ?>"><?php print htmlentities($nervnummer); ?></td>
					<td><textarea style="width: 100%; min-width: 800px" name="fertigkeiten"><?php print htmlentities($fertigkeiten); ?></textarea></td>
<?php
					foreach ($time_categories as $time_category) {
?>
						<td><input type="number" min="0" max="<?php print htmlentities($time_category[2] - $time_category[1]); ?>" name="time_category_<?php print $time_category[0]; ?>_richtwert" />
<?php
					}
?>
					<td><input type="submit" /></td>
					<td><?php print htmlentities($how_many_days_have_this_nachweis_id); ?></td>
				</form>
			</tr>
<?php
	}
?>
	</table>
