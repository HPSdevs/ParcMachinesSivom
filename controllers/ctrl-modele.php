<?php

function CallDesignationModeleMachines($idmodele)
{
  require("components/mysql.php");
  $sql = "SELECT designation FROM modelemachine WHERE id_modelemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmodele]);
  $data = $stmt->fetch();
  $dump = $data["designation"] ?? "";
  return $dump;
}
function CallGetModeleMachines($marque)
{
  require("components/mysql.php");
  $sql = "SELECT * FROM modelemachine WHERE statut = 1 AND idx_marque = 0 or idx_marque = ? ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$marque]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetAllModeleMachines()
{
  require("components/mysql.php");
  $sql = "SELECT * FROM modelemachine ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallUpdateModeleMachine($designation, $marque, $statut, $id)
{
  require("components/mysql.php");
  $sql = "UPDATE modelemachine SET idx_marque = ?, statut= ?, designation = ? WHERE idx_marque > 0 AND id_modelemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$marque, $statut, $designation, $id]);
  return;
}
function CallDeleteModeleMachine($id)
{
  require("components/mysql.php");
  $sql = "SELECT COUNT(idx_modele) as nb FROM machine WHERE idx_marque > 0 AND idx_modele = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql = "DELETE FROM modelemachine WHERE idx_marque > 0 AND id_modelemachine = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return true;
  }
  return false;
}

function CallInsertModeleMachine($designation, $marque, $statut)
{
  require("components/mysql.php");
  $sql = "INSERT INTO modelemachine (idx_marque,statut,designation) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$marque, $statut, $designation]);
  return;
}
