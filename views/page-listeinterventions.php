<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}   // check start app

require_once("./controllers/ctrl-intervention.php");
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
  $genre = 1;
}
if (isset($_POST['pgd'])) {
  $page = abs(intval($_POST['pgd']));
}
if (isset($_POST['gre'])) {
  $genre = abs(intval($_POST['gre']));
  $page = 1;
}
//----traitement
$genre = $genre > 2 ? 2 : ($genre < 0 ? 0 : $genre);
$data = CallGetFullIntervention($page, $genre);
$quantite = CallHowmanyIntervention($genre); // $statut
$nbpage = ceil($quantite / $maxparpage);
if ($page > $nbpage) {
  $page = $nbpage;
}
if ($page < 1) {
  $page = 1;
}
//----Page
echo "<div class='titrepage'>Demandes & interventions</div>";
echo "<div class='explainpage'>la liste</div>";
echo "<form action='' method='post'>";
echo "<div class='container parc'>";
echo "<div><label>sélection des types d'interventions à afficher</label><select name='gre' id='gre' style='width:400px;'  
      onchange='window.location.href=\"?inters/1/\"+document.getElementById(`gre`).value '>";
$a = ($genre == 2) ? "selected" : "";
echo "<option value='2' $a> Toutes les interventions</option>";
$a = ($genre == 1) ? "selected" : "";
echo "<option value='1' $a> Que les intervention en cours</option>";
$a = ($genre == 0) ? "selected" : "";
echo "<option value='0' $a> Que les interventions cloturées</option>";
echo "</select>";
echo "</div><div class='mouvepage'>";
$a = "";
if ($page <= 1) {
  $a = "disabled";
}
echo "<input type='button' value='Page précédente' " . $a . " onclick='window.location.href=\"?inters/" . ($page - 1)
  . "/\"+document.getElementById(`gre`).value '>";
echo "<input type='text'  id='pgd' name='pgd' style='text-align: right;' value='" . $page . "' maxlength='6'/ onchange='a=document.getElementById(\"pgd\").value;window.location.href=\"?inters/\"+a'>";
echo "/<input type='text'  value='" . $nbpage . "'/ readonly>";
$a = "";
if ($page >= $nbpage) {
  $a = "disabled";
}
//echo "<input type='button' value='Page suivante' " . $a . " onclick='window.location.href=\"?inters/" . ($page + 1) . "\"' />";
echo "<input type='button' value='Page suivante' " . $a . " onclick='window.location.href=\"?inters/" . ($page + 1)
  . "/\"+document.getElementById(`gre`).value '>";
echo "</div></div></form><div style='margin-top:30px'></div><div class='container'>";
echo "<div class='colonne'>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>N°</td><td>Machine</td><td>Motif de l'intervention</td><td>Km / Heure</td><td>Date.dem</td><td>Date.clot.</td><td>Nb Pré.</td><td>Duré Pré.</td><td>Cout</td><td>Rap.</td><td>Urg.</td><td>Imm.</td><td>Inu.</td></tr></thead><tbody>";
foreach ($data as $i) {

  echo "<tr style='height:40px' onclick='location.href=\"index.php?voirinter/" . $i['id_intervention'] . "\"'>";
  $a = $i['statut_intervention'] > 7 ? "🟢" : "🔴";
  echo "<td width='110'>$a " . numero($i['id_intervention']) . "</td>";
  echo "<td width='550'><p style='width:550px' class='cuttext'>" . $i['machine'] . "</p></td>";
  echo "<td width='320'><p style='width:320px' class='cuttext'>" . $i['motif'] . "</td>";
  $a = $i['idx_genre'] < 2 ? enKm($i['kilometrage']) : $i['kilometrage'] . "H";
  echo "<td width='120' style='text-align:right;padding-right:10px'><p style='width:120px' class='cuttext'>$a</td>";
  echo "<td width='100'><p style='width:100px' class='cuttext'>" . frenchdate($i['crea']) . "</td>";
  $a = $i['statut_intervention'] > 7 ? frenchdate($i['clot']) : "";
  echo "<td width='120'><p style='width:120px' class='cuttext'>" . $a . "</td>";
  echo "<td width='70'>" . $i['total_prestation'] . "</td>";
  echo "<td width='90'>" . enTemps($i['total_duree']) . "</td>";
  echo "<td width='150'>" . enArgent($i['total_cout']) . "</td>";
  $a = $i['statut_depose']  ? "🚩" : " "; //
  echo "<td width='20' title='rapatriement'>" . $a . "</td>";
  $a = $i['statut_urgent']  ? "⚡" : " "; //
  echo "<td width='20'  title='urgent'>" . $a . "</td>";
  $a = $i['statut_immobilise']  ? "⚠️" : " "; //
  echo "<td width='20'  title='immobilise'>" . $a . "</td>";
  $a = $i['statut_inutilisable']  ? "🔒" : " "; //
  echo "<td width='20'  title='inutilisable'>" . $a . "</td>";

  echo "</tr>";
}
if (!$data){
echo "<tr><td colspan='13' style='text-align:center;height:200px'>Aucune donnée</td></tr>";  
}
echo "</tbody></table>";
echo "</div></div>";
