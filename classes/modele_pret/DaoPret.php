<?php

class DaoPret extends PDO
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
}

?>