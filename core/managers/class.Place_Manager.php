<?php	
    include_once(dirname(__FILE__). "/class.DB_Acces.php");
    include_once(dirname(__FILE__). "/business/class.place.php");
    include_once(dirname(__FILE__). "/../treatments/class.Log.php");

    class Place_Manager{

        private $DB_acces;
        private $userId;
        private $arborescence;
        
        public function __construct($userId, $arborescence){
                //--initialisation des attibuts
                $this->DB_acces = new DB_Acces();
                $this->userId = $userId;
                $this->arborescence = $arborescence;
        }
        
        public function getAllPlaces(){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT lieu.IdLieu, lieu.NomLieu, lieu.LocalisationGPS ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Lieu lieu";

            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Place(utf8_encode($res['IdLieu']),
                                        utf8_encode($res['NomLieu']),
                                        utf8_encode($res['LocalisationGPS']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            if(!isset($retour)){
                $retour[] = "aucun_lieu";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function getPlaceByName($nomLieu){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            //$retour = 'nonInit';

            //--Construction de la requete
            $sql = "SELECT lieu.IdLieu, lieu.NomLieu, lieu.LocalisationGPS ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Lieu lieu ".
                    "WHERE lieu.NomLieu = '".utf8_decode($nomLieu)."'";

            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Place(utf8_encode($res['IdLieu']),
                                    utf8_encode($res['NomLieu']),
                                    utf8_encode($res['LocalisationGPS']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            if(!isset($retour)){
                $retour = "inexistant";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function addPlace($name, $coord){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "INSERT INTO ".$this->DB_acces->getPrefixTables()."Lieu ( IdLieu , NomLieu , LocalisationGPS ) ".
                    "VALUES ('', '".utf8_decode($name)."', '".$coord."')";
            
            //--Ex�cution
            $req = mysql_query($sql);
            if($req == '1'){
                $retour = "insertionOk";
                Log::ajoutLigneBDD($this->userId, "Ajout lieu", $sql, $this->arborescence);
            }
            else {
                $retour = "insertionKo";
                Log::ajoutLigneBDD($this->userId, "Erreur ajout lieu", $sql, $this->arborescence);
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();

            return $retour;
        }
    }
