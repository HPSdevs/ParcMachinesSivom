<?php
if (! defined("hpsstart")) {
    header('Location: ../index.php');
} // check start app

require_once("./controllers/ctrl-intervention.php");
require_once("./controllers/ctrl-machine.php");
// traitement retour du quad de demande
$chx       = $_POST['chx'] ?? null;
if ($chx) {
    $dep       = $_POST['dep'] ?? 0;
    $adress    = strip_tags(trim($_POST['adress']));
    $tinter    = $_POST['tinter'];
    $com       = strip_tags(trim($_POST['com']));
    $idinter   = $_POST['idin'];
    $idmach    = $_POST['idma'];
    switch ($chx) {
        case 'delt':
            CallDeleteIntervention($idinter);
            echo "<div class='tempmodal rouge'>Cette demande a été effacée</div>";
            header("Location: ./index.php?voirmachine/$idmach");
            break;
        case 'save':
            CallUpdateSaveIntervention($dep, $adress, $tinter, $com, $idinter);
            echo "<div class='tempmodal vert'>Votre demande a été sauvegardée</div>";
            header("Location: ./index.php?voirmachine/$idmach");
            break;
        case 'send':
            CallUpdateSendIntervention($dep, $adress, $tinter, $com, $idinter);
            echo "<div class='tempmodal vert'>Votre demande a été envoyée</div>";
            sendDemandeintervention(); // fonction email vers les chefs meca
            header("Location: ./index.php?voirmachine/$idmach");
            break;
        default:
            header("Location: ./index.php?voirmachine/$idmach");
            break;
    }
} elseif (isset($URLACTION[1])) {
    $idmachine = abs(intval($URLACTION[1]));
    CallRefreshTrashIntervention();
    if (CallCheckIfMachineExist($idmachine)) {
        $idinter = CallGetDemandIntervention($IDUSER, $idmachine, 0);
        if (! $idinter) { // si pas existante, creation valable 48heures.
            $idinter = CallInsertInterMachine($IDUSER, $idmachine);
        }
    } else {
        header('Location: ./index.php?voirparc');
    }
} else {
    header('Location: ./index.php?voirparc');
}
// ----Chargement DATA
$machine = CallGetThisMachine($idmachine);
$intervention = CallGetInterventionByID($idinter);
// ----Page
echo "<div class='titrepage'>Demande d'intervention</div>";
echo "<div class='explainpage'>Les demandes d'intervention sauvegardées sont modifiables pendant 48 heures, les demandes envoyées ne sont plus modifiables.</div>";
echo "<div class='quadrature trio'>";
// Q1
echo "<div class='quad a border'>";
include("./components/quad/machine-informations.php");
echo "</div>";
echo "<div class='quad b border'>";
include("./components/quad/intervention-demande.php");
echo "</div>";
echo "<div class='quad c border'>";
//echo "<div class='titre'>Documents</div>";
// var_dump ( $machine );
// echo "<hr>";
// var_dump ( $intervention );
echo "</div>";
echo "</div>";
