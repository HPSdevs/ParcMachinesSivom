<?php
if (!defined ( "hpsstart" )) {header('Location: ../index.php');}   // check start app
if (!($GRADE & 192)) { header('Location: ../index.php');}          // check droits

// echo "grade:".$grade." &192:".($grade&192)." &128:".($grade&128)." !&128:".!($grade&128);
?>
<div class="titrepage">Gestion du parc</div>
<div class='explainpage'>Ajout/Modification/Suppression des machines</div>
<main class="menugeneral">
    <a href="?voirparc"><div>Voir le parc</div></a>
    <a href="?addmachine"><div>Ajouter Véhicule/Machine</div></a>
    <a href="?menu"><div class="retour">Retour menu principal</div></a>
</main>