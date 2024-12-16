<?php
require_once("./controllers/ctrl-document.php");
$documents = CallGetAllDocuments($idmachine);
//VAR reference $idmachine  $UPLOADMAX
//--table affichage
echo "<div id='pdilist' class='limitheight'>";
echo "<table id='tbhp' class='journallist hovermode'>";
foreach ($documents as $l) {
  $m = $l['legende'] ? $l['legende'] :  "<font color='grey'>" . $l['filename'] . "</font>";
  //$n = explode("_", $l['filename']);
  echo "<tr id='" . $l['id_document'] . "'>";
  echo "<td data-leg='" . $l['legende'] . "' width='110px' title='date d`ajout'>" . frenchdate($l['date_creation']) . "</td>";
  echo "<td width=225px><div style='width:220px' class='cuttext' title='ajouté par'>" . $l['nom'] . "</div></td>";
  echo "<td width=555px title='intitulé/désignation'>" . $m . "</td>";
  echo "</tr>";
}
echo "</table></div>";
//--action documents
$j = "";
foreach ($UPLOADFOK  as $i) {
  $j .= $i . " ";
}
if ($GRADE > 1) {
  echo "<div class='fac'><form enctype='multipart/form-data' action='' method='post'><fieldset><legend>Types de fichiers acceptés : $j</legend>";
  echo "<input type='hidden' id='idmd' name='idmd' value=''/>";
  echo "<div class='lgn'><input id='idfile' type='file' name='fsag' /></div></br>";
  echo "Désignation ou intitulé de contenu pour ce fichier (40 caractères max.)<br/>";
  echo "<input type='text' maxlength=40 style='width:100%' name='lege' id='lege' /><br/>";
  echo "</br>&nbsp;&nbsp;&nbsp;<input tabindex='9' type='reset' value='&nbsp;Annuler la sélection&nbsp;' onclick='doreset()'/>&nbsp;";
  echo "<button tabindex='8' type='submit' name='btd' id='modoc' value='modoc' disabled=disabled/>Modifier document</button>&nbsp;";
  echo "<button tabindex='7' type='submit' name='btd' id='redoc' value='redoc' disabled=disabled/>Enlever document</button>&nbsp;";
  echo "<button tabindex='6' type='submit' name='btd' id='addoc' value='addoc'/>Ajouter document</button>&nbsp;";
  echo '</fieldset></form></div>';
}
?>
<script>
  var markhps = document.getElementById("idfile");
  markhps.addEventListener("change",
    function(e) {
      doreset();
      files = e.target.files;
      a = files[0].name;
      lege.value = a;
    }, false);

  var oldtr = null;
  var hps = document.getElementById('tbhp');
  hps.addEventListener('click', function(e) {
    tr = e.target.closest('tr');
    if (tr) {
      index = tr.rowIndex;
      if (hps.rows[index]) {
        id = hps.rows[index].id;
        if (id) {
          if (oldtr) {
            oldtr.className = '';
          }
          tr.className = 'selected';
          oldtr = tr;
          document.getElementById('idmd').value = id;
          document.getElementById('lege').value = hps.rows[index].cells[0].getAttribute('data-leg');
          document.getElementById('addoc').disabled = true;
          document.getElementById('modoc').disabled = false;
          document.getElementById('redoc').disabled = false;
        }
      }
    }
  }, false);

  function doreset() {
    document.getElementById('addoc').disabled = false;
    document.getElementById('redoc').disabled = true;
    document.getElementById('modoc').disabled = true;
    if (oldtr) {
      oldtr.className = '';
      oldtr = null;
    }
  }
</script>