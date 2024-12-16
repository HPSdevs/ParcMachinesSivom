<?php
if (!defined ( "hpsstart" )) {header('Location: ../index.php');}   // check start app

require_once("./controllers/ctrl-journal.php");
require_once("./controllers/ctrl-typeintervention.php");
require_once("./controllers/ctrl-genre.php");

$listrole = [128=>'Admin',192=>'Chef + Admin',194=>'Méca + Chef + Admin',195=>'Tout le monde'];

//----traitement
   if(isset($_POST['submit'])) {
    $action = $_POST['submit'];
    $id     = intval($_POST['hpi']);
    $design = strip_tags(trim($_POST['hp0']));
    $genre  = $_POST['hp1'];
    $statut = $_POST['hp2'];
    $role   = $_POST['hp3']; 
    switch($action){
      case "upd":
          if ($id){
          CallUpdateTypeInter($design,$role,$genre,$statut,$id);
          echo "<div class='tempmodal vert'>le type a été mofifiée</div>";
          CallInsertJournal($IDUSER,64,$LOGIN." a modifié le type d'intervention '".$design."' (".$id."/".$role."/".$genre."/".$statut.")");
          }
          break;
      case "add":
          if ($design && $id===0){
          CallInsertTypeInter($design,$role,$genre,$statut);  
          echo "<div class='tempmodal vert'>le type a été ajoutée</div>";
          CallInsertJournal($IDUSER,64,$LOGIN." a ajouté le type d'intervention '".$design."' (".$role."/".$genre."/".$statut.")");
          }
          break;
      case "del":
          if ($id){  
            $res=CallDeleteTypeInter($id);
            if ($res){
              echo "<div class='tempmodal vert'>le type a été effacée</div>";
              CallInsertJournal($IDUSER,64,$LOGIN." a effacé le type d'intervention '".$design."' (".$role."/".$id."/".$genre."/".$statut.")");
            }else{
              echo "<div class='tempmodal rouge'>Impossible le type d'intervention est utilisé</div>";  
            }
          }
          break;

    }
   }

//----Chargement DATA
$genremachines=CallGetallGenreMachines();
$typeinter=CallGetAllTypeInter();

function genre($x){
  global $genremachines;
  foreach ( $genremachines as $g){ 
    if ($x==$g['id_genremachine']){return $g['designation'];}
  }
}

echo "<div class='titrepage'>Gestion des types d'interventions</div>";
echo "<div class='explainpage'>motifs de la démarche pour une intervention</div>";

echo "<div class='container'>";
echo "<div class='cotegauche'>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>Désignation ↓</td><td>Rôle</td><td>Genre</td><td width='50px'  class='centrer'>Affichage</td></tr></thead><tbody>";

foreach ( $typeinter as $m){
  echo"<tr id='".$m['id_typeintervention']."'>";
  echo"<td  data-rol='".$m['role']."' data-gen='".$m['genre']."' data-sta='".$m['statut']."' >".$m['designation']."</td>";
  echo"<td>".$listrole[$m['role']]."</td>";
  echo"<td>".genre($m['genre'])."</td>";
  echo"<td class='centrer'>".statut($m['statut'])."</td>";
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
<label>Pour une utilisation par</label>
<select type='text' id='hp3' name='hp3'>
<option value='195'>Utilisateur + Meca + Chef + Admin</option>  
<option value='194'>Meca + Chef + Admin</option>  
<option value='192'>Chef + Admin</option>  
<option value='128'>Admin</option>  
</select>
<label>Pour le genre</label>
<select type='text' id='hp1' name='hp1'>
<?php 
foreach ( $genremachines as $g){ echo "<option value='".$g['id_genremachine']."' >".$g['designation']."</option>";}
?>
</select>
<label>Affichage dans les choix</label>
<select type='text' id='hp2' name='hp2'>
<option value='0'>Pas pris en compte/non affiché</option>  
<option value='1'>En fonctionnement/sera affiché</option>  
</select>

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
  p2 = hps.rows[index].cells[0].getAttribute('data-sta');document.getElementById("hp2").value= p2;
  p3 = hps.rows[index].cells[0].getAttribute('data-rol');document.getElementById("hp3").value= p3;
  document.getElementById("hp0").value= p0;document.getElementById("hp1").value= p1; 
  }}
},false);
</script>
