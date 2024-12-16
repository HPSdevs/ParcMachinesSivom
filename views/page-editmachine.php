<?php
if (!defined('hpsstart') || ($GRADE < 2)) {
  header('Location: ../index.php');
}
// check start app
//----Require
require_once('./controllers/ctrl-energie.php');
require_once('./controllers/ctrl-marque.php');
require_once('./controllers/ctrl-modele.php');
require_once('./controllers/ctrl-typemachine.php');
require_once('./controllers/ctrl-journal.php');
require_once('./controllers/ctrl-machine.php');

//----data load par defaut
$energiemachines = CallGetAllEnergieMachines();
$marquemachines = CallGetAllMarqueMachines();
$modelemachines = CallGetAllModeleMachines();
$typemachines = CallGetAllTypeMachines();
$rec = false;
// Si erreur
$mar = 0;
//-----Traitement
if (isset($_POST['submit'])) {
  $act  = $_POST['submit'];
  $idmac = intval(trim($_POST['idedit']));
  $gen  = $_POST['genre'];
  $actif = $_POST['actif'];
  $typ  = $_POST['type'];
  $mod  = $_POST['model'];
  $nrj  = $_POST['energie'];
  $mar  = $_POST['marque'];
  $ima  = strip_tags(trim($_POST['imat']));
  $pui  = intval(trim($_POST['puissance']));
  $datp = $_POST['dateprem'];
  $datt = $_POST['datetech'];
  $obs  = strip_tags(trim($_POST['obs']));
  $im = verifImmatriculation($ima);
  switch ($act) {
    case 'sra':
      if (SearchSimpleIMAT($im) == $idmac || SearchSimpleIMAT($im) == false) {
        include('./components/machine-designation.php');
        CallUpdateMachine($gen, $nrj, $mod, $typ, $mar, $pui, $im, $datp, $datt, $des, $obs, $IDUSER, $idmac);
        CallInsertJournal($IDUSER, 2, $LOGIN . ' a modifié ' . $des);
        echo "<div class='tempmodal vert'>Vos données ont été ajoutées</div>";
        header("Location: ./index.php?voirmachine/$idmac");
      } else {
        echo "<div class='tempmodal rouge'>Immatriculation déjà présente !</div>";
        $rec = true;
      }
      break;
    case 'dtd':
      if ($actif) {
        echo "<div class='tempmodal rouge'>Machine désactivée !</div>";
        CallOffMachine($idmac);
      } else {
        echo "<div class='tempmodal vert'>Machine Activée !</div>";
        CallOnMachine($idmac);
      }
      break;
  }
}
//----Chargement DATA pour l'EDITION
if (isset($URLACTION[1])) {
  $idedit  = intval($URLACTION[1]);
  if ($idedit < 1) {
    header('Location: ./index.php');
  }
  $machine = CallGetMachine($idedit);
  $mar  = $machine['idx_marque'];
  $g    = $machine['idx_genre'];
  $typ  = $machine['idx_type'];
  $mod  = $machine['idx_modele'];
  $nrj  = $machine['idx_energie'];
  $ima  = $machine['imat'];
  $actif = $machine['actif'];
  $pui  = $machine['puissance'];
  $datp = $machine['date_premservice'];
  $datt = $machine['date_procvsttech'];
  $obs  = $machine['observation'];
  $rec = true;
}
// si modification par url
if (isset($URLACTION[2])) {
  $gurl = intval($URLACTION[2]);
  if ($g != $gurl) {
    $g = $gurl;
    $mar = 0;
    $mod = 0;
    $typ = 0;
    $nrj = 0;
  }
}
if (isset($URLACTION[3])) {
  $markurl = intval($URLACTION[3]);
  if ($mar != $markurl) {
    $mar = $markurl;
    $mod = 0;
  }
}
$a = $g == 1 ? "selected" : "";
$b = $g == 2 ? "selected" : "";
if ($g) {
  $energiemachines = CallGetEnergieMachines($g);
  $marquemachines = CallGetMarqueMachines($g);
  $modelemachines = CallGetModeleMachines($mar);
  $typemachines = CallGetTypeMachines($g);
}
//----Page
echo "<form action='' method='POST'>";
echo "<input type='hidden' name='idedit' value='" . $idedit . "'/>";
echo "<input type='hidden' name='actif' value='" . $actif . "'/>";
echo "<div class='titrepage'>Edition d'une machine</div>";
echo "<div class = 'explainpage'></div>";
echo "<div class = 'masterpage'>";
echo "<div class = 'soustitrepage'>Sélectionner chaque élement composant la nouvelle machine ( 1→5 ):</div>";
echo "<div class = 'choixliste'>";
echo "<div class = 'choixelem'><label>1. Genre</label>";
echo "<select id = 'genre' name = 'genre' size = '15' required = 'required' onclick = 'let e=document.getElementById(\"genre\").value;window.location.href=\"index.php?editmachine/" . $idedit . "/\"+e' >";
echo "<option value = '1' " . $a . ">Véhicule</option><option value = '2' " . $b . ">Outil</option></select></div>";
echo "<div class = 'choixelem'><label>2. Marque [D1]</label>";
echo "<select name = 'marque' id = 'marque' size = '15' required = 'required' onclick = 'let e=document.getElementById(\"marque\").value;window.location.href=\"index.php?editmachine/" . $idedit . "/" . $g . "/\"+e' >>";
foreach ($marquemachines as $v) {
  if ($v["statut"]) {
    $a = "";
    if ($v["id_marquemachine"] == $mar) {
      $a = "selected";
    }
    echo "<option value = '" . $v['id_marquemachine'] . "' " . $a . ">" . $v['designation'] . "</option>";
  }
}
echo "</select></div>";
echo "<div class = 'choixelem'><label>4. Modele [D3]</label><select name = 'model' size = '15' required = 'required' >";
foreach ($modelemachines as $v) {
  if ($v["statut"]) {
    $a = "";
    if ($rec && $v["id_modelemachine"] == $mod) {
      $a = "selected";
    }
    echo "<option value = '" . $v['id_modelemachine'] . "' " . $a . ">" . $v['designation'] . "</option>";
  }
}
echo "</select></div>";
echo "<div class = 'choixelem'>";
echo "<label>3. Type [J2]</label>";
echo "<select name = 'type' size = '15' required = 'required'>";
foreach ($typemachines as $v) {
  if ($v['statut']) {
    $a = "";
    if ($rec && $v['id_typemachine'] == $typ) {
      $a = "selected";
    }
    echo "<option value = '" . $v['id_typemachine'] . "' " . $a . ">" . $v['designation'] . "</option>";
  }
}
echo "</select></div>";
echo "<div class = 'choixelem'><label>5. Energie [P3]</label><select name = 'energie' size = '15' required = 'required' >";
foreach ($energiemachines as $v) {
  if ($v["statut"]) {
    $a = "";
    if ($rec && $v["id_energiemachine"] == $nrj) {
      $a = "selected";
    }
    echo "<option value = '" . $v['id_energiemachine'] . "' " . $a . ">" . $v['designation'] . "</option>";
  }
}
echo "</select></div></div><div class = 'soustitrepage'>Puis renseigner les différents renseignements :</div>";
echo "<div class = 'choixliste'>";
$a = "";
if ($rec) {
  $a = $ima;
}
if ($g == 1) {
  echo "<div class = 'choixelem'><label>Immatriculation [A]</label><input type = 'text' name = 'imat' value = '" . $a . "' required = 'required' placeholder = 'XX 999 XX ou 9999 XX 99'></div>";
} else {
  echo "<div class = 'choixelem'><label>N° de série (non vérifié)</label><input type = 'text' name = 'imat'  value = '" . $a . "' required = 'required' placeholder = '0000XX ou 9999'></div>";
}
$a = "";
if ($rec) {
  $a = $pui;
}
echo "<div class = 'choixelem'><label>Puissance en Watt [P2] (noté en KW sur carte)</label><input type = 'number' value = '" . $a . "' name = 'puissance'></div>";
$a = date('Y-m-d');
if ($rec) {
  $a = $datp;
}
echo "<div class = 'choixelem'><label>Date mise en service [B]</label><input type = 'date' value = '" . $a . "' name = 'dateprem'></div>";
$a = date('Y-m-d');
if ($rec) {
  $a = $datt;
}
echo "<div class = 'choixelem'><label>Date prochaine visite [X1]</label><input type = 'date' value = '" . $a . "' name = 'datetech'></div>";
echo "</div><div class = 'choixliste'>";
$a = "";
if ($rec) {
  $a = $obs;
}
echo "<div class = 'choixligne'><label>Observations</label><textarea rezize = none name = 'obs'>" . $a . "</textarea></div>";
echo "</div><div class = 'actions'>";
$a = $actif ? "Désactiver" : "Activer";
echo "<button  name = 'submit' value = 'dtd'>$a cette machine</button>";
?>
<input type='button' onclick="location.href = 'index.php?voirparc';
" value='Retour liste du parc' />
<button name='submit' value='sra'>Modifier cette machine</button>
</div>
</div>
</form>