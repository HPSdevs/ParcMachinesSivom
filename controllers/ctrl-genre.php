<?php

function CallGetGenreMachines()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM genremachine WHERE statut = 1 ORDER BY designation DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetallGenreMachines()
{
  require("components\mysql.php");
  $sql = "SELECT * FROM genremachine ORDER BY designation DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
