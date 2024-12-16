<?php
$c = parse_ini_file("./configx-hps/config-basededonnees.ini");
$dsn = "mysql:host=" . $c['host'];
$dsn .= ";port=" . $c['port'];
$dsn .= ";dbname=" . $c['db'];
$dsn .= ";charset=" . $c['charset'];
$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $c['user'], $c['userpass'], $options);
} catch (\PDOException $e) {
     echo "<div><p style='font-size:32px'>ParcVéhiculesSIVOM</p><hr/>
     <p style='font-size:24px'>Erreur technique<br/>Ce service est momentanément indisponible.</br>Veuillez nous excuser pour la gêne occasionnée.</p>
     <br/><hr/><p>" . $e->getMessage() . "</p></div>";
}