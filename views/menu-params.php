<?php
if (!defined("hpsstart")) {
    header('Location: ../index.php');
}   // check start app
if (!($GRADE & 192)) {
    header('Location: ../index.php');
}          // check droits

// echo "grade:".$grade." &192:".($grade&192)." &128:".($grade&128)." !&128:".!($grade&128);
?>
<div class="titrepage">Paramètres</div>
<div class='explainpage'>Personnaliser l’application en fonction de ses besoins et de son utilisation</div>
<main class="menugeneral">
    <a href="?marques">
        <div>Gestion des marques/modèles</div>
    </a>
    <a href="?type">
        <div>Gestion des types</div>
    </a>
    <a href="?energie">
        <div>Gestion des énergies</div>
    </a>
    <a href="?action">
        <div>Gestion des actions</div>
    </a>
    <a href="?typeinter">
        <div>Gestion des types interventions</div>
    </a>
    <a href="?backup">
        <div>Sauvegarder la base de données</div>
    </a>
    <a href="?siteonoff">
        <div>Maintenance du site</div>
    </a>
    <a href="?menu">
        <div class="retour">Menu principal</div>
    </a>
</main>