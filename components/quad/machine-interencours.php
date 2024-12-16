<?php
$idmachine = $machine["id_machine"];
include_once('./controllers/ctrl-intervention.php');
//===DIV QUAD
echo "<div class='titre'>Interventions en cours</div>";
//---Appear
echo "<div class='cmdappear'>";
echo "<a href='index.php?addinter/$idmachine' ><img src='./assets/icons/plus.svg' title='DEMANDER INTERVENTION'/></a>";
echo "</div>";
//---fin appear
$lst = CallGetMachineInterventionFull($idmachine, 1);
echo "<table class='journallist hovermode'>";
foreach ($lst as $l) {
    $e = $l['statut_depose']  ? "🚩" : " "; //
    $d = $l['statut_urgent']  ? "⚡" : " "; //
    $c = $l['statut_inutilisable']  ? "🔒" : " "; //
    $b = $l['statut_immobilise']  ? "⚠️" : " "; //
    $a = $l['total_prestation']  ? "🔧" : " "; // si prestation en cours
    $dem  = $l['idx_demandeur'];
    $link = " onclick=\"window.location='index.php?voirinter/" . $l['id_intervention'] . "'\"";
    $okclick =  $GRADE > 1 ? $link : ($IDUSER == $dem ? $link : "");
    echo "<tr $okclick>";
    echo "<td width='80px' title='numero intervention'>" . numero($l['id_intervention']) . "</td>";
    echo "<td width='120px' title='date de demande'>" . frenchdate($l['crea']) . "</td>";
    echo "<td><div style='width:190px' class='cuttext' title='motif intervention'>" . $l['motif'] . "</div></td>";

    echo "<td width='22px' title='Hors centre'>$e</td>";
    echo "<td width='22px' title='Immobilisation'>$b</td>";
    echo "<td width='22px' title='Hors service'>$c</td>";
    echo "<td width='22px' title='Urgent'>$d</td>";
    echo "<td width='22px' title='Prestation en cours'>$a</td>";
    echo "<td width='22px'></td>";

    echo "<td><div style='width:180px' class='cuttext' title='demandeur'>" . $l['demandeur'] . "</div></td>";
    echo "</tr>";
}
echo "</table>";
