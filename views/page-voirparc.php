<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}   // check start app

require_once("./controllers/ctrl-machine.php");
require_once("./controllers/ctrl-genre.php");
//----init variables
$maxparpage = 10;
if (isset($URLACTION[1])) {
  $page = abs(intval($URLACTION[1]));
} else {
  $page = 1;
}
if (isset($URLACTION[2])) {
  $genre = intval($URLACTION[2]);
} else {
  $genre = 3;
}
if (isset($_POST['pgd'])) {
  $page = abs(intval($_POST['pgd']));
}
if (isset($_POST['gre'])) {
  $genre = abs(intval($_POST['gre']));
  $page = 1;
}
//----traitement
$genre = $genre > 3 ? 3 : ($genre < 1 ? 1 : $genre);
$data = CallGetCombienMachine($genre);
$quantite = $data["total"]; // nb enregistrement
$nbpage = ceil($quantite / $maxparpage);
if ($page > $nbpage) {
  $page = $nbpage;
}
if ($page < 1) {
  $page = 1;
}
//----Chargement DATA
$genres = CallGetGenreMachines();
$machines = CallGetAllMachineFull($page, $genre);
//----Page
echo "<div class='titrepage'>Le parc</div>";
echo "<div class='explainpage'>liste des machines</div>";
echo "<form action='' method='post'>";
echo "<div class='container parc'>";
echo "<div><label>Genre de machine</label><select name='gre' style='width:400px;'  onchange='submit();'>";
foreach ($genres as $g) {
  if ($g['id_genremachine'] == $genre) {
    $a = "selected";
  } else {
    $a = "";
  }
  echo "<option value='" . $g['id_genremachine'] . "' " . $a . ">" . $g['designation'] . "</option>";
}
echo "</select>";
echo "</div><div class='mouvepage'>";
$a = "";
if ($page <= 1) {
  $a = "disabled";
}
$b = "";
if ($genre <> 3) {
  $b = "/" . $genre;
}
echo "<input type='button' value='Page précédente' " . $a . " onclick='window.location.href=\"?voirparc/" . ($page - 1) . $b . "\"' />";
echo "<input type='text'  id='pgd' name='pgd' style='text-align: right;' value='" . $page . "' maxlength='6'/ onchange='a=document.getElementById(\"pgd\").value;window.location.href=\"?voirparc/\"+a'>";
echo "/<input type='text'  value='" . $nbpage . "'/ readonly>";
$a = "";
if ($page >= $nbpage) {
  $a = "disabled";
}
echo "<input type='button' value='Page suivante' " . $a . " onclick='window.location.href=\"?voirparc/" . ($page + 1) . $b . "\"' />";
echo "</div></div></form><div style='margin-top:30px'></div><div class='container'>";
echo "<div class='colonne'>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>Actif</td><td>Alerte</td><td colspan='3'>Désignation ↓</td><td class='centrer'>Immat/N°série</td class='centrer'><td  class='centrer'>Puiss.fiscale</td><td  class='centrer'>Puissance W</td><td class='centrer'>Mise en service</td><td class='centrer'>Prochain Contrôle</td><td>Observations</td></tr></thead><tbody>";
foreach ($machines as $m) {
  $pw  = $m['puissance'] / 100000;
  $cv = round(pow(1.8 * $pw, 2) + 3.87 * $pw + 1.34);
  $alerte = $m["alerte"] ? "<img src='./assets/icons/warning.svg' title='Evenement'>" : "";
  echo "<tr id='" . $m['id_machine'] . "' height='50px'>";
  echo "<td width='30px'  class='centrer'>" . statut($m['actif']) . "</td>";
  echo "<td width='30px'  class='centrer'>" . $alerte . "</td>";
  //echo "<td width='30px'>" . $icon . "</td>";
  $a =  $m['idx_modele'] > 1 ? " <small>" . $m['modele'] : "</small>";
  echo "<td>" . $m['marque'] . $a . "</td>";
  echo "<td width='220px'>" . $m['type'] . "</td>";
  echo "<td width='150px'>" . $m['energie'] . "</td>";
  echo "<td width='130px' class='centrer'>" . $m['imat'] . "</td>";
  echo "<td width='120px' class='centrer'>" . $cv . "</td>";
  echo "<td width='120px' class='centrer'>" . $m['puissance'] . "w </td>";
  echo "<td width='155px' class='centrer'>" . frenchdate($m['date_premservice']) . "</td>";
  echo "<td width='155px' class='centrer'>" . frenchdate($m['date_procvsttech']) . "</td>";
  echo "<td width='400px' ><div style='width:400px;' class='cuttext'>" . $m['observation'] . "</div></td>";
  echo "</tr>";
}
echo "</tbody></table>";
echo "</div></div>";
?>
<script type="text/javascript" src="scripts/voirparc.js"></script>