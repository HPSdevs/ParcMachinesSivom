<?php
if (!defined("hpsstart")) {
  header('Location: ./index.php');
}   // check start app
//----Require
require_once("./controllers/ctrl-machine.php");

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
//----Page
//echo "<form action='' method='POST'>";
echo "<div class='titrepage'>Vue générale " . $machine['genre'] . "</div>";
echo "<div class='explainpage'>détails de la machine</div>";
echo "<div class='quadrature'>";
// Q1
echo "<div class='quad a border'>";
include("./components/quad/machine-informations.php");
echo "</div>";
// Q2
echo "<div class='quad b border'>";
include("./components/quad/machine-interencours.php");
echo "</div>";
// Q3
echo "<div class='quad c border'>";
include("./components/quad/machine-documents.php");
echo "</div>";
// Q4
echo "<div class='quad d border'>";
include("./components/quad/machine-interfinies.php");
echo "</div>";
// cloture Quad
echo "</div>";
