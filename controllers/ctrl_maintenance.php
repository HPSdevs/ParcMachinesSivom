<?php
function CallDoMaintenance()
{
  require("components/mysql.php");
  // Chaque jour faire...
  $sql = "SELECT  NOW() > DATE_ADD(lastmaintenance, INTERVAL 1 DAY) as temps FROM preferences WHERE id = 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetch();
  $dump = $data["temps"] ?? 0;
  if ($dump) {
    // ci-dessous la liste des choses à faire
    MaintenanceDeleteOldJournal();
    MaintenanceUpdateDate();
  }
}
function MaintenanceUpdateDate()
{
  require("components/mysql.php");
  // memorisation de la derniere date de la maintenance
  $sql = "UPDATE preferences SET lastmaintenance = NOW() WHERE id = 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
}
function MaintenanceDeleteOldJournal()
{
  require("components/mysql.php");
  // effacement automatique du journal des évènements si supérieur a trois mois.
  $sql = "DELETE FROM journal WHERE moment < DATE_SUB(NOW(), INTERVAL 3 MONTH)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  return;
}
function GetSiteStatut()
{
  require("components/mysql.php");
  $sql = "SELECT sitestatut FROM preferences WHERE id = 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetch();
  return $data['sitestatut'];
}
function ToggleSiteStatut($value)
{
  require("components/mysql.php");
  $sql = "UPDATE preferences SET sitestatut = ? WHERE id = 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$value]);
}
