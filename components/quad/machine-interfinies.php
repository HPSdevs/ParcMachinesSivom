<?php
$idmachine = $machine["id_machine"];
include_once('./controllers/ctrl-intervention.php');
//===DIV QUAD
echo "<div class='titre'>Interventions cloturées</div>";
//---Appear
//echo "<div class='cmdappear'>";
//echo "<a href='index.php?addinter/$idmachine' ><img src='./assets/icons/interadd.svg' title='Demander intervention'/></a>";
//echo "<a href='index.php?editinter'><img src='./assets/icons/intermod.svg' title='Modifier une intervention '/></a>";
//echo "<a href='index.php?editinter'><img src='./assets/icons/interdel.svg' title='Effacer une intervention '/></a>";
//echo "<a href='index.php?editinter'><img src='./assets/icons/interval.svg' title='Valider une intervention '/></a>";
//echo "<a href='index.php?editinter'><img src='./assets/icons/intersea.svg' title='Chercher une intervention '/></a>";
//echo "</div>";
//---fin appear
$lst = CallGetMachineInterventionFull($idmachine, 0);
echo "<table class='journallist hovermode'>";
//echo "<th><tr><td>#</td><td>date</td><td>Motif</td><td>Machine</td><td>Demandeur</td></tr></Th>";
foreach ($lst as $l) {
	$dem  = $l['idx_demandeur'];
	$link = " onclick=\"window.location='index.php?voirinter/" . $l['id_intervention'] . "'\"";
	$okclick =  $GRADE > 1 ? $link : ($IDUSER == $dem ? $link : "");
	echo "<tr $okclick>";
	echo "<td width='80px'  title='n° de demande'>" . numero($l['id_intervention']) . "</td>";
	echo "<td width='120px' title='date de demande'>" . frenchdate($l['crea']) . "</td>";
	echo "<td width='120px' title='date de cloture'>" . frenchdate($l['clos']) . "</td>";
	$a = $l['idx_genre'] < 2 ? enKm($l['kilometrage']) : $l['kilometrage'] . "H";
	echo "<td width='110px' title='Kilometrage ou Heures' align='right'>$a&nbsp;&nbsp;</td>";
	echo "<td><div style='width:190px' class='cuttext' title='motif d`intervention'>" . $l['motif'] . "</div></td>";
	echo "<td><div style='width:220px' class='cuttext' title='intervention demandé par'>" . $l['demandeur'] . "</div></td>";
	echo "</tr>";
}
echo "</table>";
