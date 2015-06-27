SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `db_bps` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `db_bps` ;

-- -----------------------------------------------------
-- Table `db_bps`.`Compte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Compte` (
  `numCompte` VARCHAR(10) NOT NULL,
  `password` VARCHAR(45) NULL,
  `nomProprietaire` VARCHAR(45) NULL,
  `prenomProprietaire` VARCHAR(45) NULL,
  `numeroCNI` VARCHAR(45) NULL,
  `solde` VARCHAR(45) NULL,
  `soldeVirtuel` VARCHAR(45) NULL,
  `seuilMin` VARCHAR(45) NULL,
  PRIMARY KEY (`numCompte`),
  UNIQUE INDEX `numCompte_UNIQUE` (`numCompte` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`Transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Transaction` (
  `codeTransaction` INT NOT NULL AUTO_INCREMENT,
  `dateCompete` VARCHAR(10) NULL,
  `typeTransaction` VARCHAR(45) NULL,
  `montantTransaction` FLOAT NULL,
  PRIMARY KEY (`codeTransaction`))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`Compte_has_Transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Compte_has_Transaction` (
  `Compte_numCompte` VARCHAR(10) NOT NULL,
  `Transaction_codeTransaction` INT NOT NULL,
  PRIMARY KEY (`Compte_numCompte`, `Transaction_codeTransaction`),
  INDEX `fk_Compte_has_Transaction_Transaction1_idx` (`Transaction_codeTransaction` ASC),
  INDEX `fk_Compte_has_Transaction_Compte_idx` (`Compte_numCompte` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`CodePaiementAttentes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`CodePaiementAttentes` (
  `code` VARCHAR(25) NOT NULL,
  `numEmeteur` VARCHAR(45) NOT NULL,
  `echeance` VARCHAR(45) NOT NULL,
  `cniEmeteur` VARCHAR(45) NOT NULL,
  `codeTransaction` INT NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  INDEX `fk_CodePaiementAttentes_Transaction1_idx` (`codeTransaction` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`CodePaiementUtilises`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`CodePaiementUtilises` (
  `code` VARCHAR(25) NOT NULL,
  `dateUtilisation` VARCHAR(45) NOT NULL,
  `numRecepteur` VARCHAR(45) NOT NULL,
  `codeTransaction` INT NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  INDEX `fk_CodePaiementUtilises_Transaction1_idx` (`codeTransaction` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`ComptePret`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`ComptePret` (
  `montantCredit` VARCHAR(45) NOT NULL,
  `montantDebit` VARCHAR(45) NOT NULL,
  `numCompte` VARCHAR(10) NOT NULL,
  INDEX `fk_ComptePret_Compte1_idx` (`numCompte` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`CompteAssurance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`CompteAssurance` (
  `idCompteAssurance` INT NOT NULL AUTO_INCREMENT,
  `etat` VARCHAR(15) NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  `soldeAssurance` DECIMAL(11) NOT NULL,
  `taux` DECIMAL(4) NOT NULL,
  `plafond` DECIMAL(11) NOT NULL,
  `seuil` DECIMAL(11) NOT NULL,
  `dateDebut` DATE NOT NULL,
  `dateFin` DATE NOT NULL,
  `benefice` DECIMAL(11) NOT NULL,
  `CompteAssurancecol` VARCHAR(45) NOT NULL,
  `Compte_numCompte` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idCompteAssurance`),
  INDEX `fk_CompteAssurance_Compte1_idx` (`Compte_numCompte` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`Pret`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Pret` (
  `idPret` INT NOT NULL,
  `montantPret` FLOAT NULL,
  `tauxRemboursement` INT NULL,
  `DureePret` INT NULL,
  `typeRemboursement` VARCHAR(45) NULL,
  `periodeRemboursement` VARCHAR(45) NULL,
  PRIMARY KEY (`idPret`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_bps`.`Contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Contrat` (
  `Compte_numCompte` VARCHAR(10) NOT NULL,
  `Pret_idPret` INT NOT NULL,
  PRIMARY KEY (`Compte_numCompte`, `Pret_idPret`),
  INDEX `fk_Compte_has_Pret_Pret1_idx` (`Pret_idPret` ASC),
  INDEX `fk_Compte_has_Pret_Compte1_idx` (`Compte_numCompte` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `db_bps`.`Rubrique`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_bps`.`Rubrique` (
  `idRubrique` INT NOT NULL,
  `titreRubrique` VARCHAR(45) NULL,
  `descriptionRubrique` VARCHAR(45) NULL,
  PRIMARY KEY (`idRubrique`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
