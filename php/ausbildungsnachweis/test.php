<?php
$GLOBALS['get_artistname_and_id_cache'] = null;
//verschafft Zugang zu der Datenbank in mariadb
$GLOBALS['password'] = trim(file_get_contents('/etc/dbpw'));
$GLOBALS['mysqli'] = new mysqli("localhost", "root", $GLOBALS['password']);
if ($GLOBALS['mysqli']->connect_errno) {
	die("Verbindung fehlgeschlagen: " . $GLOBALS['mysqli']->connect_error);
}

function esc ($string) {
        return ''.$GLOBALS["mysqli"]->real_escape_string($string).'';
}

function get_single_value_from_query ($query, $default = NULL) {
        $result = run_query($query);
        $return_value = $default;
        while ($row = $result->fetch_row()) {
                $return_value = $row[0];
        }
        return $return_value;
}

$GLOBALS["queries"] = [];
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

function insert_date() {
  $datum=$_GET["datum"];
  print_r(date_parse_from_format("j.n", $datum));
  $datumarray=date_parse_from_format("j.n", $datum);
  print "2022-$datumarray[month]-$datumarray[day]";
  $fomat_date="2022-$datumarray[month]-$datumarray[day]";
  $query="INSERT INTO test_db2.id_datum (datum) VALUES ('$fomat_date')";
  run_query($query);
}
if(array_key_exists("datum", $_GET)) {
  insert_date();
}
?>
<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
</head>
<body>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Anmelden und Login</a></li>
    <li><a href="#tabs-2">Album und Artist</a></li>
    <li><a href="#tabs-3">bezeichnung des dritten tabs</a></li>
  </ul>
  <div id="tabs-1">
    <form method="get">
      <input name="datum"></input>
      <button>save</button>
    </form>
  </div>
  <div id="tabs-2">
    <h1>Album und Artist</h1>
			print "<br>\n<h2>Alben verändern/hinzufügen</h2>\n";
			print "<table>\n";
			print "<tr>\n";
			print "<th>Album</th>\n";
			print "<th>Artist</th>\n";
			print "<th>Del</th>\n";
			print "<th>Save</th>\n";
			print "</tr>\n";
			print "</table>\n";
	?>
  </div>
  <div id="tabs-3">
    tab 3 inhalt
  </div>
</div>
</body>
</html>

