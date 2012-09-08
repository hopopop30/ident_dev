<?php
    session_start();
    include_once(dirname(__FILE__). "/../../core/presenters/administration/userAdministration/class.userAdministration_Presenter.php");

    $pres = unserialize($_SESSION["useradmin_pres"]);

    //--Récupération de informations
    if($_POST['nav'] == 'modif'){
        
        $id = $_POST['id'];
        $login = $_POST['login'];
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $site = $_POST['site'];
        $dpt = $_POST['dep'];
        $actif = $_POST['check'];
        $admin = $_POST['check2'];
        
        $pres->modifyUser($id, $login, $email, $nom, $prenom, $site, $dpt, $actif, $admin);
        
        $_SESSION["useradmin_pres"] = serialize($pres);
        echo json_encode("Ok");
    }
    
    //--Suppression d'une image
    if($_POST['nav'] == 'delete'){
        
        $id = $_POST['id'];
        $pres->deleteUser($id);
        
        $_SESSION["useradmin_pres"] = serialize($pres);
        echo json_encode("Ok");
    }
?>