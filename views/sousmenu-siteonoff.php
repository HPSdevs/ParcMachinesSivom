<?php
if (!defined("hpsstart")) {
  header('Location: ./index.php');
}   // check start app
//----Require
require_once("./controllers/ctrl_maintenance.php");
//----data load par defaut 
$bfm = GetSiteStatut();
//-----Traitement
$act  = $_POST['submit'] ?? "";
if ($act == "val") {
  $bfm  = intval($_POST['bfm']  ?? 1);
  ToggleSiteStatut($bfm);
  header('Location: index.php?siteonoff');
}
$a = ($bfm == 1) ? "" : "checked";
//----Page
?>
<form action='' method='POST'>
  <div class='titrepage'>Maintenance</div>
  <div class='explainpage'>seul l'admin a accès à cette page</div>
  <div style='display:flex;justify-content: center;align-items: center;width:63%;flex-direction:column;  margin-left:20%;margin-right:20%'>
    <div style='font-size:25px'>Cela permet de passer le site en ' maintenance ' c'est à dire sans aucune interaction car personne ne peut naviguer dessus. Vous êtes alors dans la possibilité de sauvegarder ou de modifier des éléments de l'application ou de la base de données sans aucune interférence.
      <p><br>Note: tous utilisateurs hormis le(s) administateur(s) seront automatiquement déconnectés du site.</p>
    </div><br><br>
    <div class='inline'>Maintenance de l'application <div class='hpscheck'><input name='bfm' class='tgl tgl-ios' id='toggle-urg' type='checkbox' <?php echo $a ?> value='0'><label class='tgl-btn' for='toggle-urg'></label></div>
    </div><br>
    <div class='boutons'><button class="bouta" name='submit' value='val'>Valider la position du bouton</button></div>
  </div>