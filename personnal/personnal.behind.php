<?php
    session_start();
    include_once(dirname(__FILE__). "/../core/presenters/personnal/class.Personnal_Presenter.php");
    if($_POST['nav'] == 'modification'){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $site = $_POST['site'];
        $dpt = $_POST['dpt'];
        $photo = $_POST['photo'];

        $pres = unserialize($_SESSION["personnal_pres"]);

        $isOk = $pres->userModification($nom, $prenom, $site, $dpt, $photo);

        $_SESSION["personnal_pres"] = serialize($pres);
        echo json_encode($isOk);
    }
?>