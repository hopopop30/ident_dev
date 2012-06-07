<?php	
	include_once(dirname(__FILE__). "/class.DB_Acces.php");
	
	class Parameters_Manager{
		
		private $DB_acces;
		
		public function __construct(){
			//--initialisation des attibuts
			$this->DB_acces = new DB_Acces();
		}
		
		//--R�cup�re le texte promotionnel
		public function getTextPromo(){

			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = '';
		
			//--Construction de la requete
			$sql = "SELECT ip.ValeurParam ".
					"FROM ".$this->DB_acces->getPrefixTables()."Parametres ip ".
					"WHERE NomParam = 'Texte_Promo'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
		
		public function getUserPictureDirectory(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = '';
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'rep_photo_utilisateur'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
		
		public function getTempDirectory(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = '';
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'rep_temp'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
		
		public function getEmailIdentificator(){
			
			//--Connexion � la base
			$this->DB_acces->connexion();
			//--Tableau de retour
			$retour ='';
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'Email_Appli'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			//--Retour du tableau
			return $retour;
		}
		
		public function getAdresseSite(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour ='';
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'Chemin_Appli'";
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			//--Retour du tableau
			return $retour;
		}
                
                public function getPicturesDirectory(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = '';
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'depot_final_photos'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
                
                public function getLegalsExtensions(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = array();
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'liste_extensions_acceptees'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = explode("|", utf8_encode($res['ValeurParam']));
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		} 
                
                public function getVersion(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = "";
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'Version'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		} 
                
                public function getEnvironment(){
			//--Connexion � la base
			$this->DB_acces->connexion();
			
			//--Tableau de retour
			$retour = "";
		
			//--Construction de la requete
			$sql = "SELECT ValeurParam FROM ".$this->DB_acces->getPrefixTables()."Parametres WHERE NomParam = 'Environnement'";
			
			//--Ex�cution
			$req = mysql_query($sql);	
			
			//--R�cup�ration et tri
			while($res = mysql_fetch_array($req, MYSQL_ASSOC)){
				if($res != null){
					$retour = utf8_encode($res['ValeurParam']);
				}
			}
			
			//--Fermeture de la base
			$this->DB_acces->deconnexion();
			
			//--Retour du tableau
			return $retour;
		}
	}