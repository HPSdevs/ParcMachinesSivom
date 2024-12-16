<?php
if (!defined('hpsstart')) {
  header('Location: ./index.php');
}
// check start app
require_once('./controllers/ctrl-intervention.php');
require_once('./controllers/ctrl-typeintervention.php');
require_once('./controllers/ctrl-machine.php');
require_once('./controllers/ctrl-action.php');
require_once("./controllers/ctrl-journal.php");
require_once('./controllers/ctrl-prestation.php');

// ----id?
if (isset($URLACTION[1])) {
  $id = abs(intval($URLACTION[1]));
} else {
  header('Location: ./index.php?voirparc');
}
// ---data
$idinter      = $id < 1 ? 1 : $id;
// ----prestation part
$cmd = $_POST['aac'] ?? ''; // commande
if ($cmd) {
  $idp = $_POST['idp'] ?? ''; // id prestation
  $act = $_POST['act'] ?? ''; // action
  $qud = $_POST['qud'] ?? ''; // quand
  $tps = $_POST['tps'] ?? ''; // temps
  $obj = $_POST['obj'] ?? ''; // objet
  $obj = htmlspecialchars($obj, ENT_QUOTES);
  $qte = $_POST['qte'] ?? 1; // quantite
  $prx = $_POST['prx'] ?? 0; // prix unit.
  // switch
  switch ($cmd) {
    case 'aaca':
      if ($idinter) {
        CallInsertPrestation($idinter, $IDUSER, $act, $qud, $tps, $obj, $qte, $prx);
        CallUpdateTotalIntervention($idinter);
        CallUpdateAutoStatutintervention($idinter);
        echo "<div class='tempmodal vert'>Prestation d'intervention ajoutée</div>";
      }
      break;
    case 'aacm':
      if ($idp) {
        CallUpdatePrestation($act, $qud, $tps, $obj, $qte, $prx, $idp);
        CallUpdateTotalIntervention($idinter);
        echo "<div class='tempmodal vert'>Prestation d'intervention modifiée</div>";
      }
      break;
    case 'aace':
      if ($idp) {
        CalDeletePrestation($idp);
        CallUpdateTotalIntervention($idinter);
        echo "<div class='tempmodal vert'>Prestation d'intervention enlevée</div>";
      }
      break;
  }
}
// ----gestion part
$cmd = $_POST['ges'] ?? '';   // commande
if ($cmd) {
  $xidi = $_POST['idi'] ?? 0;  // id intervention
  $xkil = $_POST['kil'] ?? 0;  // kilometres/heures
  $xurg = $_POST['urg'] ?? 0;  // urgence
  $xinu = $_POST['inu'] ?? 0;  // hors service
  $ximm = $_POST['imm'] ?? 0;  // immobilisation
  $xdep = $_POST['dep'] ?? 0;  // rapratriement
  $xsti = $_POST['sti'] ?? 1;  // statut intervention
  $xcom = $_POST['com'] ?? ''; // commentaire meca
  $xcom = htmlspecialchars($xcom, ENT_QUOTES);
  // switch
  switch ($cmd) {
    case 'int':
      CallUpdateGestionIntervention($xkil, $xurg, $xinu, $ximm, $xdep, $xsti, $xcom, $xidi);
      CallInsertJournal($IDUSER, 2, $LOGIN . " a modifié la gestion de l'intervention n°" . $xidi);
      if ($xsti & 24) {  // email de fin d'inter
        $iddestin = CallWhoIsDemandeur($xidi);
        sendFinIntervention($iddestin);
      }
      break;
  }
}
/*
// AFFICHAGE
*/
$intervention = CallGetInterventionByID($idinter);
if (!$intervention) header('Location: ./index.php?voirparc');
$idmachine       = $intervention['idx_machine'];
// CHECK autorisation de voir
$demandeur  = $intervention['idx_demandeur'];
$kick =  $GRADE > 1 ? false : ($IDUSER == $demandeur ? false : true);
if ($kick) header('Location: ./index.php?voirparc');
//
CallUpdateAlerte($idmachine); // mise à jour automatique d'alerte
$machine         = CallGetThisMachine($idmachine);
$action          = CallGetAction($idmachine);
$numerointer     = numero($idinter);
$txtintervention = CallGetDesignInter($intervention['idx_typeintervention']);
$statutinter     = $intervention['statut_intervention'];
$totalprestation = $intervention['total_prestation'];
$datecreation    = frenchdate($intervention['date_creation']);
$datecloture     = frenchdate($intervention['date_cloture']);
$a = "demande d'intervention";
$b = "";
if ($statutinter & 24) {
  $dateinterval   = date_diff(new DateTimeImmutable($intervention['date_creation']), new DateTimeImmutable($intervention['date_cloture']));
  $dateaff        = $dateinterval->days > 0 ? ($dateinterval->days > 1 ? "(" . $dateinterval->days . " jours)" : "(" . $dateinterval->days . " jour)") : "";
  $a = "intervention";
  $b = " cloturée le $datecloture $dateaff";
}
// ----Page
//echo "<form action='' method='POST'>";
echo "<div class='titrepage'>$a n°$numerointer du $datecreation</div>";
echo "<div class='explainpage'>$b</div>";
echo "<div class='quadrature trio'>"; // TRIO ou pas
// Q1
echo "<div class='quad a border'>";
include('./components/quad/machine-informations.php');
echo '</div>';

// Q2
echo "<div class='quad b'>";
echo "<div class='onglets'><div class='tabs'>"; // avec onglets 
$a = ($totalprestation > 1) ? "s" : "";
echo "<span class='tab'><input id='tab-1' checked='checked' name='tab-group-1' type='radio'/>";
echo "<label for='tab-1'>Prestation$a de l'intervention</label><div class='content'>";
include('./components/quad/intervention-prestations.php');
echo "</div></span>";

if ($GRADE > 2 || ($GRADE = 2 && $statutinter < 8)) {   // meca si non cloturée & tjs chef ou admin
  echo "<span class='tab'><input id='tab-2' name='tab-group-1' type='radio'/>";
  echo "<label for='tab-2'>Gestion de l'intervention</label><div class='content'>";
  include('./components/quad/intervention-gestion.php');
  echo "</div></span>";
}
echo "</div></div>"; // tabs & onglets 
echo "</div>"; //q


// Q3
echo "<div class='quad c border'>";
include('./components/quad/intervention-resume.php');
echo '</div>';


// Q4
// echo "<div class='quad d'>";
// include( './components/quad/machine-interfinies.php' );

echo '</div>'; // Fin quadrature
