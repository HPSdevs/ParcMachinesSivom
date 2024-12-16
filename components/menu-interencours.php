<?php
include_once("./controllers/ctrl-intervention.php");
/* STATUT_INTERVENTION en valeur
  0  = créée mais pas encore validé par le demandeur	    (48 heures d'existence)
  1  = validée par le demandeur, en attente de traitement
  2  = Traitement en cours
  4  = Traitement assigné (...not in this version)
  8  = intervention refusée
  16 = intervention cloturée
*/
//              affichage que des interventions du client       :  ou l'ensemble
$lst = $GRADE < 2 ? CallGetAllDemandeurIntervention(1, $IDUSER) :  CallGetAllInterventionFull(1);
echo "<table class='journallist hovermode'>";  // taille  820
//echo "<th><tr><td>#</td><td>date</td><td>Motif</td><td>Machine</td><td>Demandeur</td></tr></Th>";
foreach ($lst as $l) {
  $e = $l['statut_depose']  ? "🚩" : " "; //
  $d = $l['statut_urgent']  ? "⚡" : " "; //
  $c = $l['statut_inutilisable']  ? "🔒" : " "; //
  $b = $l['statut_immobilise']  ? "⚠️" : " "; //
  $a = $l['total_prestation']  ? "🔧" : " "; // si prestation en cours

  //$s = $l['statut_intervention']  & 2 ? "🟢" : "🟡"; //
  //$s = $l['statut_intervention']  & 1 ? "🔴" : $s; // 🏁

  echo "<tr onclick=\"window.location='index.php?voirinter/" . $l['id_intervention'] . "'\">";
  // echo "<td width='80px'>" . numero($l['id_intervention']) . "</td>";
  echo "<td width='110px'>" . frenchdate($l['crea']) . "</td>";
  echo "<td width='22px' title='Hors centre'>$e</td>";
  echo "<td width='22px' title='Immobilisation'>$b</td>";
  echo "<td width='22px' title='Hors service'>$c</td>";
  echo "<td width='22px' title='Urgent'>$d</td>";
  echo "<td width='22px' title='Prestation en cours'>$a</td>";
  echo "<td width='22px' title=''>&nbsp;</td>";
  echo "<td><div style='width:200px' class='cuttext'>" . $l['motif'] . "</div></td>";
  echo "<td><div style='width:380px' class='cuttext'>" . $l['machine'] . "</div></td>";
  //echo"<td><div style='width:180px' class='cuttext'>".$l['demandeur']."</div></td>";
  //echo"<td><div style='width:120px' class='cuttext'>".$l['mecanicien']."</div></td>";
  echo "</tr>";
}
echo "</table>";
