<?php
	session_start();
	include_once(dirname(__FILE__). "/../core/presenters/identification/class.Identification_Presenter.php");
        
	$pres = unserialize($_SESSION["identification_pres"]);
        
        //--Gestion de l'identification
        if($_POST['nav'] == 'superFamille'){
            $supFamList = $pres->getSuperFamilleList();
            $retour = array(array());
            
            for($i = 0; $i < count($supFamList); $i++){
                $retour[$i]['id'] = $supFamList[$i]->getId();
                $retour[$i]['nom'] = $supFamList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        ////--Gestion de l'identification
        if($_POST['nav'] == 'superFamilleParFamille'){
            $supFamList = $pres->getSuperFamilleFromFamilleList($_POST['idFam']);
            $retour = array(array());
            
            for($i = 0; $i < count($supFamList); $i++){
                $retour[$i]['id'] = $supFamList[$i]->getId();
                $retour[$i]['nom'] = $supFamList[$i]->getNom();
            }
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'FamilleSeules'){
            $famList = $pres->getFamilleAloneList();
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'Famille'){
            $famList = $pres->getFamilleList($_POST['idFam']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'sousFamille'){
            $famList = $pres->getSousFamilleList($_POST['idFam'], $_POST['idSupFam']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'tribu'){
            if($_POST['idSousFam'] == "Aucun résultat" || $_POST['idSousFam'] == 'Sélectionnez'){
                $_POST['idSousFam'] = "";
            }
            $famList = $pres->getTribuList($_POST['idSousFam']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'genre'){
            if($_POST['idTribu'] == "Aucun résultat" || $_POST['idSousFam'] == 'Sélectionnez'){
                $_POST['idTribu'] = "";
            }
            $famList = $pres->getGenreList($_POST['idTribu']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'sousGenre'){
            if($_POST['idGenre'] == "Aucun résultat" || $_POST['idSousFam'] == 'Sélectionnez'){
                $_POST['idGenre'] = "";
            }
            $famList = $pres->getSousGenreList($_POST['idGenre']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNom();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'espece'){
            if($_POST['idSousGenre'] == "Aucun résultat" || $_POST['idSousFam'] == 'Sélectionnez'){
                $_POST['idSousGenre'] = "";
            }
            $famList = $pres->getEspeceList($_POST['idSousGenre']);
            $retour = array(array());
            
            for($i = 0; $i < count($famList); $i++){
                $retour[$i]['id'] = $famList[$i]->getId();
                $retour[$i]['nom'] = $famList[$i]->getNomEspece();
            }
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        if($_POST['nav'] == 'infos'){
            if($_POST['idEspece'] == "Aucun résultat" || $_POST['idEspece'] == 'Sélectionnez'){
                $_POST['idEspece'] = "";
            }
            $famList = $pres->getInfosEspece($_POST['idEspece']);
            $retour = array();
            
            //for($i = 0; $i < count($famList); $i++){
                $retour['id'] = $famList->getId();
                $retour['nomEspece'] = $famList->getNomEspece();
                $retour['Descripteur'] = $famList->getNomDescripteur();
                $retour['annee'] = $famList->getAnnee();
                $retour['nomVernaculaire'] = $famList->getNomVernaculaire();
            //}
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        //--Validation ----------------------------------------------------------
        if($_POST['nav'] == 'badOrder'){
            
            $retour = $pres->badOrder();
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        if($_POST['nav'] == 'valid'){
            
            $retour = $pres->Validation();
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
        }
        
        //--Gestion des images---------------------------------------------------
	if($_POST['nav'] == 'nextPic'){
		
            $picture = $pres->getNextPic();
            if($picture != "empty"){
                $retour['img'] = $picture->getNomFichier();
                $retour['lieu'] = $picture->getLieu();
                $retour['date'] = $picture->getDatePriseVue();
                $retour['ident'] = $picture->getIdentifiee();

                $dateExplode = explode(" ", $retour['date']);
                $dateExplode2 = explode("-", $dateExplode[0]); //--Formattage date
                $jour = $dateExplode2[2];
                $mois = $dateExplode2[1];
                $an = $dateExplode2[0];
                $dateAffich = $jour."-".$mois."-".$an; 
                $retour['date'] = $dateAffich;
                
                $retour['nbr'] = $pres->getCurrentNumber();
                $retour['total'] = $pres->getPhotoNumber();
            }
            else $retour = "empty";
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
	}
        
	if($_POST['nav'] == 'prevPic'){
		
            $picture = $pres->getPrevPic();
            if($picture != "empty"){
                $retour['img'] = $picture->getNomFichier();
                $retour['lieu'] = $picture->getLieu();
                $retour['date'] = $picture->getDatePriseVue();
                $retour['ident'] = $picture->getIdentifiee();

                $dateExplode = explode(" ", $retour['date']);
                $retour['date'] = $dateExplode[0];
                
                $retour['nbr'] = $pres->getCurrentNumber();
                $retour['total'] = $pres->getPhotoNumber();
            }
            else $retour = "empty";
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
	}
        
	if($_POST['nav'] == 'rechargerliste'){
            
            $filtreVueTexte = $_POST['nonVue'];
            
            if($filtreVueTexte == "true"){
                $filtreVue = true;
            }else $filtreVue = false;
            
            //--Change la liste
            $picture = $pres->getAllPictures($filtreVue);
            
            //--Récupère l'a image courante
            $picture = $pres->getCurrentPic();
                //print_r($picture);
            if($picture != "empty"){
                $retour['img'] = $picture->getNomFichier();
                $retour['lieu'] = $picture->getLieu();
                $retour['date'] = $picture->getDatePriseVue();
                $retour['dejaVue'] = $picture->getIdentifiee();

                $dateExplode = explode(" ", $retour['date']);
                $retour['date'] = $dateExplode[0];
                
                $retour['nbr'] = $pres->getCurrentNumber();
                $retour['total'] = $pres->getPhotoNumber();
            }
            else $retour = "empty";
            
            $_SESSION["identification_pres"] = serialize($pres);
            echo json_encode($retour);
	}
	
	
	
?>