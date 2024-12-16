<?php
if (!defined ( "hpsstart" )) {header('Location: ../index.php');}   // check start app

require_once("./controllers/ctrl-action.php");
require_once("./controllers/ctrl-journal.php");

//----traitement
   if(isset($_POST['submit'])) {
    $action = $_POST['submit'];
    $id     = intval($_POST['hpi']);
    $design = strip_tags(trim($_POST['hp0']));
    $statut = $_POST['hp2'];
    switch($action){
      case "upd":
          if ($id){
            CallUpdateAction($design,$statut,$id);
            echo "<div class='tempmodal vert'>l'action a été mofifiée</div>";
            CallInsertJournal($IDUSER,64,$LOGIN." a modifié l'énergie '".$design."' (".$id."/".$statut.")");
          }
          break;
      case "add":
          if ($design && $id===0){
            CallInsertAction($design,$statut);  
            echo "<div class='tempmodal vert'>l'action a été ajoutée</div>";
            CallInsertJournal($IDUSER,64,$LOGIN." a ajouté l'énergie '".$design."' (".$statut.")");
          }
          break;
      case "del":
          if ($id){  
            $res=CallDeleteAction($id);
            if ($res){
              CallInsertJournal($IDUSER,64,$LOGIN." a effacé l'énergie '".$design."' (".$id."/".$statut.")");
              echo "<div class='tempmodal vert'>l'action a été effacée</div>";
            }else{
              echo "<div class='tempmodal rouge'>Impossible l'action est utilisée</div>";  
            }
          }
          break;

    }
   }

//----Chargement DATA
$action=CallGetAllAction();


echo "<div class='titrepage'>Gestion des actions</div>";
echo "<div class='explainpage'>Ce qui est fait dans une intervention</div>";
echo "<div class='container'>";
echo "<div class='cotegauche'>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>Désignation ↓</td><td>Affichage</td></tr></thead><tbody>";

foreach ( $action as $m){
  echo"<tr id='".$m['id_action']."'>";
  echo"<td  data-sta='".$m['statut']."' >".$m['designation']."</td>";
  echo"<td width='50px'  class='centrer'>".statut($m['statut'])."</td>";
  echo"</tr>";
}
?>
</tbody></table>
</div>
<div class='cotedroit'>
<div class='stickyman'>
<form action='' method='post'>
<fieldset><legend>ACTIONS</legend>
<input type='hidden' id='hpi' name='hpi'/>
<label>Désignation</label>
<input type='text' id='hp0' name='hp0'/>
<label>Affichage dans les choix</label>
<select type='text' id='hp2' name='hp2'>
<option value='0'>Pas pris en compte/non affiché</option>  
<option value='1'>En fonctionnement/sera affiché</option>  
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
  p0 = hps.rows[index].cells[0].innerHTML; 
  p2 = hps.rows[index].cells[0].getAttribute('data-sta');
  document.getElementById("hp0").value= p0; document.getElementById("hp2").value= p2;
  }}
},false);
</script>
