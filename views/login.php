<?php
if (!defined("hpsstart")) {
  header('Location: ../index.php');
}
$loginmessage = "";
if (isset($_POST["hpslogin"]) && isset($_POST["hpspass"])) {
  $login = strtolower(strip_tags(trim($_POST["hpslogin"])));
  $pass  = strip_tags(trim($_POST["hpspass"]));
  $veri  = strip_tags(trim($_POST["hpstoken"]));
  $user  = CallCheckLogin($login);
  if ($user && (password_verify($pass, $user["password"])) && password_verify(hpsstart, $veri)) {
    if ($user["statut"] == 1) {
      CallUpdateLastLog($user["id_user"]);
      $_SESSION["hpsuser"] = $user;
      header('Location: index.php');
    } else {
      $loginmessage = "Compte désactivé";
    }
  } else {
    $loginmessage = "Identifiant ou mot de passe inconnus";
  }
}
?>
<link href="./assets/styles/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <form action="index.php" method="post">
    <div class="connexion">
      <div class="encart">
        <div class="titre">
          <h4><?php echo $NAMEAPP ?></h4>
          <h3>©2024 <a href="https://github.com/HPSdevs"><?php echo $COPYRIGHT ?></a></h3>
          <h2>Version <?php echo $VERSION ?></h2>
        </div>
        <div class="information"><?php echo $loginmessage ?></div>
        <input name="hpstoken" type="hidden" value="<?php echo $CHECK ?>" />
        <label for="hpslogin" >Identifiant</label><input id="hpslogin" name="hpslogin" class="login" maxlength="30" type="text" required="required" title="Fonctionne avec ou sans majuscule" />
        <label for="hpspass">Mot de passe</label><input id="hpspass" name="hpspass" class="pass" maxlength="30" type="password" required="required" />
        <div class="tooltip"><img src="./assets/icons/password.svg" class="icon" alt="icon mot de passe"/>
          <div class="texttip">Si vous avez des difficultés de connexion, muni de votre identifiant contactez votre administrateur.</div>
        </div>
        <button>Connexion</button>
      </div>
    </div>
  </form>