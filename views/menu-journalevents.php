<?php
if (!defined ( "hpsstart" )) {header('Location: ../index.php');}   // check start app

//----Chargement DATA
echo "<div class='titrepage'>Journal des évènements</div>";
require("./controllers/journal-evenements.php");
$journal = CallGetJournalByRank($GRADE);
echo "<table class='journal'";
foreach ( $journal as $l){
  echo"<tr>";
  echo"<td class='quand'>".$l['quand']."</td>";
  echo"<td class='designation'>".$l['designation']."</td>";
  echo"</tr>";
}
echo "</table>";
