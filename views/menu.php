	<?php
    if (!defined("hpsstart")) {
        header('Location: ../index.php');
    }   // check start app
    ?>
	<div class="titrepage">Menu principal</div>
	<div class='explainpage'>Votre tableau de bord</div>
	<div class='container'>
	    <div class='cotegauche moitie'>
	        <div class="menugeneral">
	            <?php
                //  Attention ce menu marche en binaire, il faut combiner les bits pour les affichages
                //  128=Admin  64=ChefMeca  32=futur  16=futur  8=futur  4=futur  2=meca  1=user
                $blockmenu = [
                    // niveau  | on/off  |  affmin
                    [195, 1,  1, "?voirparc", "Le Parc"],
                    [194, 1, 2, "?inters", "Demandes et<br/>Interventions"],
                    [192, 1, 64, "?gestparc", "Gestion du Parc"],
                    [256, 0, 64, "?gestentr", "gestion des entretiens"],
                    [256, 0, 64, "?gestassu", "Gestion des assurances"],
                    [256, 0, 64, "?gestaffe", "Gestion des affectations"],
                    [128, 1, 128, "?utilisateurs", "Gestion des utilisateurs"],
                    [128, 1, 128, "?journal", "Journal d'évènements"],
                    [192, 1, 64, "?params", "Paramètres"],
                ];
                $i = 0;
                do {
                    $m = $blockmenu[$i];
                    if ($m[1]) {
                        if ($GRADE >= $m[2]) {
                            if ($m[0] & $GRADE) {
                                echo "<a href='" . $m[3] . "'><div>" . $m[4] . "</div></a>";
                            } else {
                                echo "<div class='disable'>" . $m[4] . "</div>";
                            }
                        } else {
                            echo "<div class='disable'></div>";
                        }
                    } else {
                        echo "<div class='disable'></div>";
                    }
                    $i++;
                } while ($i < 9);
                echo "</div><small class='center' style='opacity:.25'><br>' $NAMEAPP ' copyright $COPYRIGHT, version $VERSION</small>";
                echo "</div>";
                /*--cote droit--*/
                echo "<div class='cotedroit moitie'>";
                echo "<fieldset class='statut'><legend>LES INTERVENTIONS EN COURS</legend>";
                include('./components/menu-interencours.php');
                echo "</fieldset>";
                echo "<fieldset class='statut'><legend>LES INTERVENTIONS CLOTURÉES</legend>";
                include('./components/menu-interfinies.php');
                echo "</fieldset>";
                if ($GRADE>64) include('./components/menu-activite.php');
                echo "</div>";
                ?>