<?php
require_once('./controllers/ctrl-prestation.php');
require_once('./controllers/ctrl-utilisateur.php');
// $idinter --> $idmachine --> $idaction
/* STATUT_INTERVENTION en valeur
  0  = créée mais pas encore validé par le demandeur	    (48 heures d'existence)
  1  = validée par le demandeur, en attente de traitement
  2  = Traitement en cours
  4  = Traitement assigné (...not in this version)
  8  = intervention refusée
  16 = intervention cloturée
*/
// $idinter  => numéro de l'intervention
$intervention = CallGetInterventionByID($idinter);
$kil = $intervention['kilometrage'];         // kilometres/heures
$urg = $intervention['statut_urgent'];       // urgence
$inu = $intervention['statut_inutilisable']; // hors service
$imm = $intervention['statut_immobilise'];   // immobilisation
$dep = $intervention['statut_depose'];       // rapratriement
$sti = $intervention['statut_intervention']; // statut intervention
$com = $intervention['comment_mecanicien'];  // commentaire meca
//$mecaniciens = CallGetAllMeca(); // pas de choix dans cette version

echo "<form method='POST' act=''>";
echo "<input type='hidden' name='idi' value='$idinter'/>";
echo "<div style='text-align:center'>Nombre de kilometres au compteur ou nbre d'heures machine au moment de la prise en charge<br/><input name='kil' type='number' value='$kil'/></div>";
echo "<br/><br/>";
echo "<div class='inline' style='margin-left:60px'>";
$a = $urg ? "checked" : "";
echo "<div class='inline' >intervention urgente:<div class='hpscheck'><input name='urg' class='tgl tgl-ios' id='toggle-urg' type='checkbox' $a value='1'><label class='tgl-btn' for='toggle-urg'></label></div></div>";
$a = $inu ? "checked" : "";
echo "<div class='inline' >machine hors service:<div class='hpscheck'><input name='inu' class='tgl tgl-ios' id='toggle-tgl' type='checkbox' $a value='1'><label class='tgl-btn' for='toggle-tgl'></label></div></div>";
$a = $imm ? "checked" : "";
echo "<div class='inline' >machine immobilisée:<div class='hpscheck'><input name='imm' class='tgl tgl-ios' id='toggle-imm' type='checkbox' $a value='1'><label class='tgl-btn' for='toggle-imm'></label></div></div>";
echo "</div>";

if ($dep) {
  echo "<fieldset class='fieldnorm margetop fondnormal centertext'><legend></legend>";
  echo "Initialement à la demande d'intervention, la machine à été sous mise le statut 'rapatriement'<br/>est-ce que la machine est à cet instant rapatriée ?";
  echo "<div class='inline' >";
  $a = $dep ? "checked" : "";
  echo "<div class='hpscheck center'><input name='dep' class='tgl tgl-ios' id='toggle-dep' type='checkbox' $a value='1'><label class='tgl-btn' for='toggle-dep'></label></div></div>";
  echo "</fieldset>";
}

echo "<fieldset class='fieldnorm margetop fondnormal centertext'><legend>⚠️ Statut de la demande d'intervention&nbsp;⚠️</legend>";
echo "<p>Cet indicateur permet de définir le statut de la demande, si cette dernière est cloturée c'est définitif<br/> (Cela signifie que tous les travaux sont effectués et la machine est de nouveau disponible)</p><br/>";
echo "<select name='sti' required='required' >";
$a = ($sti & 1) ? "selected" : "";
echo "<option value='1' $a>En attente de traitement</option>";
$a = ($sti & 2) ? "selected" : "";
echo "<option value='2' $a>Traitement en cours</option>";
//$a = ($sti & 4) ? "selected" : "";
//echo "<option value='4' $a>Traitement et assignation</option>";
$a = ($sti & 8) ? "selected" : "";
echo "<option value='8' $a>Traitement refusé (mettre motif ci-dessous)</option>";
echo "<option value='' disabled>---------------------------------------</option>";
$a = ($sti & 16) ? "selected" : "";
echo "<option value='16' $a>Traitement cloturé.</option>";
echo "</select></br>";
// echo "<span><label for='meca'>Pseudo du mécanicien</label><select name='mecaassign' required='required' >";
// foreach ($mecaniciens as $m) { echo "<option value='" . $m['id_user'] . "' >" . $m['pseudo'] . '</option>'; }
// echo "</select></span>";
echo "</fieldset><br/>";
echo "</br>Commentaire ou motif en réponse pour l'intervention:";
echo "<textarea name='com' cols='93' rows='2' maxlength='900' placeholder='...'>" . $com . "</textarea>";
echo "<br/><br/><p class='centertext'><button type='submit' name='ges' value='int'>VALIDER CETTE PAGE</button></p>";
echo "</form>";
