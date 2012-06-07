<?php
    session_start();
    include_once(dirname(__FILE__). "/../../core/presenters/administration/pictureAdministration/class.setOrderToPicture_Presenter.php");

    $pres = unserialize($_SESSION["setOrder_pres"]);

    //--Récupération de informations
    if($_POST['nav'] == 'getAllBadPics'){
        
        $pics = $pres->getPicturesWithoutOrder();
        
        if($pics[0] == "aucune_image" ){
            $retour = "aucune_image";
        }else{
            $retour = array(array());
            $i = 0;
            foreach ($pics as $pic) {
                $dateExplode = explode(" ", $pic->getDatePriseVue());
                $dateExplode2 = explode("-", $dateExplode[0]); //--Formattage date
                $jour = $dateExplode2[2];
                $mois = $dateExplode2[1];
                $an = $dateExplode2[0];
                $dateAffich = $jour."-".$mois."-".$an;

                $retour[$i]['date'] = $dateAffich; 
                $retour[$i]['util'] = $pic->getUtilisateur();
                $retour[$i]['lieu'] = $pic->getLieu();
                $retour[$i]['id'] = $pic->getId();
                $retour[$i]['chem'] = $pic->getNomFichier();

                $i++;
            }
        }
        $_SESSION["setOrder_pres"] = serialize($pres);
        echo json_encode($retour);
    }
    
    //--Suppression d'une image
    if($_POST['nav'] == 'getAllOrders'){
        
        $orders = $pres->getOrderList();
        $retour = array(array());
        
        for($i = 0; $i < count($orders); $i++){
            $retour[$i]['id'] = $orders[$i]->getId();
            $retour[$i]['nom'] = $orders[$i]->getNom();
        }

        $_SESSION["setOrder_pres"] = serialize($pres);
        echo json_encode($retour);
    }
    
    //--Suppression d'une image
    if($_POST['nav'] == 'deleteImage'){
        
        $retour = $pres->deletePic($_POST['img'], $_POST['chem']);

        $_SESSION["setOrder_pres"] = serialize($pres);
        echo json_encode($retour);
    }
    
    //--Ajout d'un nouvel ordre
    if($_POST['nav'] == 'validOrder'){
        
        $retour = $pres->newOrder($_POST['imgId'], $_POST['orderId']);

        $_SESSION["setOrder_pres"] = serialize($pres);
        echo json_encode($retour);
    }
?>