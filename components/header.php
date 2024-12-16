<?php
if ( !defined( 'hpsstart' ) ) {
    header( 'Location: ../index.php' );
}
?>
<link href = 'assets/styles/main1.css' rel = 'stylesheet' type = 'text/css' />
<link href = 'assets/styles/main2.css' rel = 'stylesheet' type = 'text/css' />
<link href = 'assets/styles/main3.css' rel = 'stylesheet' type = 'text/css' />
<link href = 'assets/styles/main4.css' rel = 'stylesheet' type = 'text/css' />
</head>
<body>
<header>
<div class = 'name' title = "Pseudo de l'utilisateur connecté"><img src = "./assets/icons/grade<?php echo $GRADE ?>.svg" /><?php echo $PSEUDO ?></div>
<div style = 'font-weight:600' title = "Nom de l'application"><?php echo $NAMEAPP ?></div>
<div class = 'search'>
<form method = 'GET' action = '?search'>
<?php
$a = '';
if ( isset( $URLSEARCH[ 1 ] ) ) {
    $a = "value='" . urldecode( $URLSEARCH[ 1 ] ) . "'";
}
echo "<img class='iconleft' title='CHERCHER' src='assets/icons/search.svg'/>";
echo "<input name='search' maxlength='45' id='search' type='search' placeholder='Immatriculation, Marque, Type, Energie, N°série' $a title='Barre de recherche alphanumérique ( sans symbole, ni signe )'/>";
?>
</form>
</div>
<div class = 'action'>
<?php
if ( !$ETATSITE ) echo "<div class='maintenance blink' title='Le site est à l&#39;
arrêt'>MAINTENANCE</div>&nbsp;";
?>
<div class = 'menu' title = 'Retour vers le menu principal'><button onclick = "location.href='index.php?menu'">Menu principal</button></div>
<div class = 'theme' title = 'Changement de thème du site'><button onclick = "location.href='index.php?theme=<?php echo intval(1 - $THEME) ?>'"><img src = 'assets/icons/theme.svg' /></button></div>
<div class = 'disco' title = "Déconnexion de l'utilisateur"><button onclick = "location.href='index.php?offline'"><img src = 'assets/icons/onoff.svg' /></button></div>
</div>
</header>