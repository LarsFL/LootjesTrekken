<?PHP
require_once('database.php');

session_start();
#header('Content-Type: text/event-stream');
#header('Cache-Control: no-cache');

$login = $_POST['docentLog'];
$login = htmlspecialchars($login);
$login = $conn->real_escape_string($login); 
#echo $login;
$sql = "SELECT * FROM `docenten`";
$passwordsSQL = [];
$passwords = [];
$thing = $conn->query($sql);

while ($row = $thing->fetch_assoc()) {
	$passwordsSQL[] = $row['pass'];
	#var_dump($row);
}

foreach ($passwordsSQL as $password){
	#var_dump($password);
	$passwords[] = $password;
}

#var_dump($passwordsSQL);

if (in_array($login, $passwordsSQL)){
	$_SESSION['ingelogd'] = true;	
	echo "\nlogin succesvol";
	header('Location:index.php');
} else {
		echo ("Sorry, $login is niet het goeie wachtwoord"	);

}
?>
