<?php
if (!defined("hpsstart")) {
  header('Location: ./index.php');
}   // check start app
//----Require
require_once("./controllers/ctrl-machine.php");
require_once("./controllers/ctrl-document.php");
//----data load par defaut 
if (isset($URLACTION[1])) {
  $id = abs(intval($URLACTION[1]));
} else {
  header('Location: ./index.php?voirparc');;
}
$id = $id < 1 ? 1 : $id;
$machine = CallGetThisMachine($id);
$idmachine = $id; // memorise la machine pour l'ensemble des pages suivantes
//-----Traitement
if (!$machine) {
  header('Location: ./index.php');
}
require_once("./controllers/ctrl-document.php");
// ----gestion document
$err  = "";
$nerr = "";
$cmd = $_POST['btd'] ?? '';   // commande
if ($cmd) {
  $xidmd = $_POST['idmd'] ?? 0;     // iddocument
  $xfich = $_FILES['fsag'] ?? null; // nomfichier
  $xlege = $_POST['lege'] ?? '';    // legendefichier
  $xlege = htmlspecialchars($xlege, ENT_QUOTES);

  switch ($cmd) {
    case 'addoc':
      if ($idmachine && $IDUSER) {
        $nom    = $xfich['name'] ?? '';
        $taille = $xfich['size'] ?? 0;
        $chemin = pathinfo($nom) ?? '';
        $extension = $chemin['extension'] ?? '';
        if (!$nom) {
          $err = "Choisissez d'abord un fichier";
        } elseif ($taille < 1000) {
          $err = "Le fichier est trop petit (min 1Ko)";
        } elseif ($taille > $UPLOADMAX) {
          $err = "Le fichier est trop gros (max " . ($UPLOADMAX / 1000000) . " Mo)";
        } elseif (!(in_array($extension, $UPLOADFOK))) {
          $err = "Ce type de fichier n'est pas autorisé";
        }

        if (!$err) { // switch si pas erreur
          $dest = $UPLOADDIR;
          if (!file_exists($dest)) mkdir($dest);
          $par1 = $machine['marque'] . "-" . $machine['imat'];
          $par2 = substr("0000" . dechex($IDUSER), -4);
          $par3 = dechex(date("YmdHis"));
          $part = $par1 . "-" . $par2 . "_" . $par3 . "." . $extension;
          if (move_uploaded_file($xfich['tmp_name'], $dest . $part)) {
            CallInsertDocument($idmachine, $IDUSER, $xlege, $part);
            $nerr = "Téléchargement document effectué";
          } else {
            $err = "Erreur de Téléchargement";
          }
        }
      }
      break;
    case 'modoc':
      CallUpdateDocument($IDUSER, $xlege, $xidmd);
      $nerr = "Modification document effectuée";
      break;
    case 'redoc':
      $temp = CallFilenameDoc($xidmd);
      if ($temp) unlink($UPLOADDIR . $temp['filename']);
      CallDeleteDocument($xidmd);
      $nerr = "Effacement document effectué";
      break;
  }
}
//----Erreur telechargement ?
if ($err) {
  echo "<div class='tempmodal rouge'>$err</div>";
} else if ($nerr) {
  echo "<div class='tempmodal vert'>$nerr</div>";
}

//----Page
echo "<div class='titrepage'>Vue " . $machine['genre'] . "</div>";
echo "<div class='explainpage'>documents</div>";
echo "<div class='quadrature trio'>";
// Q1
echo "<div class='quad a border'>";
include("./components/quad/machine-informations.php");
echo "</div>";

// Q2
echo "<div class='quad b'>";
echo "<div class='onglets'><div class='tabs'>"; // avec onglets 
echo "<span class='tab'><input id='tab-1' checked='checked' name='tab-group-1' type='radio'/>";
echo "<label for='tab-1'>Gestion des documents</label><div class='content'>";
include('./components/quad/machine-gestiondocs.php');
echo "</div></span>";
/*
  echo "<span class='tab'><input id='tab-2' name='tab-group-1' type='radio'/>";
  echo "<label for='tab-2'>onglet2</label><div class='content'>";
  include('./components/quad/xxx.php');
  echo "</div></span>";
*/
echo "</div></div>"; // tabs & onglets 
echo "</div>"; //q
// Q3
echo "<div class='quad c border'>";
include('./components/quad/machine-documents.php');
echo "</div>";
// Q4
// echo "<div class='quad d border'>";
// echo "</div>";
// cloture Quad
echo "</div>";
