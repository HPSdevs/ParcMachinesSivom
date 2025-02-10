<?php
function CallGetAllMachine()
{
  require("components/mysql.php");
  $sql = "SELECT * FROM machine ORDER BY designation ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $data = $stmt->fetchAll();
  return $data;
}
function CallGetCombienMachine($genre)
{  // used pour faire les différentes pages
  require("components/mysql.php");
  $sql = "SELECT COUNT(id_machine) as total FROM machine WHERE idx_genre & ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre]);
  $data = $stmt->fetch();
  return $data;
}
function CallGetAllMachineFull($page, $genre)
{  // page>=1 
  require("components/mysql.php");
  $sql = "SELECT id_machine, typemachine.designation AS type, marquemachine.designation AS marque, 
          modelemachine.designation AS modele, energiemachine.designation AS energie,
          idx_genre,idx_modele,imat,puissance,date_premservice,date_procvsttech,actif,alerte,observation
          FROM machine 
          INNER JOIN marquemachine  ON idx_marque   =id_marquemachine 
          INNER JOIN modelemachine  ON idx_modele   =id_modelemachine
          INNER JOIN typemachine    ON idx_type     =id_typemachine 
          INNER JOIN energiemachine ON idx_energie  =id_energiemachine 
          WHERE idx_genre & ? 
          ORDER BY machine.id_machine ASC LIMIT 10 OFFSET " . ($page - 1) * 10;
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallCheckIfMachineExist($id)
{
  require("components/mysql.php");
  $sql = "SELECT id_machine FROM machine WHERE id_machine = ? ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  return $data["id_machine"] ?? false;
}
function CallGetMachine($id)
{
  require("components/mysql.php");
  $sql = "SELECT * FROM machine WHERE id_machine = ? ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  return $data;
}
function CallGetThisMachine($id)
{
  require("components/mysql.php");
  $sql = "SELECT typemachine.designation AS type, marquemachine.designation AS marque, 
          modelemachine.designation AS modele, energiemachine.designation AS energie,
          genremachine.designation AS genre, id_genremachine as idgenre, id_modelemachine as idmodele, id_machine, imat,puissance,date_premservice,date_procvsttech,actif,machine.designation,observation
          FROM machine 
          INNER JOIN genremachine   ON idx_genre    =id_genremachine 
          INNER JOIN marquemachine  ON idx_marque   =id_marquemachine 
          INNER JOIN modelemachine  ON idx_modele   =id_modelemachine
          INNER JOIN typemachine    ON idx_type     =id_typemachine 
          INNER JOIN energiemachine ON idx_energie  =id_energiemachine 
          WHERE id_machine = ? ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch();
  return $data;
}
function SearchSimpleIMAT($imat)
{
  require("components/mysql.php");
  $sql = "SELECT id_machine FROM machine WHERE imat LIKE ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$imat]);
  $data = $stmt->fetch();
  $a =  isset($data['id_machine']) ? $data['id_machine'] : false;
  return $a;
}
function SearchIMAT($imat)
{
  require("components/mysql.php");
  $imat = "%" . $imat . "%";
  $sql = "SELECT typemachine.designation AS type, marquemachine.designation AS marque, 
          modelemachine.designation AS modele, energiemachine.designation AS energie,
          genremachine.designation AS genre, id_genremachine as idgenre, id_modelemachine as idmodele, id_machine,imat,puissance,date_premservice,date_procvsttech,actif,observation
          FROM machine 
          INNER JOIN genremachine   ON idx_genre    =id_genremachine 
          INNER JOIN marquemachine  ON idx_marque   =id_marquemachine 
          INNER JOIN modelemachine  ON idx_modele   =id_modelemachine
          INNER JOIN typemachine    ON idx_type     =id_typemachine 
          INNER JOIN energiemachine ON idx_energie  =id_energiemachine 
          WHERE imat LIKE ? LIMIT 50";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$imat]);
  $data = $stmt->fetchAll();
  return $data;
}
function SearchDES($search = "%")
{
  $item = explode(" ", strtolower(trim($search)));
  $searchtoo = "";
  $imat = "%" . $item[0] . "%";
  for ($i = 1; $i < sizeof($item); $i++) {
    $searchtoo .= "AND LOWER ( CONCAT (machine.designation,typemachine.designation,observation,date_premservice)) LIKE '%" . $item[$i] . "%' ";
  }
  require("components/mysql.php");
  $sql = "SELECT typemachine.designation AS type, marquemachine.designation AS marque, 
          modelemachine.designation AS modele, energiemachine.designation AS energie,
          genremachine.designation AS genre, id_genremachine as idgenre, id_modelemachine as idmodele, id_machine,imat,puissance,date_premservice,date_procvsttech,actif,observation
          FROM machine 
          INNER JOIN genremachine   ON idx_genre    =id_genremachine 
          INNER JOIN marquemachine  ON idx_marque   =id_marquemachine 
          INNER JOIN modelemachine  ON idx_modele   =id_modelemachine
          INNER JOIN typemachine    ON idx_type     =id_typemachine 
          INNER JOIN energiemachine ON idx_energie  =id_energiemachine 
          WHERE LOWER ( CONCAT (machine.designation,typemachine.designation,observation,date_premservice)) LIKE ? $searchtoo LIMIT 50";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$imat]);
  $data = $stmt->fetchAll();
  return $data;
}
function CallInsertMachine($genre, $nrj, $modele, $type, $marque, $puissancee, $imat, $dateprem, $datetech, $design, $obs, $creator)
{
  require("components/mysql.php");
  $now = date("Y-m-d");
  $sql = "INSERT INTO machine (actif, idx_genre, idx_energie, idx_modele,idx_type,idx_marque,puissance,imat,date_premservice, date_procvsttech,designation,observation,creation_date,creation_creator) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([1, $genre, $nrj, $modele, $type, $marque, $puissancee, $imat, $dateprem, $datetech, $design, $obs, $now, $creator]);
  return;
}
function CallUpdateMachine($genre, $nrj, $modele, $type, $marque, $puissancee, $imat, $dateprem, $datetech, $design, $obs, $creator, $id)
{
  require("components/mysql.php");
  $now = date("Y-m-d");
  $sql = "UPDATE machine SET idx_genre= ?, idx_energie = ?, idx_modele = ?,idx_type = ?,idx_marque= ?,puissance = ?,imat =?,date_premservice = ?, date_procvsttech = ?,designation = ?,observation = ?,creation_date = ?,creation_creator = ? WHERE id_machine= ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $nrj, $modele, $type, $marque, $puissancee, $imat, $dateprem, $datetech, $design, $obs, $now, $creator, $id]);
  return;
}
function CallOffMachine($idmachine)
{
  require("components/mysql.php");
  $sql = "UPDATE machine SET actif = 0 WHERE id_machine= ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmachine]);
  return;
}
function CallOnMachine($idmachine)
{
  require("components/mysql.php");
  $sql = "UPDATE machine SET actif = 1 WHERE id_machine= ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmachine]);
  return;
}
function CallUpdateAlerte($idmachine)
{
  require("components/mysql.php");

  $sql = "SELECT COUNT(id_intervention) as nb FROM intervention WHERE idx_machine = ? AND statut_intervention & 7";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$idmachine]);
  $data = $stmt->fetch();
  $sql = "UPDATE machine SET alerte= ? WHERE id_machine= ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$data['nb'], $idmachine]);
  return;
}
