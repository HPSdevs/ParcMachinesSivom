<?php
echo "<div class='titre'>Documents</div>";
if ($GRADE > 1 && $URLACTION[0] != "voirdocs") {  // ne pas afficher l'icon si déjà dans le menu
  echo "<div class='cmdappear'>";
  echo "<a href='index.php?voirdocs/$idmachine' title='AJOUTER/MODIFIER DOCUMENTS'><img src='./assets/icons/intermod.svg'/></a>";
  echo '</div>';
}
//--- Page
require_once("./controllers/ctrl-document.php");
$documents = CallGetAllDocuments($idmachine);

//--table affichage
echo "<table class='journallist hovermode'>";
foreach ($documents as $l) {
  $i = $l['id_document'];
  $ext = substr(strrchr($l['filename'], '.'), 1);
  echo "<tr onClick=\"window.open('document.php?$i','Document','top=10,left=900, width=900, height=900, toolbar=0, scrollbars=1');return(false)\">";
  echo "<td width='100px'></td>";
  echo "<td width='120px' title='date de dépot du document'>" . frenchdate($l['date_creation']) . "</td>";
  echo "<td width='80px'>$ext</td>";
  if ($l['legende']) {
    echo "<td title='légende du document'>" . $l['legende'] . "</td>";
  } else {
    echo "<td><font color='grey' title='nom du fichier'>" . $l['filename'] . "</font></td>";
  }
  echo "</tr>";
}
echo "</table>";
