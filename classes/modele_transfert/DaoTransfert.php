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
                self::$_instance = new PDO('mysql:host=localhost;dbname=db_bps', "root", "passer", $pdo_options);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$_instance;
    }

    /**
     * @param $dateCompete
     * @param $type
     * @param $montant
     * @return bool
     */
    public function addTransaction($dateCompete,$type,$montant){
        $bdd =  DaoTransfert::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `Transaction` (`dateCompete`, `typeTransaction`, `montantTransaction`) VALUES  (?,?,?)') ;
        $i = $stmt->execute(array($dateCompete,$type,$montant));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }

    /**
     * @param $numcompte
     * @param $codeTransaction
     */
    public function addCompteTransaction($numcompte,$codeTransaction){
        $bdd =  DaoTransfert::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `Compte_has_Transaction`(`Compte_numCompte`, `Transaction_codeTransaction`) VALUES (?,?)') ;
        $i = $stmt->execute(array($numcompte,$codeTransaction));

    }

    /**
     * @param $dateCompete
     * @return string
     */
    public function getCodeTransaction($dateCompete){
        $bdd =  DaoTransfert::getInstance();
        $stmt = $bdd->prepare('SELECT `codeTransaction` FROM `Transaction` WHERE dateCompete = ?') ;
        $i = $stmt->execute(array($dateCompete));
        return $stmt->fetchColumn();
    }

    /**
     * Cette méthode permet d'enregistrer les codes de paiements utilisé avec les detailles pour le retracer
     * @param $code
     * @param $dateUtilisation
     * @param $numRecepteur
     * @param $codeTransaction
     * @return bool
     */
    public function addUsedCodePaiment($code,$dateUtilisation,$numRecepteur,$codeTransaction){
        $bdd =  DaoTransfert::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `CodePaiementUtilises`(`code`, `dateUtilisation`, `numRecepteur`, `codeTransaction`) VALUES (?,?,?,?)') ;
        $i = $stmt->execute(array($code,$dateUtilisation,$numRecepteur,$codeTransaction));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }
}    