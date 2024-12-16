<?php

function CallDesignationTypeMachines($idtype)
{
  require("components\mysql.php");
  $sql = "SELECT designation FROM typemachine WHERE id_typemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idtype]);
  $data = $stmt->fetch();
  $dump = $data["designation"] ?? "";
  return $dump;
}
function CallGetTypeMachines($genre)
{
  require("components\mysql.php");
  $sql = "SELECT * FROM typemachine WHERE statut = 1 AND genre & ? ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetAllTypeMachines()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM typemachine ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallUpdateTypeMachine($designation, $genre, $statut, $id)
{
  require("components\mysql.php");
  $sql = "UPDATE typemachine SET genre = ?, statut= ?, designation = ? WHERE id_typemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation, $id]);
  return;
}
function CallDeleteTypeMachine($id)
{
  require("components\mysql.php");
  $sql = "SELECT COUNT(idx_type) as nb FROM machine WHERE idx_type = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql = "DELETE FROM typemachine WHERE id_typemachine = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return true;
  }
  return false;
}

function CallInsertTypeMachine($designation, $genre, $statut)
{
  require("components\mysql.php");
  $sql = "INSERT INTO typemachine (genre,statut,designation) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation]);
  return;
}
