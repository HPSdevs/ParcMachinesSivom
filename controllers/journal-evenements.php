<?php

function CallGetAllJournal()
{
  require("components/mysql.php");
  $sql = "SELECT DATE_FORMAT(moment, '%d/%m/%Y %H:%i') as quand, designation FROM journal ORDER BY moment DESC LIMIT 500;";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetJournalByRank($grade)
{
  require("components/mysql.php");
  $sql = "SELECT DATE_FORMAT(moment, '%d/%m/%Y %H:%i') as quand, designation FROM journal WHERE grade <= ? ORDER BY moment DESC LIMIT 100";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$grade]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetJournalById($id_user)
{
  require("components/mysql.php");
  $sql = "SELECT DATE_FORMAT(moment, '%d/%m/%Y %H:%i') as quand, designation FROM journal WHERE id_user = ? ORDER BY moment DESC LIMIT 50";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id_user]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallInsertJournal($id_user, $grade, $designation)
{
  require("components/mysql.php");
  $sql = "INSERT INTO journal (id_user,grade,designation) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id_user, $grade, $designation]);
  return;
}
