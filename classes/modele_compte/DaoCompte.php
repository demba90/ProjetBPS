<?php

/**
 * Created by PhpStorm.
 * User: thiam
 * Date: 22/05/2015
 * Time: 17:36
 */
class DaoCompte extends PDO
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

    public  function authentification($numCompte,$password){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT COUNT(*) FROM Compte WHERE numcompte = ? AND password = ?') ;
        $i = $stmt->execute(array($numCompte,$password));
        $i = $stmt->fetchColumn(0);
        return $i ;

    }

    public function getSolde($numCompte){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT solde FROM Compte WHERE numCompte = ?') ;
        $i = $stmt->execute(array($numCompte));
        $i = $stmt->fetchColumn(0);
        return $i ;
    }

    public function getSeuilMinimal($numCompte){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT seuilMin FROM Compte WHERE numCompte = ?') ;
        $i = $stmt->execute(array($numCompte));
        $i = $stmt->fetchColumn(0);
        return $i ;
    }

    public function getNom($numCompte){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT nomProprietaire FROM Compte WHERE numCompte = ?') ;
        $i = $stmt->execute(array($numCompte));
        //print_r($stmt->fetchColumn()) ; 
        return $stmt->fetchColumn();
    }
    public function getPrenom($numCompte){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT prenomProprietaire FROM Compte WHERE numCompte = ?') ;
        $i = $stmt->execute(array($numCompte));
        //print_r($stmt->fetchColumn()) ; 
        return $stmt->fetchColumn();
    }

    public function getCni($numCompte){
        $bdd =  DaoCompte::getInstance();
        $stmt = $bdd->prepare('SELECT numeroCNI FROM Compte WHERE numCompte = ?') ;
        $i = $stmt->execute(array($numCompte));
        //print_r($stmt->fetchColumn()) ; 
        return $stmt->fetchColumn();
    }
}    