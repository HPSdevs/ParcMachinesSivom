<?php
function CallGetAllDocuments($idmachine)
{
  require("components\mysql.php");
  $sql = "SELECT id_document,idx_machine, idx_rapporteur, document.date_creation, legende, filename, p1.pseudo AS nom FROM document 
          LEFT JOIN utilisateur AS p1 ON idx_rapporteur  = p1.id_user  
          WHERE idx_machine = ? ORDER BY date_creation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmachine]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallFilenameDoc($iddoc)
{
  require("components\mysql.php");
  $sql = "SELECT  filename, legende FROM document WHERE id_document = ? ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$iddoc]);
  $data = $stmt->fetch();
  return $data;
}
function CallUpdateDocument($rappoteur, $legende, $iddocument)
{
  require("components\mysql.php");
  $sql = "UPDATE document SET idx_rapporteur = ? , legende= ? WHERE id_document = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$rappoteur, $legende, $iddocument]);
  return;
}
function CallDeleteDocument($iddocument)
{
  require("components\mysql.php");
  $sql = "DELETE FROM document WHERE id_document = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$iddocument]);
}
function CallInsertDocument($idmachine, $idrapporteur, $legende, $filename)
{
  require("components\mysql.php");
  $sql = "INSERT INTO document (idx_machine,idx_rapporteur,legende,filename,date_creation) VALUES (?,?,?,?,NOW())";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmachine, $idrapporteur, $legende, $filename]);
  return;
}
