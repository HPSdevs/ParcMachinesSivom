<?php
include_once( './controllers/ctrl-prestation.php' );
$color = [ '#303030c0', '#671926c0', '#722f0ec0', '#bca268c0', '#172e69c0', '#007580c0' ];
$joursdesmois = [ 0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
$desigdesmois = [ '', 'JAN', 'FEV', 'MAR', 'AVR', 'MAI', 'JUN', 'JUI', 'AOU', 'SEP', 'OCT', 'NOV', 'DEC' ];
echo "<fieldset class='statut'><legend>ACTIVITÉS PRESTATIONS</legend>";
$now = getdate();
$mois  = $now[ 'mon' ];
$annee = $now[ 'year' ];
$jour = $now[ 'mday' ];
// bissextile
if ( ( $mois === 1 ) && ( ( ( $annee-1 ) % 4 === 0 && ( $annee-1 ) % 100 > 0 ) || ( ( $annee-1 ) % 400 === 0 ) ) ) {
    $joursdesmois[ 2 ] += 1;
} elseif ( ( ( $annee % 4 === 0 ) && ( $annee % 100 > 0 ) ) || ( $annee % 400 === 0 ) ) {
    $joursdesmois[ 2 ] += 1;
}
// date debut - date fin
$refdate = new DateTime( "$annee-$mois-1" );
$interval = new DateInterval( 'P11M' );
$startdate = $refdate->sub( $interval );
$startjour = $startdate->format( 'N' );
$startannee = $startdate->format( 'Y' );
$data = CallGetActivites( $startdate->format( 'Y-m-d' ), date( 'Y-m-d', $now[ 0 ] ) );

echo "<div class='actglo'><div class='actgfx'>";
echo "<div class='actlegj'>Lundi<br>Mardi<br>Mercredi<br>Jeudi<br>Vendredi<br>Samedi<br>Dimanche&nbsp;&nbsp;</div>";
echo "<div class='actlegm'>";
for ( $m = -11; $m <= 0; $m++ ) {
    $mc = ( $mois + $m )%13 ;
    $mc =  $mc<1 ? $mc = 12+$mc : $mc;
    echo "<div class='actlegmn'>".$desigdesmois[ $mc ].'</div>';
}
echo '</div>';
echo "<div class='actmois'>";
$start = true;
for ( $m = -11; $m <= 0; $m++ ) {
    $mc = ( $mois + $m )%13 ;
    $mc =  $mc<1 ? $mc = 12+$mc : $mc;
    if ( $start ) {
        for ( $j = 1; $j<$startjour; $j += 1 ) {
            echo  "<div class='actday rien'></div>";
        }
        $start = false;
    }
    for ( $j = 1; $j <= $joursdesmois[ $mc ] ; $j++ ) {
        $ref = $REFACTIVITES<2 ? 1 : $REFACTIVITES;
        $vd = $data[ $mc*100+$j ] ?? 0 ;
        $vc = round( $vd / $ref *3 ) ;
        $vc = $vc > 5 ? 5 : $vc ;
        $c  = $color[ $vc ];
        if ( $mc == $mois && $j>$jour ) {
            echo "<div class='actday out'></div>";
        } else {
            //  onclick = 'location.href=\"?show-$j/$mc\"'
            $s = $vd>1 ? 's' : '';
            echo "<div class='actday' title='$vd Prestation$s'>";
            echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='$c'/></svg>";
            echo '</div>';
        }
    }
}
echo '</div>';
echo '</div>';
echo '</div>';
echo "<div class='actlegende'>moins ";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 0 ]."'/></svg>";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 1 ]."'/></svg>";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 2 ]."'/></svg>";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 3 ]."'/></svg>";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 4 ]."'/></svg>";
echo "<svg width='13' height='13' xmlns='http://www.w3.org/2000/svg'><rect width='11' height='11' x='1' y='1' rx='2' ry='2' fill='".$color[ 5 ]."'/></svg>";
echo ' plus</div>';

echo '</fieldset>';
?>