	<?PHP
	$servername = ""; //Server naam (localhost is standaard)
	$username = "";	//Server login naam
	$password = ""; //Server login wachtwoord
	$dbname = "klasselootjes"; //Database naam
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
?>	
