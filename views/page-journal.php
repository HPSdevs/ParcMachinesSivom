<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}   // check start app
require("./controllers/ctrl-journal.php");
//----Chargement DATA
echo "<div class='titrepage'>Journal des évènements</div>";
echo "<div class='explainpage'>…</div>";
$journal = CallGetJournalByRank($GRADE);
echo "<table class='journal'";
foreach ($journal as $l) {
  echo "<tr>";
  echo "<td class='quand'>" . $l['quand'] . "</td>";
  echo "<td class='designation'>" . $l['designation'] . "</td>";
  echo "</tr>";
}
echo "</table>";
