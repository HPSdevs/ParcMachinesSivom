<?php

function CallGetActivites( $datestart, $dateend ) {
    require( 'components/mysql.php' );
    $sql = "SELECT CONCAT(MONTH(quand),DAY(quand)) as quand, COUNT(id_prestation) as cmpt FROM prestation  WHERE quand BETWEEN '$datestart' AND '$dateend' GROUP BY quand;";
    $stmt = $pdo->prepare( $sql );
    $stmt->execute();
    $datx = $stmt->fetchall();
    $data = array_column( $datx, 'cmpt', 'quand' );
    return $data;
}

function CallPrestation( $idintervention ) {
    require( 'components/mysql.php' );
    $sql = 'SELECT id_prestation, idx_mecanicien, utilisateur.login, idx_action,designation, quand, duree,objet,quantite, (prix/100) as prix,(total/100) as total FROM prestation 
            JOIN action ON idx_action = id_action
            LEFT JOIN utilisateur ON idx_mecanicien = id_user
            WHERE idx_intervention = ? ORDER BY quand';
    $stmt = $pdo->prepare( $sql );
    $stmt->execute( [ $idintervention ] );
    $data = $stmt->fetchAll();
    return $data;
}

function CallUpdatePrestation( $idx_action, $quand, $duree, $objet, $quantite, $prix, $idpresta ) {
    require( 'components/mysql.php' );
    $prix  = intval( $prix * 100 );
    $total = ( $prix && $quantite ) ? intval( $prix ) * intval( $quantite ) : 0;
    $sql  = 'UPDATE prestation SET idx_action = ?, quand = ?, duree = ?, objet= ?, quantite = ?, prix= ?, total = ? WHERE id_prestation = ?';
    $stmt = $pdo->prepare( $sql );
    $stmt->execute( [ $idx_action, $quand, $duree, $objet, $quantite, $prix, $total, $idpresta ] );
    return;
}

function CalDeletePrestation( $idpresta ) {
    require( 'components/mysql.php' );
    $sql  = 'DELETE FROM prestation WHERE id_prestation = ?';
    $stmt = $pdo->prepare( $sql );
    $stmt->execute( [ $idpresta ] );
    return;
}

function CallInsertPrestation( $idx_intervention, $idx_mecanicien, $idx_action, $quand, $duree, $objet, $quantite, $prix ) {
    require( 'components/mysql.php' );
    $prix  = intval( $prix ) * 100;
    $total = ( $prix && $quantite ) ? intval( $prix ) * intval( $quantite ) : 0;
    $sql   = 'INSERT INTO prestation (idx_intervention, idx_mecanicien, idx_action,quand, duree , objet, quantite, prix, total) VALUES (?,?,?,?,?,?,?,?,?)';
    $stmt  = $pdo->prepare( $sql );
    $stmt->execute( [ $idx_intervention, $idx_mecanicien, $idx_action,  $quand, $duree, $objet, $quantite, $prix, $total ] );
    return;
}
