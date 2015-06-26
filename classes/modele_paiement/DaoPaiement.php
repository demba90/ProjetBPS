<?php

/**
 * Created by PhpStorm.
 * User: thiam
 * Date: 22/05/2015
 * Time: 17:36
 */
class DaoPaiement extends PDO
{
    private static $_instance;

    // constructeur par défaut
    public function __construct()
    {

    }

    /**
     * Cette méthode permet d'avoir une instance de la base de données
     * @return PDO
     */
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
    public function addWaitCodePaiment($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `CodePaiementUtilises`(`code`, `dateUtilisation`, `numRecepteur`, `codeTransaction`) VALUES (?,?,?,?,?)') ;
        $i = $stmt->execute(array($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }
}    