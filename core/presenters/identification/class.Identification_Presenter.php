<?php	
    include_once(dirname(__FILE__). "/../../managers/class.Picture_Manager.php");
    include_once(dirname(__FILE__). "/../../managers/class.Order_Manager.php");
    include_once(dirname(__FILE__). "/../../managers/class.Identification_Manager.php");
    include_once(dirname(__FILE__). "/../../managers/class.User_Manager.php");
    include_once(dirname(__FILE__). "/../../treatments/class.emailSender.php");
    include_once(dirname(__FILE__). "/../../managers/class.Parameters_Manager.php");
    include_once(dirname(__FILE__). "/../../treatments/class.Log.php");

    class Identification_Presenter{

        private $identification_manager;
        private $picture_manager;
        private $order_manager;
        private $user_manager;
	private $param_manager;
        private $userId;
        private $orderId;
        private $picturesList;
        private $cursor;
        
        private $sel_supFam;
        private $sel_fam;
        private $sel_sousFam;
        private $sel_tribu;
        private $sel_genre;
        private $sel_sousGenre;
        private $sel_Espece;
        private $sel_descriteur;
        private $sel_annee;
        private $sel_nomVernaculaire;
        
        
        private $emptyFolder;

        public function Identification_Presenter($idOrdre, $userId){
                //--initialisation des attibuts
                $this->identification_manager = new Identification_Manager($userId, $idOrdre, "../");
                $this->picture_manager = new Picture_Manager($userId, "../");
                $this->order_manager = new Order_Manager($userId, "../");
                $this->user_manager = new User_Manager($userId, "../");
                $this->param_manager = new Parameters_Manager();
                $this->picturesList = array(); 
                $this->cursor = 0;
                $this->userId = $userId;
                $this->orderId = $idOrdre;
                $this->emptyFolder = false;
                //--Cahrgement de toutes les photos
                $this->getAllPictures(false);
                
                Log::ajoutLignePage($userId, "Identification", "../");
        }
        
        public function getUserPictureDirectory(){
            return $this->param_manager->getUserPictureDirectory();
        }
        public function getSiteAddress(){
            return $this->param_manager->getAdresseSite();
        }
        public function getPictureDir(){
            return $this->param_manager->getPicturesDirectory();
        }
        
        //--Gestion des images
        public function getCurrentNumber(){ 
            return $this->cursor+1; 
        }
        public function getPhotoNumber(){ 
            return count($this->picturesList);
        }
        
        public function getAllPictures($filtreVue){
            $this->emptyFolder = false;
            
            $this->picturesList = $this->picture_manager->getAllPicture($this->orderId, $filtreVue, $this->userId);
            //print_r($this->picturesList);
            //--Dans le cas ou il n'y aurait plus de photo
            if($this->picturesList[0] == "aucune_image"){
                $this->emptyFolder = true;
            }
            $this->cursor = 0;
        }
        
        public function getCurrentPic(){ 
            //--Vérifie si un acces concurrent n'a pas identifié la photo
            if($this->emptyFolder == false){
                if($this->picture_manager->getIfPictureIsIdentified($this->picturesList[$this->cursor]->getId()) == 1){
                    $this->picturesList[$this->cursor]->setIdentifiee(1);
                }
                $this->picture_manager->addViewedPicture($this->picturesList[$this->cursor]->getId(), $this->userId);
                return $this->picturesList[$this->cursor]; 
            }
            else {
                return "empty";
            }
        }
        
        public function getNextPic(){
            //--Vérifie si un acces concurrent n'a pas identifié la photo
            if($this->emptyFolder == false){
                if($this->picture_manager->getIfPictureIsIdentified($this->picturesList[$this->cursor]->getId()) == 1){
                    $this->picturesList[$this->cursor]->setIdentifiee(1);
                }

                if($this->cursor != count($this->picturesList) - 1){
                    $this->cursor++;
                }
                else $this->cursor = 0;
            }
            return $this->getCurrentPic();              
        }
        
        public function getprevPic(){
            //--Vérifie si un acces concurrent n'a pas identifié la photo
            if($this->emptyFolder == false){
                if($this->picture_manager->getIfPictureIsIdentified($this->picturesList[$this->cursor]->getId()) == 1){
                    $this->picturesList[$this->cursor]->setIdentifiee(1);
                }

                if($this->cursor != 0){
                    $this->cursor--;
                }
                else $this->cursor = count($this->picturesList) - 1;
            }
            return $this->getCurrentPic();            
        }

        //--Gestion de l'identification
        public function getSuperFamilleList(){
            return $this->identification_manager->getSuperFamilleList();
        }
        //--Gestion de l'identificationgetSuperFamilleList
        public function getFamilleAloneList(){
            return $this->identification_manager->getFamilleAloneList();
        }
        //--Gestion de l'identification
        public function getFamilleList($idSupFam){
            $this->sel_supFam = $idSupFam;
            return $this->identification_manager->getFamilleList($this->sel_supFam);
        }
        
        public function getSuperFamilleFromFamilleList($idFam){
            $this->sel_fam = $idFam;
            return $this->identification_manager->getSuperFamilleFromFamilleList($this->sel_fam);
        }
        
        public function getSousFamilleList($idFam, $idSupFam){
            $this->sel_fam = $idFam;
            $this->sel_supFam = $idSupFam;
            return $this->identification_manager->getSousFamilleList($this->sel_fam, $this->sel_supFam);
        }
        
        public function getTribuList($idSousFam){
            $this->sel_sousFam = $idSousFam;
            return $this->identification_manager->getTribuList($this->sel_supFam, $this->sel_fam, $this->sel_sousFam);
        }
        
        public function getGenreList($idTribu){
            $this->sel_tribu = $idTribu;
            //echo $this->sel_tribu;
            return $this->identification_manager->getGenreList($this->sel_supFam, $this->sel_fam, $this->sel_sousFam, $this->sel_tribu);
        }
        
        public function getSousGenreList($idGenre){
            $this->sel_genre = $idGenre;
            return $this->identification_manager->getSousGenreList($this->sel_supFam, $this->sel_fam, $this->sel_sousFam, $this->sel_tribu, $this->sel_genre);
        }
        
        public function getEspeceList($idSousGenre){
            $this->sel_sousGenre = $idSousGenre;
            return $this->identification_manager->getEspeceList($this->sel_supFam, 
                                                                    $this->sel_fam, 
                                                                    $this->sel_sousFam, 
                                                                    $this->sel_tribu, 
                                                                    $this->sel_genre,
                                                                    $this->sel_sousGenre);
        }
        
        public function getInfosEspece($idEspece){
            $this->sel_Espece  = $idEspece;
            return $this->identification_manager->getEspece($this->sel_Espece);
        }
        
        public function badOrder(){
            //--Récupération de l'objet image correspondant
            $photo = $this->picturesList[$this->cursor];
            //--Récupération de l'objet ordre correspondant
            $adminIds = $this->order_manager->getAdministrateurByOrders($this->orderId);
            $admins = array();
            foreach($adminIds as $id){
                $admins[] = $this->user_manager->getUserById($id);
            }
            
            //--Mise de l'ordre de l'image à 0
            if($this->picture_manager->setBadOrder($photo->getId()) == "updateOk"){
            
                $photo->setOrdre(0);
                $photo->setIdentifiee(1); //--Juste l'objet
                
                $adresseSite = $this->param_manager->getAdresseSite();
                $ordre = $this->order_manager->getOrderById($this->orderId);

                //--Envoi de l'email aux responsables de l'ordre
                foreach($admins as $admin){
                    $body = "Bonjour ".$admin->getNom()." ".$admin->getPrenom().", \n".
                            "La photo présente dans l'email à étée identifiée comme ne faisant pas parti de l'ordre ".$ordre->getNom().".\n".
                            "Vous pourrez retrouver cette image pour lui assigner un nouvel ordre depuis le menu d'administration sur ".$adresseSite." \n\n".
                            "Merci et à bientot\n".
                            "L'équipe d'identificator\n";

                EmailSender::SendWithPJ("Identificator-Admin: Photo de mauvais ordre", $admin->getEmail(), $body, "../photos/identification/".$photo->getNomFichier());
                }

                //--Récupération de l'objet user du photographe
                $photographe = $this->user_manager->getUserById($photo->getIdUtilisateur());
                $dateExplode = explode(" ", $photo->getDatePriseVue());
                $dateAffich = $dateExplode[0];

                //--Envoi un email au phtographe
                $adresseSite = $this->param_manager->getAdresseSite();

                $body = "Bonjour ".$photographe->getNom()." ".$photographe->getPrenom().", \n".
                        "La photo présente dans l'email ajoutée le ".$photo->getDateDepot()." et correspondant à votre chasse du ".$dateAffich." à ".$photo->getLieu()." a étée identifiée comme ne faisant pas parti de l'ordre ".$ordre->getNom().".\n".
                        "Cette image sera prochainement attribuée à l'ordre auquel elle correspond \n".
                        "Vous serez alors prévenu par email de son déplacement \n\n".
                        "Merci et à bientot sur ".$adresseSite." \n".
                        "L'équipe d'identificator\n";

                EmailSender::SendWithPJ("Identificator: Photo de mauvais ordre", $admin->getEmail(), $body, "../photos/identification/".$photo->getNomFichier());
                return "Ok";
            }
            else return "Ko";
            
        }
        
        public function validation(){
            //--Récupration de l'objet image
            $photo = $this->picturesList[$this->cursor];
            
            //--Valide l'image
            if($this->picture_manager->identifyPicture($photo->getId()) == "updateOk"){
                
                $photo->setIdentifiee(1);
            
                //--Envoi de l'email au photographe responsable
                $photographe = $this->user_manager->getUserById($photo->getIdUtilisateur());
                $dateExplode = explode(" ", $photo->getDatePriseVue());
                $dateAffich = $dateExplode[0];

                $supFam = $this->identification_manager->getSuperFamilleById($this->sel_supFam);
                $fam = $this->identification_manager->getFamilleById($this->sel_fam);
                $sousFam =  $this->identification_manager->getSousFamilleById($this->sel_sousFam);
                $tribu = $this->identification_manager->getTribuById($this->sel_tribu);
                $genre = $this->identification_manager->getGenreByID($this->sel_genre);
                $sousGenre = $this->identification_manager->getSousGenreById($this->sel_sousGenre);
                $espece = $this->identification_manager->getEspece($this->sel_Espece);

                $adresseSite = $this->param_manager->getAdresseSite();
                $ordre = $this->order_manager->getOrderById($this->orderId);

                $body = "Bonjour ".$photographe->getNom()." ".$photographe->getPrenom().", \n".
                        "Votre photo déposée le ".$photo->getDateDepot().", correspondant à votre chasse du ".$dateAffich." à ".$photo->getLieu()." faisant parti de l'ordre ".$ordre->getNom()." a étée identifiée.\n".
                        "Elle fait parti de la superfamille : ".$supFam->getNom().", \n".
                        "de la famille : ".$fam->getNom().", \n".
                        "de la sous-famille : ".$sousFam->getNom().", \n".
                        "de la tribu : ".$tribu->getNom().", \n".
                        "du genre : ".$genre->getNom().", \n".
                        "du sous-genre : ".$sousGenre->getNom().", \n".
                        "de l'espece : ".$espece->getNomEspece().", \n\n".
                        "Merci et à bientot sur ".$adresseSite." \n".
                        "L'équipe d'identificator\n";

                EmailSender::SendWithPJ("Identificator: Photo identifiée", $photographe->getEmail(), $body, "../photos/identification/".$photo->getNomFichier());
                return "Ok";
            }
            else return "Ko";
        }
    }