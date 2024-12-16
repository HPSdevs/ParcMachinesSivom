<?php
include('./controllers/ctrl-typeintervention.php');
// ===DIV QUAD

//---Appear
//echo "<div class='cmdappear'>";
//echo "<a href='index.php?voirparc'><img src='./assets/icons/list.svg' title='Voir le parc'/></a>";
//echo "<a href='javascript:history.back()'><img src='./assets/icons/back.svg' title='Revenir en arrière'/></a>";
//echo "</div>";
//---fin appear
echo "<div class='titre'>DEMANDE n°" . $intervention['id_intervention'] . "</div>";
$typeInter = CallGetTypeInter($machine['idgenre'], $GRADE);
echo "<form action='?addinter/" . $machine['id_machine'] . "' method='POST'>";
echo "<input type='hidden' name='idin' value='" . $intervention['id_intervention'] . "' />";
echo "<input type='hidden' name='idma' value='" . $machine['id_machine'] . "' />";
echo "<fieldset class='fieldnorm red'><legend>&nbsp;RAPATRIEMENT&nbsp;</legend>";
echo "Si la machine est accidentée/immobilisée et vous ne pouvez donc pas la présenter au service technique, merci de cocher la case ci-dessous et de renseigner au plus utile sa location.<br/><br/>";
echo "<div class='inline' >Le matériel ci-contre est immobilisé et doit être rapatrié :";
$a = $intervention['statut_depose'] ? "checked" : "";
echo "<div class='hpscheck'><input name='dep' class='tgl tgl-ios' id='toggle-34' type='checkbox' $a value='1'><label class='tgl-btn' for='toggle-34'></label></div></div>";
echo "<div>↪ Emplacement précis (n°, rue, ville ou toutes autres informations utiles.) :";
echo "<textarea name='adress' cols='93' rows='3'>" . $intervention['depose_lieu'] . "</textarea></div>";
echo "</fieldset><br>";
echo "<fieldset class='fieldnorm'><legend>&nbsp;Concernant la demande d'intervention&nbsp;</legend>";
echo "Motif de la demande d'intervention : <select name='tinter' required='required' >";
foreach ($typeInter as $t) {
	$a = "";
	if ($t["id_typeintervention"] == $intervention['idx_typeintervention']) {
		$a = "selected";
	}
	echo "<option value='" . $t["id_typeintervention"] . "' " . $a . ">" . $t["designation"] . "</option>";
}
echo "</select><br><br>";
echo "Explications/Commentaires sur le motif de la demande :";
echo "<textarea name='com' cols='93' rows='8' maxlength='900' placeholder='Merci de détailler au maximum le ou les problèmes rencontrés (minimum 20 caractères.)'>" . $intervention['comment_demandeur'] . "</textarea>";
echo "</fieldset><br>";
echo "<div style='display:flex;justify-content: center;'>";
echo "<button name='chx' value='delt'>Effacer cette demande</button>";
echo "&nbsp;&nbsp;&nbsp;<button name='chx' value='save'>Sauvegarder la demande</button>";
echo "&nbsp;&nbsp;&nbsp;<button name='chx' value='nope'>RETOUR</button>";
echo "&nbsp;&nbsp;&nbsp;<button name='chx' value='send' class='bold'>Envoyer la demande</button>";
echo "</div></form>";
