<?php
// ParcSivom ©HPSdevs@gmail.com
// Projet de Stage pour Titre Pro DWWM du 26/08 au 06/11/2024
$NAMEAPP   = 'ParcMachinesSIVOM';
$COPYRIGHT = 'HANNOT Philippe';
$VERSION   = '1.2 (revision 2)';
setlocale( LC_TIME, 'fr_FR' );
ini_set( 'display_errors', 'on' );
include( 'components/functions.php' );
include( 'components/functions-email.php' );
require_once( './controllers/ctrl-utilisateur.php' );
session_set_cookie_params(0, '/', '', true, true);
session_start();
define( 'hpsstart', 'HPS' . date( 'diHY' ) );
$CHECK     = password_hash( hpsstart, PASSWORD_DEFAULT );
$THEME     = 0;
$APPDIR    = __DIR__;
$UPLOADMAX = 3000000;
// octets
$UPLOADDIR = 'Documents/';
$UPLOADFOK = array( 'pdf', 'txt', 'jpeg', 'jpg', 'png', 'gif', 'webp' );
// ACTIVITIES SERVICES CHART
// ( must be greater than 1 ) correspond to an average activity per day
$REFACTIVITES = 4 ;
//--------------------------------
if ( isset( $_SESSION[ 'hpsuser' ] ) ) {
    if ( isset( $_GET[ 'theme' ] ) ) {
        $THEME = abs( intval( $_GET[ 'theme' ] ) ) > 0 ? 1 : $THEME;
        $_SESSION[ 'hpsuser' ][ 'theme' ] = $THEME;
        CallUpdateTheme( $THEME, $_SESSION[ 'hpsuser' ][ 'id_user' ] );
        echo '<script>history.back();</script>';
        exit;
    } else {
        $THEME = $_SESSION[ 'hpsuser' ][ 'theme' ];
    }
}
include( 'components/domhead.php' );
include( 'components/routeur.php' );
