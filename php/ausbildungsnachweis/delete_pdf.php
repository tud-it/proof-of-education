<?php

include"mysql_functions.php";

$query = "delete from nachweisdatei_wochennr_id where id = '".$_GET["id"]."'";
run_query($query);

?>