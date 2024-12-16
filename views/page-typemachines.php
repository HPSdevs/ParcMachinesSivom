<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}   // check start app
//----start
require_once("./controllers/ctrl-typemachine.php");
require_once("./controllers/ctrl-genre.php");
require_once("./controllers/ctrl-journal.php");
//----traitement
if (isset($_POST['submit'])) {
  $action = $_POST['submit'];
  $id     = intval($_POST['hpi']);
  $design = strip_tags(trim($_POST['hp0']));
  $genre  = $_POST['hp1'];
  $statut = $_POST['hp2'];
  switch ($action) {
    case "upd":
      if ($id) {
        CallUpdateTypeMachine($design, $genre, $statut, $id);
        echo "<div class='tempmodal vert'>Le type a été modifié</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a modifié Type '" . $design . "' (" . $id . "/" . $genre . "/" . $statut . ")");
      }
      break;
    case "add":
      if ($design && $id === 0) {
        CallInsertTypeMachine($design, $genre, $statut);
        echo "<div class='tempmodal vert'>Le type a été ajouté</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a ajouté Type '" . $design . "' (" . $genre . "/" . $statut . ")");
      }
      break;
    case "del":
      if ($id) {
        $res = CallDeleteTypeMachine($id);
        if ($res) {
          echo "<div class='tempmodal vert'>Le type a été effacé</div>";
          CallInsertJournal($IDUSER, 64, $LOGIN . " a effacé Type '" . $design . "' (" . $id . "/" . $genre . "/" . $statut . ")");
        } else {
          echo "<div class='tempmodal rouge'>Impossible le type est utilisé</div>";
        }
      }
      break;
  }
}

//----Chargement DATA
$genremachines = CallGetallGenreMachines();
$typemachines = CallGetAllTypeMachines();

function genre($x)
{
  global $genremachines;
  foreach ($genremachines as $g) {
    if ($x == $g['id_genremachine']) {
      return $g['designation'];
    }
  }
}


echo "<div class='titrepage'>Gestion des types</div>";
echo "<div class='explainpage'>Classification dans les véhicules et dans les outils</div>";
echo "<div class='container'>";
echo "<div class='cotegauche'>";
echo "<table id='hpstab' class='listeelements center'>";
echo "<thead><tr><td>Désignation ↓</td><td>Genre</td><td width='50px' class='centrer'>Affichage</td></tr></thead><tbody>";

foreach ($typemachines as $m) {
  echo "<tr id='" . $m['id_typemachine'] . "'>";
  echo "<td  data-gen='" . $m['genre'] . "' data-sta='" . $m['statut'] . "' >" . $m['designation'] . "</td>";
  echo "<td>" . genre($m['genre']) . "</td>";
  echo "<td class='centrer'>" . statut($m['statut']) . "</td>";
  echo "</tr>";
}
?>
</tbody>
</table>
</div>
<div class='cotedroit'>
  <div class='stickyman'>
    <form action='' method='post'>
      <fieldset>
        <legend>ACTIONS</legend>
        <input type='hidden' id='hpi' name='hpi' />
        <label>Désignation</label>
        <input type='text' id='hp0' name='hp0' maxlength='35' />
        <label>Pour le genre</label>
        <select type='text' id='hp1' name='hp1'>
          <?php
          foreach ($genremachines as $g) {
            echo "<option value='" . $g['id_genremachine'] . "' >" . $g['designation'] . "</option>";
          }
          ?>
        </select>
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
          <input class="boutd" type='reset' id='su' value='Annuler sélection' />
        </div>
      </fieldset>
    </form>
  </div>
</div>
</div>
<script type="text/javascript" src="scripts/machine.js"></script>