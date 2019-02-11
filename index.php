<?PHP
	require_once('database.php');


	session_start();

	if (isset($_SESSION['ingelogd'])){
		$ingelogd = $_SESSION['ingelogd'];
	}

	if (isset($_SESSION['huidigeLootje'])){
		$huidigeLootje = $_SESSION['huidigeLootje'];
		$huidigeLootje = htmlspecialchars($huidigeLootje);
		$huidigeLootje = $conn->real_escape_string($huidigeLootje);
	}

	if (isset($_SESSION['huidigeLootjeNr'])){
		$huidigeLootjeNr = $_SESSION['huidigeLootjeNr'];
	}

	if (isset($_SESSION['Truncated'])){
		$truncated = true;
	}

	if (isset($_SESSION['id'])){
		$lootje = $_SESSION['id'];

		$sql = "SELECT * FROM `v1g`";
		$res = $conn->query($sql);

		$last_user = false;
		$user = [];
		$uwBeurt = false;
		while ($row = $res->fetch_assoc()){
			if ($row['PersoonId'] == $lootje-1){
				$last_user = $row;
			}
			if ($row['PersoonId'] == $lootje){
				$user = $row;
			}
		}

		/*if($last_user['AlGeweest'] && !$user['AlGeweest']){
			$uwBeurt = true;
		}*/
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="mooiheid.css">
	</head>
	<body>
		<?php if(!isset($ingelogd)) { ?>
		<h1 id="hoofder">Welkom bij mijn fantastische lootjes-trek site</h1>
		</br>
		<?php } ?>
		<?php if (!isset($lootje) and !isset($ingelogd)){?>
		<a id="naam">Voer hier je naam in</a>
		<form action="insert.php" method="post">
			<input type="text" id="name" name="name">
			<input type="submit" id="verstuur" value="Send">
		</form>
		<?php } ?>

		<?php if (isset($lootje) and !isset($ingelogd)) { ?>
			<div>
				<h3>Je staat in de wachtrij, je nummer is: <?= $lootje ?></h3>
			</div>
		<?php } ?>
		<h1 id="aanDeBeurt"></h1>
		
		<?php if(!isset($ingelogd)) { ?>
		</br>
		</br>
		</br>
		</br>
		</br>
		<a>Als je een docent bent, kan je hier inloggen</a>
		<form action="docent.php" method="post">
			<input type="password" id="docentLog" name="docentLog">
			<input type="submit" value="Login">
		</form>
		<script>
			const Url = "getusers.php?update=<?=$lootje?>";
			
			
			const Params = {
			    headers: {
			        "content-type" : "application/json; charset=UTF-8"
			    },
			    method: "GET"
			};
			
			function fetchData() {fetch(Url, Params).then(data=> {
				return data.json()})
			.then(result=>{
				handleData(result)})
			.catch(error=>{
				console.log(error)
			})};
			
			const delay = t => new Promise(resolve => setTimeout(resolve, t));
			
			function handleData(stuff){
				console.log(stuff.AlGeweest);
			    if(stuff.AlGeweest == 1){
			        let aanDeBeurt = document.getElementById("aanDeBeurt");
			        aanDeBeurt.innerText = "Je bent aan de beurt.";
			    }
				delay(3000).then(() => {fetchData()});
			}

			fetchData();
		</script>
		<?php } elseif($ingelogd == true) { ?>
		<!-- Hier volgt alle code en html voor de docent -->
		<h1>Welkom docent</h1>
		</br>
		</br>
		<?php if(isset($_SESSION['Truncated'])) { ?>
		<h3>Alle gebruikers gewist</h3>
		<?php } ?>
		</br>
		<?php if(isset($huidigeLootje)) { ?>
		<h2>Gebruiker <?= $huidigeLootje ?> is aan de beurt met nummer: <?= $huidigeLootjeNr ?>
		<?php } ?>
		</br>
		</br>
		<form action="docentacties.php" method="post">
			<button type='submit' name="volgende">Trek volgende lootje</button>
			<button type="submit" name='trunkate'>Beeindig les</button>
		</form>

		<?php } ?>
	</body>
</html>
