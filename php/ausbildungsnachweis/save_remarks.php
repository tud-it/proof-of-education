<?php
include("mysql_functions.php");
$query = "insert into nachweis_db.remarks (woche, zeile, spalte, bemerkung) values ('".$_GET["woche"]."', '".$_GET["zeile"]."', '".$_GET["spalte"]."', '".$_GET["bemerkung"]."') on duplicate key update woche = values(woche), zeile = values(zeile), spalte = values(spalte), bemerkung = values(bemerkung)";
run_query($query);
?>