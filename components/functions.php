<?php
function Cryptage($code)
{
    $Xcode = password_hash($code, PASSWORD_BCRYPT);
    return $Xcode;
}
function verifImmatriculation($ima)
{
    $p = '#^([0-9]+|[a-z]+)(?:\s|-)?([a-z]+|[0-9]+)(?:\s|-)?([a-z]+|[0-9]+)$#i';
    if (preg_match('#^(?(?!ss|ww)[a-hj-np-tv-z]{2})(?:\s|-)?[0-9]{3}(?:\s|-)?(?(?!ss)[a-hj-np-tv-z]{2})$#i', $ima)) {
        $pro = strtoupper(preg_replace($p, '$1-$2-$3', $ima));
        return $pro;
    } elseif (preg_match('#^[0-9]{1,4}(?:\s|-)?[a-hj-np-tv-z]{2,3}(?:\s|-)?(?:97[1-6]|0[1-9]|[1-8][0-9]|9[1-5]|2[ab])$#i', $ima)) {
        $pro = strtoupper(preg_replace($p, '$1 $2 $3', $ima));

        return $pro;
    } else {
        return $ima;
    }
}
function statut($x)
{

    return $x ? "<img src='./assets/icons/true.svg'>" : "<img src='./assets/icons/false.svg'>";
}
function frenchdate($xdate)
{
    if ($xdate) {
        $date = new DateTimeImmutable($xdate);
        return $date->format('d/m/Y');
    } else {
        return "";
    }
}
function frenchtime($xtime)
{
    $date = new DateTimeImmutable($xtime);
    return $date->format('d/m/Y H:i:s');
}
function gadgettime($xtime)
{
    $date = new DateTimeImmutable($xtime);
    return $date->format('Y-m-d');
}
function enTemps($minutes)
{
    $jours = floor($minutes / 1440);
    $heures = floor(($minutes - $jours * 1440) / 60);
    $minutes = $minutes % 60;
    $a = $jours ? sprintf("%dJ%02d:%02d", $jours, $heures, $minutes) : sprintf("%02d:%02d", $heures, $minutes);
    return $a;
}
function enArgent($cout)
{
    return sprintf("%.02f€", $cout);
}
function enKm($kilometres)
{
    $a = $kilometres ? sprintf("%06dKm", $kilometres) : "non relevé";
    return $a;
}
function tempspasse($date)
{
    $day = new Datetime($date);
    $now    = new Datetime();
    $diff = $now->diff($day);
    $m =  $diff->format('%m');
    $a =  $diff->format('%y');
    $b = $a > 1 ? " ans" : " an";
    $b = $m > 0 ? "+" . $a . $b : $a . $b;
    return $a >= 1  ? $b : ($m >= 1 ? $m . " mois" : "<1 mois");
}
function numero($numero, $length = 6)
{
    $long = strlen($numero);
    $zero = str_repeat('0', $long < $length ? $length - $long : 0);
    return "<span class='hpsnumero'>$zero</span>" . $numero;
}



?>