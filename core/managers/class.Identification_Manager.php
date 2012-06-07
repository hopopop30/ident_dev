<?php	
    include_once(dirname(__FILE__). "/class.DB_Acces.php");
    include_once(dirname(__FILE__). "/business/class.superFamille.php");
    include_once(dirname(__FILE__). "/business/class.famille.php");
    include_once(dirname(__FILE__). "/business/class.sousFamille.php");
    include_once(dirname(__FILE__). "/business/class.tribu.php");
    include_once(dirname(__FILE__). "/business/class.genre.php");
    include_once(dirname(__FILE__). "/business/class.sousGenre.php");
    include_once(dirname(__FILE__). "/business/class.espece.php");
    include_once(dirname(__FILE__). "/../treatments/class.Log.php");
    

    class Identification_Manager{

        private $DB_acces;
        private $idOrdre;
        private $idUser;
        private $arborescence;

        public function __construct($userId, $idOrdre, $arborescence){
                //--initialisation des attibuts
                $this->DB_acces = new DB_Acces();
                $this->idOrdre = $idOrdre;
                $this->idUser = $userId;
                $this->arborescence = $arborescence;
        }
        
        public function getSuperFamilleList(){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();
 
            //--Construction de la requete
            $sql = "SELECT DISTINCT sf.IdSuperFamille, sf.NomSuperFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SuperFamille sf ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdSuperFamille = sf.IdSuperFamille ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new SuperFamille($res['IdSuperFamille'],
                                               utf8_encode($res['NomSuperFamille']));
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
        public function getSuperFamilleFromFamilleList($idFam){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT sf.IdSuperFamille, sf.NomSuperFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SuperFamille sf ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdSuperFamille = sf.IdSuperFamille ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdFamille = ".$idFam." ";
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new SuperFamille($res['IdSuperFamille'],
                                               utf8_encode($res['NomSuperFamille']));
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
        public function getFamilleAloneList(){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT f.IdFamille, f.NomFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Famille f ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdFamille = f.IdFamille ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Famille($res['IdFamille'],
                                            utf8_encode($res['NomFamille']));
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
        public function getFamilleList($idSupFam){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT f.IdFamille, f.NomFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Famille f ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdFamille = f.IdFamille ".
                    "WHERE e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.idOrdre = ".$this->idOrdre." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Famille($res['IdFamille'],
                                            utf8_encode($res['NomFamille']));
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
        
        public function getSousFamilleList($idFam, $idSupFam){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT sf.IdSousFamille, sf.NomSousFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SousFamille sf ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdSousFamille = sf.IdSousFamille ".
                    "WHERE e.IdFamille = ".$idFam." ".
                    "AND e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.idOrdre = ".$this->idOrdre." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new SousFamille($res['IdSousFamille'],
                                            utf8_encode($res['NomSousFamille']));
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
        
        public function getTribuList($idSupFam, $idFam, $idSousFam){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT t.IdTribu, t.NomTribu ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Tribu t ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdTribu = t.IdTribu ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.IdFamille = ".$idFam." ";
                    if($idSousFam != ""){
                        $sql = $sql."AND e.IdSousFamille = ".$idSousFam." ";
                    }
                    
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Tribu($res['IdTribu'],
                                            utf8_encode($res['NomTribu']));
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
        
        public function getGenreList($idSupFam, $idFam, $idSousFam, $idTribu){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT g.IdGenre, g.NomGenre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Genre g ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdGenre = g.IdGenre ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.IdFamille = ".$idFam." ";
                    if($idSousFam != ""){
                        $sql = $sql."AND e.IdSousFamille = ".$idSousFam." ";
                    }
                    if($idTribu != ""){
                        $sql = $sql."AND e.IdTribu = ".$idTribu." ";
                    }
                    
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Genre($res['IdGenre'],
                                utf8_encode($res['NomGenre']));
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
        
        public function getSousGenreList($idSupFam, $idFam, $idSousFam, $idTribu, $idGenre){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT sg.IdSousGenre, sg.NomSousGenre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SousGenre sg ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Espece e ON e.IdSousGenre = sg.IdSousGenre ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.IdFamille = ".$idFam." ";
                    if($idSousFam != ""){
                        $sql = $sql."AND e.IdSousFamille = ".$idSousFam." ";
                    }
                    if($idTribu != ""){
                        $sql = $sql."AND e.IdTribu = ".$idTribu." ";
                    }
                    if($idGenre != ""){
                        $sql = $sql."AND e.IdGenre = ".$idGenre." ";
                    }
                    
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new SousGenre($res['IdSousGenre'],
                                utf8_encode($res['NomSousGenre']));
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
        
        public function getEspeceList($idSupFam, $idFam, $idSousFam, $idTribu, $idGenre, $idSousGenre){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Tableau de retour
            $retour = array();

            //--Construction de la requete
            $sql = "SELECT DISTINCT e.IdEspece, e.NomEspece, d.NomDescripteur, a.Annee, e.NomVernaculaire ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Espece e ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Descripteur d ON d.IdDescripteur = e.IdDescripteur ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Annee a ON a.IdAnnee = e.IdAnnee ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdSuperFamille = ".$idSupFam." ".
                    "AND e.IdFamille = ".$idFam." ";
                    if($idSousFam != ""){
                        $sql = $sql."AND e.IdSousFamille = ".$idSousFam." ";
                    }
                    if($idTribu != ""){
                        $sql = $sql."AND e.IdTribu = ".$idTribu." ";
                    }
                    if($idGenre != ""){
                        $sql = $sql."AND e.IdGenre = ".$idGenre." ";
                    }
                    if($idSousGenre != ""){
                        $sql = $sql."AND e.IdSousGenre = ".$idSousGenre." ";
                    }
                    
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour[] = new Espece($res['IdEspece'],
                                utf8_encode($res['NomEspece']),
                                utf8_encode($res['NomDescripteur']),
                                utf8_encode($res['Annee']),
                                utf8_encode($res['NomVernaculaire']));
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
        
        public function getEspece($idEspece){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT DISTINCT e.IdEspece, e.NomEspece, d.NomDescripteur, a.Annee, e.NomVernaculaire ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Espece e ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Descripteur d ON d.IdDescripteur = e.IdDescripteur ".
                    "INNER JOIN ".$this->DB_acces->getPrefixTables()."Annee a ON a.IdAnnee = e.IdAnnee ".
                    "WHERE e.idOrdre = ".$this->idOrdre." ".
                    "AND e.IdEspece = ".$idEspece." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Espece($res['IdEspece'],
                                utf8_encode($res['NomEspece']),
                                utf8_encode($res['NomDescripteur']),
                                utf8_encode($res['Annee']),
                                utf8_encode($res['NomVernaculaire']));
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
        
    //----Get Classes par IDs------------------------------------------------------------------------------
        
        public function getSuperFamilleById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT sf.IdSuperFamille, sf.NomSuperFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SuperFamille sf ".
                    "WHERE  sf.IdSuperFamille = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new SuperFamille($res['IdSuperFamille'],
                                utf8_encode($res['NomSuperFamille']));
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
        
        public function getFamilleById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT f.IdFamille, f.NomFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Famille f ".
                    "WHERE f.IdFamille = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Famille($res['IdFamille'],
                                utf8_encode($res['NomFamille']));
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
        
        public function getSousFamilleById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT sf.IdSousFamille, sf.NomSousFamille ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SousFamille sf ".
                    "WHERE sf.IdSousFamille = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new SousFamille($res['IdSousFamille'],
                                utf8_encode($res['NomSousFamille']));
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
        
        public function getTribuById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT t.IdTribu, t.NomTribu ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Tribu t ".
                    "WHERE t.IdTribu = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Tribu($res['IdTribu'],
                                utf8_encode($res['NomTribu']));
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
        
        public function getGenreById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT g.IdGenre, g.NomGenre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."Genre g ".
                    "WHERE g.IdGenre = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new Genre($res['IdGenre'],
                                utf8_encode($res['NomGenre']));
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
        
        public function getSousGenreById($id){
            //--Connexion � la base
            $this->DB_acces->connexion();

            //--Construction de la requete
            $sql = "SELECT sg.IdSousGenre, sg.NomSousGenre ".
                    "FROM ".$this->DB_acces->getPrefixTables()."SousGenre sg ".
                    "WHERE sg.IdSousGenre = ".$id." ";
            
            //--Ex�cution
            $req = mysql_query($sql);	

            //--R�cup�ration et tri
            while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
                if($res != null){
                    $retour = new SousGenre($res['IdSousGenre'],
                                utf8_encode($res['NomSousGenre']));
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
    }
