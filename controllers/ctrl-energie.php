<?php


function CallDesignationEnergieMachines($idnrj)
{
  require("components/mysql.php");
  $sql = "SELECT designation FROM energiemachine WHERE id_energiemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idnrj]);
  $data = $stmt->fetch();
  $dump = $data["designation"] ?? "";
  return $dump;
}

function CallGetEnergieMachines($genre)
{
  require("components/mysql.php");
  $sql = "SELECT * FROM energiemachine WHERE statut = 1 AND genre & ? ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetAllEnergieMachines()
{
  require("components/mysql.php");
  $sql = "SELECT * FROM energiemachine ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallUpdateEnergieMachine($designation, $genre, $statut, $id)
{
  require("components/mysql.php");
  $sql = "UPDATE energiemachine SET genre = ?, statut= ?, designation = ? WHERE id_energiemachine = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation, $id]);
  return;
}
function CallDeleteEnergieMachine($id)
{
  require("components/mysql.php");
  $sql = "SELECT COUNT(idx_energie) as nb FROM machine WHERE idx_energie = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql = "DELETE FROM energiemachine WHERE id_energiemachine = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return true;
  }
  return false;
}
function CallInsertEnergieMachine($designation, $genre, $statut)
{
  require("components/mysql.php");
  $sql = "INSERT INTO energiemachine (genre,statut,designation) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $statut, $designation]);
  return;
}
