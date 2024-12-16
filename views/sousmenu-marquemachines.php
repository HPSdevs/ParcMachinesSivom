<?php
if (!defined ( "hpsstart" )) {header('Location: ../index.php');}   // check start app

require_once("./controllers/genremachines.php");
require_once("./controllers/marquemachines.php");
require_once("./controllers/journal-evenements.php");
//----traitement
  if(isset($_POST['submit'])) {
    $action = $_POST['submit'];
    $id     = $_POST['hpi'];
    $design = $_POST['hp0'];
    $genre  = $_POST['hp1'];
    $statut = $_POST['hp2'];
    switch($action){
      case "upd":
          if ($id){
          CallUpdateMarqueMachine($design,$genre,$statut,$id);
          echo "<div class='tempmodal green'>Vos données ont été sauvegardées</div>";
          CallInsertJournal($IDUSER,64,$LOGIN." a modifié Marque machine '".$design."' (".$genre."/".$statut.")");
          }
          break;
      case "add":
          if ($design){
          CallInsertMarqueMachine($design,$genre,$statut);  
          echo "<div class='tempmodal green'>Vos données ont été ajoutées</div>";
          CallInsertJournal($IDUSER,64,$LOGIN." a ajouté Marque machine '".$design."' (".$genre."/".$statut.")");
          }
          break;
      case "del":
          if ($id){  
          CallDeleteMarqueMachine($id);
          echo "<div class='tempmodal green'>Vos données ont été effacées</div>";
          CallInsertJournal($IDUSER,64,$LOGIN." a effacé Marque machine '".$design."' (".$genre."/".$statut.")");
          }
          break;

    }
   }

//----Chargement DATA
$genremachines=CallGetallGenreMachines();
$marquemachines=CallGetAllMarqueMachines();

function genre($x){
  global $genremachines;
  foreach ( $genremachines as $g){ 
    if ($x==$g['id_genremachine']){return $g['designation'];}
  }
}
function statut($x){
  return $x? "[on]":"[off]";
}

echo "<div class='titrepage'>Marques de Machines</div>";

echo "<div class='container'>";
echo "<div class='cotegauche'>";
echo "<fieldset><legend>LISTE DE DONNÉES</legend>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>Désignation ↓</td><td>Genre</td><td>Affichage</td></tr></thead><tbody>";

foreach ( $marquemachines as $m){
  echo"<tr id='".$m['id_marquemachine']."'>";
  echo"<td  data-gen='".$m['genre']."' data-sta='".$m['statut']."' >".$m['designation']."</td>";
  echo"<td>".genre($m['genre'])."</td>";
  echo"<td class='centrer'>".statut($m['statut'])."</td>";
  echo"</tr>";
}
?>
</tbody></table></fieldset>
</div>
<div class='cotedroit'>
<div class='stickyman'>
<form action='' method='post'>
<fieldset><legend>ACTIONS</legend>
<input type='hidden' id='hpi' name='hpi'/>
<label>Désignation</label>
<input type='text' id='hp0' name='hp0'/>
<label>Pour le genre</label>
<select type='text' id='hp1' name='hp1'>
<?php 
foreach ( $genremachines as $g){ echo "<option value='".$g['id_genremachine']."' >".$g['designation']."</option>";}
?>
</select>
<label>Affichage dans les choix</label>
<select type='text' id='hp2' name='hp2'>
<option value='0'>Pas pris en compte</option>  
<option value='1'>En fonctionnement</option>  
</select>
<!-- <input type='checkbox' id='hp2' name='hp2' value="True"/> -->
<div class='boutons'>
  <button class="bouta" name='submit' value='del'>Retirer</button>
  <button class="boutb" name='submit' value='upd'>Sauver modification</button>
  <button class="boutc" name='submit' value='add'>Ajouter</button>
  <input class="boutd" type='reset' id='su' value='Annuler sélection'/>
</div>
</fieldset></form>
</div>
</div></div>
<script>
 var hps = document.getElementById("hpstab");
 hps.addEventListener("click", function(e){event = e.target;index = event.parentElement.rowIndex ; 
 if(hps.rows[index]){id = hps.rows[index].id;if (id){  document.getElementById("hpi").value= id;
  p0 = hps.rows[index].cells[0].innerHTML; p1 = hps.rows[index].cells[0].getAttribute('data-gen');
  p2 = hps.rows[index].cells[0].getAttribute('data-sta');
  document.getElementById("hp0").value= p0;document.getElementById("hp1").value= p1; document.getElementById("hp2").value= p2;
  }}
},false);
</script>
