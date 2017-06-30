<?php
require 'include.php';
$pdo = connect();
	$query = $_GET["sql"];
	$query = "$query union all $query";

	$result = $pdo->prepare($query);
	$result->execute();
	if ($result->fetchColumn(0)) {
		echo str_replace(' ', '', $result->fetchColumn(0));
	} else {echo "";}

