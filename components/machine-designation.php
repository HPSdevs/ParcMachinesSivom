<?php
    // Partie commune de mise en place de la partie "designation" interne d'une machine (pour simplifier la recherche)
    // fonctionne pour Add Machine et Edit Machine
    $txtmar = CallDesignationMarqueMachines($mar);
    $txtmod = CallDesignationModeleMachines($mod);
    $txttyp = CallDesignationTypeMachines($typ);
    $txtnrj = CallDesignationEnergieMachines($nrj);

if ($gen==1){ // vhl
    $des = $txtmar;
    if ($mod>1)  $des.=" ".$txtmod;
    $des .= " ".$im;
    if ($txttyp) $des.=" ".$txttyp;
    if ($nrj>1)  $des.=" ".$txtnrj;
}else{ // tools
    $des = $txtmar;
    if ($mod>1)  $des.=" ".$txtmod;
    if ($txttyp) $des.=" ".$txttyp;
    if ($nrj>1)  $des.=" ".$txtnrj;
    $des .= " ".$im;
}
?>