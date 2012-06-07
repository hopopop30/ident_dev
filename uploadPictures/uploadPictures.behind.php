<?php
    session_start();
    include_once(dirname(__FILE__). "/../core/presenters/uploadpictures/class.UploadPictures_Presenter.php");
    include_once(dirname(__FILE__). "/../core/managers/business/class.place.php");
    $pres = unserialize($_SESSION['uploadPics_pres']);
    
    //--Récupération de l'utilisateur connecté
    if($_POST['nav'] == 'recupFolder'){
        
        //--Création du dossier et récupération de son nom
        $retour = $pres->createAndReturnFolder();
        
        $_SESSION['uploadPics_pres'] = serialize($pres);
        
        //--Retour
        echo json_encode($retour);
    }

    else if($_POST['nav'] == 'uploadCompleted'){
        $ordre = $_POST['ordre'];
        $date = $_POST['date'];
        $lieu = $_POST['lieu'];
        $nbrPhotos = $_POST['nbrPhotos'];
        $tempFolder = $_POST['tempFolder'];

        //--Traitement des photos, déplacement + copy/paste
        $retour = $pres->traitementPhotosDepot($ordre, $date, $lieu, $nbrPhotos, "");
        
        //$_SESSION['uploadPics_pres'] = serialize($pres);
        //--Retour
        echo json_encode($retour);
    }
    
    else if ($_POST['nav'] == 'autocompleteLieu'){
        $places = $pres->getPlaceList();
        $retour = array();
        foreach($places as $nomLieu){
            $retour[] = $nomLieu->getNom();
        }
        
        //--Retour
        echo json_encode($retour);
    }
?>