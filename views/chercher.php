<?php
if (!defined("hpsstart")) {
    header('Location: ../index.php');
}   // check start app
require("controllers/ctrl-machine.php");
if (isset($URLSEARCH[1])) {
    $search = $URLSEARCH[1];
}
$matos = null;
if ($search) {
    $ima = verifImmatriculation($search);
    if ($ima) {
        $matos = SearchIMAT($ima);
    } else {
        $matos = SearchIMAT($search);
    }
}
if (!$matos) {
    $matos = SearchDES($search);
}

//-----Page
echo "<div class='titrepage'>Résultats de la recherche</div>";
echo "<div class='explainpage'>&nbsp;</div>";
echo "<div class='container'>";
echo "<div class='colonne'>";

if ($matos) {
    echo "<table id='hpstab' class='listeelements center'>";
    echo "<thead><tr><td colspan='4'>Désignation ↓</td><td class='centrer'>Immat/N°série</td class='centrer'><td  class='centrer'>Puiss.fiscale</td><td  class='centrer'>Puissance W</td><td class='centrer'>Mise en service</td><td class='centrer'>Prochain Contrôle</td><td>Observations</td><td>Actif</td></tr></thead><tbody>";
    foreach ($matos as $m) {
        $pw  = $m['puissance'] / 100000;
        $cv = round(pow(1.8 * $pw, 2) + 3.87 * $pw + 1.34);
        $icon = $m["idgenre"] & 1 ? "<img src='./assets/icons/car.svg' title='Véhicule'>" : "";
        $icon = $m["idgenre"] & 2 ? "<img src='./assets/icons/tool.svg' title='Outil'>" : $icon;
        echo "<tr id='" . $m['id_machine'] . "' height='50px'>";
        echo "<td width='30px'>" . $icon . "</td>";
        $a =  $m['idmodele'] > 1 ? " <small>" . $m['modele'] : "</small>";
        echo "<td>" . $m['marque'] . $a . "</td>";
        echo "<td width='220px'>" . $m['type'] . "</td>";
        echo "<td width='180px'>" . $m['energie'] . "</td>";
        echo "<td width='130px' class='centrer'>" . $m['imat'] . "</td>";
        echo "<td width='120px' class='centrer'>" . $cv . "</td>";
        echo "<td width='120px' class='centrer'>" . $m['puissance'] . "w </td>";
        echo "<td width='155px' class='centrer'>" . frenchdate($m['date_premservice']) . "</td>";
        echo "<td width='155px' class='centrer'>" . frenchdate($m['date_procvsttech']) . "</td>";
        echo "<td width='400px' ><div style='width:400px;' class='cuttext'>" . $m['observation'] . "</div></td>";
        echo "<td width='30px'  class='centrer'>" . statut($m['actif']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</div></div>";
} else {
    echo "<div style='width:100%;height:500px;display:flex;justify-content: center;align-items: center;'>Aucun résultat trouvé.</div>";
}
?>
<script>
    var hps = document.getElementById("hpstab");
    hps.addEventListener("click", function(e) {
        event = e.target;
        index = event.parentElement.rowIndex;
        if (hps.rows[index]) {
            id = hps.rows[index].id;
            if (id) {
                window.location.href = "?voirmachine/" + id;
            }
        }
    }, false);
</script>