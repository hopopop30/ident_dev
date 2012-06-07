<?php

include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
include_once(dirname(__FILE__). "/../../managers/class.Order_Manager.php");
include_once(dirname(__FILE__). "/../../managers/class.Place_Manager.php");
include_once(dirname(__FILE__). "/../../managers/class.Picture_Manager.php");
include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
include_once(dirname(__FILE__). "/../../treatments/class.Log.php");

class UploadPictures_Presenter {
    private $repOrig;
    private $repDest;
    private $repTemp;
    private $nbrPhotos;
    private $listePhotosOrig;
    private $listePhotosFinale;
    private $login;
    private $listExtensions;
    
    private $param_manager;
    private $order_manager;
    private $place_manager;
    private $picture_manager;
    private $user_manager;

    //public function UploadPictures_Presenter($repOrig, $repDest, $nbrPhotos, $login, $extensions){
    public function UploadPictures_Presenter($userId, $login){
        
            
            $this->param_manager = new Parameters_Manager();
            $this->order_manager = new Order_Manager($userId, "../");
            $this->place_manager = new Place_Manager($userId, "../");
            $this->picture_manager = new Picture_Manager($userId, "../");
            $this->user_manager = new User_Manager($userId, "../");
            
            $user = $this->user_manager->getUser($login);
            
            $this->repOrig = $this->param_manager->getTempDirectory();
            $this->repTemp = $this->param_manager->getTempDirectory();
            $this->repDest = $this->param_manager->getPicturesDirectory();
            $this->listePhotosOrig = array();
            $this->listePhotosFinale = array();
            $this->login = $login;
            $this->listExtensions = $this->param_manager->getLegalsExtensions();
            
            Log::ajoutLignePage($user->getId(), "Upload Picture", "../");
    }
    
    public function getRepOrig(){ return $this->repOrig; }
    //public function getListExtensions() { return $this->listExtensions; }

    public function getUserPictureDirectory(){
        return $this->param_manager->getUserPictureDirectory();
    }
                
    public function createAndReturnFolder(){
        $time = time()."";
        if(@mkdir ("../".$this->repOrig."depotTempo_".$this->login."_".date('Y-m-d')."_".$time,0777,true)){
            $this->repTemp = "../".$this->repOrig."depotTempo_".$this->login."_".date('Y-m-d')."_".$time;
            return "../".$this->repOrig."depotTempo_".$this->login."_".date('Y-m-d')."_".$time;
        }			
        else return "erreurCreationDir";
    }
    
    public function getOrderList(){
        
        return $this->order_manager->getAllOrders();
    }
    
    public function getPlaceList(){
        
        return $this->place_manager->getAllPlaces();
    }
    
    public function traitementPhotosDepot($ordre, $date, $lieu, $nbrPhotos, $coordonneesLieu){
        $this->nbrPhotos = $nbrPhotos;
        //--erreurs: 0->recup, 1->renommage, 2->copié/collé, 3->supression originaux, 4->Enregistrement en base de données
        $erreur = array();

        //$traitement = new TraitementUploadPhoto("../".$tempFolder, "../".$this->repFinal, $nbrPhotos, $this->user->getLogin(), $this->listExtensions);

        //---Récupération des fichiers
        $erreur[0] = $this->recuperationFichiers();

        //---Renommer des fichiers
        $erreur[1] = $this->renommerFichiers();

        //---Copier/coller des fichiers
        $erreur[2] = $this->copierCollerFichiers();

        //--Suppression des fichiers et dossier originaux
        $erreur[3] = $this->supressionDossierOrig();

        //--Récupération de la liste des photos finales
        $photos = $this->getCheminPhotosFinales();
        
        //--Récupération des ID
        $ordreSel = $this->order_manager->getOrderByName($ordre);
        
        $lieuSel = $this->place_manager->getPlaceByName($lieu);
        //--Gestion du lieu inexistant
        if($lieuSel == "inexistant"){
            $this->place_manager->addPlace($lieu, "");
            $lieuSel = $this->place_manager->getPlaceByName($lieu);
        }
        
        $user = $this->user_manager->getUser($this->login);
 
        //--Gestion du format de la date
        list($jour, $mois, $annee) = explode("-", $date);
        $formatDate = $annee."-".$mois."-".$jour;
        
        $compteur = 0;
        //--Insertion de chacunes des photos
        foreach($photos as $photo){
            $this->picture_manager->addPicture($lieuSel->getId(), $ordreSel->getId(), $photo, $formatDate, $user->getId());
            $compteur++;
        }
        $erreur[4] = $nbrPhotos - $compteur;

        return $erreur;
    }
    
    //--Fonctions privée ------------------------------------------------------
    private function getCheminPhotosFinales(){
        $retour = array();
        foreach($this->listePhotosFinale as $photo){
            $retour[] = $photo;
            //$retour[] = $this->repDest."/".$photo;
        }
        return $retour;
    }

    //--Retourne un tableau dimension1:entier nombre d'erreur dimension2:la liste des fichiers
    private function recuperationFichiers(){
        //--Ouvre le dossier
        if($dir = opendir($this->repTemp)) {
           
            while(false !== ($file = readdir($dir))){
                foreach($this->listExtensions as $extension){
                    //--Vérifie pour toutes les extensions autorisées
                    if(preg_match("/.".$extension."/i", $file) && $file != "." && $file != ".."){
                            $this->listePhotosOrig[] = $file;
                    }
                }
            }
            closedir($dir);
            return $this->nbrPhotos - count($this->listePhotosOrig);
        }
        else return "erreurOuvertureDossier";
    }

    private function renommerFichiers(){
        $i = 0;
        $compteur =0;
        foreach($this->listePhotosOrig as $fichier){
            $ext = pathinfo($this->repTemp."/".$fichier, PATHINFO_EXTENSION);
            $nom = $this->login."_".date('Y-m-d')."_".time()."_".$i.".".$ext;
            if(rename($this->repTemp."/".$fichier, $this->repTemp."/".$nom)) {

                $this->listePhotosFinale[$i] = $nom;
                $compteur++;
            }
            else $this->listePhotosFinale[$i] = "erreur";
            $i++;
        }
        return count($this->listePhotosOrig) - $compteur;
    }

    private function copierCollerFichiers(){
        $compteur = 0;

        foreach($this->listePhotosFinale as $fichier){
            if(copy($this->repTemp."/".$fichier, "../".$this->repDest."/".$fichier)){
                $compteur++;
            }				
        }
        return count($this->listePhotosFinale) - $compteur;
    }

    private function supressionDossierOrig(){
        $compteur = 0;

        foreach($this->listePhotosFinale as $fichier){
            if(!unlink($this->repTemp."/".$fichier)){
                $compteur++;
            }	
        }
        if(!rmdir($this->repTemp)){
            $compteur = "erreurEffacementDossier";
        }
        return $compteur;
    }
    //--------------------------------------------------------------------------
}
