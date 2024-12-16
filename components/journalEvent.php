<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}
?>
require("./controllers/journal-evenements.php");
$journal = CallGetJournalByRank($GRADE);
echo "<table class='listejournal'>";
  foreach ( $journal as $l){
  echo"<tr>";
    echo"<td class='quand'>".$l['quand']."</td>";
    echo"<td class='designation'>".$l['designation']."</td>";
    echo"</tr>";
  }
  echo "</table>";
?>