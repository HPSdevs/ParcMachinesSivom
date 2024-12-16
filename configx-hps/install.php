<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="../assets/styles/install.css" rel="stylesheet" type="text/css" />
	<title>Installation</title>
</head>

<body>
	<div class="connexion">
		<div class="encart">
			<div class="titre">
				<h4>ParcMachinesSIVOM</h4>
				<h3>©2024 <a href="https://github.com/HPSdevs">HANNOT Philippe</a></h3>
				<h2>module d'installation v1.0</h2>
			</div>
			<div class="information">
				<div class="info">
					<?php
					ini_set('display_errors', 'on');
					$c = parse_ini_file("../configx-hps/config-basededonnees.ini");
					foreach ($c as $key => $val) {
						eval("\$config$key = '$val';");
					}
					if (is_array($c)) {
						$dsn = "mysql:host=" . $confighost . ";port=" . $configport;
						$dsn .= ";dbname=" . $configdb . ";charset=" . $configcharset;
						$options = [
							PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
							PDO::ATTR_EMULATE_PREPARES   => false,
						];
						echo "Le host est ' $confighost '<br/>";
						echo "Le user de la base sera ' $configuser '<br/>";
						$pdo = new PDO("mysql:host=$confighost", $configroot, $configrootpass, NULL);
						echo "<br/>Création de la base de données<br>";
						$pdo->exec("CREATE DATABASE IF NOT EXISTS `$configdb`;");
						echo "Création de l'utilisateur<br/>";
						$pdo->exec("CREATE USER IF NOT EXISTS $configuser@$confighost IDENTIFIED BY '$configuserpass';GRANT SELECT, INSERT, UPDATE, DELETE ON $configdb.* TO $configuser@$confighost;");
						$filename = '../configx-hps/_base2donnees/basetoinstall.sql';
						echo "Lecture du fichier ' basetoinstall.sql '<br/>";
						$templine = '';
						$lines = file($filename);
						foreach ($lines as $line) {
							if (substr($line, 0, 2) == '--' || $line == '')
								continue;
							$templine .= $line;
							if (substr(trim($line), -1, 1) == ';') {
								try {
									$pdo->exec($templine);
								} catch (\PDOException $e) {
								}
								$templine = '';
							}
						}
						echo "Configuration de la base effectuée.</div><br/>";
						echo "<button onclick=\"location.href='../index.php'\">Lancement application</button>";
					}
					?>
				</div>
			</div>
		</div>
</body>

</html>