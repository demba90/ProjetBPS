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
    public function addWaitCodePaiment($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction){
        $bdd =  DAO::getInstance();
        $stmt = $bdd->prepare('INSERT INTO `codepaiementattentes`(`code`, `numEmeteur`, `echeance`, `cniEmeteur`, `codeTransaction`) VALUES (?,?,?,?,?)') ;
        $i = $stmt->execute(array($code,$numEmeteur,$echeance,$cniEmeteur,$codeTransaction));
        //print_r($stmt->fetchColumn()) ; 
        return $i;
    }
}    