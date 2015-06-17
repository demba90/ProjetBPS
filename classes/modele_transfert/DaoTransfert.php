<?php

/**
 * Created by PhpStorm.
 * User: thiam
 * Date: 22/05/2015
 * Time: 17:36
 */
 class DaoTransfert extends PDO
{
    private static $_instance;

    // constructeur par défaut
    public function __construct()
    {

    }

    static function getInstance(){
        if (!isset(self::$_instance)) {
            try {
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                self::$_instance = new PDO('mysql:host=localhost;dbname=db_bps', "root", "", $pdo_options);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$_instance;
    }


    public function addTransaction($dateCompete){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `transaction`( `dateCompete`) VALUES (?)') ;
        $i = $stmt->execute(array($dateCompete));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }

    public function addCompteTransaction($numcompte,$codeTransaction){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `compte_has_transaction`(`Compte_numCompte`, `Transaction_codeTransaction`) VALUES (?,?)') ;
        $i = $stmt->execute(array($numcompte,$codeTransaction));

    }
    public function getCodeTransaction($dateCompete){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('SELECT `codeTransaction` FROM `transaction` WHERE dateCompete = ?') ;
        $i = $stmt->execute(array($dateCompete));
        return $stmt->fetchColumn();
    }

    public function addUsedCodePaiment($code,$dateUtilisation,$numRecepteur,$codeTransaction){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `codepaiementutilises`(`code`, `dateUtilisation`, `numRecepteur`, `codeTransaction`) VALUES (?,?,?,?)') ;
        $i = $stmt->execute(array($code,$dateUtilisation,$numRecepteur,$codeTransaction));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }
}    