<meta charset="utf-8"/>
<?php
	include("../classes/model_paiement/PaiementObjet.php");

	//Note importante: Pour parler plus généralement on dira toujours client au lieu de client
	setlocale (LC_TIME, 'fr_FR.utf8','fra');  
	 //la fonction setlocale avec ces paramétres permet d'avoir la date compléte en Français.
    $date = strftime('%A %d %B %Y, %H:%M:%S'); //on recupére la date ici
	$sender = $_GET["sender"]; // le numero de l'emeteur
	//$sender = "+221777162478";
	$message = $_GET["text"];// on recupére le message du client. 

	$paiementObjet = new PaiementObjet();
	$paiementObjet->demanderCodePaiement($message,$date,$sender);

	
?>
+