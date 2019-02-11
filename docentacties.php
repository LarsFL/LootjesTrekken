<?PHP
require_once('database.php');
session_start();


if (isset($_POST['volgende'])){
	$sqlSelect = "SELECT * FROM `v1g`";
	$query = $conn->query($sqlSelect);
	while ($row = $query->fetch_assoc()) {
		$sqlReturn[] = $row;
		#var_dump($row);
	}

	var_dump($sqlReturn);

	foreach ($sqlReturn as $user){
		if ($user['AlGeweest'] == true) {
			echo "\n geweest";
		} else {
			$_SESSION['huidigeLootje'] = $user['Naam'];
			$_SESSION['huidigeLootjeNr'] = $user['PersoonId'];
			var_dump($user);
			$userNaam = $user['Naam'];
			echo "\n$userNaam is niet geweest";
			$volgendeId = $user['PersoonId'];
			echo $volgendeId;
			$sqlVolgende = "UPDATE `v1g` SET `AlGeweest`=1 WHERE `PersoonId`= '{$volgendeId}'";
			$volgendeQuery = $conn->query($sqlVolgende);
			header('Location:index.php');
			break;
		}
	}
} elseif (isset($_POST['trunkate'])) {
	//do other things to stop 
	$sqlTruncate = ("TRUNCATE `v1g`");
	$truncateQuery = $conn->query($sqlTruncate);
	$_SESSION['Truncated'] = true;
	header('Location:index.php');
} else {
	echo "Something went wrong";
}

?>
