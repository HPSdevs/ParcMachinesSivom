<?php
/* STATUT_INTERVENTION en valeur
  0  = créée mais pas encore validé par le demandeur	    (48 heures d'existence)
  1  = validée par le demandeur, en attente de traitement
  2  = Traitement en cours
  4  = Traitement assigné (...not in this version)
  8  = intervention refusée
  16 = intervention cloturée
*/
function CallRefreshTrashIntervention()
{
	require("components/mysql.php");
	// effacement des vieilles demandes d'intervention non validée et supérieur à 48 heures.
	$sql = "DELETE FROM intervention WHERE statut_intervention = 0 AND date_creation < DATE_SUB(NOW(), INTERVAL 48 HOUR)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return;
}
function CallHowmanyIntervention($statut)  //  Liste des interventions
{
	require("components/mysql.php");
	$sta = ($statut == 1) ? "WHERE statut_intervention < 8 " : "";  // en cours
	$sta = ($statut == 0) ? "WHERE statut_intervention > 7 " : $sta;  // cloture
	$sql = "SELECT COUNT(id_intervention) as nb	FROM intervention $sta";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetch();
	return $data['nb'];
}
function CallGetFullIntervention($page, $statut)  //  Liste des interventions
{
	require("components/mysql.php");

	$sta = ($statut == 1) ? "WHERE statut_intervention < 8 " : "";  // en cours
	$sta = ($statut == 0) ? "WHERE statut_intervention > 7 " : $sta;  // cloture

	$sql = "SELECT id_intervention,idx_machine,idx_genre,total_prestation,total_duree,(total_cout/100) as total_cout,statut_intervention,statut_depose,statut_urgent,statut_immobilise,statut_inutilisable,
			kilometrage, intervention.date_creation AS crea, intervention.date_cloture as clot, machine.designation AS machine, 
			typeintervention.designation AS motif  
			FROM intervention
			JOIN typeintervention  ON idx_typeintervention =id_typeintervention
			JOIN machine           ON idx_machine          =id_machine
			$sta
			ORDER BY intervention.date_creation DESC LIMIT 10 OFFSET " . ($page - 1) * 10;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetInterventionByID($id)
{
	require("components/mysql.php");
	$sql = "SELECT * FROM intervention WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetch();
	return $data;
}
function CallWhoIsDemandeur($id)
{
	require("components/mysql.php");
	$sql = "SELECT idx_demandeur FROM intervention WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id]);
	$data = $stmt->fetch();
	return $data['idx_demandeur'];
}
function CallGetIntervention($statut)
{
	require("components/mysql.php");
	$a = $statut ? "& 7" : "& 24";
	$sql = "SELECT * FROM intervention WHERE statut_intervention $a ORDER BY date_creation ASC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetAllInterventionFull($statut)
{
	require("components/mysql.php");
	$sta = ($statut) ?  "& 7" : "& 24";
	$tri = ($statut) ?  "ASC" : "DESC";
	$sql = "SELECT id_intervention,idx_machine,idx_genre,total_prestation,(total_cout/100) as total_cout,statut_intervention,statut_depose,statut_urgent,statut_immobilise,statut_inutilisable,
			kilometrage, intervention.date_creation AS crea, intervention.date_cloture as clot, machine.designation AS machine, 
			typeintervention.designation AS motif,  p1.pseudo AS demandeur, p2.pseudo AS mecanicien
			FROM intervention
			JOIN typeintervention  ON idx_typeintervention =id_typeintervention
			JOIN machine           ON idx_machine          =id_machine
			LEFT JOIN utilisateur AS p1 ON idx_demandeur   =p1.id_user  
			LEFT JOIN utilisateur AS p2 ON idx_mecanicien  =p2.id_user 
			WHERE statut_intervention $sta AND intervention.date_creation > DATE_SUB(NOW(), INTERVAL 1 YEAR) 
			ORDER BY intervention.date_creation $tri LIMIT 100 ;";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetAllDemandeurIntervention($statut, $iddemandeur)
{
	require("components/mysql.php");
	$sta = ($statut) ?  "& 7" : "& 24";
	$tri = ($statut) ?  "ASC" : "DESC";
	$sql = "SELECT id_intervention,idx_machine,idx_genre,total_prestation,(total_cout/100) as total_cout,statut_intervention,statut_depose,statut_urgent,statut_immobilise,statut_inutilisable,
			kilometrage, intervention.date_creation AS crea, intervention.date_cloture as clot, machine.designation AS machine, 
			typeintervention.designation AS motif,  p1.pseudo AS demandeur, p2.pseudo AS mecanicien
			FROM intervention
			JOIN typeintervention  ON idx_typeintervention =id_typeintervention
			JOIN machine           ON idx_machine          =id_machine
			LEFT JOIN utilisateur AS p1 ON idx_demandeur   =p1.id_user  
			LEFT JOIN utilisateur AS p2 ON idx_mecanicien  =p2.id_user 
			WHERE idx_demandeur = ? AND statut_intervention $sta AND intervention.date_creation > DATE_SUB(NOW(), INTERVAL 1 YEAR) 
			ORDER BY intervention.date_creation $tri LIMIT 100 ;";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$iddemandeur]);
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetMachineInterventionFull($idmachine, $statut)
{
	require("components/mysql.php");
	$sta = ($statut) ? "& 7" : "& 24";
	$tri = ($statut) ? "ASC" : "DESC";
	$sql = "SELECT id_intervention,total_prestation,statut_intervention,statut_depose,statut_urgent,statut_immobilise,statut_inutilisable,intervention.date_creation AS crea, intervention.date_cloture AS clos,kilometrage,idx_machine, idx_genre, machine.designation AS machine, typeintervention.designation AS motif,  p1.pseudo AS demandeur, p2.pseudo AS mecanicien, p1.id_user as idx_demandeur
			FROM intervention
			JOIN typeintervention  ON idx_typeintervention =id_typeintervention
			JOIN machine           ON idx_machine          =id_machine
			LEFT JOIN utilisateur AS p1 ON idx_demandeur   =p1.id_user
			LEFT JOIN utilisateur AS p2 ON idx_mecanicien  =p2.id_user
			WHERE idx_machine = ? AND statut_intervention $sta AND intervention.date_creation > DATE_SUB(NOW(), INTERVAL 1 YEAR)
			ORDER BY intervention.date_creation $tri LIMIT 100 ;";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idmachine]);
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetMachineIntervention($idmachine, $statut)
{  // savoir toutes les inter false= arretée ou true= running
	require("components/mysql.php");
	$a = ($statut) ? "& 7" : "& 24";
	$sql = "SELECT * FROM intervention WHERE statut_intervention $a AND idx_machine = ? ORDER BY date_creation ASC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$statut, $idmachine]);
	$data = $stmt->fetchAll();
	return $data;
}
function CallGetDemandIntervention($iddemandeur, $idmachine, $statut)
{
	require("components/mysql.php");
	$sql = "SELECT id_intervention FROM intervention WHERE idx_machine= ? AND statut_intervention = ? AND idx_demandeur = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idmachine, $statut, $iddemandeur]);
	$data = $stmt->fetch();
	$dump = $data["id_intervention"] ?? false;
	return $dump;
}
function CallGetMecaIntervention($idmecano, $statut)
{
	require("components/mysql.php");
	$sql = "SELECT * FROM intervention WHERE statut_intervention = ?  AND idx_mecanicien = ? ORDER BY date_creation ASC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$statut, $idmecano]);
	$data = $stmt->fetchAll();
	return $data;
}
function CallInsertInterMachine($iddemandeur, $idmachine)
{
	require("components/mysql.php");
	$sql = "INSERT INTO intervention (idx_machine, idx_demandeur,statut_intervention,date_creation) VALUES (?,?,0,now())";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idmachine, $iddemandeur]);
	$data = $pdo->lastInsertId();
	return $data;
}
function CallUpdateSaveIntervention($depose, $adress, $type, $com, $idinter)
{
	require("components/mysql.php");
	$sql = "UPDATE intervention SET statut_depose = ?, depose_lieu= ?, idx_typeintervention = ?, comment_demandeur = ? , date_creation = NOW() WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$depose, $adress, $type, $com, $idinter]);
	return;
}
function CallUpdateSendIntervention($depose, $adress, $type, $com, $idinter)
{
	require("components/mysql.php");
	$sql = "UPDATE intervention SET statut_depose = ?, depose_lieu= ?, idx_typeintervention = ?, comment_demandeur = ? , statut_intervention = 1, date_creation = NOW() WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$depose, $adress, $type, $com, $idinter]);
	return;
}
function CallDeleteIntervention($idinter)
{
	require("components/mysql.php");
	$sql = "DELETE FROM intervention WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idinter]);
	return;
}
function CallUpdateTotalIntervention($idinter)
{
	require("components/mysql.php");
	$totalprix = 0;
	$totaltemps = null;
	$sql = 'SELECT duree,total FROM prestation WHERE idx_intervention = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idinter]);
	$data = $stmt->fetchAll();
	foreach ($data as $d) {
		$totalprix  +=  $d['total'];
		$totaltemps +=  date('H', strtotime($d['duree'])) * 60 + date('i', strtotime($d['duree']));
	}
	$sql = "UPDATE intervention SET total_prestation = ? , total_duree = ? , total_cout = ? WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([count($data), $totaltemps, $totalprix, $idinter]);
	return;
}
function CallUpdateAutoStatutintervention($idinter)
{
	require("components/mysql.php");
	$sql = "SELECT statut_intervention, total_prestation FROM intervention WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$idinter]);
	$data = $stmt->fetch();
	if (($data['statut_intervention'] = 1) && ($data['total_prestation'] > 0)) {
		$sql = "UPDATE intervention SET statut_intervention = 2  WHERE id_intervention = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$idinter]);
	}
}
function CallUpdateGestionIntervention($kilometre, $urgence, $inutilisable, $immobil, $rapatriement, $statut, $comment, $idinter)
{
	require("components/mysql.php");
	$opt = ($statut & 24) ? ", date_cloture = NOW()" : "";
	$sql = "UPDATE intervention SET kilometrage = ?, statut_urgent = ?, statut_inutilisable = ?, statut_immobilise = ?, statut_depose = ?, statut_intervention = ?, comment_mecanicien = ? $opt WHERE id_intervention = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$kilometre, $urgence, $inutilisable, $immobil, $rapatriement, $statut, $comment, $idinter]);
	return;
}
