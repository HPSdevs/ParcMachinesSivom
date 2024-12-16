<?php
//===DIV QUAD
$pw  = $machine['puissance'] / 100000;
$cv = round(pow(1.8 * $pw, 2) + 3.87 * $pw + 1.34);
//---Appear
echo "<div class='cmdappear'>";
if ($URLACTION[0] != 'voirmachine') {
  echo "<a href='index.php?voirmachine/" . $machine["id_machine"] . "'><img src='./assets/icons/voir.svg' title='VUE GÉNÉRALE DE CETTE MACHINE'/></a>";
}
echo "<a href='index.php?voirparc'><img src='./assets/icons/list.svg' title='VOIR TOUT LE PARC'/></a>";
if ($GRADE > 1) {
  echo "<a href='index.php?editmachine/" . $machine["id_machine"] . "'><img src='./assets/icons/edit.svg' title='EDITER CETTE MACHINE'/></a>";
}
echo "<a href='javascript:history.back()'><img src='./assets/icons/back.svg' title='PAGE PRÉCÉDENTE'/></a>";
echo "</div>";
//---fin appear
echo "<div class='type'>" . $machine['type'] . "</div>";
$a = $machine["idgenre"] == 2 ? "n°" : "";
echo "<div class='imat cuttext'>" . $a . $machine['imat'] . "</div>";
echo "<div class='marque cuttext'>" . $machine['marque'] . "</div>";
if ($machine["idmodele"] > 1) {
  echo "<div class='modele' >" . $machine['modele'] . "</div>";
}
echo "<div class='separ1'></div>";
echo "<div class='cv' title='Equivalence en puissance fiscale'>" . $cv . " cv</div>";
echo "<div class='energie cuttext' title='Energie'>" . $machine['energie'] . "</div>";
echo "<div class='puissance cuttext' title='Puissance en watt'>" . $machine['puissance'] . "w</div>";
echo "<div class='date1'>Date mise en service&nbsp;&nbsp;: " . frenchdate($machine['date_premservice']) . " (" . tempspasse($machine['date_premservice']) . ")</div>";
echo "<div class='date2'>Date visite technique&nbsp;: " . frenchdate($machine['date_procvsttech']) . " (" . tempspasse($machine['date_procvsttech']) . ")</div>";
echo "<div class='separ2'></div>";
echo "<div class='obs'>" . $machine['observation'] . "</div>";
