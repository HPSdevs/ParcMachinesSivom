<?php
require_once('./controllers/ctrl-prestation.php');
// $idinter --> $idmachine --> $idaction
/* STATUT_INTERVENTION en valeur
  0  = créée mais pas encore validé par le demandeur	    (48 heures d'existence)
  1  = validée par le demandeur, en attente de traitement
  2  = Traitement en cours
  4  = Traitement assigné (...not in this version)
  8  = intervention refusée
  16 = intervention cloturée
*/
$comment    = $intervention['comment_demandeur'];
$deposestat = $intervention['statut_depose'];
$deposelieu = $intervention['depose_lieu'];
$datenow    = date('Y-m-d');
$timenow    = '00:00';
// ------------------------PAGE
$lst = CallPrestation($idinter);
$totalprix = 0;
$totaltemps = null;
//--recapliste
echo "<div id='pdilist' class='limitheight'><table id='hpspdi' class='journallist hovermode'>";
echo "<th><tr class='centertext titletext'><td>Date</td><td>Action</td><td>Objet</td><td>Qte</td><td>P.U.HT</td><td>Total HT</td></tr></Th>";
foreach ($lst as $l) {
    $totalprix  +=  $l['total'] / 100;
    $totaltemps +=  date('H', strtotime($l['duree'])) * 60 + date('i', strtotime($l['duree']));
    echo "<tr id='" . $l['id_prestation'] . "'>"; //           
    echo "<td data-qud='" . gadgettime($l['quand']) . "' data-tps='" . $l['duree'] . "' width='110px'>" . frenchdate($l['quand']) . "</td>";
    echo "<td data-hps='" . $l['idx_action'] . "'><div style='width:170px' class='cuttext' title='Effectué par " . $l['login'] . "'>" . $l['designation'] . "</div></td>";
    echo "<td data-obj='" . $l['objet'] . "'><div style='width:230px' class='cuttext'>" . $l['objet'] . "</div></td>";
    echo "<td data-qte='" . $l['quantite'] . "'><div style='width:40px' class='cuttext centertext'>" . $l['quantite'] . "</div></td>";
    echo "<td data-prx='" . ($l['prix'] * 1) . "'><div style='width:120px' class='cuttext righttext'>" . enArgent($l['prix']) . "</div></td>";
    echo "<td><div style='width:120px' class='cuttext righttext'>" . enArgent($l['total']) . "</div></td>";
    echo "</tr>";
}
echo "<tr><td colspan='6'>&nbsp;</td></tr>";
//$a = $totaltemps ? date('H:i', mktime(0, $totaltemps)) : '00:00';
$a = enTemps($totaltemps);
echo "<tr class='righttext'><td colspan='4'>Temps total de l'intervention :</td><td>" . $a . "</td><td>&nbsp;</td></tr>";
echo "<tr class='righttext'><td colspan='4' >Prix total (HT) de l'intervention :</td><td>" . enArgent($totalprix * 100) . "</td><td>&nbsp;</td></tr>";
echo "</table></div>";
//--Prestation
if ($statutinter < 8 && $GRADE > 1) {
    echo "<div class='fac'><form method='POST' act='';'><fieldset><legend>Action de prestation</legend>";
    echo "<input type='hidden' id='idp' name='idp' value=''/>";
    echo "<div class='lgn'>";
    echo "<span><label for='qud'>En date du</label><input tabindex='0' id='qud' name='qud' type='date' class='qud' value='$datenow'/></span>";
    echo "<span><label for='act'>Action effectuée</label><select tabindex='1' type='text' name='act' id='act' class='slc'/>";
    foreach ($action as $g) {
        echo "<option value='" . $g['id_action'] . "' >" . $g['designation'] . '</option>';
    }
    echo '</select></span>';
    echo "<span><label for='tps'>Temps passé (h:m)</label><input tabindex='2' id='tps' name='tps' type='time' class='prx' value='$timenow'></span>";
    echo '</div>';
    echo "<div class='lgn'><span><label for='obj'>désignation de la pièce ou matériel</label><input tabindex='3' name='obj' id='obj' type='text' class='obj' placeholder='Pièce utilisée'/></span>";
    echo "<span><label for='qte'>Quantité</label><input tabindex='4' id='qte' name='qte' type='number' class='qte' value='1'/></span>";
    echo "<span><label for='prx'>Prix unitaire H.T.</label><input tabindex='5' name='prx' id='prx' type='text' pattern='^\d*(\.\d{0,2})?$'   placeholder='00.00' class='prx'/></span>";
    echo '</div>';
    echo "</br>&nbsp;&nbsp;&nbsp;<input tabindex='9' type='reset' value='&nbsp;Annuler la sélection&nbsp;' onclick='doreset()'/>&nbsp;";
    echo "<button tabindex='8' type='submit' name='aac' id='aacm' value='aacm' disabled=disabled/>Modifier la ligne</button>&nbsp;";
    echo "<button tabindex='7' type='submit' name='aac' id='aace' value='aace' disabled=disabled/>Enlever la ligne</button>&nbsp;";
    echo "<button tabindex='6' type='submit' name='aac' id='aaca' value='aaca'/>Ajouter la ligne</button>&nbsp;";
    echo '</fieldset></form></div>';
    echo "
    <script>
    var oldtr = null;
    var hps = document.getElementById('hpspdi');
    hps.addEventListener('click', function(e) {
        tr = e.target.closest('tr');
        if (tr) {
            index = tr.rowIndex;
            if (hps.rows[index]) {
                id = hps.rows[index].id;
                if (id) {
                    if (oldtr) {
                        oldtr.className = '';
                    }
                    tr.className = 'selected';
                    oldtr = tr;
                    document.getElementById('idp').value = id;
                    document.getElementById('qud').value = hps.rows[index].cells[0].getAttribute('data-qud');
                    document.getElementById('tps').value = hps.rows[index].cells[0].getAttribute('data-tps');
                    document.getElementById('act').value = hps.rows[index].cells[1].getAttribute('data-hps');
                    document.getElementById('obj').value = hps.rows[index].cells[2].getAttribute('data-obj');
                    document.getElementById('qte').value = hps.rows[index].cells[3].getAttribute('data-qte');
                    document.getElementById('prx').value = hps.rows[index].cells[4].getAttribute('data-prx');
                    document.getElementById('aaca').disabled = true;
                    document.getElementById('aace').disabled = false;
                    document.getElementById('aacm').disabled = false;
                }
            }
        }
    }, false);

    function doreset() {
        document.getElementById('aaca').disabled = false;
        document.getElementById('aacm').disabled = true;
        document.getElementById('aace').disabled = true;
        if (oldtr) {
            oldtr.className = '';
            oldtr = null;
        }
    }
    document.getElementById('pdilist').lastElementChild.scrollIntoView(false);
    </script>";
}
