<?php

#	if(file_exists("/etc/dbpw")) {
#		$GLOBALS['password'] = trim(file_get_contents('/etc/dbpw'));
#	} else {
#		die("Cannot open /etc/dbpw");
#	}
	$GLOBALS['password'] = "devpass";
	$GLOBALS['mysqli'] = new mysqli("mariadb", "devuser", $GLOBALS['password']);
	if ($GLOBALS['mysqli']->connect_errno) {
		die("Verbindung fehlgeschlagen: " . $GLOBALS['mysqli']->connect_error);
	}

	if (!mysqli_select_db($GLOBALS["mysqli"], "nachweis_db")){
		$sql = "CREATE DATABASE nachweis_db";
		if (run_query($sql) === TRUE) {
			mysqli_select_db($GLOBALS["mysqli"], "nachweis_db");
			load_sql_file_get_statements("nachweis.sql");
		} else {
			echo "Error creating database: " . $GLOBALS['mysqli']->error;
		}
	}

	$GLOBALS["first_name"] = "Claudia";
	if(user_first_name()) {
		$GLOBALS["first_name"] = user_first_name();
	}
	$GLOBALS["last_name"] = "Adler";
	if(user_last_name()) {
		$GLOBALS["last_name"] = user_last_name();
	}

	$GLOBALS["queries"] = [];

	function get_tag_id_from_datum($datum) {
		$query = "select id from kommentare_id_datum_stunden where datum = '".esc($datum)."'";
		return get_single_value_from_query($query);
	}

	function get_nachweisnummer_from_nachweis_id ($id) {
		$query = "select concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) as nachweisnummer from nachweis_db.nachweis where id = ".esc($id);
		return get_single_value_from_query($query);
	}

	function run_query ($query) {
		$start_time = microtime(true);
		$result = $GLOBALS['mysqli']->query($query);
		if($result === false) {
			dier("Query failed:\n$query\nError:\n".$GLOBALS["mysqli"]->error);
		}
		$end_time = microtime(true);
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		$GLOBALS["queries"][] = ["query" => $query, "runtime" => ($end_time - $start_time), "location" => $caller['file'].', '.$caller['line']];
		return $result;
	}

	function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}

	function wochennummer($woche) {
		return get_single_value_from_query("select ausbildungsnachweisnr from woche_ausbildungsnachweisnr where woche = '".htmlentities($woche)."'");
	}

	function user_number() {
		$number_of_users_query = "select count(*) from nachweis_db.name_vorname_starttimestamp";
		return get_single_value_from_query($number_of_users_query, 0);
	}

	function user_last_name() {
		return get_single_value_from_query("select name from nachweis_db.name_vorname_starttimestamp");
	}

	function user_first_name() {
		return get_single_value_from_query("select vorname from nachweis_db.name_vorname_starttimestamp");
	}

	function is_nachweisnummer($string) {
		if(preg_match("/^[A-Z][0-9][a-z]$/", $string)) {
			$nummer_datenbank = get_single_value_from_query("SELECT concat(teil_ausbildungsberuf_buchstabe, lfd_nr, fertigkeiten_buchstabe) AS nachweisnummer FROM nachweis_db.nachweis HAVING nachweisnummer = '$string'");
			if($nummer_datenbank != NULL) {
				return true;
			}
		}
		return false;
	}

	function get_single_value_from_query ($query, $default = NULL) {
		$result = run_query($query);
		$return_value = $default;
		while ($row = $result->fetch_row()) {
			$return_value = $row[0];
		}
		return $return_value;
	}

	function esc_or_null ($string) {
		if($string != "") {
			return "'".esc($string)."'";
		} else {
			return "NULL";
		}
	}

	function esc ($string) {
	        return $GLOBALS["mysqli"]->real_escape_string($string);
		}

	function dier ($data, $enable_html = 0) {
		$source_data = debug_backtrace()[0];
		@$source = 'Aufgerufen von <b>'.debug_backtrace()[1]['file'].'</b>::<i>'.debug_backtrace()[1]['function'].'</i>, line '.htmlentities($source_data['line'])."<br>\n";
		print $source;

		print "<pre>\n";
		ob_start();
		print_r($data);
		$buffer = ob_get_clean();
		if($enable_html) {
			print $buffer;
		} else {
			print htmlentities($buffer);
		}
		print "</pre>\n";

		print "Backtrace:\n";
		print "<pre>\n";
		foreach (debug_backtrace() as $trace) {
			print htmlentities(sprintf("\n%s:%s %s", $trace['file'], $trace['line'], $trace['function']));
		}
		print "</pre>\n";

		exit();
	}

	function load_sql_file_get_statements ($file) {
		$contents = file_get_contents($file);
		$contents = "SET FOREIGN_KEY_CHECKS=0;\n$contents";
		$contents = preg_replace("/--.*/", "", $contents);
		$contents = preg_replace("/\/\*.*?\*\/;/", "", $contents);
		$contents = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $contents);
		$contents = "$contents\nSET FOREIGN_KEY_CHECKS=0;\n";

		$queries = explode(";", $contents);
		foreach ($queries as $query) {
			if(!preg_match("/^\s*$/", $query)) {
				run_query($query);
			}
		}
	}

	function looks_like_date ($date) {
		if(preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
			return true;
		}
		return false;
	}

	function get_git_history ($path, $from_date, $to_date) {
		if(is_dir($path) && is_dir("$path/.git")) {
			if(looks_like_date($from_date)) {
				if(looks_like_date($to_date)) {
					$command = "git --git-dir $path.git log --oneline --since=$from_date --until=$to_date | grep -v 'nachweisdb_backup.sql.aes256'";
					ob_start();
					system($command, $return_value);
					$result = ob_get_clean();

					if($return_value == 0) {
						return $result;
					} else {
						file_put_contents('php://stderr', "$command failed. Exit-Code: $return_value\n");
					}
				} else {
					file_put_contents('php://stderr', "$to_date does not look like a valid date\n");
				}
			} else {
				file_put_contents('php://stderr', "$from_date does not look like a valid date\n");
			}
		} else {
			file_put_contents('php://stderr', "$path does not exist\n");
		}
	}

	function get_data_from_column($query, $index) {
		$result = run_query($query);
		$array = [];
		while($row = $result->fetch_assoc()) {
			$array[] = $row["$index"];
		}
		return $array;
	}

	function get_path() {
		return get_data_from_column("select filepath from nachweis_db.id_project_filepath where search = 1", "filepath");
	}

	/* function get_git_all($path_array, $from_date, $to_date) {
		foreach($path_array as $path) {
			print $path;
			print "<pre>" .get_git_history($path, $from_date, $to_date). "</pre>";
		}
		print dirname(__FILE__);
		print "<pre>" .get_git_history(dirname(__FILE__), $from_date, $to_date). "</pre>";

	} */

	function get_git_all($path_array, $from_date, $to_date) {                                                                                                                                                                           
		if(!in_array(dirname(__FILE__), $path_array)) {                                                                                                                                                                             
			$path_array[] = dirname(__FILE__);                                                                                                                                                                                  
		}                                                                                                                                                                                                                           
		foreach($path_array as $path) {                                                                                                                                                                                             
			$git_history = get_git_history($path, $from_date, $to_date);                                                                                                                                                        
			if($git_history) {                                                                                                                                                                                                  
				print $path;                                                                                                                                                                                                
				print "<pre>" .$git_history. "</pre>";                                                                                                                                                                      
			}                                                                                                                                                                                                                   
		}                                                                                                                                                                                                                           
	} 

	function isStringInFile($file, $string){
		$valid = false;

		if (strpos($file, $string) !== false) {
			$valid = true;
		}

		return $valid;
	}

	function file_is_signed ($file) {
		return isStringInFile($file, 'adbe.pkcs7.detached');
	}

	$GLOBALS["first_day_timestamp"] = get_single_value_from_query("SELECT starttimestamp FROM nachweis_db.name_vorname_starttimestamp WHERE id = 1");
	
?>
