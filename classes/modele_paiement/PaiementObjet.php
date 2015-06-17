<?php
    require 'DaoPaiement.php';
    require '../modele_compte/DaoCompte.php';
    require '../modele_transfert/DaoTransfert.php';
    /**
    * 
    */
    class PaiementObjet 
    {
        
        function __construct(argument)
        {
            # code...
        }
    

        /*
        *Cette fonction permet de lire le message du client.
        *Elle vérifiera (en scénario normal):
        *1: si la syntaxe est respectée
        *2: si le numéro de compte et le password exsitent dans la base de données
        *3: si le solde restant moins le seuil minimal est inférieur au montant solicité par le client.
        * A chaque fois qu'un test n'est pas vérifier la fonction arréte et notifie le client la cause de l'échec.
        */
        function demanderCodePaiement($message,$date,$sender){
            //1: Vérification de la syntaxe. La bonne a le format pm#numCompte#password#montant
            $tabMessage = explode("#", $message); // count($tabMessage) permet d'avoir la taille du tableau
            if (count($tabMessage) != 4 ) {
                echo "Merci de vérifier la syntaxe de votre message. BPS la banque pour tous. www.bps.com"; //100 caractères
            }else{
                $daoPaiement = new DaoPaiement();
                $daoCompte = new DaoCompte();
                $daoTransfert = new DaoTransfert();
                //2: vérification de l'authentificiter des informations donnée OC Origine Client
                $auth = $daoCompte -> authentification($tabMessage[1],$tabMessage[2]);
                $solde = $daoCompte -> getSolde($tabMessage[1]);
                $seuilMin = $daoCompte -> getSeuilMinimal($tabMessage[1]);
                $cni = $daoCompte -> getCni($tabMessage[1]);
                $tabName = strtoupper($daoCompte->getPrenom($tabMessage[1]))." ".$daoCompte->getNom($tabMessage[1]);
                $montant = intval($tabMessage[3]);
                if( $auth != 1 ){
                    echo "Merci de vérifier les informations données. BPS la banque pour tous."; //68 caractères
                }
                elseif (($solde - $montant) < $seuilMin) {
                    //3: Vérification du montant
                    echo "Mr(Mmd) ".$tabName." votre solde est insuffisant pour effectuer cet opération. Veuillez créditer votre compte."; //110 caractères
                }else{
                    //tout ce passe bien le client est bien identifié. Il reste à générer un code de paiement et véfirier
                    // s'il n'est ni en attente ni déja utilisé
                    //Si oui on lui envoie ça et l'écheance de 30 jours
                    //on mettra dans solde virtuel le solde actuel moins le montant 
                    $code = generateCode();
                    //$daoTransfert ->addTransaction($date);
                    //$codeTr = intval($daoTransfert->getCodeTransaction($date));
                    //$daoTransfert->addCompteTransaction($tabMessage[1],$codeTr);
                    //$daoPaiement ->addWaitCodePaiment($code,$sender,"30 jours",$cni,$codeTr);
                    echo "Votre code est '".$code."' et a une validité de ".strtoupper("30 jours").". La BPS vous remercie de votre fidéliter"; //126 caracètes
                    
                }
            }
        }   

        function generateCode($length = 14) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    }

?>