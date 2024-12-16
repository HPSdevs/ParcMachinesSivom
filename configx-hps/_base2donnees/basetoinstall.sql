-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ParcSivom
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ParcSivom
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ParcSivom` DEFAULT CHARACTER SET utf8 ;
USE `ParcSivom` ;

-- -----------------------------------------------------
-- Table `ParcSivom`.`utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`utilisateur` (
  `id_user` INT(4) UNSIGNED NULL AUTO_INCREMENT,
  `statut` TINYINT(1) UNSIGNED NULL DEFAULT 1,
  `grade` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `theme` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `login` VARCHAR(20) NOT NULL,
  `pseudo` VARCHAR(25) NULL,
  `password` VARCHAR(72) NOT NULL,
  `courriel` VARCHAR(60) NULL,
  `date_creation` DATETIME(6) NULL DEFAULT NOW(),
  `date_lastlog` DATETIME(6) NULL,
  PRIMARY KEY (`id_user`));


-- -----------------------------------------------------
-- Table `ParcSivom`.`genremachine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`genremachine` (
  `id_genremachine` TINYINT(1) UNSIGNED NULL AUTO_INCREMENT,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(20) NULL,
  PRIMARY KEY (`id_genremachine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`typemachine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`typemachine` (
  `id_typemachine` SMALLINT(2) UNSIGNED NULL AUTO_INCREMENT,
  `genre` TINYINT(1) UNSIGNED NULL,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(35) NULL,
  PRIMARY KEY (`id_typemachine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`energiemachine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`energiemachine` (
  `id_energiemachine` TINYINT(1) UNSIGNED NULL AUTO_INCREMENT,
  `genre` TINYINT(1) UNSIGNED NULL,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(20) NULL,
  PRIMARY KEY (`id_energiemachine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`marquemachine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`marquemachine` (
  `id_marquemachine` SMALLINT(2) UNSIGNED NULL AUTO_INCREMENT,
  `genre` TINYINT(1) UNSIGNED NULL,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(20) NULL,
  PRIMARY KEY (`id_marquemachine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`modelemachine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`modelemachine` (
  `id_modelemachine` SMALLINT(2) UNSIGNED NULL AUTO_INCREMENT,
  `idx_marque` SMALLINT(2) UNSIGNED NULL,
  `statut` TINYINT(1) UNSIGNED NULL DEFAULT 1,
  `designation` VARCHAR(20) NULL,
  PRIMARY KEY (`id_modelemachine`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`machine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`machine` (
  `id_machine` INT UNSIGNED NULL AUTO_INCREMENT,
  `actif` TINYINT(1) UNSIGNED NULL DEFAULT 1,
  `alerte` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `idx_genre` TINYINT(1) UNSIGNED NULL,
  `idx_energie` TINYINT(1) UNSIGNED NOT NULL,
  `idx_type` SMALLINT(2) UNSIGNED NOT NULL,
  `idx_marque` SMALLINT(2) UNSIGNED NOT NULL,
  `idx_modele` SMALLINT(2) UNSIGNED NOT NULL,
  `puissance` INT UNSIGNED NULL,
  `imat` VARCHAR(10) NOT NULL,
  `date_premservice` DATE NULL,
  `date_procvsttech` DATE NULL,
  `designation` VARCHAR(60) NULL,
  `observation` TEXT NULL,
  `creation_date` DATETIME(6) NULL,
  `creation_creator` INT(4) NULL,
  PRIMARY KEY (`id_machine`),
  INDEX `imat_idx` (`imat` ASC),
  INDEX `model_idx` (`idx_modele` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`typeintervention`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`typeintervention` (
  `id_typeintervention` TINYINT(1) UNSIGNED NULL AUTO_INCREMENT,
  `role` TINYINT(1) UNSIGNED NULL,
  `genre` TINYINT(1) UNSIGNED NULL,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(40) NULL,
  PRIMARY KEY (`id_typeintervention`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`intervention`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`intervention` (
  `id_intervention` INT(4) UNSIGNED NULL AUTO_INCREMENT,
  `idx_machine` INT(4) UNSIGNED NOT NULL,
  `idx_demandeur` INT(4) UNSIGNED NOT NULL,
  `idx_mecanicien` INT(4) UNSIGNED NOT NULL,
  `idx_typeintervention` TINYINT(1) UNSIGNED NULL,
  `statut_intervention` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `statut_immobilise` TINYINT(1) UNSIGNED NULL,
  `statut_inutilisable` TINYINT(1) UNSIGNED NULL,
  `statut_urgent` TINYINT(1) UNSIGNED NULL,
  `kilometrage` INT(4) UNSIGNED NULL,
  `date_creation` DATETIME(6) NULL,
  `date_cloture` DATETIME(6) NULL,
  `comment_demandeur` TINYTEXT NULL,
  `comment_mecanicien` TINYTEXT NULL,
  `statut_depose` TINYINT(1) UNSIGNED NULL,
  `depose_lieu` TINYTEXT NULL,
  `total_prestation` TINYINT(1) UNSIGNED NULL,
  `total_duree` INT(4) UNSIGNED NULL,
  `total_cout` INT(4) UNSIGNED NULL,
  PRIMARY KEY (`id_intervention`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`action`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`action` (
  `id_action` TINYINT(1) UNSIGNED NULL AUTO_INCREMENT,
  `statut` TINYINT(1) UNSIGNED NULL,
  `designation` VARCHAR(40) NULL,
  PRIMARY KEY (`id_action`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`prestation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`prestation` (
  `id_prestation` INT(4) UNSIGNED NULL AUTO_INCREMENT,
  `idx_intervention` INT(4) UNSIGNED NULL,
  `idx_mecanicien` INT(4) UNSIGNED NULL,
  `idx_action` TINYINT(1) UNSIGNED NULL,
  `quand` DATETIME(6) NULL,
  `duree` TIME NULL,
  `objet` VARCHAR(80) NULL,
  `quantite` TINYINT(1) UNSIGNED NULL DEFAULT 1,
  `prix` INT(4) UNSIGNED NULL,
  `total` INT(4) UNSIGNED NULL,
  PRIMARY KEY (`id_prestation`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`document`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`document` (
  `id_document` INT(4) UNSIGNED NULL AUTO_INCREMENT,
  `idx_machine` INT(4) UNSIGNED NULL,
  `idx_rapporteur` INT(4) UNSIGNED NULL,
  `date_creation` DATETIME(6) NULL,
  `legende` VARCHAR(80) NULL,
  `filename` VARCHAR(255) NULL,
  PRIMARY KEY (`id_document`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`journal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`journal` (
  `id_event` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` INT(4) UNSIGNED NULL,
  `grade` TINYINT(1) UNSIGNED NULL,
  `moment` DATETIME(6) NULL DEFAULT NOW(),
  `designation` VARCHAR(255) NULL,
  PRIMARY KEY (`id_event`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParcSivom`.`preferences`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParcSivom`.`preferences` (
  `id` TINYINT(1) NOT NULL AUTO_INCREMENT,
  `lastmaintenance` DATETIME NULL DEFAULT NOW(),
  `sitestatut` TINYINT(1) UNSIGNED NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ParcSivom`.`utilisateur`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (1, 1, 128, 0, 'hpsdevs', 'Developpeur', '$2y$10$MUZ874ZSjVVXsoQldi1X9.zz2fDfwuc4HezJmUGx1ADzAOoH6P.fu', 'hpsdevs@gmail.com', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (2, 1, 128, 0, 'admin', 'Administrateur', '$2y$10$VeZ542rDwRgkuid39U0zQ.u8S9TJhTU32Aq3p3NI7QgLl5MuiiJju', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (3, 1, 64, 0, 'chef', 'Chef meca', '$2y$10$VD6Q3u2sYNfDJaxTGudMO./3CFL1kcG/d8tfzDj7AWJPEblzp2pf.', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (4, 1, 1, 0, 'user02', 'Lucie', '$2y$10$3hl.F0Pmq5Nz0yw7UjOcz.UZENbJpBfMB/WWtpmNZ3wz71bRFnLTe', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (5, 1, 1, 0, 'user01', 'Jean Marc', '$2y$10$zNwVUPUc6VY.9nrHPQYGR.JMNX2rTdwby.P8VdRdwpRgXeJGHdImy', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (6, 1, 2, 0, 'meca1', 'Mecanicien Jacques', '$2y$10$BwuXXIK7n4vcFLD3v6w.oeYRViehfP4BmcPvOwq8xxLKhb48A68ti', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');
INSERT INTO `ParcSivom`.`utilisateur` (`id_user`, `statut`, `grade`, `theme`, `login`, `pseudo`, `password`, `courriel`, `date_creation`, `date_lastlog`) VALUES (7, 1, 2, 0, 'meca2', 'Mecanicien Paul Emilien', '$2y$10$a0y/s81XL.kno/3tOz94mul5/U54j5Wlgul19N4CAGMvPaPJBn04m', 'veuillez@remplir.fr', '2024-09-01', '2024-09-01');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`genremachine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`genremachine` (`id_genremachine`, `statut`, `designation`) VALUES (1, 1, 'Véhicule');
INSERT INTO `ParcSivom`.`genremachine` (`id_genremachine`, `statut`, `designation`) VALUES (2, 1, 'Outil');
INSERT INTO `ParcSivom`.`genremachine` (`id_genremachine`, `statut`, `designation`) VALUES (3, 1, 'Véhicule + Outil');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`typemachine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (1, 1, 1, 'Transport en commun');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (2, 1, 1, 'Camion bache');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (3, 1, 1, 'Camion Frigorifique');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (4, 1, 1, 'Camion Plateau');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (5, 1, 1, 'Camion-Citerne');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (6, 1, 1, 'Camionnette');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (7, 1, 1, 'Fourgon');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (8, 1, 1, 'Machine et  instruments remorqués');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (9, 1, 1, 'Machine Agricole automotrice');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (10, 1, 1, 'Mobylette/Cyclomoteur');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (11, 1, 1, 'Remorque');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (12, 1, 1, 'Tracteur');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (13, 1, 1, 'Transpalette / Clark');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (14, 1, 1, 'Véhicule automoteur spécialisé');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (15, 1, 1, 'Automobile');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (16, 2, 1, 'Outil de coupe');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (17, 2, 1, 'Outil de fixation');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (18, 2, 1, 'Outil de gonflage');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (19, 2, 1, 'Outil de mesure');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (20, 2, 1, 'Outil de nettoyage');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (21, 2, 1, 'Outil de perçage/vissage');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (22, 2, 1, 'Outil de perforation');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (23, 2, 1, 'Outil de pression');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (24, 2, 1, 'Outil de serrage');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (25, 2, 1, 'Outil de surface');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (26, 1, 1, 'Camion benne à ordure');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (27, 1, 1, 'Epandeur de sel');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (28, 1, 1, 'Camion balayeuse');
INSERT INTO `ParcSivom`.`typemachine` (`id_typemachine`, `genre`, `statut`, `designation`) VALUES (29, 1, 1, 'Camion hydrocureur');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`energiemachine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (1, 3, 1, '[nc]');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (2, 3, 1, 'Diesel');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (3, 3, 1, 'Electrique');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (4, 3, 1, 'Essence');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (5, 3, 1, 'Hybride Essence');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (6, 3, 1, 'Hybride Gasoil');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (7, 2, 1, 'Hydraulique');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (8, 3, 1, 'Hydrogène');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (9, 2, 1, 'Pneumatique');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (10, 3, 1, 'Sans plomb 95');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (11, 3, 1, 'Sans plomb 98');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (12, 3, 1, 'Super');
INSERT INTO `ParcSivom`.`energiemachine` (`id_energiemachine`, `genre`, `statut`, `designation`) VALUES (13, 3, 1, 'Ethanol');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`marquemachine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (1, 1, 1, 'PEUGEOT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (2, 1, 1, 'RENAULT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (3, 1, 1, 'CITROEN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (4, 1, 1, 'FORD');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (5, 1, 1, 'WOLKSWAGEN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (6, 1, 1, 'DACIA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (7, 1, 1, 'AUDI');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (8, 1, 1, 'FIAT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (9, 1, 1, 'OPEL');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (10, 1, 1, 'SEAT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (11, 1, 1, 'HONDA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (12, 1, 1, 'MAZDA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (13, 1, 1, 'TOYOTA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (14, 1, 1, 'HYUNDAI');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (15, 1, 1, 'KIA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (16, 2, 1, 'ABAC');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (17, 2, 1, 'ACF');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (18, 2, 1, 'ALTRAD');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (19, 2, 1, 'DIAM');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (20, 2, 1, 'FALCOM');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (21, 2, 1, 'GYS');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (22, 2, 1, 'HOLZKRAFT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (23, 2, 1, 'IMER');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (24, 2, 1, 'KARCHER');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (25, 2, 1, 'KNIPEX');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (26, 2, 1, 'KRANZLE');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (27, 2, 1, 'KSTOOLS');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (28, 2, 1, 'LACAIR');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (29, 2, 1, 'LACME');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (30, 2, 1, 'LEMAN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (31, 2, 1, 'LIFTER');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (32, 2, 1, 'LINCOLN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (33, 2, 1, 'MAKITA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (34, 2, 1, 'METABO');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (35, 2, 1, 'MILWAWKEE');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (36, 2, 1, 'NILFISK');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (37, 2, 1, 'OPTIMUM');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (38, 2, 1, 'PROMAC');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (39, 2, 1, 'SAM');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (40, 2, 1, 'SDMO');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (41, 2, 1, 'SENCO');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (42, 2, 1, 'SIDAMO');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (43, 2, 1, 'SODIMAT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (44, 2, 1, 'STOCKMAN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (45, 2, 1, 'TIMBER');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (46, 2, 1, 'TUBESCA-COMABI');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (47, 2, 1, 'UNICRAFT');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (48, 2, 1, 'VIRAX');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (49, 2, 1, 'WERA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (50, 2, 1, 'WORMS');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (51, 2, 1, 'WUITHOM');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (52, 1, 1, 'IVECO');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (53, 1, 1, 'SCANIA');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (54, 1, 1, 'MAN');
INSERT INTO `ParcSivom`.`marquemachine` (`id_marquemachine`, `genre`, `statut`, `designation`) VALUES (55, 1, 1, 'DAF');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`modelemachine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (1, 0, 1, '[nc]');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (2, 1, 1, '2008');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (3, 1, 1, '3008');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (4, 1, 1, '408');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (5, 1, 1, '308');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (6, 1, 1, '5008');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (7, 1, 1, '508');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (8, 1, 1, 'Boxer');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (9, 1, 1, 'Expert');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (10, 1, 1, 'Partner');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (11, 1, 1, 'Rifter');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (12, 1, 1, 'Traveller');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (13, 2, 1, 'Arkana');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (14, 2, 1, 'Austral');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (15, 2, 1, 'Captur');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (16, 2, 1, 'Clio');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (17, 2, 1, 'D10');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (18, 2, 1, 'Espace');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (19, 2, 1, 'Express');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (20, 2, 1, 'Kangoo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (21, 2, 1, 'Scenic');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (22, 2, 1, 'Kadjar');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (24, 2, 1, 'Koleos');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (25, 2, 1, 'Master');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (26, 2, 1, 'Megane');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (27, 2, 1, 'R5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (28, 2, 1, 'Symboz');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (29, 2, 1, 'Trafic');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (30, 2, 1, 'Twingo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (31, 2, 1, 'Twizy');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (32, 2, 1, 'Zoe');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (33, 3, 1, 'Ami');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (34, 3, 1, 'Berlingo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (35, 3, 1, 'C3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (36, 3, 1, 'C3 Aircross');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (37, 3, 1, 'C4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (38, 3, 1, 'C5 Aicross');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (39, 3, 1, 'C5X');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (40, 3, 1, 'Grand C4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (41, 3, 1, 'Jumper');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (42, 3, 1, 'Jumpy');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (43, 3, 1, 'Spacetourer');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (44, 4, 1, 'Bronco');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (45, 4, 1, 'Capri');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (46, 4, 1, 'Ecosport');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (47, 4, 1, 'Expedition');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (48, 4, 1, 'Explorer');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (49, 4, 1, 'F150');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (50, 4, 1, 'Fiesta');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (51, 4, 1, 'Focus');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (52, 4, 1, 'Galaxy');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (53, 4, 1, 'Gt');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (54, 4, 1, 'Ka');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (55, 4, 1, 'Kuga');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (56, 4, 1, 'Maverick');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (57, 4, 1, 'Mercury');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (58, 4, 1, 'Mustang');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (59, 4, 1, 'Puma');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (60, 4, 1, 'Ranger');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (61, 4, 1, 'S-Max');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (62, 4, 1, 'Tourneo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (63, 4, 1, 'Transit');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (64, 5, 1, 'Amarok');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (65, 5, 1, 'Arteon');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (66, 5, 1, 'Caddy');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (67, 5, 1, 'California');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (68, 5, 1, 'Caravelle');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (69, 5, 1, 'Crafter');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (70, 5, 1, 'Golf');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (71, 5, 1, 'Golf Sportvan');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (72, 5, 1, 'Grand california');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (73, 5, 1, 'Id Buzz');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (74, 5, 1, 'Id3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (75, 5, 1, 'Id4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (76, 5, 1, 'Id5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (77, 5, 1, 'Id7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (78, 5, 1, 'Multivan');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (79, 5, 1, 'Passat');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (80, 5, 1, 'Polo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (81, 5, 1, 'T-Cross');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (82, 5, 1, 'T-Roc');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (83, 5, 1, 'Taigo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (84, 5, 1, 'Tiguan');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (85, 5, 1, 'Touareg');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (86, 5, 1, 'Touran');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (87, 5, 1, 'Transporter');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (88, 5, 1, 'Up!');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (89, 6, 1, 'Bigster');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (90, 6, 1, 'Duster');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (91, 6, 1, 'Jogger');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (92, 6, 1, 'Logan');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (93, 6, 1, 'Sandero');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (94, 6, 1, 'Spring');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (95, 7, 1, 'A1');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (96, 7, 1, 'A3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (97, 7, 1, 'A4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (98, 7, 1, 'A5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (99, 7, 1, 'A6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (100, 7, 1, 'A7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (101, 7, 1, 'A8');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (102, 7, 1, 'E-Tron');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (103, 7, 1, 'Q2');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (104, 7, 1, 'Q3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (105, 7, 1, 'Q4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (106, 7, 1, 'Q5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (107, 7, 1, 'Q6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (108, 7, 1, 'Q7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (109, 7, 1, 'Q8');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (110, 7, 1, 'Rs3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (111, 7, 1, 'Rs4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (112, 7, 1, 'Rs5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (113, 7, 1, 'Rs6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (114, 7, 1, 'Rs7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (115, 7, 1, 'S3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (116, 7, 1, 'S4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (117, 7, 1, 'S5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (118, 7, 1, 'S6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (119, 7, 1, 'S7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (120, 7, 1, 'S8');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (121, 7, 1, 'Sq2');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (122, 7, 1, 'Sq5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (123, 7, 1, 'Sq7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (124, 7, 1, 'Sq8');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (125, 7, 1, 'Tt');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (126, 8, 1, '500');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (127, 8, 1, '500L');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (128, 8, 1, '500X');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (129, 8, 1, '600');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (130, 8, 1, '600e');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (131, 8, 1, 'Doblo Cargo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (132, 8, 1, 'Ducato');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (133, 8, 1, 'Fiorino');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (134, 8, 1, 'Grande Panda');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (135, 8, 1, 'Panda');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (136, 8, 1, 'Punto');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (137, 8, 1, 'Scudo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (138, 8, 1, 'Talento');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (139, 8, 1, 'Tipo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (140, 8, 1, 'Topolino');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (141, 8, 1, 'Ulysse');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (142, 9, 1, 'Ampera');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (143, 9, 1, 'Astra');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (144, 9, 1, 'Combo Cargo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (145, 9, 1, 'Combo Life');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (146, 9, 1, 'Corsa');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (147, 9, 1, 'Crossland');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (148, 9, 1, 'Frontera');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (149, 9, 1, 'Grandland');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (150, 9, 1, 'Insignia');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (151, 9, 1, 'Mokka');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (152, 9, 1, 'Movano');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (153, 9, 1, 'Vivaro');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (154, 9, 1, 'Zafira');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (155, 10, 1, 'Arona');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (156, 10, 1, 'Ateca');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (157, 10, 1, 'Ibiza');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (158, 10, 1, 'Leon');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (159, 10, 1, 'Tarraco');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (160, 11, 1, 'Accord');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (161, 11, 1, 'Civic');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (162, 11, 1, 'Cr-v');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (163, 11, 1, 'E');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (164, 11, 1, 'Hr-v');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (165, 11, 1, 'Jazz');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (166, 11, 1, 'Zr-v');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (167, 12, 1, '2');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (168, 12, 1, '3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (169, 12, 1, 'Cx-5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (170, 12, 1, 'Cx-60');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (171, 12, 1, 'Cx-80');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (172, 12, 1, 'Mx-30');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (173, 12, 1, 'Mx5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (174, 13, 1, 'Auris');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (175, 13, 1, 'Avensis');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (176, 13, 1, 'Aygo X');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (177, 13, 1, 'Bz4x');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (178, 13, 1, 'C-hr');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (179, 13, 1, 'Camry');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (180, 13, 1, 'Corolla');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (181, 13, 1, 'Gr86');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (182, 13, 1, 'Highlander');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (183, 13, 1, 'Hilux');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (184, 13, 1, 'Land Cruiser');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (185, 13, 1, 'Mirai');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (186, 13, 1, 'Prius');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (187, 13, 1, 'Proace');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (188, 13, 1, 'Rav4');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (189, 13, 1, 'Supra');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (190, 13, 1, 'Yaris');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (191, 13, 1, 'Yaris Cross');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (192, 14, 1, 'Bayon');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (193, 14, 1, 'I10');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (194, 14, 1, 'I20');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (195, 14, 1, 'I30');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (196, 14, 1, 'Ioniq5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (197, 14, 1, 'Ioniq6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (198, 14, 1, 'Ioniq7');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (199, 14, 1, 'Kona');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (200, 14, 1, 'Nexo');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (201, 14, 1, 'Santa Fe');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (202, 14, 1, 'Staria');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (203, 14, 1, 'Tucson');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (204, 15, 1, 'Ceed');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (205, 15, 1, 'Ev3');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (206, 15, 1, 'Ev5');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (207, 15, 1, 'Ev6');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (208, 15, 1, 'Ev9');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (209, 15, 1, 'Niro');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (210, 15, 1, 'Picanto');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (211, 15, 1, 'Proceed');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (212, 15, 1, 'Rio');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (213, 15, 1, 'Sorento');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (214, 15, 1, 'Soul');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (215, 15, 1, 'Sportage');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (216, 15, 1, 'Stinger');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (217, 15, 1, 'Stonic');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (218, 15, 1, 'Xceed');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (219, 55, 1, 'XB');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (220, 55, 1, 'XFC');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (221, 55, 1, 'XDC');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (222, 55, 1, 'XD');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (223, 55, 1, 'XF');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (224, 55, 1, 'XG');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (225, 54, 1, 'TGX');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (226, 54, 1, 'TGS');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (227, 54, 1, 'TGM');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (228, 54, 1, 'TGL');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (229, 54, 1, 'TGE');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (230, 52, 1, 'DAILY');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (231, 52, 1, 'EUROCARGO');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (232, 52, 1, 'S-WAY');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (233, 52, 1, 'X-WAY');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (234, 52, 1, 'T-WAY');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (235, 53, 1, 'Serie L');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (236, 53, 1, 'Serie P');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (237, 53, 1, 'Serie G');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (238, 53, 1, 'Serie R');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (239, 53, 1, 'Serie S');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (240, 2, 1, 'Trucks T');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (241, 2, 1, 'Trucks K');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (242, 2, 1, 'Trucks C');
INSERT INTO `ParcSivom`.`modelemachine` (`id_modelemachine`, `idx_marque`, `statut`, `designation`) VALUES (243, 2, 1, 'Trucks D');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`machine`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`machine` (`id_machine`, `actif`, `alerte`, `idx_genre`, `idx_energie`, `idx_type`, `idx_marque`, `idx_modele`, `puissance`, `imat`, `date_premservice`, `date_procvsttech`, `designation`, `observation`, `creation_date`, `creation_creator`) VALUES (1, 1, NULL, 1, 2, 15, 3, 35, 66000, 'AA-001-BB', '2024-01-10', '2026-05-27', 'CITROEN C3  AA-001-BB  Diesel', 'VOITURE TEST', '2024-09-13 00:00:00.000000', 2);
INSERT INTO `ParcSivom`.`machine` (`id_machine`, `actif`, `alerte`, `idx_genre`, `idx_energie`, `idx_type`, `idx_marque`, `idx_modele`, `puissance`, `imat`, `date_premservice`, `date_procvsttech`, `designation`, `observation`, `creation_date`, `creation_creator`) VALUES (2, 1, NULL, 1, 2, 15, 6, 91, 85000, 'AA-002-BB', '2020-01-01', '2026-01-01', 'DACIA jogger  AA-002-BB  Diesel ', 'VOITURE TEST', '2024-09-13 00:00:00.000000', 2);
INSERT INTO `ParcSivom`.`machine` (`id_machine`, `actif`, `alerte`, `idx_genre`, `idx_energie`, `idx_type`, `idx_marque`, `idx_modele`, `puissance`, `imat`, `date_premservice`, `date_procvsttech`, `designation`, `observation`, `creation_date`, `creation_creator`) VALUES (3, 1, NULL, 2, 3, 20, 24, 1, 1500, '001245', '2023-02-20', '2013-02-20', 'KARCHER Outil de nettoyage Electrique 001245', 'OUTIL TEST', '2024-09-13 00:00:00.000000', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`typeintervention`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (39, 192, 3, 1, '… Entree dans le parc');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (40, 192, 3, 1, '… Sortie du parc');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (1, 195, 1, 1, 'Accident');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (2, 195, 1, 1, 'Bris de glace');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (3, 195, 1, 1, 'Bruit suspect');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (4, 195, 1, 1, 'Defaut (autre)');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (5, 195, 1, 1, 'Defaut eclairage');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (6, 195, 1, 1, 'Defaut frein');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (7, 195, 1, 1, 'Defaut pneumatique');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (8, 195, 1, 1, 'Defaut voyant');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (9, 195, 1, 1, 'Document/Administratif');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (10, 195, 1, 1, 'En panne');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (11, 195, 1, 1, 'Evenement naturel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (12, 195, 1, 1, 'Incendie');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (13, 195, 1, 1, 'Vandalisme');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (14, 195, 1, 1, 'Vol');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (15, 194, 3, 1, 'Controle exceptionnel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (16, 194, 3, 1, 'Controle mensuel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (17, 194, 3, 1, 'Controle trimestriel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (18, 194, 3, 1, 'Controle semestriel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (19, 194, 3, 1, 'Controle annuel');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (20, 194, 3, 1, 'Revision annuelle');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (21, 194, 3, 1, 'Depose garage de marque');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (22, 194, 3, 1, 'Retour garage de marque');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (23, 194, 3, 1, 'Depose pour expertise');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (24, 194, 3, 1, 'Reprise suite expertise');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (25, 194, 3, 1, 'Carrosserie');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (26, 194, 3, 1, 'Changement batterie');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (27, 194, 3, 1, 'Controle technique');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (28, 194, 3, 1, 'Diagnostic suite defaut');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (29, 194, 3, 1, 'Eclairage');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (30, 194, 3, 1, 'Electricite');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (31, 194, 3, 1, 'Entretien');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (32, 194, 3, 1, 'Freinage');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (33, 194, 3, 1, 'Liquide');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (34, 194, 3, 1, 'Mecanique');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (35, 194, 3, 1, 'Peinture');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (36, 194, 3, 1, 'Pneumatique');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (37, 194, 3, 1, 'Pre-contrôle technique');
INSERT INTO `ParcSivom`.`typeintervention` (`id_typeintervention`, `role`, `genre`, `statut`, `designation`) VALUES (38, 194, 3, 1, 'Vitrerie');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`action`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (1, 1, 'Affutage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (2, 1, 'Analyse');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (3, 1, 'Constatation');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (4, 1, 'Echange (occasion)');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (5, 1, 'Mise à niveau');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (6, 1, 'Mise en place (neuf)');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (7, 1, 'Modification');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (8, 1, 'Nettoyage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (9, 1, 'Percage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (10, 1, 'Soudage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (11, 1, 'Traitement');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (12, 1, 'Usinage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (13, 1, 'Verification');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (14, 1, 'Facture exterieure');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (15, 1, 'Rapatriement');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (16, 1, 'Reparation');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (17, 1, 'Cablage');
INSERT INTO `ParcSivom`.`action` (`id_action`, `statut`, `designation`) VALUES (18, 1, 'Depannage');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ParcSivom`.`preferences`
-- -----------------------------------------------------
START TRANSACTION;
USE `ParcSivom`;
INSERT INTO `ParcSivom`.`preferences` (`id`, `lastmaintenance`, `sitestatut`) VALUES (1, NULL, NULL);

COMMIT;

