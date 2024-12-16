<?php
function backuptable($tab){
require("components\mysql.php");
$sql = "SELECT * FROM ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$tab]);
$data = $$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $row) {
   echo "INSERT INTO $tab VALUES (" . implode(',', array_map(function($v) { return "'$v'"; }, $row)) . ");\n";
}
// Enregistrement des données 
$file = "backuptable-$tab-".date('Ymd-His').".sql";
$fp = fopen($file, 'w');
foreach ($data as $row) {
    fwrite($fp, "INSERT INTO $tab VALUES (" . implode(',', array_map(function($v) { return "'$v'"; }, $row)) . ");\n");
}
fclose($fp);
}
?>