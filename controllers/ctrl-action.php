<?php

function CallGetAction()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM action WHERE statut = 1 ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetAllAction()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM action ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallUpdateAction($designation, $statut, $id)
{
  require("components\mysql.php");
  $sql = "UPDATE action SET statut= ?, designation = ? WHERE id_action = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$statut, $designation, $id]);
  return;
}
function CallDeleteAction($id)
{
  require("components\mysql.php");
  $sql = "SELECT COUNT(idx_action) as nb FROM prestation WHERE idx_action = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  if ($data['nb'] == 0) {
    $sql = "DELETE FROM action WHERE id_action = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return true;
  }
  return false;
}
function CallInsertAction($designation, $statut)
{
  require("components\mysql.php");
  $sql = "INSERT INTO action (statut,designation) VALUES (?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$statut, $designation]);
  return;
}
