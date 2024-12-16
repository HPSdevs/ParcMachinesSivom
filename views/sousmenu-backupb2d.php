<?php
echo "<div class='titrepage'>Sauvegarde</div>";
echo "<div class='explainpage'>MySQL</div>";
//----Page
echo "<div style='display:flex;justify-content: center;align-items: center;width:100%;flex-direction:column'>";
echo "<p>Sauvegarder l'ensemble du parc et des interventions sous forme d'un seul fichier,</p>";
echo "<p>pour une éventuelle restauration en cas de problème de données avec le serveur.</p><br/>";
echo "<p style='margin-bottom:100px'>le fichier sera sauvegardé dans le répertoire backup de l'application.</p>";
if(!isset($_POST['submit'])) {
echo "<form action='' method='POST'>";
echo "<button name='submit' value='val'>Faire une sauvegarde</button>";
echo "</form></div>";
}else{
require("components\mysql.php");
$filename = 'backup_' . date('Ymd-His') . '.sql';  //  .gz
$cmd = $c['dumplocation']."mysqldump --host=".$c['host']." --password=".$c['userpass']." --user=".$c['user']." --single-transaction ".$c['db']." >backup/".$filename;
 $res= system($cmd,$cmdstat);
 if (!$cmdstat){
 echo "Le fichier ' $filename ' a été sauvegardé.";
}else{
 echo "Erreur sauvegarde impossible.";
 }
}
?>