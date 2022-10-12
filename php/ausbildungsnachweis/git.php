<?php
	include("mysql_functions.php");

?>

	<h1>Git Übersicht</h1>

	<a href="ausbildungsnachweis.php?woche=<?php print $_GET["woche"] ?>">Zurück zum Ausbildungsnachweis</a><br><br>

	<table style="border: solid black 2px">
		<tr>
			<th>Projekt</th>
			<th>Pfad</th>
			<th>Suchen?</th>
			<th>Löschen?</th>
		</tr>

<?php

	foreach(get_data_from_column("select id from nachweis_db.id_project_filepath", "id") as $id) {
		$project = get_single_value_from_query("select project from nachweis_db.id_project_filepath where id = $id");
		$path = get_single_value_from_query("select filepath from nachweis_db.id_project_filepath where id = $id");
?>
		<form method='get'>
			<tr>
				<input type="hidden" name="id" value='<?php print $id ?>'>
				<td><input name='project' type='text' value='<?php print $project ?>'></td>
				<td><input name='path' type='text' value='<?php print $path ?>'></td>
<?php

	if(get_single_value_from_query("select search from nachweis_db.id_project_filepath where id = $id") == "1") {
?>
				<td><input name='search' type='checkbox' checked></td>
<?php
	} else {
?>
				<td><input name='search' type='checkbox'></td>
<?php
	}
?>
				<td><input type='checkbox' name='delete'></td>
				<td><button>Save</button></td>
			</tr>
		</form>
<?php
	}
?>
		<form method='get'>
			<tr>
				<td><input name='project_new'></td>
				<td><input name='path_new'></td>
				<td colspan="2"></td>
				<td><button>Save</button>
			</tr>
		</form>
	</table>
<?php

	if(array_key_exists("search", $_GET)) {
		$search = 1;
	} else {
		$search = 0;
	}

	if(array_key_exists("id", $_GET)) {
		if(array_key_exists("delete", $_GET)) {
			$query = "delete from nachweis_db.id_project_filepath where id = '".esc($_GET["id"])."'";
		} else {
			$query = "update nachweis_db.id_project_filepath set project = '".esc($_GET["project"])."', filepath = '".esc($_GET["path"])."', search=$search where id = '".esc($_GET["id"])."'";
		}
		run_query($query);
		print '<script>window.location.href = "git.php";</script>';

	}

	if(array_key_exists("project_new", $_GET)) {
		$query = "insert into nachweis_db.id_project_filepath (project, filepath, search) values ('".esc($_GET["project_new"])."', '".esc($_GET["path_new"])."', '$search')";
		run_query($query);
		print '<script>window.location.href = "git.php";</script>';
	}

?>
