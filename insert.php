<?php
require_once('database.php');

session_start();

if(isset($_POST['name']) && !empty($_POST['name'])){
	$name = $_POST["name"];
	$name = htmlspecialchars($name);
	$name = $conn->real_escape_string($name);
	
	$sql = "INSERT INTO `v1g`(`Naam`) VALUES ('{$name}')";
	if ($conn->query($sql)) {
		$_SESSION['id'] = $conn->insert_id;
		header('Location:index.php');
		echo "Alles werkt :)";
	} else{
		echo "Iets werkte niet :(";
	}
} else {
	exit();
}

/*
if(isset($uwBeurt)){
	$beurtSql = "UPDATE `v1g` SET `AlGeweest`='1' WHERE PersoonId='{$user}'";
	if ($conn->query($beurtSql)) {
		echo "Geupdate ofzo :)";
	}
}*/
?>