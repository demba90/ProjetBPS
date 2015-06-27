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

    /**
     * Avec cette méthode on ajoute un nouveau code donné à un client dans la base de données. On y ajdoint le numéro de
     * carte national d'identité de l'emmeteur qui sera le coupon permettant de l'utiliser
     * @param $code
     * @param $numEmeteur
     * @param $echeance
     * @param $cniEmeteur
     * @param $codeTransaction
     * @return bool
     */
    public function addWaitCodePaiment($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction){
        $bdd =  DaoPaiement::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `CodePaiementAttentes`(`code`, `numEmeteur`, `echeance`, `cniEmeteur`, `codeTransaction`) VALUES (?,?,?,?,?)') ;
        $i = $stmt->execute(array($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }

    /**
     * Cette fonction est utilisé pour la génération des cheque. Elle permet de vérifier si
     * un cheque éléctronique certifié est déjà donné et en attente d'utilisation
     * @param $code
     * @return mixed
     */
    public function chequeOlder($code){
        $bdd =  DaoPaiement::getInstance();
        $stmt = $bdd->prepare('SELECT `code` FROM `CodePaiementAttentes` WHERE code = ?') ;
        $stmt->execute(array($code));
        $i = $stmt->fetch();
        return $i;
    }

    /**
     * De meme que la fonction en haut, on utilise, en paiement, cette fonction pour voir si
     * un cheque éléctronique certifié généré est déjà utilisé ou pas
     * @param $code
     * @return bool|mixed
     */
    public function chequeUsed($code){
        $bdd =  DaoPaiement::getInstance();
        $stmt = $bdd->prepare('SELECT `code` FROM `CodePaiementUtilises` WHERE code = ?') ;
        $i = $stmt->execute(array($code));
        $i = $stmt->fetch();
        return $i;
    }
}    