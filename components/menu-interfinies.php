<?php
include_once("./controllers/ctrl-intervention.php");
//              affichage que des interventions du client       :  ou l'ensemble
$lst = $GRADE < 2 ? CallGetAllDemandeurIntervention(0, $IDUSER) :  CallGetAllInterventionFull(0);
echo "<table class='journallist hovermode'>"; // Taille  820
foreach ($lst as $l) {
	echo "<tr onclick=\"window.location='index.php?voirinter/" . $l['id_intervention'] . "'\">";
	echo "<td width='120px' title='date fin intervention'>" . frenchdate($l['clot']) . " </td>";
	echo "<td><div style='width:210px' class='cuttext' title='motif intervention'>" . $l['motif'] . "</div></td>";
	$a = $l['idx_genre'] < 2 ? enKm($l['kilometrage']) : $l['kilometrage'] . "H";
	echo "<td width='120px'><div style='width:120px;text-align:right' class='cuttext' title='kilometrage/nombre heures'>$a&nbsp;&nbsp;</div></td>";
	echo "<td><div style='width:400px' class='cuttext' title='machine concernée'>" . $l['machine'] . "</div></td>";
	echo "</tr>";
}
echo "</table>";
