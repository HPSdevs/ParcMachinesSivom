<?php
if (!defined("hpsstart")) {
    header('Location: ../index.php');
} elseif (isset($_SESSION["hpsuser"])) {
    $defaut = true;
    $GRADE  =  $_SESSION["hpsuser"]["grade"];
    $IDUSER =  $_SESSION["hpsuser"]["id_user"];
    $LOGIN  =  $_SESSION["hpsuser"]["login"];
    $PSEUDO =  $_SESSION["hpsuser"]["pseudo"];
    //  $parsed_url = parse_url($_SERVER['REQUEST_URI']);
    //  $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';
    $clean_url = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES);
    $query = parse_url($clean_url, PHP_URL_QUERY) ?? "";
    $URLACTION = explode("/", $query);
    $URLSEARCH = explode("=", $query);
    //------------------------------------ROUTINE MAINTENANCE
    require_once("./controllers/ctrl_maintenance.php");
    $ETATSITE = GetSiteStatut();
    if ($GRADE < 128 && !$ETATSITE) {
        session_destroy();
        echo "<link href='assets/styles/login.css' rel='stylesheet' type='text/css' /><div class='connexion'><div class='encart'><div class='titre'><h4>$NAMEAPP</h4><h3>©2024 <a href='https://github.com/HPSdevs'>$COPYRIGHT</a></h3><h2>Version $VERSION</h2></div><div style='height:202px; padding-top:50px'><p style='font-size:24px;text-align:center;text-wrap: balance'>Veuillez nous excuser, mais le site est actuellement et momentanément en maintenance.</p></div></div></div>";
        exit;
    } else {
        CallDoMaintenance();
    }
    //------------------------------------ROUTER(LOL)
    // ATTENTION ici c'est le grade MINI pour acces (travaille pas en BITS)
    //  128 = Admin     64 = ChefMeca     2= meca    1= user
    $routes = [
        ["params", 64, "menu-params"],
        ["gestparc", 64, "menu-parc"],
        ["inters", 2, "page-listeinterventions"],
        ["type", 64, "page-typemachines"],
        ["marques", 64, "page-marquemachines"],
        ["modele", 64, "page-modelemachines"],
        ["action", 64, "page-action"],
        ["typeinter", 64, "page-typeintervention"],
        ["energie", 64, "page-energiemachines"],
        ["journal", 128, "page-journal"],
        ["addmachine", 64, "page-addmachine"],
        ["addinter", 1, "page-addintervention"],
        ["utilisateurs", 128, "page-utilisateurs"],
        ["voirparc", 1, "page-voirparc"],
        ["voirmachine", 1, "page-voirmachine"],
        ["voirinter", 1, "page-voirintervention"],
        ["voirdocs", 1, "page-voirdocuments"],
        ["editmachine", 2, "page-editmachine"],
        ["backup", 128, "sousmenu-backupb2d"],
        ["siteonoff", 128, "sousmenu-siteonoff"]
    ];
    if ($URLACTION[0] == "offline") {   // deconnexion
        $THEME = 0;
        session_unset();
        session_destroy();
        header('Location: index.php');
    }
    foreach ($routes as $r) {        // Fonction normal du menu
        if ($URLACTION[0] == $r[0] && ($GRADE >= $r[1])) {
            if (isset($URLACTION[1])) {
                $dump = strip_tags(trim($URLACTION[1]));
                $URLACTION[1] = str_replace(array("'", '"', "`", "%", "*", "!", "&", "_", "/", "\\"), "", $dump);
            }
            include("components/header.php");
            include("views/" . $r[2] . ".php");
            $defaut = false;
        }
    }
    if ($URLSEARCH[0] === "search") {  // pour Search apres un petit nettoyage
        if (isset($URLSEARCH[1])) {
            $a = $URLSEARCH[1];
            $a = str_replace(array("'", '"', "`", "*", "!", "amp;", "&", "_", "/", "\\"), "", substr(urldecode(trim($a)), 0, 45));
            $a = preg_replace('/\s+/', ' ', $a); // kick multiple space
            $a = preg_replace('/[^a-zA-Z0-9\s]/', '', $a); // kick all no alphanumerique
            $URLSEARCH[1] = $a;
            //if (strlen($URLSEARCH[1]) > 1) {
            include("components/header.php");
            include("views/chercher.php");
            $defaut = false;
            //}
        }
    }
    if ($defaut) {
        echo "<meta http-equiv='refresh' content=\"180; url='index.php'\">";
        include("components/header.php");
        include("views/menu.php");
    }
    //------------------------------------END OF PROGRAM
} else {
    include("views/login.php");
}
include("components/domfooter.php");
