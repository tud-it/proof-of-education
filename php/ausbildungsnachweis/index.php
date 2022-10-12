<?php
	include("mysql_functions.php");

	function print_error ($msg) {
		print "<span style='background-color: red'>".htmlentities($msg)."</span><br>";
	}

	$number_of_users_query = "select count(*) from nachweis_db.name_vorname_starttimestamp";
	$number_of_users = get_single_value_from_query($number_of_users_query, 0);

	if($number_of_users == 0) {
		if(array_key_exists("setup", $_GET) && $_GET["setup"] != "") {
			if(array_key_exists("vorname", $_GET) && $_GET["vorname"] != "") {
				$vorname = $_GET["vorname"];
				if(array_key_exists("nachname", $_GET) && $_GET["nachname"] != "") {
					$nachname = $_GET["nachname"];
					if(array_key_exists("erster_tag", $_GET) && $_GET["erster_tag"] != "") {
						$erster_tag = $_GET["erster_tag"];
						if(validateDate($erster_tag)) {
						// if(preg_match("/20\d\d-\d{1,2}-\d{1,2}/", $erster_tag)) {
							$unix_timestamp = strtotime("$erster_tag 12:00:00");
							while (getdate($unix_timestamp)["weekday"] != "Monday") {
								$unix_timestamp -= 86400;
							}

							$query = "insert into nachweis_db.name_vorname_starttimestamp (name, vorname, starttimestamp) values ('".esc($nachname)."', '".esc($vorname)."', '".esc($unix_timestamp)."')";

							run_query($query);
							header('Location: index.php');
							exit(0);
						} else {
							print_error("$erster_tag sieht nicht aus wie ein Datum bzw. ist im falschen Format");
						}
					} else {
						print_error("Erster Tag nicht gegeben");
					}
				} else {
					print_error("Nachname nicht gegeben");
				}
			} else {
				print_error("Vorname nicht gegeben");
			}
		}
	}

	$number_of_users = get_single_value_from_query($number_of_users_query, 0);

	if($number_of_users) {
		$timestamp = time();

		$max_week = ceil(($timestamp - $GLOBALS["first_day_timestamp"]) / (7 * 86400));

		print "<table>\n";
		for ($i = $max_week; $i > 0; $i--) {
			$this_week_start = $GLOBALS["first_day_timestamp"] + ($i * 7 * 86400);
			$start_date = date('Y-m-d', $this_week_start);
			$end_date = date('Y-m-d', $this_week_start + (4 * 86400));

			print "<tr><td><a href='ausbildungsnachweis.php?woche=$i'>Woche $i</a><td><td>$start_date &mdash; $end_date</tr>\n";
		}
		print "</table>";
	} else {
		print "Keine User, bitte einen neuen eingeben:";
?>
		<form method="get">
			<input type="hidden" value="1" name="setup" />
			<table>
				<tr>
					<td>Vorname:</td>
					<td><input type="text" value="Claudia" name="vorname" /></td>
				</tr>
				<tr>
					<td>Nachname:</td>
					<td><input type="text" value="Adler" name="nachname" /></td>
				</tr>
				<tr>
					<td>Erster Tag der Ausbildung (YYYY-mm-dd)</td>
					<td><input type="text" value="2021-09-03" name="erster_tag" /></td>
				</tr>
			</table>
			<input type="submit" value="Eintragen" />
		</form>
<?php
	}
?>
