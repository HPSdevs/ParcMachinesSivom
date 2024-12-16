<?php

function CallGetTypeInter($genre, $role)
{
  require('components\mysql.php');
  $sql  = 'SELECT * FROM typeintervention WHERE statut = 1 AND genre & ? AND role & ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $role]);
  $data = $stmt->fetchAll();
  return $data;
}

function CallGetAllTypeInter()
{
  require('components\mysql.php');
  $sql  = 'SELECT * FROM typeintervention ORDER BY role DESC, designation  ASC';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}

function CallGetDesignInter($idtype)
{
  require('components\mysql.php');
  $sql  = 'SELECT designation FROM typeintervention WHERE id_typeintervention = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idtype]);
  $data = $stmt->fetch();
  $dump = $data["designation"] ?? "";
  return $dump;
}

function CallUpdateTypeInter($designation, $role, $genre, $statut, $id)
{
  require('components\mysql.php');
  $sql  = 'UPDATE typeintervention SET role = ?, genre = ?, statut= ?, designation = ? WHERE id_typeintervention = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$role, $genre, $statut, $designation, $id]);
  return;
}

function CallDeleteTypeInter($id)
{
  require('components\mysql.php');
  $sql  = 'SELECT COUNT(idx_typeintervention) as nb FROM intervention WHERE idx_typeintervention = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql  = 'DELETE FROM typeintervention WHERE id_typeintervention = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return true;
  }
  return false;
}

function CallInsertTypeInter($designation, $role, $genre, $statut)
{
  require('components\mysql.php');
  $sql  = 'INSERT INTO typeintervention (role,genre,statut,designation) VALUES (?,?,?,?)';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$role, $genre, $statut, $designation]);
  return;
}
