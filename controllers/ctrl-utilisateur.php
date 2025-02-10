<?php

function CallCheckLogin(string $login)
{
    require('components/mysql.php');
    $sql = 'SELECT * FROM utilisateur WHERE LOWER(login) = LOWER(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login]);
    $data = $stmt->fetch();
    return $data;
}
function CallGetUserEmail(int $iduser)
{
    require('components/mysql.php');
    $sql = 'SELECT courriel FROM utilisateur WHERE id_user= ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$iduser]);
    $data = $stmt->fetch();
    return $data['courriel'];
}
function CallGetUserChefMeca()
{
    require('components/mysql.php');
    $sql = 'SELECT courriel FROM utilisateur WHERE grade= 64';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchall();
    return $data;
}
function CallCheckExistLogin(string $login)
{
    require('components/mysql.php');
    $sql = 'SELECT id_user FROM utilisateur WHERE LOWER(login) = LOWER(?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login]);
    $data = $stmt->fetch();
    return $data;
}

function CallCheckExistLoginExceptMe(string $login, int $iduser)
{
    require('components/mysql.php');
    $sql = 'SELECT id_user FROM utilisateur WHERE (LOWER(login) = LOWER(?)) AND (id_user != ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login, $iduser]);
    $data = $stmt->fetch();
    return $data;
}

function CallUpdateLastLog(int $id_user)
{
    require('components/mysql.php');
    $sql = 'UPDATE utilisateur SET date_lastlog = now() WHERE id_user = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    return;
}

function CallUpdateTheme(int $theme, int $id_user)
{
    require('components/mysql.php');
    $sql = 'UPDATE utilisateur SET theme = ? WHERE id_user = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$theme, $id_user]);
    return;
}
function CallGetAllMeca()
{
    require("components/mysql.php");
    $sql = "SELECT * FROM utilisateur WHERE grade = 2";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchall();
    return $data;
}
function CallGetAllUser()
{
    require('components/mysql.php');
    $sql = "SELECT *, DATE_FORMAT(date_creation, '%d/%m/%Y') as datecrea, DATE_FORMAT(date_lastlog, '%d/%m %H:%i') as datelast FROM utilisateur WHERE id_user>1 ORDER BY login ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return $data;
}

function CallUpdateUser(int $statut, int $grade, string $login, string $pseudo, string $courriel, int $id_user)
{
    require('components/mysql.php');
    $sql = 'UPDATE utilisateur SET statut = ?, grade = ?, login = ?, pseudo = ?, courriel = ? WHERE id_user = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$statut, $grade, $login, $pseudo, $courriel, $id_user]);
    return;
}

function CallUpdatePWDUser(string $password, int $id_user)
{
    require('components/mysql.php');
    $sql = 'UPDATE utilisateur SET password = ? WHERE id_user = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$password, $id_user]);
    return;
}

function CallInsertUser(int $statut, int $grade, string $login, string $pseudo, string $password, string $courriel)
{
    require('components/mysql.php');
    $sql = 'INSERT INTO utilisateur (statut,grade,login,pseudo,password,courriel) VALUES (?,?,?,?,?,?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$statut, $grade, $login, $pseudo, $password, $courriel]);
    return;
}

function CallDeleteUser(int $id_user)
{
    require('components/mysql.php');
    $total = 0;
    // verification si possibilité d'effacement du user.
    $sql = "SELECT COUNT(idx_demandeur) as nb FROM intervention WHERE idx_demandeur = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    $data = $stmt->fetch();
    $total += $data['nb'];
    $sql = "SELECT COUNT(idx_mecanicien) as nb FROM intervention WHERE idx_mecanicien = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    $data = $stmt->fetch();
    $total += $data['nb'];
    $sql = "SELECT COUNT(idx_mecanicien) as nb FROM prestation WHERE idx_mecanicien = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_user]);
    $data = $stmt->fetch();
    $total += $data['nb'];
    //----
    if ($total === 0) {

        $sql = 'DELETE FROM utilisateur WHERE id_user = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_user]);
        return true;
    } else {
        return false;
    }
}
