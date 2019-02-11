<?PHP
require_once('database.php');

header("content-type:application/json");

if (isset($_GET['update'])){
	$update = $_GET["update"];
	$update = htmlspecialchars($update);
	$update = $conn->real_escape_string($update);

	$sqlUpdate = "SELECT * FROM `v1g` WHERE `PersoonId`='{$update}'";
	$updateSql = $conn->query($sqlUpdate);

	while ($row = $updateSql->fetch_assoc()) {
		$users = $row;
	}
	echo json_encode($users);
}
?>