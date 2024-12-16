<?php

function CallDesignationMarqueMachines($idmarque)
{
  require("components\mysql.php");
  $sql = "SELECT designation FROM marquemachine WHERE id_marquemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmarque]);
  $data = $stmt->fetch();
  $dump = $data["designation"] ?? "";
  return $dump;
}
function CallGetMarqueMachines($genre)
{
  require("components\mysql.php");
  $sql = "SELECT * FROM marquemachine WHERE statut = 1 AND genre & ? ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetAllMarqueMachines()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM marquemachine ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallUpdateMarqueMachine($designation, $genre, $statut, $id)
{
  require("components\mysql.php");
  $sql = "UPDATE marquemachine SET genre = ?, statut= ?, designation = ? WHERE id_marquemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation, $id]);
  return;
}
function CallDeleteMarqueMachine($id)
{
  require("components\mysql.php");
  $sql = "SELECT COUNT(idx_marque) as nb FROM machine WHERE idx_marque = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql = "SELECT COUNT(idx_marque) as nb FROM modelemachine WHERE idx_marque = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    if ($data['nb'] == 0) {
      $sql = "DELETE FROM marquemachine WHERE id_marquemachine = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$id]);
      return true;
    }
  }
  return false;
}
function CallInsertMarqueMachine($designation, $genre, $statut)
{
  require("components\mysql.php");
  $sql = "INSERT INTO marquemachine (genre,statut,designation) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation]);
  return;
}
