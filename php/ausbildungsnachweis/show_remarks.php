<?php

include("mysql_functions.php");

$query = "select zeile, spalte, bemerkung from remarks where woche = '".$_GET["woche"]."'";
$result = run_query($query);
while($row = $result->fetch_assoc()) {
    $ergebnisse[] = $row;
}

header('Content-Type: application/json');

    print json_encode($ergebnisse);
?>