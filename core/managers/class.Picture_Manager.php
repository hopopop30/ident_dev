<?php	
    include_once(dirname(__FILE__). "/class.DB_Acces.php");
    include_once(dirname(__FILE__). "/business/class.picture.php");
    include_once(dirname(__FILE__). "/../treatments/class.Log.php");

    class Picture_Manager{

        private $DB_acces;
        private $userId;
        private $arborescence;

        public function __construct($userId, $arborescence){
                //--initialisation des attibuts
                $this->DB_acces = new DB_Acces();
                $this->userId = $userId;
                $this->arborescence = $arborescence;
        }
        
        public function addPicture($idLieu, $idOrdre, $nomFichier, $datePriseVue, $utilisateur){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "INSERT INTO ".$this->DB_acces->getPrefixTables()."Image ( IdImage , NomFichier , DateDepot , DatePriseVue , IdUtilisateur , IdLieu , IdOrdre ) ".
                    "VALUES ('', '".$nomFichier."', now() , '".$datePriseVue."', '".$utilisateur."', '".$idLieu."', '".$idOrdre."')";
            
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "insertionOk";
                Log::ajoutLigneBDD($this->userId, "Ajout photo", $sql, $this->arborescence);
            }
            else {
                $retour = "insertionKo";
                Log::ajoutLigneBDD($this->userId, "Erreur Ajout photo", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
        public function getAllPicture($idOrdre, $noViewed, $userId){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();
            //--Pour toutes les photos
            if(!$noViewed){
                //--Construction de la requete
                $sql = "SELECT img.IdImage, ".
                                "img.NomFichier, ".
                                "img.DateDepot, ".
                                "img.DatePriseVue, ".
                                "img.IdUtilisateur, ".
                                "img.IdLieu, ".
                                "img.IdOrdre, ".
                                "ut.Nom, ut.Prenom, ".
                                "li.NomLieu, ".
                                "li.LocalisationGPS, ".
                                "ord.NomOrdre, ".
                                "ord.ImageOrdre, ".
                                "img.Identifiee ".
                        "FROM ".$this->DB_acces->getPrefixTables()."Image img,  ".
                            $this->DB_acces->getPrefixTables()."Utilisateur ut,  ".
                            $this->DB_acces->getPrefixTables()."Lieu li,  ".
                            $this->DB_acces->getPrefixTables()."Ordre ord ".
                        "WHERE img.IdOrdre = ".$idOrdre." ".
                        "AND ut.IdUtilisateur = img.IdUtilisateur ".
                        "AND li.IdLieu = img.IdLieu ".
                        "AND ord.IdOrdre = img.IdOrdre ".
                        "AND img.Identifiee = 0";
            }else{
            //--Pour toutes les photos non vues
                $sql = "SELECT img.IdImage, ".
                                "img.NomFichier, ".
                                "img.DateDepot, ".
                                "img.DatePriseVue, ".
                                "img.IdUtilisateur, ".
                                "img.IdLieu, ".
                                "img.IdOrdre, ".
                                "ut.Nom, ut.Prenom, ".
                                "li.NomLieu, ".
                                "li.LocalisationGPS, ".
                                "ord.NomOrdre, ".
                                "ord.ImageOrdre, ".
                                "img.Identifiee ".
                        "FROM ".$this->DB_acces->getPrefixTables()."Image img, ".
                            $this->DB_acces->getPrefixTables()."Utilisateur ut, ".
                            $this->DB_acces->getPrefixTables()."Lieu li, ".
                            $this->DB_acces->getPrefixTables()."Ordre ord ".
                        "WHERE img.IdOrdre = ".$idOrdre." ".
                        "AND ut.IdUtilisateur = img.IdUtilisateur ".
                        "AND li.IdLieu = img.IdLieu ".
                        "AND ord.IdOrdre = img.IdOrdre ".
                        "AND img.Identifiee = 0 ".
                        "AND (SELECT count(*) ".
                            "FROM ".$this->DB_acces->getPrefixTables()."WKParcours parc ".
                            "WHERE parc.IdUtilisateur = ".$userId." ".
                            "AND parc.IdImage = img.IdImage) = 0";
               
            }
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    
                    $retour[] = new Picture(utf8_encode($res['IdImage']),
                                            utf8_encode($res['IdLieu']),
                                            utf8_encode($res['IdOrdre']),
                                            utf8_encode($res['IdUtilisateur']),
                                            utf8_encode($res['NomFichier']),
                                            utf8_encode($res['DateDepot']),
                                            utf8_encode($res['DatePriseVue']),
                                            utf8_encode($res['Nom'])." ".utf8_encode($res['Prenom']),
                                            utf8_encode($res['NomLieu']),
                                            utf8_encode($res['LocalisationGPS']),
                                            utf8_encode($res['NomOrdre']),
                                            utf8_encode($res['ImageOrdre']),
                                            utf8_encode($res['Identifiee']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            if(count($retour) == 0){
                $retour[] = "aucune_image";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function getPicturesWithoutOrder(){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();
            
             $sql = "SELECT img.IdImage, ".
                                "img.NomFichier, ".
                                "img.DateDepot, ".
                                "img.DatePriseVue, ".
                                "img.IdUtilisateur, ".
                                "img.IdLieu, ".
                                "img.IdOrdre, ".
                                "ut.Nom, ut.Prenom, ".
                                "li.NomLieu, ".
                                "li.LocalisationGPS, ".
                                "img.Identifiee ".
                                "FROM ".$this->DB_acces->getPrefixTables()."Image img ".
                                "INNER JOIN ".$this->DB_acces->getPrefixTables()."Utilisateur ut ON ut.IdUtilisateur = img.IdUtilisateur ".
                                "INNER JOIN ".$this->DB_acces->getPrefixTables()."Lieu li ON li.IdLieu = img.IdLieu ".
                                "WHERE img.IdOrdre =0";
               
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    
                    $retour[] = new Picture(utf8_encode($res['IdImage']),
                                            utf8_encode($res['IdLieu']),
                                            utf8_encode($res['IdOrdre']),
                                            utf8_encode($res['IdUtilisateur']),
                                            utf8_encode($res['NomFichier']),
                                            utf8_encode($res['DateDepot']),
                                            utf8_encode($res['DatePriseVue']),
                                            utf8_encode($res['Nom'])." ".utf8_encode($res['Prenom']),
                                            utf8_encode($res['NomLieu']),
                                            utf8_encode($res['LocalisationGPS']),
                                            null,
                                            null,
                                            utf8_encode($res['Identifiee']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            if(count($retour) == 0){
                $retour[] = "aucune_image";
            }
            //--Retour du tableau
            return $retour;
            
        }
        
        public function addViewedPicture($picId, $userId){
            //--Connexion � la base
            $this->DB_acces->connexion();
            //--Vérifie que l'utilisateur n'ai pas déja identifié cette image
            $sql = "SELECT count(*) as nbr ".
                    "FROM ".$this->DB_acces->getPrefixTables()."WKParcours parc ".
                    "WHERE parc.IdUtilisateur = ".$userId." ".
                    "AND parc.IdImage = ".$picId." ";
            //--Ex�cution
            $req = mysql_query($sql);
            ////--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $nbr = $res['nbr'];
                }
            }
            if($nbr == '0'){
                //--Construction de la requete
                $sql = "INSERT INTO ".$this->DB_acces->getPrefixTables()."WKParcours ( IdUtilisateur , IdImage , DateParcours ) ".
                        "VALUES (".$userId.", ".$picId.", now())";
                //--Ex�cution
                $req = mysql_query($sql);
                if($req == '1'){
                    $retour = "insertionOk";
                    Log::ajoutLigneBDD($this->userId, "Ajout photo vue", $sql, $this->arborescence);
                }
                else {
                    $retour = "insertionKo";
                    Log::ajoutLigneBDD($this->userId, "Erreur Ajout photo vue", $sql, $this->arborescence);
                }
            }
            else{
                $retour = "insertionOk";
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
        public function identifyPicture($picId){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "UPDATE ".$this->DB_acces->getPrefixTables()."Image SET Identifiee = 1 WHERE IdImage = ".$picId." ";
           
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "updateOk";
                Log::ajoutLigneBDD($this->userId, "Photo identifiée", $sql, $this->arborescence);
            }
            else {
                $retour = "updateOk";
                Log::ajoutLigneBDD($this->userId, "Erreur photo identifiée", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
        public function getIfPictureIsIdentified($pictureId){
            ////--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = 'nonInit';
            
            $sql = "SELECT Identifiee ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Image ".
                    "WHERE IdImage = ".$pictureId." ";
            
            //--Ex�cution
            $req = mysql_query($sql);
            
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    
                    $retour =utf8_encode($res['identifiee']);
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            
            //--Retour du tableau
            return $retour;
        }
        
        public function setBadOrder($picId){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "UPDATE ".$this->DB_acces->getPrefixTables()."Image SET IdOrdre = 0 ".
                    "WHERE IdImage = ".$picId." ";
            
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "updateOk";
                Log::ajoutLigneBDD($this->userId, "Photo mauvais ordre", $sql, $this->arborescence);
            }
            else {
                $retour = "updateKo";
                Log::ajoutLigneBDD($this->userId, "Erreur photo mauvais ordre", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
        public function setNewOrder($picId, $orderId){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "UPDATE ".$this->DB_acces->getPrefixTables()."Image SET IdOrdre = ".$orderId." ".
                    "WHERE IdImage = ".$picId." ";
            
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "updateOk";
                Log::ajoutLigneBDD($this->userId, "Photo nouvel ordre", $sql, $this->arborescence);
            }
            else {
                $retour = "updateKo";
                Log::ajoutLigneBDD($this->userId, "Erreur photo nouvel ordre", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
        public function deletePic($idImg){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "DELETE FROM ".$this->DB_acces->getPrefixTables()."Image WHERE IdImage = ".$idImg." ";
            
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "supOk";
                Log::ajoutLigneBDD($this->userId, "Effacement photo", $sql, $this->arborescence);
            }
            else {
                $retour = "supKo";
                Log::ajoutLigneBDD($this->userId, "Erreur Effacement photo", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
        
    }
