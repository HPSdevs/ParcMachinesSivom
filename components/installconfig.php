
 <?php
  ini_set('display_errors', 'on');
  $c = parse_ini_file("../configx-hps/config-basededonnees.ini");
  foreach ($c as $key => $val) {
    eval("\$config$key = '$val';");
  }
  if (is_array($c)) {
    $dsn = "mysql:host=" . $confighost;
    $dsn .= ";port=" . $configport;
    $dsn .= ";dbname=" . $configdb;
    $dsn .= ";charset=" . $configcharset;
    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    echo "Host is '$confighost' user is '$configuser'<br>";
    $pdo = new PDO("mysql:host=$confighost", $configroot, $configrootpass, NULL);
    echo "Création de la base de données<br>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$configdb`;");
    echo "Création de l'utilisateur<br>";
    $pdo->exec("CREATE USER IF NOT EXISTS $configuser@$confighost IDENTIFIED BY '$configuserpass';GRANT SELECT, INSERT, UPDATE, DELETE ON $configdb.* TO $configuser@$confighost;");
    $filename = '../configx-hps/_base2donnees/basetoinstall.sql';  // HERE the location and name of 'SQL file' to install
    $templine = '';
    $ligne = 0;
    $lines = file($filename);
    $total = sizeof($lines);
    // Loop through each line
    foreach ($lines as $line) {
      $ligne += 1;
      if (substr($line, 0, 2) == '--' || $line == '')
        continue;
      $templine .= $line;
      if (substr(trim($line), -1, 1) == ';') {
        try {
          $pour = round($ligne / $total * 100);
          echo json_encode(array("pour" => $pour, "msg" => "en cours"));
          $pdo->exec($templine);
        } catch (\PDOException $e) {
          //
        }
        $templine = '';
      }
    }
  }
