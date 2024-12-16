<?php
if (!defined('hpsstart')) {
    header('Location: ../index.php');
}
// check start app

require_once('./controllers/ctrl-utilisateur.php');
require_once('./controllers/ctrl-journal.php');

//----traitement
if (isset($_POST['submit'])) {
    $action    = $_POST['submit'];
    $Xid       = $_POST['hpi'];
    $Xlogin    = htmlspecialchars(trim($_POST['hp0']), ENT_QUOTES);
    $Xpass     = htmlspecialchars(trim($_POST['hp1']), ENT_QUOTES);
    $Xstatut   = $_POST['hp2'];
    $Xgrade    = $_POST['hp3'];
    $Xcourriel = htmlspecialchars(trim($_POST['hp4']), ENT_QUOTES);
    $Xpseudo   = htmlspecialchars(trim($_POST['hp5']), ENT_QUOTES);
    switch ($action) {
        case 'upd':
            if ($Xid) {
                if (!CallCheckExistLoginExceptMe($Xlogin, $Xid)) {
                    CallUpdateUser($Xstatut, $Xgrade, $Xlogin, $Xpseudo, $Xcourriel, $Xid);
                    if ($Xpass) {
                        $Xpass = Cryptage($Xpass);
                        CallUpdatePWDUser($Xpass, $Xid);
                    }
                    echo "<div class='tempmodal vert'>Vos données ont été modifiées</div>";
                    CallInsertJournal($IDUSER, 128, $LOGIN . " a modifié Utilisateur '" . $Xpseudo . "' (" . $Xgrade . '/' . $Xstatut . ')');
                } else {
                    echo "<div class='tempmodal rouge'>MODIF: Identifiant déjà existant</div>";
                }
            }
            break;
        case 'add':
            if (!CallCheckExistLogin($Xlogin)) {
                if ($Xlogin) {
                    if ($Xpass) {
                        $Xpass = Cryptage($Xpass);
                        CallInsertUser($Xstatut, $Xgrade, $Xlogin, $Xpseudo, $Xpass, $Xcourriel);
                        echo "<div class='tempmodal vert'>Vos données ont été ajoutées</div>";
                        CallInsertJournal($IDUSER, 128, $LOGIN . " a ajouté Utilisateur '" . $Xpseudo . "' (" . $Xgrade . '/' . $Xstatut . ')');
                    } else {
                        echo "<div class='tempmodal rouge'>AJOUT: il n'y a pas de mot de passe</div>";
                    }
                } else {
                    echo "<div class='tempmodal rouge'>AJOUT: il n'y a pas d'identifiant</div>";
                }
            } else {
                echo "<div class='tempmodal rouge'>AJOUT: Identifiant déjà existant</div>";
            }
            break;
        case 'del':
            if ($Xid) {

                $res = CallDeleteUser($Xid);
                if ($res) {
                    echo "<div class='tempmodal vert'>Vos données ont été effacées</div>";
                    CallInsertJournal($IDUSER, 128, $LOGIN . " a effacé Utilisateur '" . $Xpseudo . "' (" . $Xgrade . '/' . $Xstatut . ')');
                } else {
                    echo "<div class='tempmodal vert'>Impossible Utilisateur actif</div>";
                }
            }
            break;
    }
}

//----Chargement DATA
$list = CallGetAllUser();
$Rstatut = ["<span style='color:red'>INA</span>", "<span style='color:lightgreen'>ACT</span>"];
$Rstatutclair = ['Inactif', 'Actif'];
$Rgrade  = [1 => 'USER', 2 => 'MECA', 64 => 'CHEF', 128 => 'ADMN'];
$Rgradeclair  = [1 => 'USER : utilisateur', 2 => 'MECA : mécanicien', 64 => 'CHEF : chef de service', 128 => 'ADMN : administrateur'];

echo "<div class='titrepage'>Utilisateurs de l'application</div>";
echo "<div class='explainpage'>Savoir les droits de chacun</div>";
echo "<div class='container'>";
echo "<div class='cotegauche'>";
echo "<table id='hpstab' class='listeelements center'>";
echo '<thead><tr>';
echo "<td style='width:220px'>LOGIN ↓</td>";
echo "<td style='width:280px'>Pseudo</td>";
echo "<td style='width:80px'>Statut</td>";
echo "<td style='width:80px'>Grade</td>";
echo "<td style='width:120px'>D.création</td>";
echo "<td style='width:120px'>D.Connexion</td>";
echo "<td>Courriel</td>";
echo '</tr></thead><tbody>';

foreach ($list as $l) {
    echo "<tr id='" . $l['id_user'] . "'>";
    echo "<td style='color:yellow'>" . $l['login'] . '</td>';
    echo "<td>" . $l['pseudo'] . '</td>';
    echo "<td class='centrer' data-sta='" . $l['statut'] . "' >" . $Rstatut[$l['statut']] . '</td>';
    echo "<td class='centrer' data-gra='" . $l['grade'] . "' >" . $Rgrade[$l['grade']] . '</td>';
    echo "<td class='centrer'>" . $l['datecrea'] . '</td>';
    echo "<td class='centrer'>" . $l['datelast'] . '</td>';
    echo "<td data-ema='" . $l['courriel'] . "'><div style='max-width:400px' class='cuttext'>" . $l['courriel'] . "</div></td>";
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
                <label title="il n'y a pas de casse">Identifiant (login, max 20 caractères)</label>
                <input type='text' id='hp0' name='hp0' maxlength='20' />
                <label title="il n'y a pas de casse">Pseudo (nom d'affichage, max 25 caractères)</label>
                <input type='text' id='hp5' name='hp5' maxlength='25' />
                <label>Mot de passe (12 caractères recommandées)</label>
                <input style='width:72%' type='text' id='hp1' name='hp1' maxlength='20' placeholder='Mot de passe caché & crypté' />
                <input type='button' class='generatemdp' value='Générer Mdp' onclick='gmdp()' />
                <label>Statut du compte</label>
                <select type='text' id='hp2' name='hp2'>
                    <?php
                    foreach ($Rstatutclair as $k => $l) {
                        echo "<option value='" . $k . "' >" . $l . '</option>';
                    }
                    ?>
                </select>
                <label>Grade / Rôle</label>
                <select type='text' id='hp3' name='hp3'>
                    <?php
                    foreach ($Rgradeclair as $k => $l) {
                        echo "<option value='" . $k . "' >" . $l . '</option>';
                    }
                    ?>
                </select>
                <label>Courriel / Email</label>
                <input type='text' id='hp4' name='hp4' maxlength='60' />
                <div class='boutons'>
                    <button tabindex='3' class='bouta' name='submit' value='del'>Retirer</button>
                    <button tabindex='1' class='boutb' name='submit' value='upd'>Sauver modification</button>
                    <button tabindex='2' class='boutc' name='submit' value='add'>Ajouter</button>
                    <input tabindex='0' class='boutd' type='reset' id='su' value='Annuler sélection' />
                </div>
            </fieldset>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="scripts/utilisateurs.js"></script>