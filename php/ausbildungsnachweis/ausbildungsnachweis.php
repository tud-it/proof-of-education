<?php

	if((!preg_match('/^[0-9]*$/', $_GET["woche"], $match)) || (!array_key_exists("woche", $_GET)) || ($_GET["woche"] == "")) {
		header('Location: index.php');

		print("You are being redirected");
		exit(0);
	}

	$status_code = 200;
	if(!preg_match('/^[0-9]*$/', $_GET["woche"], $match)) {
		$status_code = 400;
	}
	http_response_code($status_code);

	include("mysql_functions.php");

	if(user_number() < 1) {
		header('Location: index.php');
		exit(0);
	}

	$this_week_start = $GLOBALS["first_day_timestamp"] + ($_GET["woche"] * 7 * 86400);
	$start_date = date('d.m', $this_week_start);
	$end_date = date('d.m.Y', $this_week_start + (4 * 86400));

	$git_start_date = date('Y-m-d', $this_week_start);
	$git_end_date = date('Y-m-d', $this_week_start + (4 * 86400));

	$GLOBALS["ausbildungsnachweisnummer"] = $_GET["woche"];
	if(wochennummer($_GET["woche"])) {
		$GLOBALS["ausbildungsnachweisnummer"] = wochennummer($_GET["woche"]);
	}
?>

<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8">
	<title>Ausbildungsnachweis</title>
	<style>
		@media print {
			.suche {
				display: None;
			}
			.git_eintraege {
				display: None;
			}
			.nachweisdatei {
				display: None;
			}
			#auswahl_nummer {
				display: None;
			}
			@page {
				margin: 0;
			}
			body {
				margin: 1.6cm;
			}
			#menu {
				display: None;
			}
			#explanation {
				display: None;
			}
		}

		body {
			font-size: 11pt;
			font-family: Arial;
		}

		.day {
			writing-mode: vertical-rl;
			width: 0.5cm;
		}

		table:nth-child(3n+0) {
			border: 2px solid black;
		}

		table:nth-child(2n+0) {
			border: 2px solid black;
		}

		td {
			border-right: 2px solid black;
			border-bottom: 2px solid black;
		}

		input {
			border: 1px solid white;
		}

		.stunde {
			width: 30px;
		}

		#name {
			top: 20px;
			left: 100cm;
			width: 10cm;
		}

		#vorname {
			left: 10px;
			top: 10px;
			width: 10cm;
		}

		table {
			width: 17cm;
			margin-left: 0.5cm;
		}

		.wochen_nr {
			width: 0.6cm;
		}

		.nachweisnummer {
			width: 3.7cm;
		}

		.bemerkungen {
			width: 7cm;
		}

		.kommentar {
			width: 10.1cm;
		}

		.kleine_schrift {
			font-size: 10px;
			text-align: center;
		}

		tr {
			border-bottom: black solid 2px;
		}

		.border_none {
			border: None;
		}

		.border_right_none {
			border-right: None;
		}

		.border-bottom_none {
			border-bottom: None;
		}

		.unterschriftenfeld {
			text-align: center;
		}

		.tabelle {
			/* position:fixed; */
			padding: 5px;
			float: left;
			background-color: rgb(250,250,250);
			/* position: relative; */
		}

		.suche {
			padding: 5px;
			background-color: rgb(250,240,240);
			/*min-width: 30%;*/
			/* display: inline-block; */
			/* max-width: 47%; */
			/* float: right; */
		}

		.git_eintraege {
			padding: 5px;
			background-color: rgb(230,240,250);
			/* background-color: rgb(250,250,240); */
			min-width: 30%;
			/* max-width: 47%; */
			/* float: left; */
		}

		.nachweisdatei {
			position: sticky;
			top: 0px;
			z-index: 3;
			padding: 5px;
			background-color: rgb(240,250,240);
			/* width: 100%; */

		}

		.container {
			width: 99%;
		}

		#okmsg {
			position: fixed;
			top: 0px;
			left: 0px;
			width: 100%;
			background-color: green;
			color: white;
			z-index: 20;
		}

		#failmsg {
			position: fixed;
			top: 0px;
			width: 100%;
			background-color: red;
			color: white;
			z-index: 2;
		}

		#menu {
			font-size: 14pt;
			position: fixed;
			/* top: 5px; */
			right: 35px;
			background-color: rgba(255,255,255,70%);
			/* border: solid rgb(200,210,200) 2px; */
			padding: 5px;
			z-index: 10;
			max-width: 50%;
		}
		
		ul {
			list-style-type: none;
			padding: 10px;
			margin: 0;
		}

		#explanation {
			padding: 5px;
			position: sticky;
			top: 0px;
			margin: auto;
			text-align: center;
			/* width: 40%; */
			z-index: 4;
			background-color: rgb(230,240,250);
			/* background-color: rgb(250,240,240); */
			/* border: solid red 2px; */
		}

		.tabelle-suche {
			position: relative;
		}
	</style>

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
	<script src="holiday-de.js"></script>

	<script>

		function log(msg) {
			console.log(msg);
		}

		function insert_date(element) {

			holiday.setState('sn');

			var year = $(element).data("year");
			var month = $(element).data("month");
			var day = $(element).data("day");

			var is_holiday = holiday.isHoliday(new Date(year, month, day));

			if(is_holiday) {
				$(element).attr("placeholder", is_holiday);
			}
		}

	</script>
</head>

<body>
	<section class="container">

		<div id="menu">
			<ul>
				<!-- <label for="menu_git"><li id="menu_git" onclick="hide_msg('git')">Git</li></label> -->
				<label for="menu_search"><li id="menu_search" onclick="hide_msg('suche')">Suche</li></label>
				<label for="menu_pdfs"><li id="menu_pdfs" onclick="hide_msg('nachweisdatei')">PDFs</li></label>
				<label for="menu_explanation"><li id="menu_explanation" onclick="hide_msg('explanation')">Hinweise</li></label>
			</ul>
		</div>

		<div id="explanation" onclick="hide_msg('explanation')">
			Strg+y : kopiert die Nachweisnummern von Montag nach unten
			<br>Strg+Alt+a : kopiert die Kommentare von Montag nach unten
			<br>Strg+Alt+q : kopiert die Stundenzahl von Montag nach unten
		</div>

		<div id="okmsg" style="display: block"></div>
		<div id="failmsg" onclick="hide_msg('#failmsg')" style="display: none"></div>

		<div id="nachweisdatei" class="nachweisdatei">
			<span><b>Ausbildungsnachweise hochladen</b></span>
			<form id="formId" action="/upload" enctype="multipart/form-data" method="post">
			<input type="file" name="upload" id="file_upload" multiple="multiple" accept="application/pdf"><br>
			</form>
			<div id="uploadStatus"></div><br>

			<span><b>Ausbildungsnachweise herunterladen</b></span>
			<div id="pdf_download"></div>
		</div>
		<div class="tabelle-suche">
			<div class="tabelle">

				<table>
					<tr>
						<td class="border_none">Name: <?php print htmlentities($GLOBALS["last_name"]); ?></td>
						<td class="border_none">Vorname: <?php print htmlentities($GLOBALS["first_name"]); ?></td>
					</tr>
				</table>

				<table>
					<tr>
						<form method='get'>
							<?php print "<td colspan='4' class='border_right_none'>Ausbildungsnachweis Nr. <input name='woche' class='wochen_nr' value='".esc($GLOBALS["ausbildungsnachweisnummer"])."' oninput='change_nachweisnr(this)'> für die Woche vom $start_date &nbsp;&nbsp; bis $end_date &nbsp;&nbsp; Ausbildungsjahr</td>\n" ?>
						</form>
					</tr>
					<tr>
						<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ausgeführte Arbeiten, Unterricht usw.</td>
						<td class="kleine_schrift">Einzel-<br>stunden</td>
						<td class="kleine_schrift border_right_none">Nachweisnummer</td>
					</tr>
	<?php
					$wochentags_name = ["Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag"];
					$nachweisnr_field_counter = 0;
					$k = 0;
					$kommentar_nr = 0;

					for ($i = 0; $i < 5; $i++) {
						$day_timestamp = $this_week_start + ($i * 86400);
						$day_date = date('Y-m-d', $day_timestamp);

						// A04
						$kommentare_query = 'select kommentar_1, kommentar_2, kommentar_3, kommentar_4, kommentar_5, einzelstunde_1, einzelstunde_2, einzelstunde_3, einzelstunde_4, einzelstunde_5 from nachweis_db.kommentare_id_datum_stunden where datum = "'.esc($day_date).'"';
						$tagesdaten = [];

						$result = run_query($kommentare_query);

						while($row = $result->fetch_assoc()) {
							$tagesdaten = $row;
						}
	?>
						<form method='get' id="nachweis_<?php print $i ?>">
							<input type="hidden" name="datum" value="<?php print $day_date ?>" />
	<?php
							for ($j = 1; $j <= 5; $j++) {
	?>
							<tr class="datenzeile" data-datum="<?php print $day_date; ?>" data-tag="<?php print $i ?>" data-internal_row_nr="<?php print $k++; ?>" onkeyup="change_row(this)">
	<?php
									if($j == 1) {
	?>
								<td rowspan="5" class="day"><?php print $wochentags_name[$i]; ?></td>
	<?php
									} else {
	?>
								<input type="hidden" class="filler">
	<?php
									}

									$nachweisnummern = array();

									$tag_id = get_tag_id_from_datum($day_date);
									if($tag_id) {
										$nachweisnummern_query = "select nachweis_id from tag_nachweise where tag_id = ".esc($tag_id)." and kommentarnummer = ".esc($kommentar_nr);
										$nachweisnummern_result = run_query($nachweisnummern_query);

										while ($row = $nachweisnummern_result->fetch_row()) {
											$nachweisnummern[] = get_nachweisnummer_from_nachweis_id($row[0]);
										}
									}

									$nachweisnummern_string = join(", ", $nachweisnummern);
			?>
								<td><input onload="insert_date(this)" data-year="<?php print date("Y", $day_timestamp); ?>" data-month="<?php print date("m", $day_timestamp) - 1; ?>" data-day="<?php print date("d", $day_timestamp); ?>"  name="kommentar_<?php print $j; ?>" class="kommentar" value="<?php print array_key_exists("kommentar_$j", $tagesdaten) ? $tagesdaten["kommentar_$j"] : ''; ?>"></td>
								<td><input class="stunde" name="einzelstunde_<?php print $j; ?>" value="<?php print array_key_exists("einzelstunde_$j", $tagesdaten) ? $tagesdaten["einzelstunde_$j"] : ''; ?>"></td>
								<td class="border_right_none"><input name="nachweisnummer" class="nachweisnummer" value="<?php print htmlentities($nachweisnummern_string); ?>"></td>
							</tr>
			<?php
								$kommentar_nr++;
							}
			?>
						</form>

			<?php
					}
			?>
				</table>
				<table>
					<tr>
						<td class="unterschriftenfeld border_right_none" colspan="2">Besondere Bemerkungen</td>
					</tr>
					<tr>
						<td class="unterschriftenfeld">Auszubildender</td>
						<td class="unterschriftenfeld border_right_none">Ausbildender bzw. Ausbilder</td>
					</tr>
	<?php	
					for ($i = 0; $i < 4; $i++) {
	?>
						<tr>
							<td><input id="azubi_remark_<?php print $i ?>" class="bemerkungen" onchange="save_azubi_remarks(this)"></td>
							<td class="border_right_none"><input id="ausb_remark_<?php print $i?>" class="bemerkungen" onchange="save_ausb_remarks(this)"></td>
						</tr>
	<?php   
					}
	?>
				</table>
				<table>
						<tr>
							<td colspan="2" class="unterschriftenfeld border_right_none kleine_schrift">Für die Richtigkeit</td>
						</tr>
						<tr>
							<td class="border-bottom_none"><input class="bemerkungen"></td>
							<td class="border-bottom_none border_right_none"><input class="bemerkungen"></td>
						</tr>
				</table>
			</div>

			<div id="suche" class="suche">
				<div class="fixed">
					<span class="h_suche"><b>Suche</b></span>
				</div>
				<div id="auswahl_nummer"></div>

			</div>

		</div>
		<div id="git" class="git_eintraege">

			<a href="git.php?woche=<?php print $_GET["woche"] ?>" target="_blank">Git-Tabelle</a><br><br>
<?php
			get_git_all(get_path(), $git_start_date, $git_end_date);
?>
		</div>
	</section>

	<script>
		// Nummern werden kopiert (ctrl+y)
		$("body").on("keyup", function (e) {

			if(e.ctrlKey && e.key == 'y') {
				copy_first_entry("nachweisnummer");
			}

			if(e.ctrlKey && e.altKey && e.key == 'a') {
				copy_first_entry("kommentar");
			}

			if(e.ctrlKey && e.altKey && e.key == 'q') {
				copy_first_entry("stunde");
			}
		});

		function copy_first_entry(obj_class) {
			var first_row = document.getElementsByClassName(obj_class)[0]["value"];
			var get_elements = document.getElementsByClassName(obj_class);
			get_elements[6]["value"] = get_elements[1]["value"];
			var j = 5;
			for(var i = 0; i < 5; i++) {
				j += i;
				for(j; j < 25; j += 5) {
					get_elements[j]["value"] = get_elements[i]["value"];
					$(get_elements[j]).trigger("keyup");
				}
				j = 5;
			}
		}

		function debug(msg) {
			log(msg);
		}

		function ajax(url) {
			$.ajax({
				url: url
			});
		}

		function and_url(url_params) {
			var url = "submit.php?";
			url = url + url_params.join("&");
			return url;
		}

		function warn(message) {
			console.warn(message);
		}

		function assert(test_value, message) {
			if(!test_value) {
				alert(message);
			}
		}

		// die Suchergebnisse werden unter der Tabelle ausgegeben
		function show_search_results (search_data, data_key_nr, kommentarnr) {

			if((search_data[data_key_nr]["eingabe"] != "") || !(search_data[data_key_nr]["eingabe"].match(/^[\d\w]+$/) || (search_data[data_key_nr]["candidates"][0] !== undefined))) {
				var keys = Object.keys(search_data[data_key_nr]["candidates"]);

				if(keys.length >= 1) {
					var eingabe = search_data[0]["eingabe"];
					var eingabe_re = new RegExp("(" + eingabe + ")", "i"); ;
					document.getElementById("auswahl_nummer").innerHTML = "";
					for(var k = 0; k < keys.length; k++) {
						var this_candidate = search_data[data_key_nr]["candidates"][keys[k]];
						var p = document.createElement("p");
						p.value = this_candidate["nachweisnummer"];
						this_candidate["fertigkeiten"] = this_candidate["fertigkeiten"].replace(eingabe_re, "<span style='background-color: orange'>$1</span>")

						var p_inhalt = '<span onclick="add_nachweisnr_to_field(this, ' + kommentarnr + ',\'' + search_data[data_key_nr]["candidates"][keys[k]]["nachweisnummer"] + '\',\'' + search_data[data_key_nr]["eingabe"] + '\');">' + this_candidate["nachweisnummer"] + " " + this_candidate["fertigkeiten"] + '</span>';
						p.innerHTML = p_inhalt;
						document.getElementById("auswahl_nummer").appendChild(p);
					}
				} else {
					document.getElementById("auswahl_nummer").innerHTML = "";
				}
			}
		}

		function add_nachweisnr_to_field (element, field_nr, nachweis_text, replaces) {
			assert(typeof(field_nr) == "number", "field_nr must be number");
			var nachweisnr_feld = $(".nachweisnummer")[field_nr];
			var old_value = $(nachweisnr_feld).val();

			old_value = old_value.replace(replaces, "");
			old_value = old_value.replace(/,\s*,/, ",");

			var new_html = old_value;

			if(old_value) {
				new_html += ", ";
				new_html = new_html.replace(/,\s*,/, ",");
			}

			new_html += nachweis_text;

			$(nachweisnr_feld).val(new_html);

			$(element).remove();
			change_row($(".datenzeile")[field_nr], 1);
		}

		// Tests um Code zu überprüfen
		var test_url = "search.php?terms=informatio";
		$.getJSON(test_url, function(data) {
			if(data[0]["is_nachweisnummer"] == "true") {
				warn("request for 'informatio' search.php not working");
			}
		});

		function check_hours(row) {
			var tag = $(row).data("tag");
			var startnr = tag * 5;
			var endnr = tag * 5 + 4;
			var elemente = document.getElementsByClassName("stunde");
			var ges = 0;
			for(startnr; startnr <= endnr; startnr++) {
				var num = parseInt(elemente[startnr]["value"]);
				if(Number.isInteger(num)) {
					ges += num;
				}
			}

			if((ges == 8) || (ges == 0)) {
				for(i = 0; i < 5; i++) {
					var zeile = tag * 5 + i;

					document.getElementsByClassName("stunde")[zeile].style.backgroundColor = "white";
				}
			} else {
				for(i = 0; i < 5; i++) {
					var zeile = tag * 5 + i;
					document.getElementsByClassName("stunde")[zeile].style.backgroundColor = "red";
				}
			}
		}

		function change_row (row, dont_search_again) {
			check_hours(row);
			var internal_row_nr = $(row).data("internal_row_nr");
			var tag = $(row).data("tag");
			var datum = $(row).data("datum");

			var row_children = $(row).children();

			var td_kommentar = row_children[1];
			var td_einzelstunde = row_children[2];
			var td_nachweisnr = row_children[3];

			var kommentar_element = $(td_kommentar).children()[0];
			var einzelstunde_element = $(td_einzelstunde).children()[0];
			var nachweisnr_element = $(td_nachweisnr).children()[0];

			if(kommentar_element != "" && kommentar_element !== undefined) {
				push_params_kommentare_tabelle(datum, kommentar_element, einzelstunde_element, tag);
			}

			if(nachweisnr_element["value"] != "") {
				push_params_tag_nachweis_tabelle(datum, tag, internal_row_nr, nachweisnr_element["value"], dont_search_again);

			}
		}

		function push_params_kommentare_tabelle(datum, kommentar, einzelstunde, kommentarnr) {
			var url_params = [];
			url_params.push("datum=" + encodeURIComponent(datum));
			url_params.push(kommentar["name"] + "=" + encodeURIComponent(kommentar["value"]));
			url_params.push(einzelstunde["name"] + "=" + encodeURIComponent(einzelstunde["value"]));
			url_params.push("kommentarnummer=" + encodeURIComponent(kommentarnr));
			ajax(and_url(url_params));
			show_okmsg();
		}

		function push_params_tag_nachweis_tabelle(datum, tag, kommentarnr, eingabe, dont_search_again) {
			
			if(eingabe.match(/^([A-Z][0-9][a-z], )*[A-z][0-9][a-z]$/)) {
				var url_params = [];
				url_params.push("datum=" + encodeURIComponent(datum));
				url_params.push("tag_id=" + encodeURIComponent(tag));
				url_params.push("kommentarnummer=" + encodeURIComponent(kommentarnr));
				url_params.push("nachweisnummer=" + encodeURIComponent(eingabe));
				ajax(and_url(url_params));
				show_okmsg();
			} else {
				if(!dont_search_again) {
					$.getJSON("search.php?terms=" + eingabe, function(search_data) {
						var data_keys = Object.keys(search_data);
						if(data_keys.length == 0) {
							document.getElementById("auswahl_nummer").innerHTML = "";
						}
						for(var data_key_nr = 0; data_key_nr < data_keys.length; data_key_nr++) {
							if(search_data[data_key_nr]["is_nachweisnummer"] != "true") {
								show_search_results(search_data, data_key_nr, kommentarnr);
							}
						}
					});

				}
				
			}
		}

		function change_nachweisnr(parameter) {
			var wochennr = <?php print $_GET["woche"] ?>;
			ajax("submit.php?new_nachweisnr=" + parameter["value"] + "&woche=" + wochennr);
		}

		$("input[name='kommentar_1'").each((nr, element) => { insert_date(element) });

		//Wenn etwas hochgeladen wird sollen die PDFs gespeichert werden
		$("#file_upload").on('change', function(e){
			e.preventDefault();
			var files = document.getElementById("file_upload").files;
			// steht var reader hier wird nur eine datei gespeichert
			// readers = []
			var reader = new FileReader();
			
			// jede PDF wird durchgegangen
			for(var i = 0; i < files.length; i++) {
				// steht reader hier wird mehrmals dieselebe datei gespeichert
				// reader = new FileReader();
				// lösungsansatz mit extra reader für jeden file funktionierte nicht
				// readers.push("reader" + i)
				// dann reader durch readers[i] ersetzen
				var file = files[i];

				var filename = file["name"];

				// geht los wenn die PDF eingelesen ist
				reader.onload = function() {
					var uploaded_file = reader.result.split(',')[i];
					//log(reader.result)
					var upload_data = {
						uploaded_file: uploaded_file
					}

					var wochennr = <?php print $_GET["woche"] ?>;
	
					$.ajax({
						type: 'POST',
						url: 'save_pdf.php?filename=' + filename + '&wochennr=' + wochennr,
						data: new URLSearchParams(upload_data),
						contentType: false,
						cache: false,
						processData:false,
						error: function(a,b,c){
							$('#uploadStatus').html('<span style="color:#EA4335;">Upload failed, please try again. (' + c + ')<span>');
							show_failmsg();
						},
						success: function(data){
							$('#uploadStatus').html('<span style="color:#28A74B;">Uploaded successfully. Document is signed: ' + data + '<span><br>\n');
							show_okmsg();
							show_available_pdfs();
						}
					});
				};
				reader.readAsDataURL(file);
			}
		});

		function delete_pdf(id) {
			if(confirm("Die PDF wirklich löschen?")) {
				ajax("delete_pdf.php?id=" + id);
				show_available_pdfs();
				show_okmsg();
			}
		}

		function show_available_pdfs () {
			$.ajax({
				url: "search_pdf.php?wochennr=<?php print $_GET["woche"] ?>",
				success: function(data) {
					if(data == null) {
						$('#pdf_download').html('<p>Es wurden noch keine PDFs hochgeladen</p>');
					} else {
						$('#pdf_download').html('<ul>');
						for(var i = 0; i < data.length; i++) {
							if(data[i]["filename"].match(/.png$/)) {
								$('#pdf_download').append('<li><a href="open_png.php?id=' + data[i]["id"] + '">' + data[i]["filename"] + '</a> (nicht signiert) <button onclick="delete_pdf(' + data[i]["id"] + ')"> Lösche Datei </button></li>');
							} else {
								if(data[i]["signiert"] == 1) {
									$('#pdf_download').append('<li><a href="download_pdf.php?id=' + data[i]["id"] + '">' + data[i]["filename"] + '</a> (signiert) <button onclick="delete_pdf(' + data[i]["id"] + ')"> Lösche Datei </button></li>');
								} else {
									$('#pdf_download').append('<li><a href="download_pdf.php?id=' + data[i]["id"] + '">' + data[i]["filename"] + '</a> (nicht signiert) <button onclick="delete_pdf(' + data[i]["id"] + ')"> Lösche Datei </button></li>');
								}
							}
						}
						$('#pdf_download').append('</ul>');
					}
				}
			});
		}
		
		function save_azubi_remarks(elem) {
			$.ajax({
				url: "save_remarks.php?woche=<?php print $_GET["woche"] ?>&zeile=" + elem["id"][13] + "&spalte=1&bemerkung=" + elem["value"],
				success: function(data) {
					show_remarks();
					show_okmsg();
				},
				error: function() {
					show_failmsg();
				}
			});
		}

		function save_ausb_remarks(elem) {
			$.ajax({
				url: "save_remarks.php?woche=<?php print $_GET["woche"] ?>&zeile=" + elem["id"][12] + "&spalte=2&bemerkung=" + elem["value"]
			});
			show_remarks();
			show_okmsg();
		}
 
		function show_remarks() {
			url = "show_remarks.php?woche=<?php print $_GET["woche"] ?>";
			$.getJSON(url, function (remark_data) {
				if(remark_data != null) {
					for (row = 0; row < remark_data.length; row++) {
						if(remark_data[row]["spalte"] == "1") {
							document.getElementById("azubi_remark_" + remark_data[row]["zeile"]).value = remark_data[row]["bemerkung"];
						} else {
							document.getElementById("ausb_remark_" + remark_data[row]["zeile"]).value = remark_data[row]["bemerkung"];
						}
					}
				}
			});
		}

		function show_okmsg() {
			$("#okmsg").html("Gespeichert").show().delay(300).fadeOut();
		}

		function show_failmsg() {
			$("#failmsg").html("Nicht gespeichert").show();
		}

		function hide_msg(id) {
			if(document.getElementById(id).style.display == "none") {
				$("#" + id).show()
			} else {
				$("#" + id).hide();
			}
		}

		show_remarks();
		show_available_pdfs();
		document.getElementById("git").hidden = true 
		// document.getElementById("nachweisdatei").hidden = true 
	</script>

</body>
</html>
