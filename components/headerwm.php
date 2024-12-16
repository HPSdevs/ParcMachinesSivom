<?php
if (!defined("hpsstart")) {
    header('Location: ../index.php');
}
?>
<link href="assets/styles/main1.css" rel="stylesheet" type="text/css" />
<link href="assets/styles/main2.css" rel="stylesheet" type="text/css" />
<link href="assets/styles/main3.css" rel="stylesheet" type="text/css" />
<link href="assets/styles/main4.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="hpsmodal" id="hpsmodal">Document<span class="close" onclick="document.getElementById('hpsmodal').style.display='none'"><img src="./assets/icons/close.svg"></span><iframe id='hpsframe'></iframe></div>
    <script>
        dragElement(document.getElementById("hpsmodal"));

        function dragElement(elmnt) {
            var pos1 = 0,
                pos2 = 0,
                pos3 = 0,
                pos4 = 0;
            if (document.getElementById(elmnt.id)) {
                // if present, the header is where you move the DIV from:
                document.getElementById(elmnt.id).onmousedown = dragMouseDown;
            } else {
                // otherwise, move the DIV from anywhere inside the DIV:
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                // stop moving when mouse button is released:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    </script>
    <header>
        <div class=" name" title="Utilisateur connecté"><img src="./assets/icons/grade<?php echo $_SESSION["hpsuser"]["grade"] ?>.svg" /><?php echo $PSEUDO ?></div>
        <div class="search">
            <form method='GET' action='?search'>
                <?php
                $a = "";
                if (isset($URLSEARCH[1])) {
                    $a = "value='" . $URLSEARCH[1] . "'";
                }
                echo "<input maxlength='35' type='text' name='search' placeholder='Immatriculation, n° de série…' required='required' $a title='Barre de recherche (2 caractères minimum, sans casse)'>";
                ?>
                <img src="assets/icons/search.svg" />
            </form>
        </div>
        <div class="action">
            <div class="menu" title="Menu principal"><button onclick="location.href='index.php?menu'">Menu principal</button></div>
            <div class="theme" title="Thème du site"><button onclick="location.href='index.php?theme=<?php echo 1 - $THEME ?>'"><img src="assets/icons/theme.svg" /></button></div>
            <div class="disco" title="Déconnexion"><button onclick="location.href='index.php?offline'"><img src="assets/icons/onoff.svg" /></button></div>
        </div>
    </header>