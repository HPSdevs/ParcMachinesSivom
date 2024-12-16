<?php

// $idinter  => numéro de l'intervention
$intervention = CallGetInterventionByID($idinter);
$statutinter  = $intervention['statut_intervention'];
$comment      = $intervention['comment_demandeur'];
$retour       = $intervention['comment_mecanicien'];
$deposestat   = $intervention['statut_depose'];
$deposelieu   = $intervention['depose_lieu'];


//------------------------------ TOP
if ($statutinter & 16) {
  echo "<div class='cloture'><img src='./assets/images/cloture.png'></div>";
}
if ($statutinter & 8) {
  echo "<div class='cloture'><img src='./assets/images/refusee.png'></div>";
}
//------------------------------ BACK
echo "<div class='topback'>";
echo "<div class='titre'>Motif de La demande d'intervention</div>";
echo "<p>$txtintervention</p>";
if ($comment) {
  echo "<br/><div class='titre'>Message du demandeur</div>";
  echo "<p>$comment</p>";
}
if ($retour) {
  echo "<br/><div class='titre'>Message de retour du mécanicien</div>";
  echo "<p>$retour</p>";
}
if ($deposestat && ($statutinter & 7)) {
  echo "<br/><div class='titre'>Information d'immobilisation</div>";
  echo "<p>Machine immobilisée à l'adresse ci-dessous :</p>";
  echo "<p>$deposelieu</p>";
}
echo "</div>";
