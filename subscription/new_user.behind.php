<?php
	session_start();
	include_once(dirname(__FILE__). "/../core/presenters/subscription/class.NewUser_Presenter.php");
	if($_POST['nav'] == 'inscription'){
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$mail = $_POST['mail'];
		$site = $_POST['site'];
		$dpt = $_POST['dpt'];
		$photo = $_POST['photo'];
		
		$pres = unserialize($_SESSION["newuser_pres"]);
                 
		$isOk = $pres->verifyNewUser($login, $mail, $photo);
		
		if($isOk == "Ok"){
			$pres->addUser($login, $mdp, $nom, $prenom, $mail, $site, $dpt, $photo);
		}
		
		$_SESSION["newuser_pres"] = serialize($pres);
		echo json_encode($isOk);
	}
	
	if($_POST['nav'] == 'envoiMail'){
		$pres = unserialize($_SESSION["newuser_pres"]);
		
		//--R�cup�ration des valeur pass�es en post
		$log = $_POST['log'];
		$mdp = $_POST['mdp'];
		$mail = $_POST['mail'];
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		
		$pres->sendConfirmMail($log, $mdp, $mail, $nom, $prenom);
		
		$_SESSION["newuser_pres"] = serialize($pres);
		echo json_encode("mailSended");
	
	}
	
?>