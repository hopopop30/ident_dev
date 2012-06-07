<?php	
    include_once(dirname(__FILE__). "/class.DB_Acces.php");
    include_once(dirname(__FILE__). "/business/class.ordre.php");
    include_once(dirname(__FILE__). "/../treatments/class.Log.php");

    class Order_Manager{

        private $DB_acces;
        private $userId;
        private $arborescence;

        public function __construct($userId, $arborescence){
                //--initialisation des attibuts
                $this->DB_acces = new DB_Acces();
                $this->userId = $userId;
                $this->arborescence = $arborescence;
        }
        
        public function getAllOrders(){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT ord.IdOrdre, ord.NomOrdre, ord.ImageOrdre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Ordre ord";

            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Ordre(utf8_encode($res['IdOrdre']),
                                        utf8_encode($res['NomOrdre']),
                                        utf8_encode($res['ImageOrdre']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            
            //--Initialise les administrateur des ordres
            foreach($retour as $ord){
                $ord->setIdAdminitstrateurs($this->getAdministrateurByOrders($ord->getId()));
            }
            
            if(!isset($retour)){
                $retour = "aucun_ordre";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function getOrderById($idOrdre){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            

            //--Construction de la requete
            $sql = "SELECT ord.IdOrdre, ord.NomOrdre, ord.ImageOrdre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Ordre ord ".
                    "WHERE ord.IdOrdre = ".$idOrdre." ";

            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Ordre(utf8_encode($res['IdOrdre']),
                                        utf8_encode($res['NomOrdre']),
                                        utf8_encode($res['ImageOrdre']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            
            //--Initialise les administrateur des ordres
            $retour->setIdAdminitstrateurs($this->getAdministrateurByOrders($retour->getId()));
            
            if(!isset($retour)){
                $retour = "aucun_ordre";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function getOrderByName($name){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT ord.IdOrdre, ord.NomOrdre, ord.ImageOrdre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Ordre ord ".
                    "WHERE ord.NomOrdre = '".utf8_decode($name)."' ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Ordre(utf8_encode($res['IdOrdre']),
                                        utf8_encode($res['NomOrdre']),
                                        utf8_encode($res['ImageOrdre']));
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            
            //--Initialise les administrateur des ordres
            $retour->setIdAdminitstrateurs($this->getAdministrateurByOrders($retour->getId()));
            
            if(!isset($retour)){
                $retour = "aucun_ordre";
            }
            //--Retour du tableau
            return $retour;
        }
        
        public function getAdministrateurByOrders($idOrdre){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT id.idUtilisateur ".
                    "FROM ".$this->DB_acces->getPrefixTables()."ParamProfilAdmin id ".
                    "WHERE id.idOrdre = ".$idOrdre." "; 
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = $res['idUtilisateur'];
                }
            }

            //--Fermeture de la base
            $this->DB_acces->deconnexion();
            
            //--Retour du tableau
            return $retour;
        }
    }
