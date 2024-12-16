<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}   // check start app
$aff0 = 0;
$aff1 = 0;
$indmar = 0;
//----start
require_once("./controllers/ctrl-marque.php");
require_once("./controllers/ctrl-modele.php");
require_once("./controllers/ctrl-genre.php");
require_once("./controllers/ctrl-journal.php");
//----traitement
if (isset($_POST['marmit'])) {
  $action = $_POST['marmit'];
  $genre  = $_POST['mark1'];
  $statut = $_POST['mark2'];
  $id     = intval($_POST['marki']);
  $design = strip_tags(trim($_POST['mark0']));

  console("MAR:", $action, $id, $design, $genre, $statut); //  <<----------------- CONSOLE !

  switch ($action) {
    case "marupd":
      if ($id) {
        CallUpdateMarqueMachine($design, $genre, $statut, $id);
        echo "<div class='tempmodal vert'>la marque a été sauvegardée</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a modifié Marque '" . $design . "' (" . $id . "/" . $genre . "/" . $statut . ")");
      }
      break;
    case "maradd":
      if ($design && $id == 0) {
        CallInsertMarqueMachine($design, $genre, $statut);
        echo "<div class='tempmodal vert'>la marque a été ajoutée</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a ajouté Marque '" . $design . "' (" . $genre . "/" . $statut . ")");
      }
      break;
    case "mardel":
      if ($id) {
        $res = CallDeleteMarqueMachine($id);
        if ($res) {
          echo "<div class='tempmodal vert'>la marque a été effacée</div>";
          CallInsertJournal($IDUSER, 64, $LOGIN . " a effacé Marque '" . $design . "' (" . $id . "/" . $genre . "/" . $statut . ")");
        } else {
          echo "<div class='tempmodal rouge'>Impossible, la marque est utilisée</div>";
        }
      }
      break;
  }
}
if (isset($_POST['mudmit'])) {
  $action = $_POST['mudmit'];
  $mudmar = $_POST['mud1'];
  $mudsta = $_POST['mud2'];
  $mudid  = intval($_POST['mudi']);
  $muddes = strip_tags(trim($_POST['mud0']));

  //console("MOD:",$action,$mudid,$muddes,$mudmar,$mudsta); //  <<----------------- CONSOLE !

  switch ($action) {
    case "mudupd":
      if ($mudid && $mudmar > 0) {
        CallUpdateModeleMachine($muddes, $mudmar, $mudsta, $mudid);
        echo "<div class='tempmodal vert'>le modèle a été modifié</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a modifié le modèle '" . $muddes . "' (" . $mudid . "/" . $mudmar . "/" . $mudsta . ")");
      }
      break;
    case "mudadd":
      if ($muddes && $mudmar > 0) {
        CallInsertModeleMachine($muddes, $mudmar, $mudsta);
        echo "<div class='tempmodal vert'>le modèle a été ajouté</div>";
        CallInsertJournal($IDUSER, 64, $LOGIN . " a ajouté le modèle '" . $muddes . "' (" . $mudmar . "/" . $mudsta . ")");
      }
      break;
    case "muddel":
      if ($mudid && $mudmar > 0) {
        $res = CallDeleteModeleMachine($mudid);
        if ($res) {
          echo "<div class='tempmodal vert'>le modèle a été effacé</div>";
          CallInsertJournal($IDUSER, 64, $LOGIN . " a effacé le modèle '" . $muddes . "' (" . $mudid . "/" . $mudmar . "/" . $mudsta . ")");
        } else {
          echo "<div class='tempmodal rouge'>Impossible, le modèle est utilisé</div>";
        }
      }
      break;
  }
}

//----Chargement DATA
$genremachines = CallGetallGenreMachines();
$marquemachines = CallGetAllMarqueMachines();
$modelemachines = CallGetAllModeleMachines();
//----Chargement DATA si précisé
if (isset($URLACTION[1])) {
  $mar = intval($URLACTION[1]);
} else {
  $mar = 0;
}
if ($mar) {
  $modelemachines = CallGetModeleMachines($mar);
  $indmar = array_search($mar, array_column($marquemachines, "id_marquemachine"));
  $affstatut = $marquemachines[$indmar]['statut'];
  $aff0 = $affstatut == 0 ? "selected" : "";
  $aff1 = $affstatut == 1 ? "selected" : "";
}

echo "<div class='titrepage'>Gestion des marques/modèles</div>";
echo "<div class='explainpage'>Chaque marque peut avoir plusieurs modèles</div>";
//-------------------------------------------------------------------------------------------------------------------
echo "<div class='container'>";
//-------------------------------------------------------------------------------------------------------------------
echo "<div class='cotegauche quart'>";
echo "<div class='stickyman'>";
echo "<form action='index.php?marques' method='post'>";
echo "<fieldset><legend>MARQUE</legend>";
echo "<input type='hidden' name='marki' value='" . $mar . "'/>";
echo "<label>Désignation de la Marque</label>";
$a = $mar ?  $marquemachines[$indmar]['designation'] : "";
echo "<input type='text' name='mark0' value='" . $a . "' maxlength='20'/>";
echo "<label>Pour le genre</label>";
echo "<select type='text' name='mark1'>";
foreach ($genremachines as $g) {
  $a = $g['id_genremachine'] == $marquemachines[$indmar]['genre'] ? "selected" : "";
  echo "<option value='" . $g['id_genremachine'] . "' " . $a . ">" . $g['designation'] . "</option>";
}
echo "</select>";
echo "<label>Affichage dans les choix</label>";
echo "<select type='text' name='mark2'><option value='0' " . $aff0 . ">Pas pris en compte</option><option value='1' " . $aff1 . ">En fonctionnement</option></select>";
echo "<div class='boutons'>";
echo "<button class='bouta' name='marmit' value='mardel'>Retirer</button>";
echo "<button class='boutb' name='marmit' value='marupd'>Sauver modification</button>";
echo "<button class='boutc' name='marmit' value='maradd'>Ajouter</button>";
echo "<button class='boutd' name='marmit' value='marres'>Annuler sélection</button>";
echo "</div></fieldset></form></div></div>";
echo "<div class='cotegauche quart limity'>";
//-------//
echo "<table id='marque' class='listeelements'>";
foreach ($marquemachines as $ma) {
  $a = $mar == $ma["id_marquemachine"] ? "class='selected'" : "";
  $b = $ma["statut"] ? "<img src='./assets/icons/true.svg'>" : "<img src='./assets/icons/false.svg'>";
  $c = $ma["genre"] & 1 ? "<img src='./assets/icons/car.svg'>" : "";
  $d = $ma["genre"] & 2 ? "<img src='./assets/icons/tool.svg'>" : "";
  echo "<tr id='" . $ma["id_marquemachine"] . "' " . $a . ">";
  echo "<td width='30px'>" . $b . "</td>";
  echo "<td width='30px'>" . $c . "</td>";
  echo "<td width='30px'>" . $d . "</td>";
  echo "<td>" . $ma['designation'] . "</td></tr>";
}
echo "</table>";
echo "</div>";
//-------------------------------------------------------------------------------------------------------------------
echo "<div class='cotegauche quart limity'>";
echo "<table id='modele' class='listeelements'>";
foreach ($modelemachines as $mo) {
  $b = $mo["statut"] ? "<img src='./assets/icons/true.svg'>" : "<img src='./assets/icons/false.svg'>";
  echo "<tr id='" . $mo["id_modelemachine"] . "'>";
  echo "<td width='30px' data-sta='" . $mo['statut'] . "'>" . $b . "</td>";
  echo "<td data-mar='" . $mo['idx_marque'] . "'>" . $mo['designation'] . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='cotedroit quart'>";
echo "<div class='stickyman'>";
echo "<form action='index.php?marques' method='post'>";
echo "<fieldset><legend>MODELE</legend>";
echo "<input type='hidden' id='mudi' name='mudi'/>";
echo "<label>Désignation du Modèle de la marque</label>";
echo "<input type='text' id='mud0' name='mud0' maxlength='20'/>";
echo "<br/><br/><br/><br/>";
echo "<input type='hidden' id='mud1' name='mud1'value='" . $mar . "'/>";
echo "<label>Affichage dans les choix</label>";
echo "<select type='text' id='mud2' name='mud2'><option value='0'>Pas pris en compte/non affiché</option><option value='1'>En fonctionnement/sera affiché</option></select>";
echo "<div class='boutons'>";
echo "<button class='bouta' name='mudmit' value='muddel'>Retirer</button>";
echo "<button class='boutb' name='mudmit' value='mudupd'>Sauver modification</button>";
echo "<button class='boutc' name='mudmit' value='mudadd'>Ajouter</button>";
echo "<input class='boutd' type='reset' id='su' value='Annuler sélection'/>";
echo "</div></fieldset></form></div></div>";

//-------------------------------------------------------------------------------------------------------------------
echo "</div>";
?>
<script>
  var markhps = document.getElementById("marque");
  markhps.addEventListener("click",
    function(e) {
      event = e.target;
      index = event.parentElement.rowIndex;
      if (markhps.rows[index]) {
        id = markhps.rows[index].id;
        if (id) {
          window.location.href = "index.php?marques/" + id;
        }
      }
    }, false);
  var mudhps = document.getElementById("modele");
  mudhps.addEventListener("click",
    function(e) {
      event = e.target;
      index = event.parentElement.rowIndex;
      if (mudhps.rows[index]) {
        id = mudhps.rows[index].id;
        if (id) {
          document.getElementById("mudi").value = id;
          t0 = mudhps.rows[index].cells[1].innerHTML;
          document.getElementById("mud0").value = t0;
          t1 = mudhps.rows[index].cells[1].getAttribute('data-mar');
          document.getElementById("mud1").value = t1;
          t2 = mudhps.rows[index].cells[0].getAttribute('data-sta');
          document.getElementById("mud2").value = t2;
        }
      }
    }, false);
</script>